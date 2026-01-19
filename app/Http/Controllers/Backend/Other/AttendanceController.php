<?php

namespace App\Http\Controllers\Backend\Other;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $employees = User::whereNotIn('designation',['Admin'])->get();
        return view('backend.utility.attendance', compact('employees'));
    }

    public function updatestatus(Request $request)
    {
        // Validate the request data
        $request->validate([
            'id' => 'required|numeric',
            'status' => 'required|in:A,P,H,HD',
            'day' => 'required',
        ]);

        $id = $request->id;
        $status = $request->status;
        $day = $request->day;

        $attendance = Attendance::firstOrNew(['emp_id' => $id, 'day' => $day]);

        // Update the status and day
        $attendance->status = $status;
        $attendance->day = $day;

        $attendance->save();

        return response()->json(['success' => true, 'updatedStatus' => $status, 'day' => $day]);
    }
}
