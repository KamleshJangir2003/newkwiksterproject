<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\adminmodel\ExcelData;

use App\Models\User;
use App\Models\Notification;
use App\Models\dayendreport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\Goal;


class dashboard_agentcontroller extends Controller
{
	public function agent_dashboard(Request $req)
{     
    $timeZone = 'America/New_York';
    $currentDate = Carbon::now($timeZone);
    $date = $currentDate->format('Y-m-d');

    $agentId = session('agent_id');
    // ================= LIVE TRANSFER (LOSS RUNS) =================

/// ================= LOSS RUNS REQUIRED / NOT REQUIRED =================

// Required = loss_runs = yes
$lossRunsRequired = DB::table('excel_data')
    ->where('click_id', $agentId)
    ->where('loss_runs', 'yes')
    ->count();

// Not Required = loss_runs = no
$lossRunsNotRequired = DB::table('excel_data')
    ->where('click_id', $agentId)
    ->where('loss_runs', 'no')
    ->count();

// ================= LIVE TRANSFER COUNT =================
$liveTransferPending = DB::table('excel_data')
    ->where('click_id', $agentId)
    ->where('live_transfer', 'no')
    ->count();

$liveTransferSuccess = DB::table('excel_data')
    ->where('click_id', $agentId)
    ->where('live_transfer', 'yes')
    ->count();

$totalLiveTransfer = $liveTransferPending + $liveTransferSuccess;

    // Live transfer count for sidebar notification (only failed ones - NO)
$liveTransferFailedCount = DB::table('excel_data')
    ->where('click_id', $agentId)
    ->where('live_transfer', 'no')
    ->count();

// Live transfer success count for sidebar notification
$liveTransferSuccessCount = $liveTransferSuccess;

// Loss runs count for sidebar notification  
$lossRunsCount = $lossRunsRequired;


    $startOfMonth = $currentDate->copy()->startOfMonth()->format('Y-m-d');
    $endOfMonth = $currentDate->copy()->endOfMonth()->format('Y-m-d');

    // 1. Today's pipeline calls count (with pipeline_updated IS NULL)
    $pipeline_call = \DB::table('excel_data')
        ->where('click_id', $agentId)
        ->where('date', $date)
        ->where('form_status', 'Pipeline')
        ->whereNull('pipeline_updated')
        ->count();

    // 2. Today's total interested forms with red_mark=1
    $total_forms = \DB::table('excel_data')
        ->where('click_id', $agentId)
        ->where('date', $date)
        ->where('form_status', 'Intrested')
        ->where('red_mark', 1)
        ->count();

    // 3. Today's dayendreport - single fetch
    $dayReportToday = \DB::table('dayendreport')
        ->where('user_id', $agentId)
        ->where('date', $date)
        ->first();

    $total_call = $dayReportToday->total_call ?? 0;
    $intrested_call = $dayReportToday->intrested ?? 0;

    // 4. Monthly pipeline count directly in DB
    $month_pipeline = \DB::table('excel_data')
        ->where('click_id', $agentId)
        ->whereBetween('date', [$startOfMonth, $endOfMonth])
        ->where('form_status', 'Pipeline')
        ->count();

    // 5. Monthly interested forms with red_mark=1 count
    $month_forms = \DB::table('excel_data')
        ->where('click_id', $agentId)
        ->whereBetween('date', [$startOfMonth, $endOfMonth])
        ->where('form_status', 'Intrested')
        ->where('red_mark', 1)
        ->count();

    // 6. Monthly interested sum from dayendreport
    $month_intrested = \DB::table('dayendreport')
        ->where('user_id', $agentId)
        ->whereBetween('date', [$startOfMonth, $endOfMonth])
        ->sum('intrested');

    // 7. Monthly total calls sum from dayendreport
    $totalmonth_call = \DB::table('dayendreport')
        ->where('user_id', $agentId)
        ->whereBetween('date', [$startOfMonth, $endOfMonth])
        ->sum('total_call');
        // Return the data to the dashboard view
        $total_all_forms = \DB::table('excel_data')
    ->where('click_id', $agentId)
    ->where('date', $date)
    ->count();

    // =================== GOALS DATA FOR AGENT ===================

// Latest target set by Admin
$latestGoal = Goal::latest()->first();

$targetValue = $latestGoal->target_value ?? 0;

// Agent ka achieved (Interested leads of this agent)
$achievedLeads = \DB::table('excel_data')
    ->where('click_id', $agentId)
    ->where('form_status', 'Intrested')
    ->count();

// Remaining leads
$remainingLeads = max(0, $targetValue - $achievedLeads);

// Percentage completed
$goalPercent = $targetValue > 0
    ? max(1, round(($achievedLeads / $targetValue) * 100))
    : 0;


    // pipeline return
    $pipeline_call = \DB::table('excel_data')
    ->where('click_id', $agentId)
    ->where('date', $date)
    ->where('form_status', 'Pipeline')
    ->whereNull('pipeline_updated')
    ->count();
    // =================== TEAM PERFORMANCE DATA FOR CHART ===================

// Get all active agents
$teamAgents = User::where('is_active', 1)
    ->where('status', 1)        // 1 = agents
    ->whereNull('deleted_at')
    ->pluck('name', 'id');



$teamLabels = [];
$teamTotalForms = [];
$teamPipeline = [];
$teamLossRuns = [];

foreach ($teamAgents as $id => $name) {

    $teamLabels[] = $name;

    // Total forms per agent (today)
    $teamTotalForms[] = DB::table('excel_data')
        ->where('click_id', $id)
        ->where('date', $date)
        ->count();

    // Pipeline per agent (today)
    $teamPipeline[] = DB::table('excel_data')
        ->where('click_id', $id)
        ->where('date', $date)
        ->where('form_status', 'Pipeline')
        ->count();

    // Loss runs per agent (today)
    $teamLossRuns[] = DB::table('excel_data')
        ->where('click_id', $id)
        ->where('date', $date)
        ->where('form_status', 'Loss')
        ->count();
}




    return view('Agent/index', compact(
        'intrested_call',
        'pipeline_call',
        'total_forms',
        'total_call',
        'month_intrested',
        'month_pipeline',
        'month_forms',
        'totalmonth_call',
        'total_all_forms',
        'latestGoal',
    'targetValue',
    'achievedLeads',
    'remainingLeads',
    'goalPercent',
    'lossRunsRequired',
    'lossRunsNotRequired',
    'lossRunsCount',
    'totalLiveTransfer',
    'liveTransferPending',
    'liveTransferSuccess',
    'liveTransferFailedCount',
    'liveTransferSuccessCount',
    // 👉 TEAM CHART VARIABLES
    'teamLabels',
    'teamTotalForms',
    'teamPipeline',
    'teamLossRuns',
   
  

        
    ));
}
	public function updateUser_modes(Request $req)
    {
        $agent_id = session('agent_id');
      
        $users =  User::whereNull('deleted_at')->where('is_active', 1)->where('id', $agent_id)->first();
        //----------------modes---------------
       
        if($req->mode == "darkmode"){
            $users->mode = 1;
            $users->header = 0;
            $users->sidebar = 0;
        }
        else if($req->mode == "semidark"){
            $users->mode = 2;
            $users->header = 0;
            $users->sidebar = 0;
        }
        else if($req->mode == "minimaltheme"){
            $users->mode = 3;
            $users->header = 0;
            $users->sidebar = 0;
        }
        else{
            $users->mode = 0;
        }
            //----------------------header-------------------------
        if($req->header  == "headercolor1"){
            $users->header = 1;
        }
        else if($req->header == "headercolor2"){
            $users->header = 2;
        }
        else if($req->header == "headercolor3"){
            $users->header = 3;
        }
        else if($req->header == "headercolor4"){
            $users->header = 4;
        }
        else if($req->header == "headercolor5"){
            $users->header = 5;
        }
        else if($req->header == "headercolor6"){
            $users->header = 6;
        }
        else if($req->header == "headercolor7"){
            $users->header = 7;
        }
        else if($req->header == "headercolor8"){
            $users->header = 8;
        }
        //--------------------- sidebar--------------------
        if($req->sidebar  == "sidebarcolor1"){
        $users->sidebar = 1;
       }
       else if($req->sidebar == "sidebarcolor2"){
        $users->sidebar = 2;
       }
       else if($req->sidebar == "sidebarcolor3"){
        $users->sidebar = 3;
       }
       else if($req->sidebar == "sidebarcolor4"){
        $users->sidebar = 4;
       }
       else if($req->sidebar == "sidebarcolor5"){
        $users->sidebar = 5;
       }
       else if($req->sidebar == "sidebarcolor6"){
        $users->sidebar = 6;
       }
       else if($req->sidebar == "sidebarcolor7"){
        $users->sidebar = 7;
       }
       else if($req->sidebar == "sidebarcolor8"){
        $users->sidebar = 8;
       }

        $users->save();
       
        $responseData = [
            'success' => true,
        ];

        // Return the JSON response
        return response()->json($responseData);
    }
    public function agent_global_search(Request $req){
        $searchTerm = $req->search;

        // Perform the search query
        $results = ExcelData::orWhere('company_name', 'like', "%$searchTerm%")
                            ->orWhere('phone', 'like', "%$searchTerm%")
                            ->orWhere('email', 'like', "%$searchTerm%")
                            ->get();
    
        return response()->json($results);
    }
    public function update_profile_pic(Request $req){
    $user = User::where('id',session('agent_id'))->first();

        $fullimagepath = '';
			if (!empty($req->img)) {
				$allowedFormats = ['jpeg', 'jpg', 'webp'];
				$extension = strtolower($req->img->getClientOriginalExtension());
				if (in_array($extension, $allowedFormats)) {
					$file = time() . '.' . $req->img->extension();
					$req->img->move(public_path('uploads/image/Ajents/'), $file);
					$fullimagepath = 'uploads/image/Ajents/' . $file;
				} else {
					// Handle invalid file format (not allowed)
					return redirect()->back()->with('error', 'Invalid file format. Only jpeg, jpg, and webp files are allowed.')->withInput();
				}
			}
            $user->image = $fullimagepath;
            $user->save();
            return redirect()->back()->with('success','Profile Picture Updated');
    }
    public function clear_notifications(){
        $noti = Notification::where('agent_id',session('agent_id'))->get();

        foreach($noti as $data){
            $data->delete();
        }
        return redirect()->back();
    }
      public function comming_soon(){
        return view('Agent.comming_soon');
    }

    // ✅ YAHI ADD KARNA HAI (Loss Runs Leads)
public function agent_leads(Request $request)
{
    $agentId = session('agent_id');

    // 🔔 Notification count (Loss Runs = yes)
    $lossRunsCount = DB::table('excel_data')
        ->where('click_id', $agentId)
        ->where('loss_runs', 'yes')
        ->count();

    // 📋 Page data (Loss Runs list)
    $datas = DB::table('excel_data')
        ->where('click_id', $agentId)
        ->where('loss_runs', 'yes')
        ->orderBy('id', 'desc')
        ->get();

    return view('Agent.leads.lossruns', compact('datas', 'lossRunsCount'));
}
public function agent_live_transfer(Request $request)
{
    $agentId = session('agent_id');

    // Get only failed live transfer leads (NO) for this agent
    $transfers = DB::table('excel_data')
        ->where('click_id', $agentId)
        ->where('live_transfer', 'no')
        ->orderBy('id', 'desc')
        ->get();

    return view('Agent.live_transfer.index', compact('transfers'));
}

public function resubmitTransfer(Request $request)
{
    $leadId = $request->lead_id;
    $reason = $request->reason;
    $agentId = session('agent_id');
    $agentName = session('agent_name') ?? 'Agent';
    
    // Get current lead
    $lead = \DB::table('excel_data')
        ->where('id', $leadId)
        ->where('click_id', $agentId)
        ->where('live_transfer', 'no')
        ->first();
    
    if ($lead) {
        // Parse existing comments
        $comments = [];
        if ($lead->comment) {
            try {
                $comments = json_decode($lead->comment, true) ?: [];
            } catch (Exception $e) {
                $comments = [];
            }
        }
        
        // Add agent's resubmit reason
        $comments[] = [
            'agent_name' => $agentName,
            'comment' => 'Resubmit Reason: ' . $reason,
            'created_at' => now()->format('Y-m-d H:i:s')
        ];
        
        // Update lead
        \DB::table('excel_data')
            ->where('id', $leadId)
            ->update([
                'live_transfer' => null,
                'comment' => json_encode($comments)
            ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Form re-submitted successfully'
        ]);
    }
    
    return response()->json([
        'success' => false,
        'message' => 'Lead not found or already processed'
    ]);
}



}

