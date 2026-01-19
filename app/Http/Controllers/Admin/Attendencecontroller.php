<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\adminmodel\Team;
use App\adminmodel\Users_detailsModal;
use App\adminmodel\AdminSidebar;
use App\adminmodel\AdminSidebar2;
use App\adminmodel\Holidays;
use App\adminmodel\Time_credit;
use App\adminmodel\SalaryModal;
use App\Models\User;
use App\Models\Leaves;
use App\Models\Attendance;
use App\Models\Salary_cycle;
use App\Models\Extra_leaves;
use App\Models\Bonus;
use App\Models\salary;
use Carbon\Carbon;
use DateTime; 
use DateInterval;
use DatePeriod;
use App\Events\UserNotification;
use App\Models\Notification;
class Attendencecontroller extends Controller
{
    public function view_holidays(Request $req)
	{

        $holidays = Holidays::paginate(10);
			return view('admin/attendence/holiday',compact('holidays'));
	}
    public function store_holidays(Request $req){
        $data = new Holidays();
        $data->name = $req->name;
        $data->date = $req->date;
        $data->save();

        return redirect()->back();
    }
    public function delete_holidays(Request $req,$id){
      
        $id = base64_decode($id);
        $data =  Holidays::find($id);
        $data->delete();
        return redirect()->back();
    }
    public function view_calender(Request $req)
	{
         $salary_cycle = Salary_cycle::get()->first();
        $agents = User::where('status',1)->get();
			return view('admin/attendence/calender',compact('agents','salary_cycle'));
	}
    public function view_time_credit(Request $req)
	{
        $currentDate = Carbon::now()->toDateString();
        $users = User::where('status',1)->wherenull('deleted_at')->where('is_active',1)->get();
        $times = Time_credit::where('date',$currentDate)->get();
       
			return view('admin/attendence/time_credit',compact('times','users'));
	}
    public function store_time_credit(Request $req){
        $currentDate = Carbon::now()->toDateString();

        $time_credit = Time_credit::where('agent_id',$req->agent_id)->where('date',$currentDate)->first();
        if(empty($time_credit))
        {
            $data = new Time_credit();
        $data->agent_id = $req->agent_id;
        $data->time = $req->time;
        $data->date = $currentDate;
        $data->save();
        $userattendence = Attendance::where('emp_id',$req->agent_id)->where('date',$currentDate)->first();
        $worktime = $userattendence->total_work;
        $userattendence->total_work = $worktime+$req->time;
        $userattendence->save();
        }
        else{
             $data = new Time_credit();
        $data->agent_id = $req->agent_id;
        $data->time = $req->time;
        $data->date = $currentDate;
        $data->save();
        $userattendence = Attendance::where('emp_id',$req->agent_id)->where('date',$currentDate)->first();
        $worktime = $userattendence->total_work;
        $userattendence->total_work = $worktime+$req->time;
        $userattendence->save();
        }

       

        return redirect()->back();
    }
    public function delete_time_credit(Request $req,$id){
      
        $id = base64_decode($id);
        $data =  Time_credit::find($id);
        $userattendence = Attendance::where('emp_id',$data->agent_id)->where('date',$data->date)->first();
        $worktime = $userattendence->total_work;
        $userattendence->total_work = $worktime-$data->time;
        $userattendence->save();
        $data->delete();
        return redirect()->back();
    }
    public function view_leave_request($n=''){
        if(!empty($n)){
            $noti = Notification::where('id',$n)->first();
            $noti->click_id = 2;
            $noti->save();
        }
		$leaves = Leaves::where('status',1)->get();
		return view('admin/attendence/view_leave_request',compact('leaves'));
	}
    public function leave_request_status(Request $req, $id ,$status){

          $id = base64_decode($id);
          $status = base64_decode($status);
          $leaves = Leaves::where('id',$id)->first();
          $leaves->status =  $status;
          $leaves->save();

       if($status == 2){
        $message = "Approved";
       }
       else{
        $message = "Declined";
       }
         
          $data = new Notification();
      $data->agent_id = $leaves->agent_id;
      $data->type = "leave";
      $data->heading = "Leave Update";
      $data->massage = "Your Leave Request is ".$message;
      $data->click_id = 1;
      $data->save();

      $data = [
          'massage'=>'Your Leave Request is '.$message,
          'user_id'=>$leaves->agent_id,
      ];

    event(new UserNotification($data));

    session()->flash('success','status update successfully');
    return redirect()->back();
         
    }

    public function get_attendance(Request $req)
{
    $userId = $req->input('user_id');
    $date = $req->input('date');

    $year = date('Y', strtotime($date));
    $month = date('m', strtotime($date));
    $currentDate = Carbon::now()->format('Y-m-d');
    // Get all attendance records for the user for the given month
    $attendanceRecords = Attendance::where('emp_id', $userId)
                                    ->whereYear('date', $year)
                                    ->whereMonth('date', $month)
                                    ->get();

    // Get all holidays for the given month
    $holidays = Holidays::whereYear('date', $year)
                        ->whereMonth('date', $month)
                        ->get();

    // Create associative arrays with dates as keys for easy lookup
    $attendanceByDate = [];
    foreach ($attendanceRecords as $record) {
        $attendanceDate = Carbon::parse($record->date)->format('Y-m-d');
        $attendanceByDate[$attendanceDate] = $record;
    }

    $holidaysByDate = [];
    foreach ($holidays as $holiday) {
        $holidayDate = Carbon::parse($holiday->date)->format('Y-m-d');
        $holidaysByDate[$holidayDate] = $holiday->name;
    }

    $events = [];
    

    // Generate all dates for the given month
    $startOfMonth = new DateTime("$year-$month-01");
    $endOfMonth = clone $startOfMonth;
    $endOfMonth->modify('last day of this month');

    $interval = new DateInterval('P1D');
    $dateRange = new DatePeriod($startOfMonth, $interval, $endOfMonth->modify('+1 day'));

    foreach ($dateRange as $date) {
        $formattedDate = $date->format('Y-m-d');
        $isSunday = $date->format('w') == 0; // Check if the date is Sunday

        if (isset($attendanceByDate[$formattedDate])) {
            $record = $attendanceByDate[$formattedDate];
            $attendanceStatus = '';

            if ($record->total_work >= 460) {
                $attendanceStatus = 'Present';
            } elseif ($record->total_work >= 230) {
                $attendanceStatus = 'Half Day';
            } elseif ($record->total_work == 0) {
                $attendanceStatus = 'Paid Leave';
            } else {
                $attendanceStatus = 'Absent';
            }
            $classNames = [];

            if ($attendanceStatus == 'Present') {
                $classNames[] = 'fc-event-green'; // Green color
            } elseif ($attendanceStatus == 'Half Day') {
                $classNames[] = 'fc-event-yellow'; // Yellow color
            } elseif ($attendanceStatus == 'Absent') {
                $classNames[] = 'fc-event-red'; // Red color
            }
            elseif ($attendanceStatus == 'Paid Leave') {
                $classNames[] = 'fc-event-begani'; // Red color
            }

            $events[] = [
                'title' => $attendanceStatus,
                'start' => $formattedDate,
                'end' => $formattedDate,
                'classNames' => $classNames
            ];
        }

        if (isset($holidaysByDate[$formattedDate])) {
            // Holiday found for this date
            $events[] = [
                'title' => $holidaysByDate[$formattedDate],
                'start' => $formattedDate,
                'end' => $formattedDate,
                'classNames' => ['fc-event-blue'] // Blue color for holidays
            ];
        }

        if (!isset($attendanceByDate[$formattedDate]) && !isset($holidaysByDate[$formattedDate]) && $formattedDate <= $currentDate && !$isSunday) {
            // No entry found for this date, it is not a holiday, not a Sunday, and not in the future, mark as Absent
            $events[] = [
                'title' => 'Absent',
                'start' => $formattedDate,
                'end' => $formattedDate,
                'classNames' => ['fc-event-red'] // Red color
            ];
        }
    }

    //--------------------------------------------------counts---------------------------------------
    $present =  Attendance::where('emp_id', $userId)
      ->whereMonth('date', $month)
      ->whereYear('date', $year)
      ->where('total_work', '>=', 460)
      ->count();

      $paidleave = Attendance::where('emp_id', $userId)
      ->whereMonth('date', $month)
      ->whereYear('date', $year)
      ->where('total_work', 0) 
      ->count();

      $Halfday = Attendance::where('emp_id', $userId)
    ->whereMonth('date', $month)
    ->whereYear('date', $year)
    ->where('total_work', '>=', 230)
    ->where('total_work', '<', 460)
    ->count();

      //----------------absent-----------

      $currentMonth = Carbon::now()->format('m');
      $endOfMonthDate = Carbon::createFromDate($year, $month, 1)->endOfMonth()->format('Y-m-d');
      if($month  == $currentMonth ){
        $fetchdate = $currentDate;  
      }else{
          $fetchdate = $endOfMonthDate;  
      }
      // Get all attendance records for the current month up to today
      $attendances =  Attendance::where('emp_id', $userId)
          ->whereBetween('date', [$startOfMonth, $fetchdate])
          ->get()
          ->groupBy(function($date) {
              return Carbon::parse($date->date)->format('Y-m-d');
          });
      // Initialize counters
      $absentCount = 0;
      $lessWorkCount = 0;
     
      $startDate = Carbon::parse($startOfMonth);
      $currentDateObj = Carbon::parse($fetchdate);
      // Iterate through each date from the start of the month to today
      for ($date = $startDate; $date->lessThanOrEqualTo($currentDateObj); $date->addDay()) {
          $formattedDate = $date->format('Y-m-d');
  
          if (!isset($attendances[$formattedDate])) {
              // No attendance record for this date
              $absentCount++;
          } else {
              // Check if total_work is less than 240 minutes
              foreach ($attendances[$formattedDate] as $attendance) {
                  if ($attendance->total_work < 230 && $attendance->total_work > 0) {
                      $lessWorkCount++;
                      break; // Move to the next date after finding a record with less work time
                  }
              }
          }
      }
  //---------------------------- holidays--------------------------------------  
  // Query to count holidays between start of month and current date
  $holidaysCount = Holidays::whereYear('date', $year)
      ->whereMonth('date', $month)
      ->whereBetween('date', [$startOfMonth, $currentDate])
      ->count();

      $startOfMonth = Carbon::parse($startOfMonth);
      $fetchdate = Carbon::parse($fetchdate);

      $sundayCount = 0;
      // Iterate through each day from the start of the month to the current date
     for ($date = $startOfMonth; $date->lte($fetchdate); $date->addDay()) {
    // Check if the day is a Sunday (Carbon uses 0 for Sunday)
    if ($date->dayOfWeek == Carbon::SUNDAY) {
        $sundayCount++;
    }
}
         $absent = $absentCount+$lessWorkCount - $holidaysCount -  $sundayCount;       
  //-------------------------------------------
  $leaves = Extra_leaves::where('agent_id',$userId)->first();

  $remain_leave = !empty($leaves->leaves) ? $leaves->leaves : 0;

 
  $bonus_check = Bonus::where('agent_id', $userId)
                   ->whereYear('updated_at', $year)
                   ->whereMonth('updated_at', $month)
                   ->first();
    
   $advance = !empty($bonus_check->advance) ? $bonus_check->advance : 0;
   $bonus = !empty($bonus_check->bonus) ? $bonus_check->bonus : 0;

   $adherence = SalaryModal::where('ajent_id',$userId)->first();
   $adherence_salary = !empty($adherence->type) ? (float) $adherence->type : 0;
   $attendanceData = $this->salary_calculate($userId, $date);

    $salary = [
        'start' => $attendanceData['startdate'],
        'end' => $attendanceData['Enddate'],
         'halfday' => $attendanceData['halfday'],
         'present' => $attendanceData['present'],
         'paidleave' => $attendanceData['paidleave'],
         'sunday' => $attendanceData['sunday'],
         'holidays' => $attendanceData['Holidays'],
         'advance' => $attendanceData['advance'],
         'bonus' => $attendanceData['bonus'],
         // Optionally include other data like per day salary
         'perdaysalary' => $attendanceData['perdaysalary'],
         'totalsalary' => $attendanceData['totalsalary'],
         'finalsalary' => $attendanceData['totalsalary']+$adherence_salary,
         
    ];

    $counts = [
       'present' => $present,
        'absent' => $absent,
        'halfday' => $Halfday,
        'paidleave' => $paidleave,
         'advance' => $advance,
         'bonus' => $bonus,
         'available_paid' => $remain_leave,
         'adherence' => $adherence_salary,
    ];

    return response()->json([
        'events'=>$events,
        'counts'=>$counts,
        'salary'=>$salary
    ]);
}

    public function update_attendence_calender(Request $req){

        $dateString = $req->input('date');
        $status = $req->input('attendance');
        $user_id = $req->input('agent_user_id');
      
        // Remove the timezone part for parsing
         $dateStringWithoutTimeZone = preg_replace('/\s*\(.*\)$/', '', $dateString);

       // Use DateTime to parse and format the date correctly
      $date = new DateTime($dateStringWithoutTimeZone);
 
       $formattedDate = $date->format('Y-m-d');

   if($status == 'present'){
      $total_work = 452;
   }elseif($status == 'halfday'){
    $total_work = 227;
   }elseif($status == 'paid'){
    $leaves = Extra_leaves::where('agent_id',$user_id)->first();
   if(!empty($leaves)){
    $remain = $leaves->leaves - 1 ;
    $leaves->leaves =  $remain;
    $leaves->save();
   }
    $total_work = 0;
   }else{
    $total_work = 100;
   }
      $attendance = Attendance::where('emp_id', $user_id)
        ->whereDate('date', $formattedDate)
         ->first();
       
             if(empty($attendance)){
                $new_atten = new Attendance();
                $new_atten->emp_id = $user_id;
                $new_atten->total_work = $total_work;
                $new_atten->day = $formattedDate;
                $new_atten->date = $formattedDate;
                $new_atten->save();
             }else{
                if($status == 'none'){
                    $attendance->delete(); 
                }else
                {$attendance->total_work = $total_work;
                $attendance->save();}
             }

             return response()->json([
                'success'=>'status changed successfully'
             ]);

    }

  
    public function store_salary_cycle(Request $req){
           $start_date = $req->Start_day; 
           $start_date_parts = explode(' ', $start_date);
           $end_date = $req->end_day; 
           $end_date_parts = explode(' ', $end_date);

          $cycle =  Salary_cycle::where('id',1)->first();

          $cycle->start_date = $start_date_parts[0];
          $cycle->end_date = $end_date_parts[0];

          $cycle->save();

          return redirect()->back();

           
    }

    public function edit_salary_datas(Request $req){
        $type = $req->type;
        $User_id = $req->agent_id;
        $Userinput = $req->Userinput;

        $month = Carbon::now()->startOfMonth(); // Get the start of the current month
         if($type == "available"){
              $leaves = Extra_leaves::where('agent_id',$User_id)->first();
              $remaining = $leaves->leaves ;
              $leaves->leaves = $remaining + $Userinput;
              $leaves->save();

              $final_value = $leaves->leaves;
         }
     $date = Carbon::now()->toFormattedDateString();
         $cycle = Salary_cycle::where('id',1)->first();
        $start = $cycle->start_date;
        $end = $cycle->end_date;
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        $previousMonth = date('m', strtotime('-1 month', strtotime($date)));

         $StartofMonth = new DateTime("$year-$previousMonth-$start");
         $EndOfMonth = new DateTime("$year-$month-$end");

         if($type == "bonus"){
          
   if(!empty($Userinput))
    {
        $bonus_check = Bonus::where('agent_id', $User_id)
        ->whereBetween('updated_at', [$StartofMonth, $EndOfMonth])
                        ->first();

    if ($bonus_check) {
      if(!empty( $bonus_check->bonus)){
        $bonus_check->bonus = $bonus_check->bonus + $Userinput; 
      }else{
        $bonus_check->bonus = $Userinput; 
      }
        $bonus_check->save();
    } else {
        // If no entry exists for the current month, create a new entry
        $bonus_check = Bonus::create([
            'agent_id' => $User_id,
            'bonus' => $Userinput, // Replace $newBonusValue with the initial bonus amount
        ]);
    }
    $final_value = $bonus_check->bonus;
 }

       }
       if($type == "advance"){
          
        if(!empty($Userinput))
         {
             $bonus_check = Bonus::where('agent_id', $User_id)
                        ->whereBetween('updated_at', [$StartofMonth, $EndOfMonth])
                        ->first();
     
         if ($bonus_check) {
           if(!empty( $bonus_check->advance)){
             $bonus_check->advance = $bonus_check->advance + $Userinput; 
           }else{
             $bonus_check->advance = $Userinput; 
           }
             $bonus_check->save();
         } else {
             // If no entry exists for the current month, create a new entry
             $bonus_check = Bonus::create([
                 'agent_id' => $User_id,
                 'bonus' => $Userinput, // Replace $newBonusValue with the initial bonus amount
             ]);
         }
         $final_value = $bonus_check->advance;
      }
     
            }
         return response()->json([
            'final_value'=>$final_value
         ]);
        

    }

    private function salary_calculate($agentId,$date){
        $salary_permonth = salary::where('ajent_id',$agentId )->first();
       if(!empty($salary_permonth->amount))
           {
            $salaryPerMonth = $salary_permonth->amount;
           } else{
               $salaryPerMonth = 0; 
           }
       
       //----------------per day salary-------------------
       $perdaysalary =  $salaryPerMonth*12/365;
///---------------------------attendence ----------------------
        $cycle = Salary_cycle::where('id',1)->first();
        $start = $cycle->start_date;
        $end = $cycle->end_date;
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        $previousMonth = date('m', strtotime('-1 month', strtotime($date)));

        $StartofMonth = new DateTime("$year-$previousMonth-$start");
        $EndOfMonth = new DateTime("$year-$month-$end");
        
        // Format the dates to the appropriate format
        $StartofMonthFormatted = $StartofMonth->format('Y-m-d');
        $EndOfMonthFormatted = $EndOfMonth->format('Y-m-d');
       
         $bonus_check = Bonus::where('agent_id', $agentId)
         ->where('created_at', '>=', $StartofMonthFormatted)
         ->where('created_at', '<=', $EndOfMonthFormatted)
      ->first();

         $present = Attendance::where('emp_id', $agentId)
         ->where('date', '>=', $StartofMonthFormatted)
         ->where('date', '<=', $EndOfMonthFormatted)
         ->where('total_work', '>=', 450)
         ->count();

      $paidleave = Attendance::where('emp_id', $agentId)
      ->where('date', '>=', $StartofMonthFormatted)
         ->where('date', '<=', $EndOfMonthFormatted)
      ->where('total_work', 0) 
      ->count();

      $Halfday = Attendance::where('emp_id', $agentId)
      ->where('date', '>=', $StartofMonthFormatted)
         ->where('date', '<=', $EndOfMonthFormatted)
      ->where('total_work', '>=', 225)
      ->where('total_work', '<', 450)
      ->count();

      $attendance = Attendance::where('emp_id', $agentId)
      ->where('date', '>=', $StartofMonthFormatted)
      ->where('date', '<=', $EndOfMonthFormatted)
        ->pluck('date') // Pluck the 'date' column from attendance records
        ->toArray(); // Convert the collection to array for easier comparison


        $currentDate = Carbon::now()->toDateString(); 
        if (Carbon::parse($currentDate)->lte(Carbon::parse($EndOfMonth))) {
          $fetchdate = Carbon::parse($currentDate);
      } else {
          $fetchdate = $EndOfMonth;
      }
     // Count holidays that have corresponding attendance entries
      $holidaysCount = Holidays::where('date', '>=', $StartofMonthFormatted)
      ->where('date', '<=', $EndOfMonthFormatted)
      ->pluck('date') // Pluck the 'date' column from attendance records
      ->toArray();
      $holidaysWithAttendance = 0;

      // Loop through each holiday date
      foreach ($holidaysCount as $holiday) {
          $holidayDate = Carbon::parse($holiday);
          $countFound = 0;
      
          // Check the previous 3 dates before the holiday date
          for ($i = 1; $i <= 3; $i++) {
            $previousDate = $holidayDate->copy()->subDays($i)->toDateString();
      
              if (in_array($previousDate, $attendance)) {
                  $countFound++;
              }
          }
      
          // If any of the previous 3 dates are found in $attendance, count this holiday
          if ($countFound > 0) {
              $holidaysWithAttendance++;
          }
      }

      $sundays = [];

     
      $StartofMonth = Carbon::parse($StartofMonth);
      $EndOfMonth = Carbon::parse($EndOfMonth);

     for ($date = $StartofMonth; $date->lte($fetchdate); $date->addDay()) {
    // Check if the day is a Sunday (Carbon uses 0 for Sunday)
    if ($date->dayOfWeek == Carbon::SUNDAY) {
        $sundays[] = $date->toDateString();
    }
    }

    $sunday_count = 0;

      // Loop through each holiday date
      foreach ($sundays as $sunday) {
          $holidayDate = Carbon::parse($sunday);
          $countFound = 0;
      
          // Check the previous 3 dates before the holiday date
          for ($i = 1; $i <= 3; $i++) {
            $previousDate = $holidayDate->copy()->subDays($i)->toDateString();
      
              if (in_array($previousDate, $attendance)) {
                  $countFound++;
              }
          }
      
          // If any of the previous 3 dates are found in $attendance, count this holiday
          if ($countFound > 0) {
              $sunday_count++;
          }
      }

      

      $bonus = !empty($bonus_check->bonus) ? $bonus_check->bonus : 0 ;
      $advance = !empty($bonus_check->advance) ? $bonus_check->advance : 0 ;

      $total_salary = ($present*$perdaysalary)+($paidleave*$perdaysalary) + ($holidaysWithAttendance*$perdaysalary) + ($sunday_count*$perdaysalary) + ($Halfday*$perdaysalary/2) + $bonus - $advance;
      return [
        'startdate'=>$StartofMonth,
        'Enddate'=>$EndOfMonth,
         'present' => $present,
         'paidleave' => $paidleave,
         'halfday' => $Halfday,
         'Holidays' => $holidaysWithAttendance,
         'sunday' => $sunday_count,
         'bonus' => $bonus,
         'advance' => $advance,
         'perdaysalary' => $perdaysalary, // Optionally include per day salary in the returned data
         'totalsalary' => $total_salary 
        
    ];
}



}