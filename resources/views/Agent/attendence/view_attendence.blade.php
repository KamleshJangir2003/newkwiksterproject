@extends('Agent.common.app')
@section('main')
    <link href="{{ asset('Agent/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <style>
		@keyframes blink {
			0% {
				opacity: 1;
			}
			50% {
				opacity: 0;
			}
			100% {
				opacity: 1;
			}
		}
	
		.blink {
			animation: blink 1s infinite;
		}
	</style>

    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Salary & Bonus</div>
                <div class="ms-auto">
                    <button type="button" class="btn btn-sm btn-outline-info px-4"style="margin-left: 20px" onclick="toggleValue(this)">Basic Salary<span id="showbasic_sal" style="display:none">:-{{$salary_data->amount}}<span></button>
                    <button type="button" class="btn btn-sm btn-outline-danger px-4" data-bs-toggle="modal" data-bs-target="#Adherencemodal" style="margin-left: 20px">A.B:-{{$salary_data->type}}</button>
                    <button type="button" class="btn btn-sm btn-outline-primary px-4"style="margin-left: 20px">D-O-J :- {{ Carbon\Carbon::parse($doj)->format('m-d-Y') }}</button>
                    <button type="button" class="btn btn-outline-warning px-2 rounded-2" data-bs-toggle="modal" data-bs-target="#leavesmodal" style="margin-left: 20px">Request Leave</button>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                <div class="col">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Salary</p>
                                    <h5 class="my-1 blink">₹ {{number_format($salary['totalsalary'], 2, '.', ',')}}</h5>  
                                </div>
                                <div class="widgets-icons bg-light-success text-success ms-auto"><i
                                        class="bx bxs-wallet"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Bonus</p>
                                    <h5 class="my-1">₹ {{$bonus}}</h5>
                                </div>
                                <div class="widgets-icons bg-light-info text-info ms-auto"><i
                                    class="fadeIn animated bx bx-gift"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Advance</p>
                                    <h5 class="my-1">₹ {{$advance}}</h5>
                                </div>
                                <div class="widgets-icons bg-light-primary text-primary ms-auto"><i
                                    class="fadeIn animated bx bx-money"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Available Leaves</p>
                                    <h5 class="my-1">{{$remain_leave}}</h5>
                                    <p class="mb-0 text-primary">Useable Leaves: {{$usable}}</p>
                                </div>
                                <div class="widgets-icons bg-light-warning text-warning ms-auto"><i
                                    class="fadeIn animated bx bx-door-open"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h6 class="mb-0 text-uppercase">Attendence </h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
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
                                                $time = $data->total_work;
                                        $remaining_time_in_minutes = -450 + $time;
                                        $currenttime = now();
                                        $entryTime = \Carbon\Carbon::parse($data->entry);
                                        $timeadd = $entryTime->diffInMinutes($currenttime);
                                        $timeleft = $remaining_time_in_minutes + $timeadd;
                                        $hours = intval($timeleft / 60);
                                        $minutes = $minutes = abs($timeleft) % 60;
                                        $remaining_time_formatted =
                                            $hours . ':' . str_pad($minutes, 2, '0', STR_PAD_LEFT);

                                            @endphp
                                            <td>
                                                @empty($data->exit_time)
                                                    Marked by admin
                                                @else
                                                    {{ $data->exit_time }}
                                                @endempty
                                            </td>
                                            <td>

                                                @if ($time >= 450)
                                                    <span
                                                        style="padding: 5px;background-color:rgb(25, 161, 25)">Present</span>
                                                @elseif($time >= 225 && $time < 450)
                                                    <span style="padding: 5px;background-color:rgb(216, 167, 7)">Half
                                                        Day</span>
                                                @else
                                                    <span
                                                        style="padding: 5px;background-color:rgb(216, 18, 18)">Absent</span>
                                                @endif
                                            </td>
                                            @if ($time < 450)
                                                <td style="color:red">{{ $remaining_time_formatted }}</td>
                                            @else
                                                <td style="color:rgb(0, 131, 0)">+{{ $remaining_time_formatted }}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <h6 class="mb-0 text-uppercase">Leaves</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Reason</th>
                                    <th scope="col">From</th>
                                    <th scope="col">To</th>
                                    <th scope="col">Days</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($leavs->isNotEmpty())
                                    @foreach ($leavs as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->reason }}</td>
                                            <td>{{ $data->from_date }}</td>
                                            <td>{{ $data->to_date }}</td>
                                            <td>{{ $data->days }}</td>

                                            @if ($data->status == 1)
                                                <td ><span style="padding:5px;background-color:orange;">Pending</span></td>
                                            @elseif($data->status == 2)
                                                <td ><span style="padding:5px;background-color:rgb(55, 216, 55);">Approved</span></td>
                                            @else
                                                <td ><span style="padding:5px;background-color:red;">Decline</span></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    @else
                                    <td colspan="6" style="text-align: center">No Leave Request Found</td>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- holidays model --}}
    <div class="modal fade" id="Adherencemodal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adherence Bonus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ol>
                        <li>Late Coming More Than Twice i.e. Beyond 7:30 Adherence Bouns Will be Marked As Zero(0).</li>
                        <li>More Then Two Absent In A Month Will Lead To Zero(0) Adherence Bonus.</li>
                        <li>Behavioral Issues More Than 2 Incidents Will Lead To Zero(0) Adherence Bonus.</li>
                        <li>For Candidates Salaried 20,000 or Below 20,000 Adherence Bonus Is 2000 If Candidates Salaried 21,000 or Above 21,000 Adherence Bonus Is 3000. </li>
                    </ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Leaves model --}}
    <div class="modal fade" id="leavesmodal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Request Leave</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('agent.store_leaves') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12" style="margin-bottom: 20px">
                                <label for="citynameInput" class="form-label">Reason<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Reason" id="dot"
                                    name="reason" required="">
                            </div>
                            <div class="col-6">
                                <label for="startDateInput" class="form-label">Date<span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" placeholder="Enter Date" id="startDate"
                                    name="from_date" required="" min="">
                            </div>
                            <div class="col-6">
                                <label for="endDateInput" class="form-label">To Date<span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" placeholder="Enter Date" id="endDate"
                                    name="to_date" required="" min="">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
{{-- notice model --}}
       
        
        <!--end page wrapper -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            // Get today's date in the format YYYY-MM-DD
            var today = new Date().toISOString().split('T')[0];
            // Set the minimum date to today for both date inputs
            document.getElementById('startDate').setAttribute('min', today);
            document.getElementById('endDate').setAttribute('min', today);
        </script>
        <script>
            function toggleValue(button) {
    var salaryAmountDiv = document.getElementById('showbasic_sal');
    if (salaryAmountDiv.style.display === 'none') {
        salaryAmountDiv.style.display = '';
    } else {
        salaryAmountDiv.style.display = 'none';
    }
}
            </script>

    @endsection
