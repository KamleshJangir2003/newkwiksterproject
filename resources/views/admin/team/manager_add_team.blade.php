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
                                                <h4 class="mt-0 header-title">Add Manager Team </h4>
                                                <hr style="margin-bottom: 50px;background-color: darkgrey;">
                                                <form action="{{ route('addmanager_team_process') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" type="text"
                                                                    value="" id="name" name="name"
                                                                    placeholder="Enter team name" required>

                                                            </div>
                                                            @error('name')
                                                                <div style="color:red">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-floating">
                                                                <select class="form-control" id="name" name="manager" required>
                                                                    <option value="" disabled selected>Select team leader name</option>
                                                                    @foreach($teams as $data)
                                                                    <option value="{{$data->id}}">{{$data->name}}</option>
                                                                    @endforeach
                                                                    <!-- Add more options as needed -->
                                                                </select>
                                                               
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 mt-3">
                                                            <label class="form-label" for="power">Add Agent
                                                                &nbsp;<span style="color:red;">*</span></label>
                                                            <div class="form-check-inline">
                                                                <label class="form-check-label" for="check1">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="check1" name="service"
                                                                        value="999"> All</label>
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
                                                                                value="{{ $service->id }}v"> {{ $service->name }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                         
                                                        <div class="form-group" style="margin-left:50px">
                                                            <div class="w-100 text-center">
                                                                <button type="submit" style="margin-top: 10px;"
                                                                    class="btn btn-danger"><i class="fa fa-user"></i>
                                                                    Submit</button>
                                                            </div>
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
