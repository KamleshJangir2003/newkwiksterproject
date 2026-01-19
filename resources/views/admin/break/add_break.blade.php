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
                                                <h4 class="mt-0 header-title">Add Break</h4>
                                                <hr style="margin-bottom: 50px;background-color: darkgrey;">
                                                <form action="{{ route('add_break_process') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <div class="col-sm-6">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" type="text"
                                                                    value="" id="name" name="name"
                                                                    placeholder="Enter break Name" required>

                                                            </div>
                                                            @error('name')
                                                                <div style="color:red">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-floating">
                                                                <input class="form-control" type="number" value=""
                                                                    id="duration" name="duration"
                                                                    placeholder="Enter duration" required>

                                                            </div>
                                                            @error('duration')
                                                                <div style="color:red">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <input type="hidden" name="admin_id"
                                                            value="{{ session('admin_id') }}">
                                                        <div class="form-group" style="margin-left:100px">
                                                            <div class="w-100 text-center">
                                                                <button type="submit" style="margin-top: 10px;"
                                                                    class="btn btn-danger">
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
