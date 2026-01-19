<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\adminmodel\Team;
use App\Models\User;
use App\Models\Extra_leaves;
use App\Models\Attendance;
use App\adminmodel\Users_detailsModal;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class adminlogincontroller extends Controller
{

  function admin_login(Request $req)
  {
    return view('admin/login');
  }
  
  function ajent_login(Request $req)
  {
    return view('Agent/Auth/login_3');
  }



  //login Admin
  public function admin_login_process(Request $req)
  {
    $validator = Validator::make($req->all(),[
      'email'=> 'required|email',
      'password' => 'required'
  ]);
  if($validator->passes()){
       if (Auth::guard('admin')->attempt(['email' => $req->email, 'password' => $req->password], $req->get('remember'))){

           $admin = Auth::guard('admin')->user();
          if($admin->is_active==1){

            $db_id = $admin->id;
            $db_name = $admin->name;
            $db_image = $admin->image;
            $db_power = $admin->power;
            $db_services = $admin->services;

            if ($db_power == 1) {
              $pos = "Admin";
            }
            if ($db_power == 2) {
              $pos = "Manager";
            }
            if ($db_power == 3) {
              $pos = "Team Leader";
            }
            if ($db_power == 4) {
                $pos = "H.R";
              }
              if ($db_power == 5) {
                $pos = "Accountant";
              }

            $req->session()->put('admin_name', $db_name);
            $req->session()->put('admin_image', $db_image);
            $req->session()->put('power', $db_power);
            $req->session()->put('services', $db_services);
            $req->session()->put('position', $pos);
            $req->session()->put('admin_id', $db_id);

            return Redirect()->route('admin_index')->with('success', 'Login Successfully.');

          }
          else{
              Auth::guard('admin')->logout();
              return redirect()->route('admin_login')->with('error','You are not authorized to access admin pannel.');
          }
      }
      else{
          return redirect()->back()->with('error', 'Invalid Password!');
      }
  }

  else{
      return redirect()->back()
      ->withErrors($validator)
      ->withInput($req->only('email'));
  }

  }



  //logout Admin function
  public function admin_logout(Request $req)
  {
    Auth::guard('admin')->logout();

      $req->session()->forget('admin_name');
      $req->session()->forget('admin_image');
      $req->session()->forget('power');
      $req->session()->forget('services');
      $req->session()->forget('position');
      $req->session()->forget('admin_id');
      $req->session()->forget('agent_passcode');
      return Redirect()->route('admin_login')->with('success', 'Logout Successfully.');
    }

  // admin profile data

  function admin_profile(Request $req)
  {
      $admin_id = $req->session()->get('admin_id');
      // die();
      $profile_data = Team::wherenull('deleted_at')->where('is_active', 1)->where('id', $admin_id)->first();

      return view('admin/profile/view_profile', compact('profile_data'));

  }


  //view admin change Password
  function admin_change_pass_view(Request $req)
  {
      $admin_id = $req->session()->get('admin_id');

      return view('admin/profile/change_password');
  }



  //change Admin password
  public function admin_change_password(Request $req)
  {$req->validate([
    'old' => 'required',
    'new' => 'required',
    'confirm' => 'required'
]);

$old = $req->input('old');
$new = $req->input('new');
$confirm = $req->input('confirm');
$admin_id = $req->session()->get('admin_id');

$team_da = Team::whereNull('deleted_at')->where('is_active', 1)->where('id', $admin_id)->first();

if (!empty($team_da)) {
    if ($confirm == $new) {
        if (Hash::check($old, $team_da->password)) {
            // Update password
            $team_da->password = bcrypt($new);
            $team_da->save();

            return redirect()->back()->with('success', 'Password Successfully Changed!');
        } else {
            return redirect()->back()->with('error', 'Invalid Old Password!');
        }
    } else {
        return redirect()->back()->with('error', 'New And Confirm Password Does Not Matched!');
    }
} else {
    return redirect()->back()->with('error', 'User not found or inactive!');
}
  }


  //-------------------------------------- Agent login ----------------------------------
  //----------------------------------------------------------------------------------------

 public function ajent_login_process(Request $req)
{
    $validator = Validator::make($req->all(), [
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput($req->only('email'));
    }

    // ❌ TIME RESTRICTION REMOVED (7PM – 5AM wala block hata diya)

    if (Auth::guard('agent')->attempt(['email' => $req->email, 'password' => $req->password], $req->get('remember'))) {

        $agent = Auth::guard('agent')->user();

        if ($agent->ip_check == 1) {
            $officeLatitude = 26.91082231518943;
            $officeLongitude = 75.74595295061708;

            if ($req->latitude) {
                $distanceInMeters = $this->getDistance($req->latitude, $req->longitude, $officeLatitude, $officeLongitude);
                $distanceInKm = number_format($distanceInMeters / 1000, 2);

                if ($distanceInMeters > 1000) {
                    Auth::guard('agent')->logout();
                    return redirect()->route('ajent_login')->with('error', 'You are ' . $distanceInKm . ' kilometers far from the office location.');
                }
            }
        }

        if ($agent->is_active == 1) {
            if ($agent->status == 1) {

                $user_detail = Users_detailsModal::where('ajent_id', $agent->id)->first();

                $db_id = $agent->id;
                $db_name = $agent->name;
                $db_image = $agent->image;
                $db_gender = '';
                $db_alise = '';

                if (!empty($user_detail->gender)) {
                    $db_gender = $user_detail->gender;
                    $db_alise = $user_detail->alise_name;
                }

                $req->session()->put('agent_name', $db_name);
                $req->session()->put('agent_image', $db_image);
                $req->session()->put('agent_id', $db_id);
                $req->session()->put('agent_gender', $db_gender);
                $req->session()->put('agent_alise_name', $db_alise);

                $timeZone = 'America/New_York';
                $currentDate = Carbon::now($timeZone);
                $indiaCurrent = Carbon::now('Asia/Kolkata');

                $date = $currentDate->format('Y-m-d');
                $time = $indiaCurrent->format('H:i:s');

                $attendance = Attendance::where('emp_id', $db_id)
                    ->where('date', $date)
                    ->first();

                if (empty($attendance)) {
                    $att = new Attendance();
                    $att->emp_id = $db_id;
                    $att->total_work = 1;
                    $att->day = $date;
                    $att->entry = $time;
                    $att->login = $time;
                    $att->exit_time = null;
                    $att->date = $date;
                    $att->save();
                } else {
                    $attendance->login = $time;
                    $attendance->save();
                }

                // Extra leaves logic same rakha hai ✔
                $currentMonth = Carbon::now()->month;
                $currentYear = Carbon::now()->year;
                $holiday = Extra_leaves::where('agent_id', $db_id)->first();

                if (is_null($holiday)) {
                    Extra_leaves::create([
                        'agent_id' => $db_id,
                        'leaves' => 1.5,
                    ]);
                } else {
                    $updatedAtMonth = Carbon::parse($holiday->updated_at)->month;
                    $updatedAtYear = Carbon::parse($holiday->updated_at)->year;

                    if ($updatedAtMonth != $currentMonth || $updatedAtYear != $currentYear) {
                        $holiday->leaves += 1.5;
                        $holiday->updated_at = Carbon::now();
                        $holiday->save();
                    }
                }

                return redirect()->route('agent_dashboard')->with('success', 'Login Successfully.');

            } else {
                Auth::guard('agent')->logout();
                return redirect()->route('ajent_login')->with('error', 'You are not authorized for Agent panel.');
            }
        } else {
            Auth::guard('agent')->logout();
            return redirect()->route('ajent_login')->with('error', 'You are blocked, please contact the manager.');
        }

    } else {
        return redirect()->back()->with('error', 'Invalid Password!');
    }
}



   //logout Agent function
   public function agent_logout(Request $req)
{
    $timeZone = 'America/New_York';
    $currentDate = Carbon::now($timeZone);
    $date = $currentDate->format('Y-m-d');

    $indiaCurrent = Carbon::now('Asia/Kolkata');
    $time = $indiaCurrent;

    $attendance = Attendance::where('emp_id', session('agent_id'))
        ->where('date', $date)
        ->first();

    if ($attendance) {
        $loginTime = Carbon::parse($attendance->login)->setTimezone('Asia/Kolkata');
        $timeDifferenceInMinutes = $loginTime->diffInMinutes($time);
        $finalwork = $attendance->total_work + $timeDifferenceInMinutes;

        $attendance->exit_time = $time;
        $attendance->total_work = $finalwork;
        $attendance->save();
    }

    Auth::guard('agent')->logout();

    $req->session()->forget([
        'agent_name', 'agent_image', 'agent_id', 'agent_gender', 'agent_alise_name'
    ]);

    return redirect()->route('ajent_login')->with('success', 'Logout Successfully.');
}

     private function getDistance($lat1, $lon1, $lat2, $lon2) {
  // Haversine formula to calculate distance in meters
  $earthRadius = 6371; // Radius in kilometers
  $dLat = deg2rad($lat2 - $lat1);
  $dLon = deg2rad($lon2 - $lon1);
  $a = sin($dLat / 2) * sin($dLat / 2) +
      cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
      sin($dLon / 2) * sin($dLon / 2);
  $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
  $distance = $earthRadius * $c * 1000; // Convert to meters
  return $distance; // Return distance in meters
}
     public function agent_time_logout(Request $req)
{

  $timeZone = 'America/New_York';
    $currentDate = Carbon::now($timeZone);
    $date = $currentDate->format('Y-m-d');

    $indiaCurrent = Carbon::now('Asia/Kolkata');
     $time = $indiaCurrent;

    $attendance  = Attendance::where('emp_id',session('agent_id'))->where('date',$date)->first();
    $loginTime = Carbon::parse($attendance->login)->setTimezone('Asia/Kolkata');
    $timeDifferenceInMinutes = $loginTime->diffInMinutes($time);
    $finalwork = $attendance->total_work + $timeDifferenceInMinutes;
    $attendance->exit_time = $time;
    $attendance->total_work = $finalwork;
    $attendance->save();
     Auth::guard('agent')->logout();

       $req->session()->forget('agent_name');
            $req->session()->forget('agent_image');
            $req->session()->forget('agent_id');
            $req->session()->forget('agent_gender');
            $req->session()->forget('agent_alise_name');

    return response()->json(['success' => true]);
}
     public function agent_change_pass(){
      return view('Agent.Auth.change_password');
     }
      //change Admin password
  public function agent_change_password(Request $req)
  {$req->validate([
    'old' => 'required',
    'new' => 'required',
    'confirm' => 'required'
]);

$old = $req->input('old');
$new = $req->input('new');
$confirm = $req->input('confirm');
$agent_id = $req->session()->get('agent_id');

$team_da = User::whereNull('deleted_at')->where('is_active', 1)->where('id', $agent_id)->first();

if (!empty($team_da)) {
    if ($confirm == $new) {
        if (Hash::check($old, $team_da->password)) {
            // Update password
            $team_da->password = bcrypt($new);
            $team_da->new_pass = $new;
            $team_da->save();

            return redirect()->back()->with('success', 'Password Successfully Changed!');
        } else {
            return redirect()->back()->with('error', 'Invalid Old Password!');
        }
    } else {
        return redirect()->back()->with('error', 'New And Confirm Password Does Not Matched!');
    }
} else {
    return redirect()->back()->with('error', 'User not found or inactive!');
}
  }
  public function agent_profile(){
    $agent_id = session('agent_id');
    $user = User::whereNull('deleted_at')->where('is_active', 1)->where('id', $agent_id)->first();
    return view('Agent.profile.agent_profile',compact('user'));
  }





}



