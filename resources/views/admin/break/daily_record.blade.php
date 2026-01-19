@extends('admin.common.app')
@section('css')
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
@endsection
@section('main')
    <style>
        .name-column {
            background-color: rgb(145, 204, 223);
            /* Set your desired background color */
        }

        .td-column {
            background-color: rgb(203, 234, 244);
            /* Set your desired background color */
        }

        .card-body {
            background-color: rgb(217, 235, 241);
        }
    </style>
    <div class="pcoded-content">
        <!-- Page-header start -->
        <div class="page-header">
        </div>
        <div class="pcoded-inner-content">
            <!-- Main-body start -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- Page-body start -->
                    <div class="page-body">

                        <div class="page-content-wrapper">
                            <!-- show success and error messages -->
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                </div>
                            @endif
                            <!-- End show success and error messages -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-header border-0">
                                        <form method="get">
                                            <div class="row g-4 align-items-center">
                                                <div class="col-sm-2">
                                                    <div class="search-box">
                                                        <input type="date" name="date" class="form-control search"
                                                            placeholder="Search for..."
                                                            value="{{ isset($_GET['date']) ? $_GET['date'] : '' }}">
                                                        <i class="ri-search-line search-icon"></i>
                                                    </div>
                                                </div>
                                                <button type="submit" class=" btn-success" style="margin-right:5px"><i
                                                        class="ti-search"></i></button>
                                                <button type="button" class=" btn-danger"
                                                    onclick="window.location.href='{{ route('daily_record_break') }}'"><i
                                                        class="fa-solid fa-circle-xmark"></i>clear</button>
                                        </form>
                                    </div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="name-column">#</th>
                                                <th scope="col" class="name-column">Name</th>
                                                <th scope="col" class="name-column">Punch IN</th>
                                                <th scope="col" class="name-column">Punch Out</th>
                                                <th scope="col" class="name-column">Work Time</th>
                                                <th scope="col" class="name-column">Breaks</th>
                                                <th scope="col" class="name-column">Leads</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($userAttendance))
                                                @php $a = 0; @endphp
                                                @foreach ($userAttendance as $user)
                                                    <tr>
                                                        <th scope="row" class="td-column">{{ $loop->iteration }}</th>
                                                        <td class="td-column"  onclick="window.location.href='{{ route('view_all_attendance', base64_encode($user['user']->id)) }}'" style="cursor: pointer;">
                                                            {{ $user['user_name'] }}</td>
                                                        <td>
                                                            {{ $user['entry'] }}
                                                        </td>
                                                        <td>
                                                            {{ $user['exit'] }}
                                                        </td>

                                                        <td style="color:green">{{ $user['Remain_time'] }}/H</td>
                                                        <td><button type="button" class="btn btn-primary"
                                                                data-toggle="modal"
                                                                data-target="#view_user_data{{ $user['user']->id }}">
                                                                View
                                                            </button></td>
                                                        <td><button type="button" class="btn btn-primary"
                                                                data-toggle="modal"
                                                                data-target="#view_lead_details{{ $user['user']->id }}">
                                                                View
                                                            </button></td>
                                                    </tr>

                                                    <!-- view detaisl model -->
                                                    <div class="modal fade" id="view_user_data{{ $user['user']->id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-xl" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle">
                                                                        Breaks</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="card radius-10">
                                                                                <div class="card-body">
                                                                                    @php

                                                                                        $currentDateUS = isset(
                                                                                            $_GET['date'],
                                                                                        )
                                                                                            ? Carbon\Carbon::parse(
                                                                                                $_GET['date'],
                                                                                            )->toDateString()
                                                                                            : Carbon\Carbon::now(
                                                                                                'America/New_York',
                                                                                            )->toDateString();
                                                                                        $breaks = App\Models\Break_detail::where(
                                                                                            'status',
                                                                                            1,
                                                                                        )
                                                                                            ->where(
                                                                                                'agent_id',
                                                                                                $user['user']->id,
                                                                                            )
                                                                                            ->whereDate(
                                                                                                'created_at',
                                                                                                $currentDateUS,
                                                                                            ) // Filter by current date
                                                                                            ->get();

                                                                                    @endphp
                                                                                    @foreach ($breaks as $break)
                                                                                        @php
                                                                                            $name_break = App\adminmodel\Breaks::where(
                                                                                                'id',
                                                                                                $break->break_id,
                                                                                            )->first();
                                                                                        @endphp
                                                                                        <div
                                                                                            class="d-flex align-items-center">
                                                                                            <div>
                                                                                                <h5 class="mb-2 text-dark">
                                                                                                    <span>
                                                                                                        {{ $name_break->name ?? '' }}({{ $name_break->duration ?? '' }}
                                                                                                        min) :-
                                                                                                        {{ floor($break->time_use) }}:{{ round(($break->time_use - floor($break->time_use)) * 60) }}
                                                                                                        min

                                                                                                    </span>
                                                                                                    <hr>
                                                                                                </h5>
                                                                                            </div>
                                                                                        </div>
                                                                                        <br>
                                                                                    @endforeach

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @php
                                                                       
                                                                    
                                                                        // Get current date in 'America/New_York' timezone
                                                                        $parsedDate = Carbon\Carbon::parse($currentDateUS);
                                                                    
                                                                        // Get the start of the week and start of the month for the given date
                                                                        $startOfWeek = $parsedDate->startOfWeek()->format('Y-m-d');
                                                                        $startOfMonth = $parsedDate->startOfMonth()->format('Y-m-d');
                                                                    
                                                                        // Fetch both weekly and monthly tasks for the given agent and date
                                                                        $tasks = App\adminmodel\Task::where('agent_id', $user['user']->id)
                                                                                                    ->where(function ($query) use ($startOfWeek, $startOfMonth) {
                                                                                                        $query->where('week', $startOfWeek) // Weekly task for the week
                                                                                                              ->orWhere('month', $startOfMonth); // Monthly task for the month
                                                                                                    })
                                                                                                    ->get();
                                                                    
                                                                        // Initialize default values for weekly and monthly tasks
                                                                        $weeklyTask = null;
                                                                        $monthlyTask = null;
                                                                    
                                                                        // Loop through tasks and assign the values to weeklyTask and monthlyTask
                                                                        foreach ($tasks as $task) {
                                                                            if ($task->week == $startOfWeek) {
                                                                                $weeklyTask = $task->task;
                                                                            }
                                                                            if ($task->month == $startOfMonth) {
                                                                                $monthlyTask = $task->task;
                                                                            }
                                                                        }
                                                                    @endphp
                                                                        <div class="col-6">
                                                                            <div class="card radius-10">
                                                                                <div class="card-body">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div>
                                                                                            <h6 class="mb-2 text-success">
                                                                                                <span>Weekly Task</span>
                                                                                            </h6>
                                                                                            <input type="number"
                                                                                                id="weektask"
                                                                                                placeholder="Weekly Task"
                                                                                                value="{{ $weeklyTask }}"
                                                                                                required
                                                                                                style="margin-bottom: 5px">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="card radius-10">
                                                                                <div class="card-body">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div>
                                                                                            <h6 class="mb-2 text-success">
                                                                                                <span>Monthly Task</span>
                                                                                            </h6>
                                                                                            <input type="number"
                                                                                                id="monthtask"
                                                                                                placeholder="Monthly Task"
                                                                                                value="{{ $monthlyTask }}"
                                                                                                required
                                                                                                style="margin-bottom: 5px">
                                                                                            <input type="hidden"
                                                                                                id="agent_id"
                                                                                                value="{{ $user['user']->id }}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-dismiss="modal">Close</button>
                                                                            <button
                                                                                class="btn btn-primary submitButton">Submit</button>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                        <!--End view detaisl model -->
                                                        <!-- view lead model -->
                                                        <div class="modal fade"
                                                            id="view_lead_details{{ $user['user']->id }}" tabindex="-1"
                                                            role="dialog" aria-labelledby="exampleModalLongTitle"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-xl" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="exampleModalLongTitle">
                                                                            Leads Details</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        @php

                                                                            // Get the current date in New York timezone
                                                                            $dateus = Carbon\Carbon::now(
                                                                                'America/New_York',
                                                                            );

                                                                            // Parse the date from the GET request or use the current date
                                                                            $currentDateUS = isset($_GET['date'])
                                                                                ? Carbon\Carbon::parse($_GET['date'])
                                                                                : $dateus;

                                                                            // Format the date correctly for comparison
                                                                            $currentDateFormatted = $currentDateUS->format(
                                                                                'Y-m-d',
                                                                            );

                                                                            // Calculate the start and end of the month
                                                                            $firstDayOfMonth = $currentDateUS
                                                                                ->startOfMonth()
                                                                                ->format('Y-m-d');
                                                                            $lastDayOfMonth = $currentDateUS
                                                                                ->endOfMonth()
                                                                                ->format('Y-m-d');

                                                                            // Get lead data for the current date
                                                                            $lead_data = App\Models\ExcelData::where(
                                                                                'click_id',
                                                                                $user['user']->id,
                                                                            )
                                                                                ->where('date', $currentDateFormatted) // Ensure the date format matches
                                                                                ->selectRaw(
                                                                                    "
                                                                            COUNT(*) as total_calls,
                                                                            SUM(form_status = 'Intrested' AND (red_mark = 2 OR red_mark IS NULL)) as interested_calls,
                                                                            SUM(form_status = 'Pipeline') as pipeline_calls,
                                                                            SUM(form_status = 'Not Connected') as not_connected_calls,
                                                                            SUM(form_status = 'Voice Mail') as voicemail_calls
                                                                        ",
                                                                                )
                                                                                ->first();
                                                                                
                                                                                $pipeline_callss = App\Models\ExcelData::where(
                                                                            'click_id',
                                                                            $user['user']->id,
                                                                        )
                                                                            ->where('date', $currentDateFormatted)
                                                                            ->where('form_status', 'Pipeline')
                                                                            ->whereNull('pipeline_updated')
                                                                            ->count();

                                                                            // Calculate total connected calls for the current date
                                                                           $dayreport = App\Models\dayendreport::where('user_id', $user['user']->id)->where('date',$currentDateFormatted)->first();
                                                                                $total_call = $dayreport->total_call??0;
                                                                             $intrested_call = $dayreport->intrested ?? 0;
                                                                            $pipeline_call =
                                                                               $pipeline_callss ?? 0;
                                                                            $notconnected =
                                                                                $lead_data->not_connected_calls ?? 0;
                                                                            $voicemail =
                                                                                $lead_data->voicemail_calls ?? 0;
                                                                            $totalcallconnected =
                                                                                $total_call -
                                                                                $notconnected -
                                                                                $voicemail;

                                                                            // Get month-end report data
                                                                            $monthendreport = App\Models\ExcelData::where(
                                                                                'click_id',
                                                                                $user['user']->id,
                                                                            )
                                                                                ->whereBetween('date', [
                                                                                    $firstDayOfMonth,
                                                                                    $lastDayOfMonth,
                                                                                ])
                                                                                ->selectRaw(
                                                                                    "
                                                                            COUNT(*) as total_calls,
                                                                            SUM(form_status = 'Intrested' AND (red_mark = 2 OR red_mark IS NULL)) as interested_calls,
                                                                            SUM(form_status = 'Pipeline') as pipeline_calls,
                                                                            SUM(form_status = 'Not Connected') as not_connected_calls,
                                                                            SUM(form_status = 'Voice Mail') as voicemail_calls
                                                                        ",
                                                                                )
                                                                                ->first();
                                                                                
                                                                                   

                                                                            // Calculate total connected calls for the month
                                                                           $total_callmonth  = App\Models\dayendreport::where('user_id',  $user['user']->id)
                                                                             ->whereBetween('date', [$firstDayOfMonth, $lastDayOfMonth])
                                                                             ->sum('total_call');
                                                                            $intrested_callmonth =
                                                                            App\Models\dayendreport::where('user_id',  $user['user']->id)
                                                                             ->whereBetween('date', [$firstDayOfMonth, $lastDayOfMonth])
                                                                             ->sum('intrested');
                                                                            $pipeline_callmonth =
                                                                                $monthendreport->$pipeline_callss ?? 0;
                                                                            $notconnectedmonth =
                                                                                $monthendreport->not_connected_calls ??
                                                                                0;
                                                                            $voicemailmonth =
                                                                                $monthendreport->voicemail_calls ?? 0;
                                                                            $totalcallconnectedmonth =
                                                                                $total_callmonth -
                                                                                $notconnectedmonth -
                                                                                $voicemailmonth;

                                                                        @endphp


                                                                        <div class="row">
                                                                            <div class="col-6">
                                                                                <div class="card radius-10">
                                                                                    <h4
                                                                                        style="text-align: center;padding:10px;margin:0px">
                                                                                        Daily</h4>
                                                                                    <div class="card-body">
                                                                                        <div
                                                                                            class="d-flex align-items-center">
                                                                                            <div>
                                                                                                <h6 class="mb-2 text-dark">
                                                                                                    <span>
                                                                                                        Total Call :-
                                                                                                        {{ $total_call }}
                                                                                                    </span>
                                                                                                    <hr>
                                                                                                </h6>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="d-flex align-items-center">
                                                                                            <div>
                                                                                                <h6 class="mb-2 text-dark">
                                                                                                    <span>
                                                                                                        Intrested call :-
                                                                                                        {{ $intrested_call }}
                                                                                                    </span>
                                                                                                    <hr>
                                                                                                </h6>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="d-flex align-items-center">
                                                                                            <div>
                                                                                                <h6 class="mb-2 text-dark">
                                                                                                    <span>
                                                                                                        Pipeline call :-
                                                                                                        {{ $pipeline_call }}
                                                                                                    </span>
                                                                                                    <hr>
                                                                                                </h6>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="d-flex align-items-center">
                                                                                            <div>
                                                                                                <h6 class="mb-2 text-dark">
                                                                                                    <span>
                                                                                                        Not connected :-
                                                                                                        {{ $notconnected }}
                                                                                                    </span>
                                                                                                    <hr>
                                                                                                </h6>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="d-flex align-items-center">
                                                                                            <div>
                                                                                                <h6 class="mb-2 text-dark">
                                                                                                    <span>
                                                                                                        Voicemail :-
                                                                                                        {{ $voicemail }}
                                                                                                    </span>
                                                                                                    <hr>
                                                                                                </h6>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="d-flex align-items-center">
                                                                                            <div>
                                                                                                <h6 class="mb-2 text-dark">
                                                                                                    <span>
                                                                                                        Total Call Connected
                                                                                                        :-
                                                                                                        {{ $totalcallconnected }}
                                                                                                    </span>
                                                                                                    <hr>
                                                                                                </h6>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <div class="card radius-10">
                                                                                    <h4
                                                                                        style="text-align: center;padding:10px;margin:0px">
                                                                                        Monthly</h4>
                                                                                    <div class="card-body">
                                                                                        <div
                                                                                            class="d-flex align-items-center">
                                                                                            <div>
                                                                                                <h6 class="mb-2 text-dark">
                                                                                                    <span>
                                                                                                        Total Call :-
                                                                                                        {{ $total_callmonth }}
                                                                                                    </span>
                                                                                                    <hr>
                                                                                                </h6>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="d-flex align-items-center">
                                                                                            <div>
                                                                                                <h6 class="mb-2 text-dark">
                                                                                                    <span>
                                                                                                        Intrested call :-
                                                                                                        {{ $intrested_callmonth }}
                                                                                                    </span>
                                                                                                    <hr>
                                                                                                </h6>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="d-flex align-items-center">
                                                                                            <div>
                                                                                                <h6 class="mb-2 text-dark">
                                                                                                    <span>
                                                                                                        Pipeline call :-
                                                                                                        {{ $pipeline_callmonth }}
                                                                                                    </span>
                                                                                                    <hr>
                                                                                                </h6>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="d-flex align-items-center">
                                                                                            <div>
                                                                                                <h6 class="mb-2 text-dark">
                                                                                                    <span>
                                                                                                        Not connected :-
                                                                                                        {{ $notconnectedmonth }}
                                                                                                    </span>
                                                                                                    <hr>
                                                                                                </h6>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="d-flex align-items-center">
                                                                                            <div>
                                                                                                <h6 class="mb-2 text-dark">
                                                                                                    <span>
                                                                                                        Voicemail :-
                                                                                                        {{ $voicemailmonth }}
                                                                                                    </span>
                                                                                                    <hr>
                                                                                                </h6>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="d-flex align-items-center">
                                                                                            <div>
                                                                                                <h6 class="mb-2 text-dark">
                                                                                                    <span>
                                                                                                        Total Call Connected
                                                                                                        :-
                                                                                                        {{ $totalcallconnectedmonth }}
                                                                                                    </span>
                                                                                                    <hr>
                                                                                                </h6>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--End view lead model -->
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                  
                                </div>
                            </div>

                            <!-- end row -->
                        </div>

                    </div>

                </div>
                <div id="styleSelector"> </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                // Use event delegation to handle clicks on dynamically generated submit buttons
                $(document).on('click', '.submitButton', function(event) {
                    event.preventDefault(); // Prevent the default button behavior

                    // Get the closest modal in which the button is clicked
                    var $modal = $(this).closest('.modal');

                    // Gather input values from the specific modal
                    var weekTask = $modal.find('#weektask').val();
                    var monthTask = $modal.find('#monthtask').val();
                    var agentId = $modal.find('#agent_id').val();

                    // Create an object to hold the data
                    var formData = {
                        weektask: weekTask,
                        monthtask: monthTask,
                        agent_id: agentId
                    };

                    console.log('Form Data:', formData); // Log form data to the console

                    // Send data via AJAX
                    $.ajax({
                        url: '{{ route('updatetask') }}', // Ensure this route exists
                        method: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content') // Include CSRF token
                        },
                        success: function(response) {
                            console.log('Success:', response); // Log success response
                            // Optionally, show a success message or update the UI
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error); // Log error response
                            console.log('XHR:', xhr); // Log the complete XHR object for debugging
                        }
                    });
                });
            });
        </script>

    @endsection
