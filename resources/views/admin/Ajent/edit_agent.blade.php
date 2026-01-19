@extends('admin.common.app')
@section('main')
    <div class="pcoded-content">
        <!-- Page-header start -->
        <div class="page-header">
            {{-- <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Add Agent</h5>

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
                                                <h4 class="mt-0 header-title">Edit Agent Form</h4>
                                                <hr style="margin-bottom: 50px;background-color: darkgrey;">
                                                <form action="{{ route('edit_agent_store',$team->id) }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <div class="form-floating">
                                                                <label class="form-label"
                                                                for="power">Name</label>
                                                                <input type="text" class="form-control" type="text"
                                                                    value="{{ old('name', $team->name ?? '') }}" id="name" name="name"
                                                                    placeholder="Enter name" required>

                                                            </div>
                                                            @error('name')
                                                                <div style="color:red">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-floating">
                                                                <label class="form-label"
                                                                for="power">Email</label>
                                                                <input class="form-control" type="email" value="{{ old('email', $team->email ?? '') }}"
                                                                    id="email" name="email" placeholder="Enter email"
                                                                    required>

                                                            </div>
                                                            @error('email')
                                                                <div style="color:red">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-floating">
                                                                <label class="form-label"
                                                                for="power">Phone</label>
                                                                <input class="form-control" type="text" value="{{ old('phone', $team->phone ?? '') }}"
                                                                    id="phone" name="phone"
                                                                    placeholder="phone no."
                                                                    onkeypress="return isNumberKey(event)" maxlength="10"
                                                                    minlength="10">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <div class="form-floating">
                                                                <label class="form-label"
                                                                for="power">Password</label>
                                                                <input class="form-control" type="password" value=""
                                                                    id="password" name="password"
                                                                    placeholder="Enter Password"  autocomplete="new-password">

                                                            </div>
                                                            @error('password')
                                                                <div style="color:red">{{ $message }}</div>
                                                            @enderror

                                                        </div>
                                                        <input type="hidden" name="admin_id" value="{{session('admin_id')}}">
                                                        <div class="form-group" style="margin-left:17px">
                                                            <div class="w-100 text-center">
                                                                <button type="submit" style="margin-top: 20px;"
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
