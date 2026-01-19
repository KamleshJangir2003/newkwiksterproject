<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\dayendreport;
use App\Models\ExcelData;
use App\Models\Attendance;
use App\Models\passcode;
use App\Models\Todo;
use App\Models\Submit_form;
use App\Models\User;
use App\Models\credentials;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Mail\FormSubmitted;
use Illuminate\Support\Facades\Mail;
use App\adminmodel\ScriptModal;
use App\Models\Training;
use App\Models\Leaves;
use App\Models\salary;
use App\adminmodel\Time_credit;
use App\adminmodel\Holidays;
use App\adminmodel\Current_employ;
use App\adminmodel\IdentityModal;
use App\adminmodel\Tab_view_lead;
use App\Models\Extra_leaves;
use App\Models\Bonus;
use App\Models\Admin_leave;
use App\Models\Notification;
use App\Models\formpage2;
use App\Models\formpage3;
use App\Models\formpage4;
use App\Models\auto_data_sender;
use App\Models\Auto_forward;
use App\Models\managerfwd;
use App\Events\UserNotification;

class Scriptcontroller extends Controller
{
	public function Submit_daily_report()
	{     session()->put('agent_passcode', 2);
        $timeZone = 'America/New_York';

        $currentDate = Carbon::now($timeZone);

        $date = $currentDate->format('Y-m-d');

        $report = dayendreport::where('user_id',session('agent_id'))->where('date',$date)->first();
    
		 if(empty($report)){
            $reportdata = new dayendreport();

            $lead_data = ExcelData::where('click_id',session('agent_id'))->where('date',$date)->get();
            $total_call = $lead_data->count();
            $intrested_call = $lead_data->where('form_status','Intrested')->where('red_mark',null)->count();
            $pipeline_call = $lead_data->where('form_status','Pipeline')->count();
            $notconnected = $lead_data->where('form_status','Not Connected')->count();
            $voicemail = $lead_data->where('form_status','Voice Mail')->count();
            $totalcallconnected  = $total_call - $notconnected - $voicemail;

            $reportdata->user_id = session('agent_id');
            $reportdata->intrested = $intrested_call;
            $reportdata->pipeline = $pipeline_call;
            $reportdata->total_call = $total_call;
            $reportdata->call_connect = $totalcallconnected;
            $reportdata->voicemail = $voicemail;
            $reportdata->date = $date;
            $reportdata->save();
            
            session()->flash('success','you report submited successfully');
           return redirect()->route('agent_logout');
         }
         else{
            session()->flash('error','you are allready submited today report');
            return redirect()->back();

         }
	}
   public function attendence(Request $req){
      
  if(session('agent_passcode')==1){
   $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $agentId = session('agent_id');
      $attandance  = Attendance::where('emp_id',session('agent_id'))->latest()->get();
      $Holidays = Holidays::get();
      $leavs = Leaves::where('agent_id',session('agent_id'))->get();

      $present = Attendance::where('emp_id', session('agent_id'))
      ->whereMonth('created_at', $currentMonth)
      ->whereYear('created_at', $currentYear)
      ->where('total_work', '>=', 480)
      ->count();

      $Halfday = Attendance::where('emp_id', session('agent_id'))
      ->whereMonth('created_at', $currentMonth)
      ->whereYear('created_at', $currentYear)
      ->where('total_work', '>=', 240)
      ->count();
  
//-----------------------------salary calculation---------------------------

//---------------------------- leaves--------------------------------------
$remainingleave = Extra_leaves::where('agent_id',$agentId)->first();
$bonus_salary = Bonus::where('agent_id', $agentId)
                        ->whereYear('updated_at', $currentYear)
                        ->whereMonth('updated_at', $currentMonth)
                        ->first();
    if(!empty($bonus_salary)) {
        $bonus = $bonus_salary->bonus;
    } 
    else{
        $bonus = 0;
    }                  
//------------------------------- salary calculate ------------------------------
$salary_permonth = salary::where('ajent_id',$agentId )->first();
        $salaryPerMonth = $salary_permonth->amount; 
     $perdaysalary =  $salaryPerMonth*12/365;

     $present =  Attendance::where('emp_id', $agentId )
      ->whereMonth('created_at', $currentMonth)
      ->whereYear('created_at', $currentYear)
      ->where('total_work', '>=', 480)
      ->count();
      $holidays = Holidays::whereMonth('date', $currentMonth)
    ->whereYear('date', $currentYear)
    ->distinct('date')
    ->count();
    $Halfday =  Attendance::where('emp_id', $agentId )
      ->whereMonth('created_at', $currentMonth)
      ->whereYear('created_at', $currentYear)
      ->where('total_work', '>=', 240)
      ->count();

    
      $holidaysalary =  ($holidays+4)*$perdaysalary;
      $presentsalary = $present*$perdaysalary;
      $halfdayssalary =  ($Halfday*$perdaysalary)/2;

      
      $user_join = Current_employ::where('ajent_id',$agentId)->first();
      $joiningDate = Carbon::parse($user_join->doj);

// Calculate the difference in months between the joining date and the current date
$currentDate = Carbon::now();
$tenureInMonths = $currentDate->diffInMonths($joiningDate);

// Check if the user's tenure is at least three months
$admin_leave = Admin_leave::where('agent_id', $agentId)
     ->whereYear('updated_at', $currentYear)
     ->whereMonth('updated_at', $currentMonth)
     ->first();
     if(!empty($admin_leave)){
       
        $adminleave = $admin_leave->leaves;
     }
     else{
        $adminleave = 0;
     }
if ($tenureInMonths >= 3) {
     $extra_leave = $adminleave;
} else {
    $extra_leave = 0;
}
$extralevesalary =  $extra_leave*$perdaysalary;
if($present !== 0 && $Halfday !== 0)
{
    $totalsalary = $holidaysalary +$presentsalary + $extralevesalary + $halfdayssalary +$bonus;
}else{
    $totalsalary = 0;
}
//--------------- end salary calculation-------------------------------------
  //----------------absent-----------
  $currentDate = Carbon::now();
  $startOfMonth = $currentDate->copy()->startOfMonth();
  

  // Get all attendance records for the current month up to today
  $attendances = Attendance::where('emp_id', $agentId)
      ->whereBetween('created_at', [$startOfMonth, $currentDate])
      ->get()
      ->groupBy(function($date) {
          return Carbon::parse($date->created_at)->format('Y-m-d');
      });

  // Initialize counters
  $absentCount = 0;
  $lessWorkCount = 0;

  // Iterate through each date from the start of the month to today
  for ($date = $startOfMonth; $date->lte($currentDate); $date->addDay()) {
      $formattedDate = $date->format('Y-m-d');

      if (!isset($attendances[$formattedDate])) {
          // No attendance record for this date
          $absentCount++;
      } else {
          // Check if total_work is less than 240 minutes
          foreach ($attendances[$formattedDate] as $attendance) {
              if ($attendance->total_work < 240) {
                  $lessWorkCount++;
                  break; // Move to the next date after finding a record with less work time
              }
          }
      }
  }

$absent = $absentCount+$lessWorkCount-4-$holidays;
//--------------end absent-----------------

      return view('agent/attendence/view_attendence',compact('attandance','Holidays','leavs','present','Halfday','absent','totalsalary','bonus'));
   }
   else{
      $checkpasscode = passcode::where('agent_id',session('agent_id'))->first();
      return view('agent/attendence/passcode',compact('checkpasscode'));
   }
   }
   public function passcode($n=''){
    if(!empty($n)){
        $noti = Notification::where('id',$n)->first();
        $noti->click_id = 2;
        $noti->save();
    }

      $checkpasscode = passcode::where('agent_id',session('agent_id'))->first();
      return view('Agent/attendence/passcode',compact('checkpasscode'));
   }
   public function passcodestore(Request $req){
      $validated = $req->validate([
         'input1' => 'required',
         'input2' => 'required',
         'input3' => 'required',
         'input4' => 'required',
     ]);

     $checkpasscode = passcode::where('agent_id',session('agent_id'))->first();
     $allpass = "$req->input1$req->input2$req->input3$req->input4";
     if(empty($checkpasscode)){
      $passcode = new passcode();
      $passcode->agent_id = session('agent_id');
     
      $passcode->passcode = $allpass;
      $passcode->save();
      $data = [
         'status'=> true,
         'message' => 'passcode created successfully',
      ];
      return response()->json($data);
     }
     else{
      if($checkpasscode->passcode == $allpass){
         session()->put('agent_passcode', 1);
         $data = [
            'status'=> true,
            'message' => 'correct pin',
         ];
          return response()->json($data);

      }else{
         $data = [
            'status'=> false,
            'message' => 'Wrong Pin',
         ];
          return response()->json($data);
      }

     }
   }
   public function todo(){
      $todos = Todo::where('agent_id',session('agent_id'))->get();
      return view('Agent/scripts/to-do',compact('todos'));
   }
   public function get_todo(Request $req){
      $todos = Todo::where('agent_id',session('agent_id'))->get();
        return response()->json($todos);
      
   }
   public function store_todo(Request $req){
      if(!empty($req->todo)){
         $todo = new Todo();
         $todo->agent_id = session('agent_id');
         $todo->comment = $req->todo;
         $todo->save();
         $data = [
            'status'=>true,
            'message'=> 'todo store successfully'
         ];
        return response()->json($data);
      }
   }
   public function delete_todo(Request $req){
      if($req->todoId){
     $todo = Todo::where('id',$req->todoId)->first()->delete();
     return response()->json('todo deleted successfully');
      }
     $todooo  = Todo::where('id',$req->EditId)->first();
     $todooo->checkbox = $req->done;
     $todooo->save();
     return response()->json('todo updated successfully');
   }
   public function submit_form(){
      return view('Agent.scripts.Submit_form');
   } 
   public function store_submit_form(Request $req){
      $validated = $req->validate([
         'company' => 'required',
         'owner' => 'required',
         'dot' => 'required',
         'phone' => 'required',
         'email' => 'required',
         'Hauls' => 'required',
         'truck_vin' => 'required',
         'trailer_vin' => 'required',
         'driver' => 'required',
         'LN' => 'required',
         'dob' => 'required',
         'issue_state' => 'required',
         'lIability' => 'required',
         'cargo' => 'required',
         'physical_damage' => 'required',
     ]);
       $user = User::where('id',session('agent_id'))->first();

     $data = new Submit_form();
     $data->agent_id = session('agent_id');
     $data->company_name = $req->company;
     $data->owner = $req->owner;
     $data->DOT = $req->dot;
     $data->phone = $req->phone;
     $data->email = $req->email;
     $data->Hauls = $req->Hauls;
     $data->Truck_VIN = $req->truck_vin;
     $data->Trailer_VIN = $req->trailer_vin;
     $data->Driver_Name = $req->driver;
     $data->LN = $req->LN;
     $data->DOB = $req->dob;
     $data->Issued_state = $req->issue_state;
     $data->LIability = $req->lIability;
     $data->Cargo = $req->cargo;
     $data->Physical_damage = $req->physical_damage;
     $data->Agent_Name = $user->name;
     $data->save();

     $emailData = [
      'id' => $data->id,
      'company_name' => $data->company_name,
      'owner' => $data->owner,
      'DOT' => $data->DOT,
      'phone' => $data->phone,
      'email' => $data->email,
      'Hauls' => $data->Hauls,
      'Truck_VIN' => $data->Truck_VIN,
      'Trailer_VIN' => $data->Trailer_VIN,
      'Driver_Name' => $data->Driver_Name,
      'LN' => $data->LN,
      'DOB' => $data->DOB,
      'Issued_state' => $data->Issued_state,
      'LIability' => $data->LIability,
      'Cargo' => $data->Cargo,
      'Physical_damage' => $data->Physical_damage,
      'Agent_Name' => $data->Agent_Name
  ];

  Mail::to($data->email)->send(new FormSubmitted($emailData));
  session()->flash('success','form submited successfully');
 return redirect()->back();
     
   } 

   public function email_script(){
      $script = ScriptModal::where('ajent_id',session('agent_id'))->first();
      return view('Agent.scripts.email',compact('script'));
   }
   public function text_script(){
      $script = ScriptModal::where('ajent_id',session('agent_id'))->first();
      return view('Agent.scripts.text',compact('script'));
   }
   public function call_script(){
      $script = ScriptModal::where('ajent_id',session('agent_id'))->first();
      return view('Agent.scripts.call',compact('script'));
   }
   public function credential(){
      $credentials = credentials::where('Ajent_id',session('agent_id'))->paginate(10);
      return view('Agent.scripts.credential',compact('credentials'));
   }
   public function store_script(Request $req){

      $id = session('agent_id');
 
     $script = ScriptModal::where('ajent_id',$id)->first();
     if(empty($script)){
         $script_data = new ScriptModal();
         $script_data->ajent_id = $id;
         $script_data->email_script = $req->email;
         $script_data->calling_script = $req->calling;
         $script_data->text_script = $req->text;
         $script_data->my_note = $req->my_note;
         $script_data->ip = $req->ip();
         $script_data->save();
     }
     else{
         if(empty($req->email)){
             $email = $script->email_script;
         }
         else{
             $email = $req->email;
         }if(empty($req->calling)){
             $calling = $script->calling_script;
         }else{
             $calling = $req->calling;
         }if(empty($req->text)){
             $text = $script->text_script;
         }else{
             $text = $req->text;
         }
         if(empty($req->my_note)){
             $my_note = $script->my_note;
         }else{
             $my_note = $req->my_note;
         }
 
         $script->email_script = $email;
         $script->calling_script = $calling;
         $script->text_script = $text;
         $script->my_note = $my_note;
         $script->save();
     }
     return redirect()->back();
 
    }
    public function store_credential(Request $req){
      $id = $req->id;
  
      $credentials = new credentials();
      $credentials->Ajent_id = $id;
      $credentials->platform = $req->platform;
      $credentials->username = $req->username;
      $credentials->password = $req->password;
      $credentials->link = $req->link;
      $credentials->save();
  
     return redirect()->back();
  
    }
    public function training_material(){
      $datas = Training::latest()->get();
      return view('Agent.scripts.training',compact('datas'));
    }
    public function store_notes(Request $req){

      $id = session('agent_id');
 
     $script = ScriptModal::where('ajent_id',$id)->first();
     if(empty($script)){
         $script_data = new ScriptModal();
         $script_data->ajent_id = $id;
         $script_data->my_note = $req->content;
         $script_data->ip = $req->ip();
         $script_data->save();
     }
     else{
         $script->my_note = $req->content;
         $script->save();
     }
   return response()->json('data update successfully');
 
    }
    public function agent_store_leaves(Request $req){

      $from_date = $req->from_date;
      $to_date = $req->to_date;

      // Create DateTime objects from the dates
      $from_date_time = new \DateTime($from_date); // Specify the global namespace with \
      $to_date_time = new \DateTime($to_date);

      // Calculate the difference
      $interval = $from_date_time->diff($to_date_time);

      // Get the number of days
      $days = $interval->days;

        if($days == 0){
            session()->flash('error','Please select min 1 day Leave');
            return redirect()->back(); 
        }else{

      $leave = new Leaves();
      $leave->agent_id = session('agent_id');
      $leave->reason=$req->reason;
      $leave->days=$days;
      $leave->from_date= $from_date;
      $leave->to_date= $to_date;
      $leave->status=1;
      $leave->save();

      $data = new Notification();
      $data->type = "leave";
      $data->heading = "Leave Request";
      $data->massage = session('agent_name')." Wants ".$days." Day Leaves";
      $data->click_id = 1;
      $data->save();

      session()->flash('success','Leave Applied Successfully');

      return redirect()->back();
        }
      
    }
    public function calculateSalary(Request $req)
    {
      $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $salary_permonth = salary::where('ajent_id',session('agent_id'))->first();
        $salaryPerMonth = $salary_permonth->amount; 
     $perdaysalary =  $salaryPerMonth*12/365;

     //----------------------- present salary ----------------
     $present = Attendance::where('emp_id', session('agent_id'))
      ->whereMonth('created_at', $currentMonth)
      ->whereYear('created_at', $currentYear)
      ->where('total_work', '>=', 480)
      ->count();
      $holidays = Holidays::whereMonth('date', $currentMonth)
    ->whereYear('date', $currentYear)
    ->distinct('date')
    ->count();
    $Halfday = Attendance::where('emp_id', session('agent_id'))
      ->whereMonth('created_at', $currentMonth)
      ->whereYear('created_at', $currentYear)
      ->where('total_work', '>=', 240)
      ->count();

    
      $holidaysalary =  ($holidays+4)*$perdaysalary;
      $presentsalary = $present*$perdaysalary;
      $halfdayssalary =  ($Halfday*$perdaysalary)/2;

      
      $user_join = Current_employ::where('ajent_id',session('agent_id'))->first();
      $joiningDate = Carbon::parse($user_join->doj);

// Calculate the difference in months between the joining date and the current date
$currentDate = Carbon::now();
$tenureInMonths = $currentDate->diffInMonths($joiningDate);

// Check if the user's tenure is at least three months
if ($tenureInMonths >= 3) {
     $extra_leave = 2;
} else {
    $extra_leave = 0;
}
$extralevesalary =  $extra_leave*$perdaysalary;
$totalsalary = $holidaysalary +$presentsalary + $extralevesalary + $halfdayssalary;

        return response()->json([
            'daily_salary' => $perdaysalary,
            'Present_salary' => $presentsalary,
            'holiday_salary' => $holidaysalary,
            'extra leves' => $extralevesalary,
            'Halfday salary' => $halfdayssalary,
            'Total_salary' => $totalsalary,
           
        ]);
    }
     public function view_load(Request $req){
    $datas = formpage2::where('agent_id',session('agent_id'))->latest()->get();

    return view('Agent.load.view_intrested_load',compact('datas'));
    }
     public function req_data(Request $req)
    {
        $name = Auth()->user()->name;
        $data = [
            'valid' => 1,
            'message' => $name . ' Requested New data',
        ];
       
        // Retrieve the first record from the auto_forward table
        $check = Auto_forward::first();
    
      
        $allowed_user_ids = json_decode($check->user_id); // Assuming user_id is stored as a JSON array.
        $id = Auth()->user()->id;
        $sender = auto_data_sender::where('agent_id', $id)->orderBy('id', 'desc')->first();
        if ($sender) {
          $lastTime = Carbon::parse($sender->last_time);
      
          if ($lastTime->diffInMinutes(Carbon::now()) < 60) {
              event(new UserNotification($data));
              return redirect()->back()->with('success', 'Request sent');
          }
      }
      if($check->status == 0){
        event(new UserNotification($data));
        return redirect()->back()->with('success', 'Request sent');
      }
      $batch_id = Tab_view_lead::where('id', $check->tab_view_ids)->first();
      if(empty($batch_id)){
        event(new UserNotification($data));
        return redirect()->back()->with('success', 'Request sent');
      }
        // Check if the user_id is "999" or if the user ID is in the allowed user ID array
        if (in_array("999", $allowed_user_ids)) {
            // If "999" is in the allowed_user_ids, bypass the user check
            $this->process_autoforward($check,$id);
        } elseif (in_array($id, $allowed_user_ids)) {
            $this->process_autoforward($check,$id);
        } else {
          event(new UserNotification($data));
            return redirect()->back()->with('success','Request sent');
        }

        return redirect()->back();
    }
    
    private function process_autoforward($check, $id)
    {
        // Fetch the batch name from Tab_view_lead based on tab_view_ids from $check
        $batch_id = Tab_view_lead::where('id', $check->tab_view_ids)->first();
        $batch_name = $batch_id->batch;
       
        // Fetch the first 100 ExcelData records that are NOT 'forwarded'
        $excelDatas = ExcelData::where('status', 'not_forwarded')->where('batch_name',$batch_name)
            ->take(100) // Limit the selection to 100 records
            ->get();
        // Extract the IDs of the ExcelData records into an array
        $leadIds = $excelDatas->pluck('id')->toArray();

// Convert the array of IDs into a comma-separated string
$leadIdsString = implode(',', $leadIds);

// Now, store it in the format ["1,2,3"]
$formattedLeadIds = "[" . "\"$leadIdsString\"". "]";

// Now $formattedLeadIds will look like ["1,2,3"]
        $jsonLeadIds =  $formattedLeadIds;
    
        // Save the managerfwd entry with the given agent ID
        $forword = new managerfwd();
        $forword->agent_id = $id;
        $forword->data_id = $jsonLeadIds;
        $forword->team_id = 50; // Assuming '50' is a fixed team ID
        $forword->save();
    
        // Mark the selected ExcelData records as 'forwarded' and 'NEW' form status
        foreach ($excelDatas as $excelData) {
            $excelData->status = 'forwarded';
            $excelData->form_status = 'NEW';
            $excelData->save();
        }
    
        // Reduce tab view based on batch_name
        $batchCounts = $excelDatas->groupBy('batch_name')->map(function ($batch) {
            return $batch->count();
        });
    
        foreach ($batchCounts as $batchName => $count) {
            $tab_view = Tab_view_lead::where('batch', $batchName)->first();
            if ($tab_view) {
                $tab_data = $tab_view->total_data;
                if ($tab_data == $count) {
                    $tab_view->delete(); // Delete the tab if all data is forwarded
                } else {
                    $tab_view->total_data = $tab_data - $count;
                    $tab_view->save();
                }
            }
        }
        $currentTimeInUSTimezone = Carbon::now('America/New_York');

        // Save the time to the database
        $sender = new auto_data_sender();
        $sender->agent_id = $id;
        $sender->last_time = $currentTimeInUSTimezone; 
        $sender->save();


        // Save notification entry for the agent
        $notification = new Notification();
        $notification->agent_id = $id;
        $notification->type = "forward";
        $notification->heading = "New leads";
        $notification->massage = "System sent you new leads";
        $notification->click_id = 1; // Adjust click_id as needed
        $notification->save();
    
        // Send event notification to user
        $data = [
            'massage' => 'You received new leads',
            'user_id' => $id,
        ];
        event(new UserNotification($data));
    
        // Return back after the process is complete
        return redirect()->back();
    }
      public function update_identety_ajent(Request $req){

      $id = session('agent_id');

      $data = IdentityModal::where('ajent_id',$id)->first();
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
              $fullaadharpath = !empty($data->aadhar_card) ? $data->aadhar_card:'';
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
              $fullpanpath = !empty($data->pan_card) ? $data->pan_card :'';
          }
//---------------------- licence image----------------------------
          $fulllicencepath = '';
    if (!empty($req->marksheet)) {
      $allowedFormats = ['jpeg', 'jpg', 'webp'];
      $extension = strtolower($req->marksheet->getClientOriginalExtension());
      if (in_array($extension, $allowedFormats)) {
        $file = time() . 'marksheet.' . $req->marksheet->extension();
        $req->marksheet->move(public_path('uploads/image/docs/'), $file);
        $fulllicencepath = 'uploads/image/docs/' . $file;
      } else {
        // Handle invalid file format (not allowed)
        return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.');
      }
    }
          else{
              $fulllicencepath = !empty($data->driving_licence) ? $data->driving_licence : '';
          }

          //---------------------- resume image----------------------------
          $fulllresumepath = '';
    if (!empty($req->resume)) {
      $allowedFormats = ['jpeg', 'jpg', 'webp'];
      $extension = strtolower($req->resume->getClientOriginalExtension());
      if (in_array($extension, $allowedFormats)) {
        $file = time() . 'resume.' . $req->resume->extension();
        $req->resume->move(public_path('uploads/image/docs/'), $file);
        $fulllresumepath = 'uploads/image/docs/' . $file;
      } else {
        // Handle invalid file format (not allowed)
        return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.');
      }
    }
          else{
              $fulllresumepath = !empty($data->resume) ? $data->resume : '';
          }

    $teamInfo = [
              'ajent_id' => session('agent_id'),
      'pan_card' => $fullpanpath,
      'aadhar_card' => $fullaadharpath,
      'marksheet' => $fulllicencepath,
      'resume' => $fulllresumepath,
    ];


          if(empty($data)) {

              $last_id = IdentityModal::create($teamInfo);
              return Redirect()->back()->with('success', 'Data Added Successfully.');
          } else {
              $data->update($teamInfo);
              return Redirect()->back()->with('success', 'Data Added Successfully.');
          }
  }
   
}