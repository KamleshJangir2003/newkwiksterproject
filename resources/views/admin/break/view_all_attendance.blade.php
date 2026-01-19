@extends('admin.common.app')
@section('css')
    <style>
        .pagination nav {
            display: inline-block;
        }

        .pagination nav div {
            display: inline-block;
        }

        .pagination nav div span {
            display: inline-block;
            margin-top: 10px;
        }

        .pagination nav div a {
            display: inline-block;
            font-size: 15px;
            min-width: 40px;
            width: auto;
            background-color: #004274 !important;
            color: white;
        }

        .pagination nav div p {
            display: none;
        }
    </style>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Additional styling for dropdown */
        .dropdown-menu {
            min-width: auto;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.15);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
    </style>
@endsection
@section('main')
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
                        <div class="row">
                            <div class="col-lg-12">
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
                                @php
                                $userDetails = App\adminmodel\Users_detailsModal::where('ajent_id', $agent->id)->first();
                           @endphp
                         
                           <button type="button" onclick="window.location.href='{{ route('daily_record_break') }}'"
                           class="btn btn-dark" style="float: left;margin-bottom: 10px"><i class="fa fa-reply" aria-hidden="true"></i>
                       </button>
                                <!-- End show success and error messages -->
                                <h4 style="float: right;margin-bottom: 10px">Attendance || {{ $userDetails->alise_name}} ({{$agent->name}})</h4>
                  
                                <div class="table-responsive">
                                    <div class="form-group row">
                                        <div class="form-group" style="width:100%; margin-left:30px">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Entery time</th>
                                                        <th scope="col">Exit time</th>
                                                        <th scope="col">Attendance</th>
                                                        <th scope="col">Total work time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (!empty($attandance))
                                                        @foreach ($attandance as $data)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $data->date }}</td>
                                                                <td>
                                                                    @empty($data->entry)
                                                                        Marked by admin
                                                                    @else
                                                                        {{ $data->entry }}
                                                                    @endempty
                                                                </td>
                                                                @php
    // Convert total work time from minutes to hours and minutes
    $time = $data->total_work; // Total work time in minutes

    // Calculate hours and minutes
    $hours = intdiv($time, 60); // Get the number of full hours
    $minutes = $time % 60;      // Get the remaining minutes

    // Format the time as "X hours Y minutes"
    $formatted_work_time = "{$hours} hours {$minutes} minutes";
@endphp

                                                                <td>
                                                                    @empty($data->exit_time)
                                                                        Marked by admin
                                                                    @else
                                                                        {{ $data->exit_time }}
                                                                    @endempty
                                                                </td>
                                                                <td>
                    
                                                                    @if ($time >= 460)
                                                                        <span
                                                                            style="padding: 5px;background-color:rgb(25, 161, 25)">Present</span>
                                                                    @elseif($time >= 230 && $time < 460)
                                                                        <span style="padding: 5px;background-color:rgb(216, 167, 7)">Half
                                                                            Day</span>
                                                                    @else
                                                                        <span
                                                                            style="padding: 5px;background-color:rgb(216, 18, 18)">Absent</span>
                                                                    @endif
                                                                </td>
                                                                @if ($time < 460)
                                                                    <td style="color:red">{{ $formatted_work_time }}</td>
                                                                @else
                                                                    <td style="color:rgb(0, 131, 0)">+{{ $formatted_work_time }}</td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                            {{ $attandance->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                </div>
                <!-- Page-body end -->
            </div>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.dCnf').click(function(e) {
                e.preventDefault();
                var mydata = $(this).attr('mydata');
                $('#cnfbox' + mydata).show();
            });

            $('.cans').click(function(e) {
                e.preventDefault();
                var mydata = $(this).attr('mydatas');
                $('#cnfbox' + mydata).hide();
            });
        });
    </script>
    </div>
    </div>
@endsection
