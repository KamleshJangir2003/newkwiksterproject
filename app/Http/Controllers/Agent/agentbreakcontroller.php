<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Break_detail;
use App\adminmodel\Breaks;
use App\Models\Attendance;
use App\adminmodel\Task;
use Carbon\Carbon;

class agentbreakcontroller extends Controller
{
    public function agent_break(Request $req){
     $datas = Breaks::where('status',1)->get();
        return view('Agent/breaks/view_breaks',compact('datas'));
    }

    public function start_break(Request $req)
    {
        // Validate the incoming request
        $req->validate([
            'id' => 'required|integer',
        ]);
    
        try {
            // Create a new Break_detail record
            $break = new Break_detail();
            $break->break_id = $req->id; // Set the break ID from the request
            $break->agent_id = session('agent_id'); // Get the agent ID from the session
            $break->time_use = 0; // Initialize time usage to 0 at the start
            $break->status = 0; // Set status to 0 (indicating break is ongoing)
    
            // Save the break record to the database
            $break->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Break started successfully!',
            ]);
        } catch (\Exception $e) {
            // Log any errors that occur
            \Log::error('Error starting break: ' . $e->getMessage());
    
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    public function complete_break_process(Request $req){

$req->validate([
    'id' => 'required|integer',
    'time' => 'required|integer', // Assuming 'time' is in seconds
]);


// Get the current date in US timezone (New York)
$currentdate = Carbon::now('America/New_York')->toDateString(); // Format as YYYY-MM-DD
$breakid = Breaks::where('id',$req->id)->first();
$timeInMinutes = $req->time / 60;
if($timeInMinutes > $breakid->duration){
    $attendance = Attendance::where('emp_id',session('agent_id'))->whereDate('created_at', $currentdate)->first();
    $reducetime = $attendance->total_work - ($timeInMinutes*2);
    $attendance->total_work = $reducetime;
    $attendance->save();
}else{
    $attendance = Attendance::where('emp_id',session('agent_id'))->whereDate('created_at', $currentdate)->first();
    $reducetime = $attendance->total_work - $timeInMinutes;
    $attendance->total_work = $reducetime;
    $attendance->save();

}
$break = Break_detail::where('break_id', $req->id)
    ->where('agent_id', session('agent_id'))
    ->whereDate('created_at', $currentdate)
    ->first();

if ($break) {
    $break->time_use = $timeInMinutes;
    $break->status = 1;
    $break->save();

    return response()->json([
        'success' => true,
        'message' => 'Break completed successfully!',
    ]);
} else {
    return response()->json([
        'success' => false,
        'message' => 'Break record not found!',
    ]);
}

    }
        public function view_agent_task(Request $req){
        $datas = Task::where('agent_id',Auth()->user()->id)->latest()->get();
        return view('Agent/breaks/view_tasks',compact('datas'));
    }
    public function statu_agent_task(Request $req, $idd)
{
    $id = base64_decode($idd);

    // Fetch the task
    $task = Task::find($id);

    if (!$task) {
        return redirect()->back()->with('error', 'Task not found!');
    }

    // Update the status to 2
    $task->status = 2;
    $task->save();

    return redirect()->back()->with('success', 'Task status updated successfully!');
}


}