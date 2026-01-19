@extends('admin.common.app')
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
                            <h4>Teams</h4>
                            <div class="card">
                                <div class="card-body">

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Phone</th>
                                                <th scope="col">Position</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($teamdetails))
                                                @php $a = 0; @endphp
                                                @foreach ($teamdetails as $team)
                                                    @php $a++; @endphp
                                                    <tr>
                                                        <th scope="row">{{ $a }}</th>
                                                        <td>{{ $team->name }}</td>
                                                        <td onclick="window.location.href='{{ route('edit_team', $team->id) }}'">{{ $team->email }}</td>
                                                        <td>{{ $team->phone }}</td>
                                                        @php $pow = $team->power; @endphp
                                                        @if ($pow == '1')
                                                            <td>{{ 'Admin' }}</td>
                                                        @endif
                                                        @if ($pow == '2')
                                                            <td>{{ 'Manager' }}</td>
                                                        @endif
                                                        @if ($pow == '3')
                                                            <td>{{ 'Team Leader' }}</td>
                                                        @endif
                                                        @if ($pow == '4')
                                                            <td>{{ 'H.R' }}</td>
                                                        @endif
                                                        @if ($pow == '5')
                                                            <td>{{ 'Accountant' }}</td>
                                                        @endif
                                                        @if ($team->is_active == 1)
                                                            <td>
                                                                <a
                                                                    href="{{ route('UpdateTeamStatus', ['active', base64_encode($team->id)]) }}">
                                                                    <div
                                                                        class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">
                                                                        <i class='bx bxs-circle me-1'></i>Active
                                                                    </div>
                                                                </a>
                                                            </td>
                                                        @else
                                                            <td>
                                                                <a
                                                                    href="{{ route('UpdateTeamStatus', ['inactive', base64_encode($team->id)]) }}">
                                                                    <div
                                                                        class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3">
                                                                        <i class='bx bxs-circle me-1'></i>Inactive
                                                                    </div>
                                                                </a>
                                                            </td>
                                                        @endif
                                                        <td>
                                                            <div class="btn-group" id="btns<?php echo $a; ?>">
                                                                <a href="{{ route('update_team', ['id' => base64_encode($team->id)]) }}"
                                                                    mydata="<?php echo $a; ?>" data-toggle="tooltip"
                                                                    data-placement="top" title="Edit"><i
                                                                        class="ti-pencil"></i></a>
                                                            </div>
                                                            <div class="btn-group" id="btns<?php echo $a; ?>">
                                                                <a href="javascript:();" class="dCnf"
                                                                    mydata="<?php echo $a; ?>" data-toggle="tooltip"
                                                                    data-placement="top" title="Delete"><i
                                                                        class="ti-trash"></i></a>
                                                            </div>
                                                            <div style="display:none" id="cnfbox<?php echo $a; ?>">
                                                                <p> Are you sure delete this </p>
                                                                <a href="{{ route('deleteTeam', base64_encode($team->id)) }}"
                                                                    class="btn btn-danger">Yes</a>
                                                                <a href="javascript:();" class="cans btn btn-default"
                                                                    mydatas="<?php echo $a; ?>">No</a>
                                                            </div>
                                                        </td>
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
