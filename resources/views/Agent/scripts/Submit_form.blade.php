@extends('Agent.common.app')
@section('main')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Form</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Submit Form</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="container">
                <div class="main-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <form action="{{route('store_submit_form')}}" method="post">
                                    @csrf
                                <div class="card-body">
                                    {{-- <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Agent ID</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" value="" />
                                        </div>
                                    </div> --}}
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Company Name</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="company" class="form-control"
                                                value="" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Owner Name</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="owner" class="form-control" value="" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">DOT</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="dot" class="form-control" value="" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Contact no.</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="phone" class="form-control" value="" />
                                        </div>
                                    </div><div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="email" class="form-control" value="" />
                                        </div>
                                    </div><div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Hauls</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="Hauls" class="form-control" value="" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Truck VIN</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="truck_vin" class="form-control" value="" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Trailer VIN</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="trailer_vin" class="form-control" value="" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Driver's Name</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="driver" class="form-control" value="" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">LN</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="LN" class="form-control" value="" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">DOB</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="dob" class="form-control" value="" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Issued state</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="issue_state" class="form-control" value="" />
                                        </div>
                                    </div> <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">LIability</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="lIability" class="form-control" value="" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Cargo</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="cargo" class="form-control" value="" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Physical damage</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="physical_damage" class="form-control" value="" />
                                        </div>
                                    </div>
                                    {{-- <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Agent Name</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" value="" />
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="submit" class="btn btn-primary px-4" value="Submit form">
                                    </div>
                                </div>
                              </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
@endsection
