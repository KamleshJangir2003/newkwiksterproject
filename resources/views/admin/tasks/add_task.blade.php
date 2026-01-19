@extends('admin.common.app')
@section('main')
    <div class="pcoded-content">
        <div class="page-header">
        
        </div>
        <div class="pcoded-inner-content">
            <!-- Main-body start -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- Page-body start -->
                    <div class="page-body">
                        <div class="row">
                            <div class="col-12"> <!-- Updated to span full width -->
                                <div class="card m-b-20">
                                    <div class="card-body">
                                        <!-- Display success and error messages -->
                                        @if (session('success'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('success') }}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif
                                        @if (session('error'))
                                            <div class="alert alert-danger" role="alert">
                                                {{ session('error') }}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif
                                        <!-- End success/error messages -->
                    
                                        <h4 class="mt-0 header-title">Manage Task</h4>
                                        <hr style="margin-bottom: 50px; background-color: darkgrey;">
                    
                                        <form action="{{route('store_task')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <!-- Deadline Date, Task Heading, Agent Name -->
                                            <div class="form-group row">
                                                <!-- Deadline Date -->
                                                <div class="col-md-4">
                                                    <label class="form-label" for="deadline_date">Deadline Date</label>
                                                    <input type="date" class="form-control" id="deadline_date" name="deadline_date" required>
                                                </div>
                    
                                                <!-- Task Heading -->
                                                <div class="col-md-4">
                                                    <label class="form-label" for="heading">Task Heading</label>
                                                    <input type="text" class="form-control" id="heading" name="heading" placeholder="Enter task heading" required>
                                                </div>
                                             
                                                <!-- Agent Name -->
                                                @if(Auth()->user()->power == 1)
                                                @php
                                                $users = App\Models\User::where('is_active',1)->get();
                                                @endphp
                                                     <div class="col-md-4">
                                                         <label class="form-label" for="agent_name">Agent Name</label>
                                                         <select class="form-control" id="agent_name" name="agent_name" required>
                                                             <option value="">Select Agent</option>
                                                             <!-- Replace with dynamic data -->
                                                             @foreach ($users as $user )
                                                             <option value="{{$user->id}}">{{$user->name}}
                                                                @if(!is_null($user->team_id)) 
                                                                (Admin)
                                                            @endif
                                                             </option>
                                                             @endforeach
                                                         </select>
                                                     </div>
                                                @else
                                                @php
                                                  $users = App\Models\User::where('is_active', 1)->wherenull('team_id')->get();
                                                 @endphp
                                                    <div class="col-md-4">
                                                        <label class="form-label" for="agent_name">Agent Name</label>
                                                        <select class="form-control" id="agent_name" name="agent_name" required>
                                                            <option value="">Select Agent</option>
                                                            <!-- Replace with dynamic data -->
                                                            @foreach ($users as $user )
                                                            <option value="{{ $user->id }}">
                                                                {{ $user->name }} 
                                                              
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif
                                            </div>
                    
                                            <!-- Task Description -->
                                            <div class="form-group">
                                                <label class="form-label" for="description">Task Description</label>
                                                <textarea class="form-control" id="description" name="description" rows="5" placeholder="Enter task description" required></textarea>
                                            </div>
                    
                                            <input type="hidden" name="admin_id" value="{{ session('admin_id') }}">
                    
                                            <div class="form-group text-center">
                                                <button type="submit" class="btn btn-danger mt-3"><i class="fa fa-save"></i> Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <!-- Page-body end -->
                </div>
                <div id="styleSelector"> </div>
            </div>
        </div>

    @endsection
