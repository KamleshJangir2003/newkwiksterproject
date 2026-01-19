@extends('admin.common.app')
@section('main')
    <div class="pcoded-content">
        <!-- Page-header start -->
        <div class="page-header">
            {{-- <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="page-header-title">
                            <h5 class="m-b-10">View Task</h5>
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
            </div> --}}
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
                                                <th scope="col">Agent Name</th>
                                                <th scope="col">Heading</th>
                                                <th scope="col">Discription</th>
                                                <th scope="col">Deadline</th>
                                                <th scope="col">Issue</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($tasks))
                                                @php $a = 0; @endphp
                                                @foreach ($tasks as $task)
                                                    @php $a++; @endphp
                                                    <tr>
                                                        <th scope="row">{{ $a }}</th>
                                                        @php
                                                            $user = App\Models\User::where('id',$task->agent_id)->first();
                                                        @endphp
                                                        <td>{{$user->name}}  </td>
                                                        <td >{{ $task->heading }}</td>
                                                        <td>{{ $task->description }}</td>
                                                        <td>{{ $task->deadline }}</td>
                                                        <td>{{ $task->created_at }}</td>

                                                        @if ($task->is_active == 1)
                                                            <td>
                                                                <a
                                                                    href="#">
                                                                    <div
                                                                        class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">
                                                                        <i class='bx bxs-circle me-1'></i>Active
                                                                    </div>
                                                                </a>
                                                            </td>
                                                        @else
                                                            <td>
                                                                <a
                                                                    href="#">
                                                                    <div
                                                                        class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3">
                                                                        <i class='bx bxs-circle me-1'></i>Inactive
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
