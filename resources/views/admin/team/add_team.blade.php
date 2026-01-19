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
                        <div class="row">

                            <div class="page-content-wrapper">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card m-b-20">
                                            <div class="card-body">
                                                <!-- show success and error messages -->
                                                @if (session('success'))
                                                    <div class="alert alert-success" role="alert">
                                                        {{ session('success') }}
                                                        <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                    </div>
                                                @endif
                                                @if (session('error'))
                                                    <div class="alert alert-danger" role="alert">
                                                        {{ session('error') }}
                                                        <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                    </div>
                                                @endif
                                                <!-- End show success and error messages -->
                                                <h4 class="mt-0 header-title">Add Team Form</h4>
                                                <hr style="margin-bottom: 50px;background-color: darkgrey;">
                                                <form action="{{ route('add_team_process') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" type="text"
                                                                    value="" id="name" name="name"
                                                                    placeholder="Enter name" required>

                                                            </div>
                                                            @error('name')
                                                                <div style="color:red">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-floating">
                                                                <input class="form-control" type="email" value=""
                                                                    id="email" name="email" placeholder="Enter email"
                                                                    required>

                                                            </div>
                                                            @error('email')
                                                                <div style="color:red">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-floating">
                                                                <input class="form-control" type="text" value=""
                                                                    id="phone" name="phone"
                                                                    placeholder="phone no. (Optional)"
                                                                    onkeypress="return isNumberKey(event)" maxlength="10"
                                                                    minlength="10">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <div class="form-floating">
                                                                <input class="form-control" type="text" value=""
                                                                    id="address" name="address"
                                                                    placeholder="address(Optional)">

                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-floating">
                                                                <input class="form-control" type="password" value=""
                                                                    id="password" name="password"
                                                                    placeholder="Enter Password" required>

                                                            </div>
                                                            @error('password')
                                                                <div style="color:red">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-sm-4 mt-2">
                                                            <select class="form-control" name="power" id="power"
                                                                required>
                                                                <option value="">Please select Type</option>
                                                                <option value="1">Admin</option>
                                                                <option value="2">Manager</option>
                                                                <option value="3">Team Leader</option>
                                                                <option value="4">H.R</option>
                                                                <option value="5">Accountant</option>
                                                            </select>
                                                            <div class="form-floating">
                                                                @error('power')
                                                                    <div style="color:red">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-right:50px">
                                                            <div class="col-sm-4"><br>
                                                                <label class="form-label" style="margin-left: 10px"
                                                                    for="power">Profile image</label>
                                                                <input class="form-control" style="margin-left: 10px"
                                                                    type="file" value="" id="img"
                                                                    name="img">
                                                            </div>
                                                            <div class="col-sm-8 mt-3">
                                                                <label class="form-label" for="power">Services
                                                                    &nbsp;<span style="color:red;">*</span></label>
                                                                <div class="form-check-inline">
                                                                    <label class="form-check-label" for="check1">
                                                                        <input type="checkbox" class="form-check-input"
                                                                            id="check1" name="service"
                                                                            value="999">All</label>
                                                                </div>

                                                                @if (!empty($service_data))
                                                                    @foreach ($service_data as $service)
                                                                        <div class="form-check-inline">
                                                                            <label class="form-check-label"
                                                                                for="<?= $service->id ?>">
                                                                                <input type="checkbox"
                                                                                    class="form-check-input"
                                                                                    id="<?= $service->id ?>"
                                                                                    name="services[]"
                                                                                    value="{{ $service->id }}v">{{ $service->name }}
                                                                            </label>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="admin_id" value="{{session('admin_id')}}">
                                                        <div class="form-group" style="margin-left:50px">
                                                            <div class="w-100 text-center">
                                                                <button type="submit" style="margin-top: 10px;"
                                                                    class="btn btn-danger"><i class="fa fa-user"></i>
                                                                    Submit</button>
                                                            </div>
                                                        </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            </div>
                        </div>
                    </div>
                    <!-- Page-body end -->
                </div>
                <div id="styleSelector"> </div>
            </div>
        </div>

    @endsection
