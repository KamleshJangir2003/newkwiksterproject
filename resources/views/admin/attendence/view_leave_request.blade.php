@extends('admin.common.app')
@section('main')
    <div class="pcoded-content">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="page-header-title">
                            <h5 class="m-b-10">View Leave Requests</h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <ul class="breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="index.html"> <i class="fa fa-home"></i> </a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
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

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Agent name</th>
                                                <th scope="col">Reason</th>
                                                <th scope="col">From</th>
                                                <th scope="col">To</th>
                                                <th scope="col">Days</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($leaves))
                                                @php $a = 0; @endphp
                                                @foreach ($leaves as $team)
                                                    @php $a++;
                                                    $user = App\Models\User::where('id',$team->agent_id)->first();
                                                     @endphp
                                                    <tr>
                                                        <th scope="row">{{ $a }}</th>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $team->reason }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($team->from_date)->format('m-d-Y') }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($team->to_date)->format('m-d-Y') }}</td>
                                                        <td>{{ $team->days }}</td>

                                                        @if ($team->status == 1)
                                                        <td>
                                                            <button class="custom-button"
                                                                id="dropdownMenuButton"
                                                                data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false"
                                                                style="background-color:#119711;color:white; padding: 2px 15px;border: none;">
                                                                <i class='bx bxs-circle me-1'></i>Pending
                                                            </button>
                                                            <div class="dropdown-menu"
                                                                aria-labelledby="dropdownMenuButton">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('leave_request_status', [base64_encode($team->id), base64_encode(2)]) }}">Approve</a>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('leave_request_status', [base64_encode($team->id), base64_encode(3)]) }}">Decline</a>
                                                            </div>
                                                        </td>
                                                        @else
                                                            <td>
                                                                <a
                                                                    href="{{ route('UpdateajentStatus', ['inactive', base64_encode($team->id)]) }}">
                                                                    <div
                                                                        class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3">
                                                                        <i class='bx bxs-circle me-1'></i>Success
                                                                    </div>
                                                                </a>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- end row -->
                        </div>

                    </div>
                    <!-- Page-body end -->
                </div>
                <div id="styleSelector"> </div>
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
