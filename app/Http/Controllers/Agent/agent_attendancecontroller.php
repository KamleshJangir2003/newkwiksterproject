<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\adminmodel\Team;
use App\adminmodel\Users_detailsModal;
use App\adminmodel\AdminSidebar;
use App\adminmodel\AdminSidebar2;
use App\adminmodel\Holidays;
use App\adminmodel\Time_credit;
use App\adminmodel\Current_employ;
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
class agent_attendancecontroller extends Controller
{
    public function agent_view_calender(Request $req)
	{
			return view('Agent/attendence/calander');
	}
    public function agent_get_attendance(Request $req)
    {
        $userId = session('agent_id');
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
    
                if ($record->total_work >= 450) {
                    $attendanceStatus = 'Present';
                } elseif ($record->total_work >= 225) {
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
          ->where('total_work', '>=', 450)
          ->count();
    
          $paidleave = Attendance::where('emp_id', $userId)
          ->whereMonth('date', $month)
          ->whereYear('date', $year)
          ->where('total_work', 0) 
          ->count();
    
          $Halfday = Attendance::where('emp_id', $userId)
        ->whereMonth('date', $month)
        ->whereYear('date', $year)
        ->where('total_work', '>=', 225)
        ->where('total_work', '<', 450)
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
                  // Check if total_work is less than 225 minutes
                  foreach ($attendances[$formattedDate] as $attendance) {
                      if ($attendance->total_work < 225 && $attendance->total_work > 0) {
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

        $counts = [
           'present' => $present,
            'absent' => $absent,
            'halfday' => $Halfday,
            'paidleave' => $paidleave,
            'holidaycount' => $holidaysCount,
            'sundaycount' => $sundayCount,
        ];
    
        return response()->json([
            'events'=>$events,
            'counts'=>$counts,
        ]);
    }

    public function attendence(Request $req){
        $cycle = Salary_cycle::where('id',1)->first();
        $start = $cycle->start_date;
        $end = $cycle->end_date;
        $date = date('Y-m-d');
        $year = date('Y'); // This will give you the current year in 'YYYY' format.
         $month = date('m');
        $previousMonth = date('m', strtotime('-1 month', strtotime($date)));
      
         $StartofMonth = new DateTime("$year-$previousMonth-$start");
         $EndOfMonth = new DateTime("$year-$month-$end");

        if(session('agent_passcode')==1){
              $userId = session('agent_id');
              $attandance  = Attendance::where('emp_id',$userId)->latest('date')->get();

               //-------------------------------------------   bonus advance leaves 
             $leaves = Extra_leaves::where('agent_id',$userId)->first();

             $remain_leave = !empty($leaves->leaves) ? $leaves->leaves : 0;

 
             $bonus_check = Bonus::where('agent_id', $userId)
                    ->whereBetween('created_at', [$StartofMonth, $EndOfMonth])
                    ->first();
    
              $advance = !empty($bonus_check->advance) ? $bonus_check->advance : 0;
              $bonus = !empty($bonus_check->bonus) ? $bonus_check->bonus : 0;


              $doj_check = Current_employ::where('ajent_id', $userId)->first();
              $doj = !empty($doj_check->doj) ? $doj_check->doj : 0;
              if ($doj !== 0) {
                $dojDate = Carbon::parse($doj);
                $threeMonthsAgo = Carbon::now()->subMonths(3);
            
                if ($dojDate->lessThanOrEqualTo($threeMonthsAgo)) {
                    $usable = $remain_leave;
                } else {
                    $usable = 0;
                }
            } else {
                $usable = 0;
            }

            $attendanceData = $this->agent_salary_calculate($userId, $date);
            $salary_data =  Salary::where('ajent_id',$userId)->first();
            $adherence = Salary::where('ajent_id',$userId)->first();
             $adherence_salary = !empty($adherence->type) ? (float) $adherence->type : 0;
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
                 'totalsalary' => $attendanceData['totalsalary']+$adherence_salary,
            ];

            $leavs = Leaves::where('agent_id',$userId)->latest()->get();

            
      
            return view('Agent/attendence/view_attendence',compact('attandance','remain_leave','advance','bonus','doj','usable','salary','leavs','salary_data'));
         }
         else{
            return redirect()->route('passcode');
         }
         }

         private function agent_salary_calculate($agentId,$date){
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
          
    
          $bonus = !empty($bonus_check->bonus) ? $bonus_check->bonus : 0 ;
          $advance = !empty($bonus_check->advance) ? $bonus_check->advance : 0 ;
    
          $total_salary = ($present*$perdaysalary)+($paidleave*$perdaysalary) + ($holidaysWithAttendance*$perdaysalary) + ($sunday_count*$perdaysalary) + ($Halfday*$perdaysalary/2) + $bonus - $advance;
          $formattedSalary = $total_salary ;
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
             'totalsalary' => $formattedSalary 
        ];
    }

}