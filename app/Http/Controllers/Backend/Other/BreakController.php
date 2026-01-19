<?php

namespace App\Http\Controllers\Backend\Other;

use App\Http\Controllers\Controller;
use App\Models\breaks;
use App\Models\login_logout;
use App\Models\User;
use Illuminate\Http\Request;

class BreakController extends Controller
{
    public function storeBreakTime(Request $request)
    {
        $userId = auth()->user()->id;
        $hours = $request->hours;
        $minutes = $request->minutes;
        $seconds = $request->seconds;

        // Check when the last break was created or updated
        $lastBreak = breaks::where('user_id', $userId)->latest()->first();

        // Check if a new record should be inserted or existing one updated
        if (!$lastBreak || now()->diffInHours($lastBreak->created_at) >= 23) {
            // Create a new breaks record
            $breaks = new breaks();
        } else {
            // Update the existing breaks record
            $breaks = $lastBreak;
        }

        // Set break type based on the request
        if ($request->breaks == 'Dinner Break') {
            $breaks->dinner_break = 'Y';
            $breaks->tea_break = 'N';
            $breaks->short_break = 'N';
            $breaks->training_break = 'N';
            $breaks->meeting_break = 'N';
        } else {
            // Set specific break types based on the request
            if ($request->breaks == 'Tea Break') {
                $breaks->tea_break = 'Y';
            } elseif ($request->breaks == 'Short Break') {
                $breaks->short_break = 'Y';
            } elseif ($request->breaks == 'Training Break') {
                $breaks->training_break = 'Y';
            } elseif ($request->breaks == 'Meeting Break') {
                $breaks->meeting_break = 'Y';
            }
        }

        // Set common fields
        $breaks->user_id = $userId;
        $breaks->hours = $hours;
        $breaks->minutes = $minutes;
        $breaks->seconds = $seconds;
        $breaks->status = 'Y';

        // Save the breaks record
        $breaks->save();

        // Update logout time
        $agent = login_logout::where('user_id', $userId)->latest()->first();
        if ($agent) {
            $agent->logout_time = now();
            $agent->save();
        }

        return response()->json(['status' => 'success']);
    }
}
