<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kwikster|Master File</title>
    @include('backend.masterfile.css')
    @yield('css')
   
</head>

<body>
    @include('backend.masterfile.header')

    <div class="container-fluid">
        @if (session('success'))
            <div class="col-sm-12 mt-4">
                <div class="alert  alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="col-sm-12">
                <div class="alert  alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

        @yield('content')

    </div>
    <!-- Upload Modal Start -->
    <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <form action="{{ url('/masterfile/import') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title" id="exampleModalLabel">Upload File(.xlsx) <span
                                class="text-danger">*</span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control" name="batch_name"
                                    placeholder="Enter Batch Name" required>
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control-file" name="excel_file"
                                    placeholder="Upload Excel File" required>
                            </div>
                        </div>
                        <div class="modal-footer border-top-0 d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </form>
    </div>
    <!-- Upload Modal End -->
    <!-- Form Modal Start -->
    <!-- staticBackdrop Modal -->
    <div class="modal fade" id="leaddata" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h4>Lead</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/update/masterfile/data/') }}" method="POST">
                        @csrf
                        <input type="hidden" name="data_id" value="" id="data_id">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="row border-end border-primary">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="firstNameinput" class="form-label">Company Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter company name"
                                                id="company_name" name="company_name">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="lastNameinput" class="form-label">Phone <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control" placeholder="Enter phone number"
                                                id="phone" name="phone">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email </label>
                                            <input type="email" class="form-control"
                                                placeholder="example@gmail.com" id="email" name="email">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="compnayNameinput" class="form-label">Company Rep1 <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter company rep..." id="company_rep1"
                                                name="company_rep1">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="emailidInput" class="form-label">Business Address <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter business address" id="business_address"
                                                name="business_address">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="address1ControlTextarea" class="form-label">Business City
                                                <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter business city" id="business_city"
                                                name="business_city">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Business State <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter business state" id="business_state"
                                                name="business_state">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Business ZIP <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter business zip" id="business_zip"
                                                name="business_zip">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">DOT <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter DOT"
                                                id="dot" name="dot" required>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">MC/Docket <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter MC"
                                                id="mc_docket" name="mc_docket">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="ForminputState" class="form-label">Unit Owned <span
                                                    class="text-danger">*</span></label>
                                            <select id="unit_owned" class="form-control" name="unit_owned">
                                                <option selected>Choose...</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">VIN <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter VIN"
                                                id="vin" name="vin">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver name" id="driver_name" name="driver_name">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver DOB <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control" placeholder="Enter driver dob"
                                                id="driver_dob" name="driver_dob">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver License <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver license" id="driver_license"
                                                name="driver_license">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver License State<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver license" id="driver_license_state"
                                                name="driver_license_state">
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Vehicle Year </label>
                                            <input type="number" class="form-control" placeholder="YYYY"
                                                id="vehicle_year" name="vehicle_year">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Vehicle Make </label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter Vehicle make..." id="vehicle_make"
                                                name="vehicle_make">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Stated Value </label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter stated value" id="stated_value"
                                                name="stated_value">
                                        </div>
                                    </div><!--end col-->
                                    {{-- 2 --}}
                                    <div class="row unit2">
                                        <hr class=" border border-2 border-primary">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">VIN2 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter VIN"
                                                    id="vin2" name="vin2">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Driver Name2 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver name" id="driver_name2"
                                                    name="driver_name2">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Driver DOB2 <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" class="form-control"
                                                    placeholder="Enter driver dob" id="driver_dob2"
                                                    name="driver_dob2">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Driver License2 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver license" id="driver_license2"
                                                    name="driver_license2">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Driver License
                                                    State2<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver license" id="driver_license_state2"
                                                    name="driver_license_state2">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Vehicle Year2 </label>
                                                <input type="number" class="form-control" placeholder="YYYY"
                                                    id="vehicle_year2" name="vehicle_year2">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Vehicle Make2 </label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter Vehicle make..." id="vehicle_make2"
                                                    name="vehicle_make2">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Stated Value2 </label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter stated value" id="stated_value2"
                                                    name="stated_value2">
                                            </div>
                                        </div><!--end col-->
                                    </div>
                                    {{-- /2 --}}
                                    {{-- 3 --}}
                                    <div class="row unit3">
                                        <hr class=" border border-2 border-primary">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">VIN3 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter VIN"
                                                    id="vin3" name="vin3">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Driver Name3 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver name" id="driver_name3"
                                                    name="driver_name3">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Driver DOB3 <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" class="form-control"
                                                    placeholder="Enter driver dob" id="driver_dob3"
                                                    name="driver_dob3">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Driver License3 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver license" id="driver_license3"
                                                    name="driver_license3">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Driver License
                                                    State3<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver license" id="driver_license_state3"
                                                    name="driver_license_state3">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Vehicle Year3 </label>
                                                <input type="number" class="form-control" placeholder="YYYY"
                                                    id="vehicle_year3" name="vehicle_year3">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Vehicle Make3 </label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter Vehicle make..." id="vehicle_make3"
                                                    name="vehicle_make3">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Stated Value3 </label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter stated value" id="stated_value3"
                                                    name="stated_value3">
                                            </div>
                                        </div><!--end col-->
                                    </div>
                                    {{-- /3 --}}
                                    {{-- 4 --}}
                                    <div class="row unit4">
                                        <hr class=" border border-2 border-primary">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">VIN4 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter VIN"
                                                    id="vin4" name="vin4">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Driver Name4 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver name" id="driver_name4"
                                                    name="driver_name4">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Driver DOB4 <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" class="form-control"
                                                    placeholder="Enter driver dob" id="driver_dob4"
                                                    name="driver_dob4">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Driver License4 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver license" id="driver_license4"
                                                    name="driver_license4">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Driver License
                                                    State4<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver license" id="driver_license_state4"
                                                    name="driver_license_state4">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Vehicle Year4 </label>
                                                <input type="number" class="form-control" placeholder="YYYY"
                                                    id="vehicle_year4" name="vehicle_year4">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Vehicle Make4 </label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter Vehicle make..." id="vehicle_make4"
                                                    name="vehicle_make4">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Stated Value4 </label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter stated value" id="stated_value4"
                                                    name="stated_value4">
                                            </div>
                                        </div><!--end col-->
                                    </div>
                                    {{-- /4 --}}
                                    {{-- 5 --}}
                                    <div class="row unit5">
                                        <hr class=" border border-2 border-primary">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">VIN5 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter VIN"
                                                    id="vin5" name="vin5">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Driver Name5 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver name" id="driver_name5"
                                                    name="driver_name5">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Driver DOB5 <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" class="form-control"
                                                    placeholder="Enter driver dob" id="driver_dob5"
                                                    name="driver_dob5">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Driver License5 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver license" id="driver_license5"
                                                    name="driver_license5">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Driver License
                                                    State5<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver license" id="driver_license_state5"
                                                    name="driver_license_state5">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Vehicle Year5 </label>
                                                <input type="number" class="form-control" placeholder="YYYY"
                                                    id="vehicle_year5" name="vehicle_year5">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Vehicle Make5 </label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter Vehicle make..." id="vehicle_make5"
                                                    name="vehicle_make5">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Stated Value5 </label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter stated value" id="stated_value5"
                                                    name="stated_value5">
                                            </div>
                                        </div><!--end col-->
                                    </div>
                                    {{-- /5 --}}

                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row text-center">
                                    <div class="col-12">
                                        <img src="{{ asset('assets/images/phonetics.png') }}" alt=""
                                            height="400" class="img-fluid">
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="ForminputState" class="form-label">Status<span
                                                    class="text-danger">*</span></label>
                                            <select id="form_status" class="form-control" name="form_status"
                                                required>
                                                <option value="Intrested">Intrested</option>
                                                <option value="Pipeline">Pipeline</option>
                                            </select>
                                        </div>
                                    </div><!--end col-->
                                    
                                    <div class="col-6">
                                        <div class="pt-4">
                                            <label id="model-form-status" class="form-label"></label>
                                            <div class="progress animated-progress custom-progress mb-4"
                                                id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                aria-expanded="false" style="cursor:pointer;">
                                                <div class="progress-bar" role="progressbar" style="width:100%";
                                                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                                                    id="progress-bar">
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6 reminder">
                                        <div class="pb-4">
                                            <label for="citynameInput" class="form-label">Reminder</label>
                                            <input type="datetime-local" class="form-control" id="reminder"
                                                name="reminder">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Comment </label>
                                            <textarea id="comment" name="comment" class="form-control" rows="4" placeholder="Write a Coment...."
                                                required></textarea>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-12">
                                        <div class="text-end">
                                            <div class="mt-4">
                                                <div class="hstack gap-2 justify-content-center">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--end col-->
                                </div>
                            </div>
                        </div><!--end row-->
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Form Modal End -->


    @include('backend.masterfile.js')
    @yield('js')
    
</body>

</html>
