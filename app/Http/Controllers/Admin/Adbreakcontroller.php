<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\adminmodel\Team;
use App\adminmodel\Breaks;
use App\adminmodel\Information;
use App\Models\Break_detail;
use App\Models\User;
use App\Models\Attendance;
use App\Models\dayendreport;
use App\Models\ExcelData;
use App\adminmodel\Task;
use Carbon\Carbon;

class Adbreakcontroller extends Controller
{
    public function add_break_view(Request $req){
        return view('admin/break/add_break');
    }
    public function break_view(Request $req){
        $datas = Breaks::all();
        return view('admin/break/view_break',compact('datas'));
    }
	public function active_break(Request $req) {
		// Get the current date in the US timezone
		$currentDateUS = Carbon::now('America/New_York')->toDateString(); // Change to the desired US timezone
	
		// Retrieve data where status is 0 and created_at is today in the US timezone
		$datas = Break_detail::where('status', 0)
					->whereDate('created_at', $currentDateUS) // Filter by current date
					->get();
	
		// Return the view with the filtered data
		return view('admin/break/active_break', compact('datas'));
	}
	public function daily_record_break(Request $req)
{
    $admin_id = $req->session()->get('admin_id');
    $timeZone = 'America/New_York';
    
    // Get the current date in the specified time zone
    $currentDate = Carbon::now($timeZone);
    $date = $req->get('date', $currentDate->format('Y-m-d')); // Use request helper method for date input

    // Fetch all active users with status = 1 and is_active = 1
    $users = User::where('status', 1)
                ->where('is_active', 1)
                ->latest()
                ->get();

    // Fetch attendance data for the given users and date in one query
    $userIds = $users->pluck('id')->toArray(); // Get user IDs in an array
    $attendances = Attendance::whereIn('emp_id', $userIds)
                             ->where('date', $date)
                             ->get()
                             ->keyBy('emp_id'); // Get attendance keyed by emp_id

    $currentDateTimeUSA = Carbon::now($timeZone); // Get the current date and time in the specified time zone
    $userAttendance = [];

    foreach ($users as $user) {
        // Get the user's attendance data for the day (if exists)
        $users_attendance = $attendances->get($user->id);

        // Set entry and exit times
        $attendance_entry = $users_attendance ? $users_attendance->entry : 'No Entry';
        $attendance_exit = $users_attendance && !empty($users_attendance->exit_time) 
                            ? Carbon::parse($users_attendance->exit_time)->format('H:i:s') 
                            : 'No Exit';

        $totalworkinhours = 0; // Default value for work hours

        if ($users_attendance) {
            $logintowork = $users_attendance->login;
            $worktimecomplete = $users_attendance->total_work;

            $loginTime = Carbon::parse($logintowork, $timeZone);
            $logoutTime = Carbon::parse($users_attendance->exit_time, $timeZone);
            
            // Calculate the time difference based on the current date and time
            if ($date === $currentDateTimeUSA->format('Y-m-d')) {
                if ($loginTime->lessThanOrEqualTo($logoutTime)) {
                    // If the login time is less than or equal to logout time, calculate the remaining work
                    $timeDifferenceInMinutes = $loginTime->diffInMinutes($currentDateTimeUSA);
                } else {
                    // If login time is greater than logout time, set remaining time to 0
                    $timeDifferenceInMinutes = 0;
                }
            } else {
                $timeDifferenceInMinutes = 0;
            }

            // Add the time difference to the total work time completed
            $totalWorkInMinutes = $worktimecomplete + $timeDifferenceInMinutes;
            $totalWorkHours = floor($totalWorkInMinutes / 60);
            $totalWorkRemainingMinutes = $totalWorkInMinutes % 60;

            $totalworkinhours = $totalWorkHours . ':' . str_pad($totalWorkRemainingMinutes, 2, '0', STR_PAD_LEFT);
        }

        // Build the user attendance data array
        $userAttendance[] = [
            'user' => $user,
            'user_name' => $user->name,
            'entry' => $attendance_entry,
            'exit' => $attendance_exit,
            'Remain_time' => $totalworkinhours,
        ];
    }

    // Return the view with the paginated users and their attendance data
    return view('admin/break/daily_record', [
        'userAttendance' => $userAttendance,
        'users' => $users
    ]);
}

    public function add_break_process(Request $req){

        $data = new Breaks();
        $data->name = $req->name;
        $data->duration = $req->duration;
        $data->status	 = 1;
        $data->added_by = $req->admin_id;
        $data->save();
        return redirect()->back()->with('success','Break added successfully');

    }

    public function UpdatebreakStatus($status, $idd, Request $req)
	{
			$id = base64_decode($idd);

				if ($status == "active") {
					$teamStatusInfo = [
						'status' => 0,
					];
					$TeamData = Breaks::where('id', $id)->first();
					$TeamData->update($teamStatusInfo);
				} else {
					$teamStatusInfo = [
						'status' => 1,
					];
					$TeamData = Breaks::where('id', $id)->first();
                  
					$TeamData->update($teamStatusInfo);
				}
            
				return Redirect()->route('break_view')->with('success', 'Status Updated Successfully.');
	}

    public function deletebreak($idd, Request $req)
	{
			$id = base64_decode($idd);


				$TeamData = Breaks::where('id', $id)->first();
				if (!empty($TeamData)) {
					$img = $TeamData->image;
					$TeamData->delete();
					return Redirect()->route('break_view')->with('success', 'break Deleted Successfully.');
				} else {
					return Redirect()->route('break_view')->with('error', 'Some Error Occurred.');
				}
	}

    public function updatetask(Request $req) {
        // Validate the incoming request
        $req->validate([
            'agent_id' => 'required|integer',
            'weektask' => 'nullable|integer', // Ensure weektask is an integer, if provided
            'monthtask' => 'nullable|integer', // Ensure monthtask is an integer, if provided
        ]);
    
        // Get the current date in US format
        $currentDateUS = Carbon::now('America/New_York');
    
        // Handle Weekly Task
        if ($req->weektask) {
            // Get the start of the current week (Monday as the start)
            $startOfWeek = $currentDateUS->startOfWeek()->format('Y-m-d');
    
            // Check if a weekly task already exists for this agent and week
            $weeklyTask = Task::where('agent_id', $req->agent_id)
                              ->where('week', $startOfWeek)
                              ->first();
    
            // If the weekly task exists, update it; otherwise, create a new entry
            if ($weeklyTask) {
                $weeklyTask->task = $req->weektask; // Update weekly task
                $weeklyTask->updated_at = $currentDateUS; // Update timestamp
                $weeklyTask->save();
            } else {
                // Create a new weekly task entry
                $weeklyTask = new Task();
                $weeklyTask->agent_id = $req->agent_id;
                $weeklyTask->week = $startOfWeek; // Store the week start date
                $weeklyTask->task = $req->weektask; // Store the weekly task
                $weeklyTask->created_at = $currentDateUS; // Store creation timestamp
                $weeklyTask->save();
            }
        }
    
        // Handle Monthly Task
        if ($req->monthtask) {
            // Get the start of the current month
            $startOfMonth = $currentDateUS->startOfMonth()->format('Y-m-d');
    
            // Check if a monthly task already exists for this agent and month
            $monthlyTask = Task::where('agent_id', $req->agent_id)
                               ->where('month', $startOfMonth)
                               ->first();
    
            // If the monthly task exists, update it; otherwise, create a new entry
            if ($monthlyTask) {
                $monthlyTask->task = $req->monthtask; // Update monthly task
                $monthlyTask->updated_at = $currentDateUS; // Update timestamp
                $monthlyTask->save();
            } else {
                // Create a new monthly task entry
                $monthlyTask = new Task();
                $monthlyTask->agent_id = $req->agent_id;
                $monthlyTask->month = $startOfMonth; // Store the month start date
                $monthlyTask->task = $req->monthtask; // Store the monthly task
                $monthlyTask->created_at = $currentDateUS; // Store creation timestamp
                $monthlyTask->save();
            }
        }
    
        // Optionally, return a response
        return response()->json(['message' => 'Task updated successfully']);
    }
      public function view_information(){
        $users = User::where('status',1)->wherenull('deleted_at')->where('is_active',1)->get();

        $currentDate = Carbon::now('America/New_York')->toDateString(); // Set to the US Eastern Time Zone
        $datas = Information::
                            where('duration', '>=', $currentDate)
                            ->get();
        return view('admin/information/view_add',compact('users','datas'));
    }
    public function store_information(Request $req){
        if($req->agent_id == "all"){
            $agent = null;
        }else{
            $agent = $req->agent_id ; 
        }
        $data = new Information();
        $data->agent_id = $agent;
        $data->text = $req->message;
        $data->duration =  $req->duration;
        $data->status = 1;
        $data->added_by = $req->id;
        $data->save();

        return redirect()->back();

    }
    public function Updateinformation(Request $req ,$status,$idd){
        $id = base64_decode($idd);
				if ($status == "active") {
					$teamStatusInfo = [
						'status' => 0,
					];
					$TeamData = Information::where('id', $id)->first();
					$TeamData->update($teamStatusInfo);
				} else {
					$teamStatusInfo = [
						'status' => 1,
					];
					$TeamData = Information::where('id', $id)->first();
					$TeamData->update($teamStatusInfo);
				}
				return Redirect()->back()->with('success', 'Status Updated Successfully.');

    }
     public function view_all_attendance(Request $req,$idd){
        $id = base64_decode($idd);

        $attandance  = Attendance::where('emp_id',$id)->latest('date')->paginate(30);
        $agent = User::where('id', $id)->first();
        return view('admin/break/view_all_attendance',compact('attandance','agent'));
    }
    
    
     public function viewsave_task(Request $req){
        return view('admin/tasks/add_task');
    }
    public function task_store(Request $request){
        $request->validate([
            'deadline_date' => 'required|date',
            'heading' => 'required|string|max:255',
            'agent_name' => 'required|string',
            'description' => 'required|string',
        ]);
        Task::create([
            'deadline' => $request->deadline_date,
            'heading' => $request->heading,
            'agent_id' => $request->agent_name,
            'description' => $request->description,
            'admin_id' => $request->admin_id,
            'status' => 1,
        ]);
    
        return redirect()->back()->with('success', 'Task added successfully!');
    }
    public function viewgived_task(Request $req){
        $tasks = Task::where('admin_id',session('admin_id'))->get();
 
        return view('admin/tasks/view_task',compact('tasks'));
    }
    public function viewmy_task(Request $req){
        $my_id = User::where('team_id',session('admin_id'))->first();
        $tasks = Task::where('agent_id',$my_id->id)->get();
 
        return view('admin/tasks/my_task',compact('tasks'));
    }
    public function delete_task(Request $req, $idd)
    {
        $id = base64_decode($idd);
    
        // Ensure the task exists before attempting to delete
        $task = Task::find($id);
    
        if (!$task) {
            return redirect()->back()->with('error', 'Task not found!');
        }
    
        $task->delete();
    
        return redirect()->back()->with('success', 'Task deleted successfully!');
    }
    
}