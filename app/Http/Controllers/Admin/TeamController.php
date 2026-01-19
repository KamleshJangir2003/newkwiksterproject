<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\adminmodel\Team;
use App\adminmodel\Users_detailsModal;
use App\adminmodel\AdminSidebar;
use App\adminmodel\AdminSidebar2;
use App\adminmodel\UserModal;
use App\adminmodel\Current_employ;
use App\adminmodel\IdentityModal;
use App\adminmodel\SalaryModal;
use App\Models\Attendance;
use App\Models\Manager_team;
use App\Models\User;
use App\adminmodel\ExcelData;
use App\Models\dayendreport;
use Carbon\Carbon;
use App\Models\Client;
use App\Models\Goal;








class TeamController extends Controller
{
		public function admin_index(Request $req)
{
    $admin_id = $req->session()->get('admin_id');
    $services = json_decode($req->session()->get('services'), true);

    // Service permission check
    if (!in_array(1, $services) && !in_array(999, $services)) {
        $service = AdminSidebar::find($services[0]);
        if ($service->url == "#") {
            $serviceDetails = AdminSidebar2::where('main_id', $services[0])->first();
            return redirect()->route($serviceDetails->url);
        }
        return redirect()->route($service->url);
    }

    // Timezone & default date
    $timeZone = 'America/New_York';
    $currentDate = Carbon::now($timeZone)->format('Y-m-d');

	// 🔹 FILTER HANDLING (ADD THIS)
$filter = $req->query('filter');

switch ($filter) {
    case 'today':
        $startDate = $currentDate;
        $endDate   = $currentDate;
        break;

    case 'yesterday':
        $startDate = Carbon::yesterday($timeZone)->format('Y-m-d');
        $endDate   = $startDate;
        break;

    case 'weekly':
        $startDate = Carbon::now($timeZone)->startOfWeek()->format('Y-m-d');
        $endDate   = Carbon::now($timeZone)->endOfWeek()->format('Y-m-d');
        break;

    case 'monthly':
        $startDate = Carbon::now($timeZone)->startOfMonth()->format('Y-m-d');
        $endDate   = Carbon::now($timeZone)->endOfMonth()->format('Y-m-d');
        break;
}


    $startDate = $req->query('start_date', $currentDate);
    $endDate   = $req->query('end_date', null);

    $startObj = Carbon::parse($startDate);

    if ($endDate) {
        $endObj = Carbon::parse($endDate);
        $rangeStart = $startObj->copy()->startOfDay();
        $rangeEnd   = $endObj->copy()->endOfDay();
    } else {
        // Only first date selected → monthly data based on that month
        $rangeStart = $startObj->copy()->startOfMonth();
        $rangeEnd   = $startObj->copy()->endOfMonth();
    }

    // Get reports for selected range
    $dayendreports = dayendreport::whereBetween('date', [$rangeStart, $rangeEnd])->get()
        ->map(fn($report) => tap($report, fn($r) => $r->date = Carbon::parse($r->date)));

    $dayReportsByUser = $dayendreports->groupBy('user_id');
    $users = User::where('status', 1)->where('is_active', 1)->latest()->get();

    $dailyData = [];
    $monthlyData = [];

//    $monthlyData = [];

foreach ($users as $user) {

    $interested = ExcelData::where('click_id', $user->id)
        ->whereBetween('created_at', [$rangeStart, $rangeEnd])
        ->where('form_status', 'Intrested')
        ->count();

    $pipeline = ExcelData::where('click_id', $user->id)
        ->whereBetween('created_at', [$rangeStart, $rangeEnd])
        ->where('form_status', 'Pipeline')
        ->count();

    $rejected = ExcelData::where('click_id', $user->id)
        ->whereBetween('created_at', [$rangeStart, $rangeEnd])
        ->whereIn('form_status', ['Rejected', 'NotInterested', 'DND'])
        ->count();

   $monthlyData[] = [
    'user'       => $user,
    'interested' => $interested,
    'live'       => $pipeline,   // pipeline = live माना गया
    'rejected'   => $rejected,
];

}


  $today = Carbon::now('America/New_York')->toDateString();

$totalDaily = dayendreport::where('date', $today)
    ->sum('intrested');


   $totalMonthly = ExcelData::where('form_status', 'Intrested')
    ->whereBetween('created_at', [
        Carbon::now('America/New_York')->startOfMonth(),
        Carbon::now('America/New_York')->endOfMonth()
    ])
    ->count();
;
	// ================= TODAY TABLE ROWS =================

$today = Carbon::now('America/New_York')->toDateString();

$rows = [];

foreach ($users as $user) {

    $todayReport = dayendreport::where('user_id', $user->id)
        ->whereDate('date', $today)
        ->first();

    $totalLeads = ExcelData::where('click_id', $user->id)
        ->whereDate('created_at', $today)
        ->count();

    $rows[] = [
        'name'        => $user->name,
        'total_leads' => $totalLeads,
        'calls'       => $todayReport->total_call ?? 0,
        'interested'  => $todayReport->intrested ?? 0,
		
        'disposition' => $todayReport->disposition ?? 0,
        'pipeline'    => $todayReport->pipeline ?? 0,
        'last_int'    => $todayReport->intrested ?? 0,
		// 'call_int'    => $todayReport->call_int ?? 0,
		// 'email_int'    => $todayReport->email_int ?? 0,
		
    ];
// 	$monthlyData[] = [
//     'user'       => $user,
//     'interested' => $interested,
//     'live'       => $pipeline,   // ✅ pipeline को live माना गया
//     'rejected'   => $rejected,
// ];


}



	// ✅ ADD THIS LINE HERE
$totalClients = Client::count();
$totalCrmData = ExcelData::count();     // ✅ ADD THIS
$totalInterestedLeads = ExcelData::where('form_status', 'Intrested')->count();
$totalEmployees = Current_employ::count();
// ✅ ADD THIS LINE HERE
// $totalEmployees = Current_employ::count();
$totalLiveLeads = ExcelData::where('form_status', 'Live')->count();

$latestGoal = Goal::latest()->first();

$targetValue = $latestGoal->target_value ?? 0;

// ✅ Sirf CURRENT MONTH ke completed leads lo
$completedLeads = ExcelData::where('form_status', 'Intrested')
    ->whereBetween('created_at', [
        Carbon::now('America/New_York')->startOfMonth(),
        Carbon::now('America/New_York')->endOfMonth()
    ])
    ->count();

// ✅ Correct progress calculation
$progressPercent = $targetValue > 0
    ? round(($completedLeads / $targetValue) * 100)
    : 0;

// 🚫 Overflow fix (100% se zyada na jaaye)
if ($progressPercent > 100) {
    $progressPercent = 100;
}

// ✅ Live transfers (same rahega)
$liveTransfers = ExcelData::where('form_status', 'Live')->count();

// -------- ACHIEVEMENT (Milestones) --------
$totalMilestones = 10;

// ✅ Milestones bhi capped at 10
$milestonesDone = $targetValue > 0
    ? min(10, round(($completedLeads / $targetValue) * 10))
    : 0;


;


$totalAttemptedLeads = dayendreport::sum('total_call');

$totalRejectedLeads = ExcelData::whereIn('form_status', ['Rejected','NotInterested','DND'])->count();


$totalActiveEmployees = Current_employ::whereNull('deleted_at')
    ->where('is_active', 1)
    ->count();

$totalInactiveEmployees = Current_employ::whereNull('deleted_at')
    ->where('is_active', '!=', 1)
    ->count();

$activeRate = $totalEmployees > 0
    ? round(($totalActiveEmployees / $totalEmployees) * 100, 1)
    : 0;


	


   return view('admin/index', compact(
    'dailyData',
    'monthlyData',
    'totalDaily',
    'totalMonthly',
    'startDate',
    'endDate',

    'totalClients',
    'totalCrmData',
    'totalInterestedLeads',
    'totalLiveLeads',
    'totalAttemptedLeads',
    'totalRejectedLeads',
	 'totalEmployees',        // 👉 यह होना चाहिए
    'totalActiveEmployees',  // 👉 यह होना चाहिए
    'totalInactiveEmployees',// 👉 यह होना चाहिए
    'activeRate', 
	'latestGoal',
'completedLeads',
'progressPercent',
'liveTransfers',  
'totalMilestones',   // 👉 ADD THIS
'milestonesDone' ,
'progressPercent',         // 👉 यह होना चाहिए

    'rows'
));

	
}
	public function add_team_view(Request $req)
	{
			$service_data = AdminSidebar::get();
			return view('admin/team/add_team', compact('service_data'));
	}
	public function view_team(Request $req)
	{
			$Team_data = Team::wherenull('deleted_at')->orderBy('id', 'desc')->get();
			return view('admin/team/view_team', ['teamdetails' => $Team_data]);
	}
	public function UpdateTeamStatus($status, $idd, Request $req)
	{
			$id = base64_decode($idd);

			$admin_id = $req->session()->get('admin_id');
			if ($id == $admin_id) {

				return Redirect()->back()->with('error', "Sorry You can't change status of yourself.");
			}
			
				if ($status == "active") {
					$teamStatusInfo = [
						'is_active' => 0,
					];
					$TeamData = Team::wherenull('deleted_at')->where('id', $id)->first();
					$TeamData->update($teamStatusInfo);
				} else {
					$teamStatusInfo = [
						'is_active' => 1,
					];
					$TeamData = Team::wherenull('deleted_at')->where('id', $id)->first();
					$TeamData->update($teamStatusInfo);
				}
				return Redirect('/view_team')->with('success', 'Status Updated Successfully.');
	}
	public function deleteTeam($idd, Request $req)
	{
			$id = base64_decode($idd);
			$admin_id = $req->session()->get('admin_id');
			if ($id == $admin_id) {
				return Redirect('/view_team')->with('error', "Sorry You can't delete yourself.");
			}
		
				$TeamData = Team::wherenull('deleted_at')->where('id', $id)->first();
				if (!empty($TeamData)) {
					$img = $TeamData->image;
					$TeamData->forceDelete();
				    $user_check = User::where('team_id',$id)->first();
					$user_check->forceDelete();
					return Redirect()->route('view_team')->with('success', 'Data Deleted Successfully.');
				} else {
					return Redirect()->route('view_team')->with('error', 'Some Error Occurred.');
				}
			
	}
	public function add_team_process(Request $req)
	{
			$admin_id = $req->session()->get('admin_id');
			$req->validate([
				'name' => 'required',
				'email' => 'required|unique:admin_teams|email',
				'password' => 'required',
				'power' => 'required '
			]);
			$service = $req->input('service');
			$services = $req->input('services');
			if ($service == 999) {
				$ser = '["999"]';
			} else {
				$ser = json_encode($services);
			}
			$fullimagepath = '';
			if (!empty($req->img)) {
				$allowedFormats = ['jpeg', 'jpg', 'webp'];
				$extension = strtolower($req->img->getClientOriginalExtension());
				if (in_array($extension, $allowedFormats)) {
					$file = time() . '.' . $req->img->extension();
					$req->img->move(public_path('uploads/image/Teams/'), $file);
					$fullimagepath = 'uploads/image/Teams/' . $file;
				} else {
					// Handle invalid file format (not allowed)
					return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.')->withInput();
				}
			}
			$teamInfo = [
				'name' => ucwords($req->input('name')),
				'email' => $req->input('email'),
				'phone' => $req->input('phone'),
				'password' => bcrypt($req->input('password')),
				'address' => $req->input('address'),
				'services' => $ser,
				'power' => $req->input('power'),
				'image' => $fullimagepath,
				'ip' => $req->ip(),
				'added_by' => $req->input('admin_id'),
				'is_active' => 1,
			];
			$last_id = Team::create($teamInfo);
			 $user_check = User::where('team_id',$last_id->id)->first();
			
			$userInfo = [
				'name' => ucwords($req->input('name')),
				'email' => $req->input('email'),
				'phone' => $req->input('phone'),
				'password' => bcrypt($req->input('password')),
				'address' => $req->input('address'),
				'new_pass' => $req->input('password'),
				'status' => 3,
				'image' => $fullimagepath,
				'ip' => $req->ip(),
				'added_by' => $req->input('admin_id'),
				'is_active' => 1,
			];
			if(empty($user_check))
			{
				$user = User::create($userInfo);
				$user->team_id = $last_id->id;
				$user->save();
			}
			else{
				$user_check->update($userInfo);
			}
			return Redirect()->route('update_team', base64_encode($last_id->id))
			->with('success', 'Data Added Successfully.');
		//return response()->json(['response' => 'OK']);
	}
    public function update_team($idd){


        $id = base64_decode($idd);

        $profile_data = Users_detailsModal::where('team_id', $id)->first();
        $current = Current_employ::where('team_id', $id)->first();
        $identety = IdentityModal::where('team_id', $id)->first();
        $salary = SalaryModal::where('team_id', $id)->first();
        $profile = Team::where('id', $id)->first();



        return view('admin/team/update',compact('profile_data','id','profile','current','identety','salary'));
    }
    public function update_team_process(Request $req){
        $admin_id = $req->session()->get('admin_id');

        $id = $req->id;

			$teamInfo = [
                'team_id' => ucwords($req->input('id')),
				'name' => ucwords($req->input('name')),
				'alise_name' => ucwords($req->input('alise_name')),
				'phone' => $req->input('phone'),
				'dob' => $req->input('dob'),
				'gender' => $req->input('gender'),
				'marital' => $req->input('marital'),
				'blood' => $req->input('blood'),
				'guardian_name' => $req->input('guardian_name'),
				'em_name' => $req->input('em_name'),
				'em_number' => $req->input('em_number'),
				'em_relation' => $req->input('em_relation'),
				'em_address' => $req->input('em_address'),
				'ip' => $req->ip(),
				'added_by' =>$admin_id,
				'is_active' => 1,
			];

            $data = Users_detailsModal::where('team_id',$id)->first();

            if(empty($data)) {

                $last_id = Users_detailsModal::create($teamInfo);
                return Redirect()->back()->with('success', 'Data Added Successfully.');
            } else {
                $data->update($teamInfo);
                return Redirect()->back()->with('success', 'Data Added Successfully.');
            }

    }
    public function update_current_process(Request $req){
        $admin_id = $req->session()->get('admin_id');

        $id = $req->id;

			$teamInfo = [
                'team_id' => ucwords($req->input('id')),
				'employ_id' => ucwords($req->input('employ_id')),
				'doj' => ucwords($req->input('doj')),
				'job_title' => ucwords($req->input('job_title')),

				'added_by' =>$admin_id,

			];

            $data = Current_employ::where('team_id',$id)->first();

            if(empty($data)) {

                $last_id = Current_employ::create($teamInfo);
                return Redirect()->back()->with('success', 'Data Added Successfully.');
            } else {
                $data->update($teamInfo);
                return Redirect()->back()->with('success', 'Data Added Successfully.');
            }




    }
    public function update_identety_process(Request $req){
        $admin_id = $req->session()->get('admin_id');

        $id = $req->id;
 
        $data = IdentityModal::where('team_id',$id)->first();
//-----------------aadhar image---------------------
        $fullaadharpath = '';
			if (!empty($req->aadhar)) {
				$allowedFormats = ['jpeg', 'jpg', 'webp'];
				$extension = strtolower($req->aadhar->getClientOriginalExtension());
				if (in_array($extension, $allowedFormats)) {
					$file = time() . 'aadhar.' . $req->aadhar->extension();
					$req->aadhar->move(public_path('uploads/image/docs/'), $file);
					$fullaadharpath = 'uploads/image/docs/' . $file;
				} else {
					// Handle invalid file format (not allowed)
					return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.');
				}
			}
            else{
				if(!empty($data->aadhar_card)){
                $fullaadharpath = $data->aadhar_card;}
            }
//----------------------- pan image-------------------------
            $fullpanpath = '';
			if (!empty($req->pan)) {
				$allowedFormats = ['jpeg', 'jpg', 'webp'];
				$extension = strtolower($req->pan->getClientOriginalExtension());
				if (in_array($extension, $allowedFormats)) {
					$file = time() . 'pan.' . $req->pan->extension();
					$req->pan->move(public_path('uploads/image/docs/'), $file);
					$fullpanpath = 'uploads/image/docs/' . $file;
				} else {
					// Handle invalid file format (not allowed)
					return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.');
				}
			}
            else{
				if(!empty($data->pan_card)){
                $fullpanpath = $data->pan_card;}
            }
//---------------------- licence image----------------------------
            $fulllicencepath = '';
			if (!empty($req->licence)) {
				$allowedFormats = ['jpeg', 'jpg', 'webp'];
				$extension = strtolower($req->licence->getClientOriginalExtension());
				if (in_array($extension, $allowedFormats)) {
					$file = time() . 'licence.' . $req->licence->extension();
					$req->licence->move(public_path('uploads/image/docs/'), $file);
					$fulllicencepath = 'uploads/image/docs/' . $file;
				} else {
					// Handle invalid file format (not allowed)
					return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.');
				}
			}
            else{
				if(!empty($data->driving_licence)){
                $fulllicencepath = $data->driving_licence;}
            }

			$teamInfo = [
                'team_id' => ucwords($req->input('id')),
				'pan_card' => $fullpanpath,
				'aadhar_card' => $fullaadharpath,
				'driving_licence' => $fulllicencepath,

				'added_by' =>$admin_id,

			];



            if(empty($data)) {

                $last_id = IdentityModal::create($teamInfo);
                return Redirect()->back()->with('success', 'Data Added Successfully.');
            } else {
                $data->update($teamInfo);
                return Redirect()->back()->with('success', 'Data Added Successfully.');
            }




    }
    public function update_salary_process(Request $req){
        $admin_id = $req->session()->get('admin_id');

        $id = $req->id;

			$teamInfo = [
                'team_id' => ucwords($req->input('id')),
				'type' => ucwords($req->input('type')),
				'amount' => ucwords($req->input('amount')),
				'ip' => $req->ip(),
				'added_by' =>$admin_id,

			];

            $data = SalaryModal::where('team_id',$id)->first();

            if(empty($data)) {

                $last_id = SalaryModal::create($teamInfo);
                return Redirect()->back()->with('success', 'Data Added Successfully.');
            } else {
                $data->update($teamInfo);
                return Redirect()->back()->with('success', 'Data Added Successfully.');
            }




    }
	public function edit_team($id){
		$team = Team::where('id',$id)->first();
        $service_data = AdminSidebar::get();
			return view('admin/team/edit_team', compact('service_data','team'));
	}
	public function edit_store(Request $req,$id){
		$service = $req->input('service');
			$services = $req->input('services');
			if ($service == 999) {
				$ser = '["999"]';
			} else {
				$ser = json_encode($services);
			}
		$team = Team::where('id',$id)->first();
		$team->name = $req->name;
		$team->email = $req->email;
		$team->phone = $req->phone;
		$team->address = $req->address;
		$team->power = $req->power;
		$team->services = $ser;
		$team->save();

		return redirect()->route('view_team');

	}
	//========================================================== Manager Team  ==================================================
	public function add_manager_team(Request $req)
	{
			$service_data = User::where('status', 1)->where('is_active', 1)->latest('created_at')->get();
		$teams = Team::where('is_active', 1)
             ->whereIn('power', [2, 3])
             ->get();
			return view('admin/team/manager_add_team', compact('service_data','teams'));
	}
	public function view_manager_team(Request $req)
	{
			$datas = Manager_team::get();
			return view('admin/team/manager_team', compact('datas'));
	}
	public function addmanager_team_process(Request $req){
		$req->validate([
			'name' => 'required',
		]);
		$service = $req->input('service');
			$services = $req->input('services');
		if ($service == 999) {
			$ser = '["999"]';
		} else {
			$ser = json_encode($services);
		}
		$team_check = Manager_team::where('manager_id',$req->manager)->first();

		if(empty($team_check)){
			$team = new Manager_team();
			$team->manager_id = $req->manager;
			$team->team_ids = $ser;
			$team->name = $req->name;
			$team->save();
			return Redirect()->back()->with('success', ' Succcessfully added manager team');

		}
		return Redirect()->back()->with('error', ' Manager allready have a team. ');

	}
	public function edit_manager_team($idd){
		$id = base64_decode($idd);
		$team = Manager_team::where('id',$id)->first();
		$teams = Team::where('is_active', 1)->where('power',2)->get();
        $service_data =  User::where('status', 1)->where('is_active', 1)->latest('created_at')->get();
	
			return view('admin/team/edit_manager_team', compact('service_data','team','teams'));
	}
	public function editmanagerteam_store(Request $req, $idd)
{
	$id = base64_decode($idd);
    $service = $req->input('service');
    $services = $req->input('services');
    
    // Handle services input
    if ($service == 999) {
        $ser = '["999"]';
    } else {
        $ser = json_encode($services);
    }

    // Fetch the team using the id
    $team = Manager_team::where('id', $id)->first();
    
    // Check if the team exists before trying to assign values
    if (!$team) {
        return redirect()->back()->with('error', 'Team not found');
    }

    // Assign the values from the request to the team object
    $team->manager_id = $req->manager;
    $team->team_ids = $ser;
    $team->name = $req->name;
    
    // Save the updated team
    $team->save();

    return redirect()->route('view_manager_team')->with('success', 'Manager team updated successfully');
}
public function deletemanagerteam(Request $req, $idd)
{
	$id = base64_decode($idd);
    // Fetch the team using the id
    $team = Manager_team::where('id', $id)->first();
    // Check if the team exists before trying to assign values
    if (!$team) {
        return redirect()->back()->with('error', 'Team not found');
    }
  $team->delete();
    return redirect()->route('view_manager_team')->with('success', 'Manager team Deleted successfully');
}

}
