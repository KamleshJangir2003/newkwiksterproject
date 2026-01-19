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
                            <div class="col-lg-12">
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
                                <div class="card" id="leadsList">
                                    <div class="card-header border-0">
                                        <form method="get">
                                            <div class="row g-4 align-items-center">
                                                <div class="col-sm-4">
                                                    <div class="search-box">
                                                        <input type="text" name="search_input" id="search_input"
                                                            class="form-control search" placeholder="Search Comapny Name, Phone,Dot,MC"
                                                            value="{{ isset($_GET['search_input']) ? $_GET['search_input'] : '' }}">
                                                        <i class="ri-search-line search-icon"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="search-box">
                                                        @php
                                                        $users = App\Models\User::where('is_active',1)->where('status',1)->get();
                                                        @endphp
                                                        <select name="agent" id="agent" class="form-control search">
                                                            <option value="">search Agent</option>
                                                            @foreach($users as $user)
                                                            @php
                                                                $userDetails = App\adminmodel\Users_detailsModal::where('ajent_id', $user->id)->first();
                                                                $name = !empty($userDetails) ? $userDetails->alise_name : $user->name;
                                                            @endphp
                                                            <option value="{{ $user->id }}" {{ isset($_GET['agent']) && $_GET['agent'] == $user->id ? 'selected' : '' }}>
                                                                {{ $name }}
                                                            </option>
                                                        @endforeach
                                                        </select>
                                                        <i class="ri-search-line search-icon"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="search-box">
                                                        <input type="date" name="date1" id="date1" class="form-control search"
                                                            placeholder="Search for..."
                                                            value="{{ isset($_GET['date1']) ? $_GET['date1'] : '' }}">
                                                        <i class="ri-search-line search-icon"></i>
                                                    </div>
                                                </div>
                                                <p style="margin-bottom:0px">To</p>
                                                <div class="col-sm-2">
                                                    <div class="search-box">
                                                        <input type="date" name="date2" id="date2" class="form-control search"
                                                            placeholder="Search comapny name, phone,dot,mc"
                                                            value="{{ isset($_GET['date2']) ? $_GET['date2'] : '' }}">
                                                        <i class="ri-search-line search-icon"></i>
                                                    </div>
                                                </div>
                                                <button type="submit" class=" btn-success" style="margin-right:5px"><i
                                                        class="ti-search"></i></button>
                                                <button type="button"  class=" btn-danger" onclick="window.location.href='{{route('verified_lead_manage')}}'"><i class="fa-solid fa-circle-xmark"></i> clear</button>

                                        </form>
                                    </div>
                                </div>
                                 {{-- modal start --}}
            <div class="modal fade" id="leadModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog " style="max-width: 100%; margin: 30px;">
                    <div class="modal-content">
                        <div class="modal-header border-bottom">
                            <h4>Lead</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="padding:40px">
                            <form action="{{ route('intrested_check') }}" method="POST" enctype="multipart/form-data"
                                onsubmit="return confirmSubmit()">
                                @csrf
                                <input type="hidden" name="data_id" value="" id="data_id">
                                <input type="hidden" name="forword_id" value="" id="forword_id">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="row border-end ">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label">Company Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter company name" id="company_name"
                                                        name="company_name">
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="lastNameinput" class="form-label">Phone <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter phone number" id="phone" name="phone">
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
                                                        id="dot" name="dot" required="">
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
                                            <div class="col-12 mb-3">
                                                <h5>Commodities</h5>
                                                <div class="row">
                                                    <div class="col-6">

                                                        <input type="checkbox" class="form-check-input"
                                                            name="commodities[]" value="Building Materials - Machinery"
                                                            id="building_machinery">
                                                        <label for="citynameInput" class="form-label"> Building Materials
                                                            -
                                                            Machinery</label>

                                                    </div>
                                                    <div class="col-6">

                                                        <input type="checkbox" class="form-check-input"
                                                            name="commodities[]" value="Building Materials"
                                                            id="buildingmaterials">
                                                        <label for="citynameInput" class="form-label"> Building
                                                            Materials</label>

                                                    </div>
                                                    <div class="col-6">

                                                        <input type="checkbox" class="form-check-input"
                                                            name="commodities[]" value="Dry Freight - Amazon"
                                                            id="Dry-Freight-Amazon">
                                                        <label for="citynameInput" class="form-label"> Dry Freight -
                                                            Amazon</label>

                                                    </div>
                                                    <div class="col-6">

                                                        <input type="checkbox" class="form-check-input"
                                                            name="commodities[]" value="Dry Freight" id="Dry-Freight">
                                                        <label for="citynameInput" class="form-label"> Dry Freight</label>

                                                    </div>
                                                    <div class="col-6">

                                                        <input type="checkbox" class="form-check-input"
                                                            name="commodities[]" value="Reefer with seafood or flowers"
                                                            id="Reefer_with_seafood_or_flowers">
                                                        <label for="citynameInput" class="form-label"> Reefer with seafood
                                                            or
                                                            flowers</label>

                                                    </div>
                                                    <div class="col-6">

                                                        <input type="checkbox" class="form-check-input"
                                                            name="commodities[]" value="Refrigerated Goods"
                                                            id="Refrigerated_Goods">
                                                        <label for="citynameInput" class="form-label"> Refrigerated
                                                            Goods</label>

                                                    </div>
                                                    <div class="col-6">

                                                        <input type="checkbox" class="form-check-input"
                                                            name="commodities[]" value="Reefer with flowers"
                                                            id="Reefer_with_flowers">
                                                        <label for="citynameInput" class="form-label"> Reefer with
                                                            flowers</label>

                                                    </div>
                                                    <div class="col-6">

                                                        <input type="checkbox" class="form-check-input"
                                                            name="commodities[]" value="Fracking Sand"
                                                            id="Fracking-Sand">
                                                        <label for="citynameInput" class="form-label"> Fracking
                                                            Sand</label>

                                                    </div>
                                                    <div class="col-6">

                                                        <input type="checkbox" class="form-check-input"
                                                            name="commodities[]" value="Hazard" id="Hazard">
                                                        <label for="citynameInput" class="form-label"> Hazard</label>

                                                    </div>
                                                    <div class="col-6">

                                                        <input type="checkbox" class="form-check-input"
                                                            name="commodities[]" value="Containerized Freight"
                                                            id="Containerized-Freight">
                                                        <label for="citynameInput" class="form-label"> Containerized
                                                            Freight</label>

                                                    </div>
                                                    <div class="col-6">

                                                        <input type="checkbox" class="form-check-input"
                                                            name="commodities[]" value="Sand &amp; Gravel"
                                                            id="SandGravel">
                                                        <label for="citynameInput" class="form-label"> Sand &amp;
                                                            Gravel</label>

                                                    </div>
                                                    <div class="col-6">

                                                        <input type="checkbox" class="form-check-input"
                                                            name="commodities[]" value="Auto 100%" id="100">
                                                        <label for="citynameInput" class="form-label"> Auto 100%</label>

                                                    </div>
                                                    <div class="col-6">

                                                        <input type="checkbox" class="form-check-input"
                                                            name="commodities[]" value="Hauls Oversized/Overweight"
                                                            id="HaulsOversizedOverweight">
                                                        <label for="citynameInput" class="form-label"> Hauls
                                                            Oversized/Overweight</label>

                                                    </div>
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="ForminputState" class="form-label">Unit Owned <span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control" id="unit_owned2" name="unit_owned">
                                                        <option selected="">Choose...</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
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

                                            <div class="row unit2" id="unit22">

                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">VIN2 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter VIN" id="vin2" name="vin2">
                                                    </div>
                                                </div><!--end col-->

                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Vehicle Year2
                                                        </label>
                                                        <input type="number" class="form-control" placeholder="YYYY"
                                                            id="vehicle_year2" name="vehicle_year2">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Vehicle Make2
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Vehicle make..." id="vehicle_make2"
                                                            name="vehicle_make2">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Stated Value2
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter stated value" id="stated_value2"
                                                            name="stated_value2">
                                                    </div>
                                                </div><!--end col-->
                                            </div>


                                            <div class="row unit3" id="unit33">

                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">VIN3 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter VIN" id="vin3" name="vin3">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Vehicle Year3
                                                        </label>
                                                        <input type="number" class="form-control" placeholder="YYYY"
                                                            id="vehicle_year3" name="vehicle_year3">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Vehicle Make3
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Vehicle make..." id="vehicle_make3"
                                                            name="vehicle_make3">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Stated Value3
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter stated value" id="stated_value3"
                                                            name="stated_value3">
                                                    </div>
                                                </div><!--end col-->
                                            </div>


                                            <!-- Driver Unit 4 -->
                                            <div class="row unit4" id="unit44">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">VIN4 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter VIN" id="vin4" name="vin4">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Vehicle Year4
                                                        </label>
                                                        <input type="number" class="form-control" placeholder="YYYY"
                                                            id="vehicle_year4" name="vehicle_year4">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Vehicle Make4
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Vehicle make..." id="vehicle_make4"
                                                            name="vehicle_make4">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Stated Value4
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter stated value" id="stated_value4"
                                                            name="stated_value4">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Driver Unit 5 -->
                                            <div class="row unit5" id="unit55">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">VIN5 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter VIN" id="vin5" name="vin5">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Vehicle Year5
                                                        </label>
                                                        <input type="number" class="form-control" placeholder="YYYY"
                                                            id="vehicle_year5" name="vehicle_year5">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Vehicle Make5
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Vehicle make..." id="vehicle_make5"
                                                            name="vehicle_make5">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Stated Value5
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter stated value" id="stated_value5"
                                                            name="stated_value5">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Driver Unit 6 -->
                                            <div class="row unit6" id="unit66">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="vin6" class="form-label">VIN6 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter VIN" id="vin6" name="vin6">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="vehicle_year6" class="form-label">Vehicle Year6
                                                        </label>
                                                        <input type="number" class="form-control" placeholder="YYYY"
                                                            id="vehicle_year6" name="vehicle_year6">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="vehicle_make6" class="form-label">Vehicle Make6
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Vehicle make..." id="vehicle_make6"
                                                            name="vehicle_make6">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="stated_value6" class="form-label">Stated Value6
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter stated value" id="stated_value6"
                                                            name="stated_value6">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Driver Unit 7 -->
                                            <div class="row unit7" id="unit77">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="vin7" class="form-label">VIN7 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter VIN" id="vin7" name="vin7">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="vehicle_year7" class="form-label">Vehicle Year7
                                                        </label>
                                                        <input type="number" class="form-control" placeholder="YYYY"
                                                            id="vehicle_year7" name="vehicle_year7">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="vehicle_make7" class="form-label">Vehicle Make7
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Vehicle make..." id="vehicle_make7"
                                                            name="vehicle_make7">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="stated_value7" class="form-label">Stated Value7
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter stated value" id="stated_value7"
                                                            name="stated_value7">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Driver Unit 8 -->
                                            <div class="row unit8" id="unit88">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="vin8" class="form-label">VIN8 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter VIN" id="vin8" name="vin8">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="vehicle_year8" class="form-label">Vehicle Year8
                                                        </label>
                                                        <input type="number" class="form-control" placeholder="YYYY"
                                                            id="vehicle_year8" name="vehicle_year8">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="vehicle_make8" class="form-label">Vehicle Make8
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Vehicle make..." id="vehicle_make8"
                                                            name="vehicle_make8">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="stated_value8" class="form-label">Stated Value8
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter stated value" id="stated_value8"
                                                            name="stated_value8">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Driver Unit 9 -->
                                            <div class="row unit9" id="unit99">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="vin9" class="form-label">VIN9 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter VIN" id="vin9" name="vin9">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="vehicle_year9" class="form-label">Vehicle Year9
                                                        </label>
                                                        <input type="number" class="form-control" placeholder="YYYY"
                                                            id="vehicle_year9" name="vehicle_year9">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="vehicle_make9" class="form-label">Vehicle Make9
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Vehicle make..." id="vehicle_make9"
                                                            name="vehicle_make9">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="stated_value9" class="form-label">Stated Value9
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter stated value" id="stated_value9"
                                                            name="stated_value9">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Driver Unit 10 -->
                                            <div class="row unit10" id="unit101">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="vin10" class="form-label">VIN10 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter VIN" id="vin10" name="vin10">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="vehicle_year10" class="form-label">Vehicle Year10
                                                        </label>
                                                        <input type="number" class="form-control" placeholder="YYYY"
                                                            id="vehicle_year10" name="vehicle_year10">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="vehicle_make10" class="form-label">Vehicle Make10
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Vehicle make..." id="vehicle_make10"
                                                            name="vehicle_make10">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="stated_value10" class="form-label">Stated Value10
                                                        </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter stated value" id="stated_value10"
                                                            name="stated_value10">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Driver Unit 1 -->
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="citynameInput" class="form-label">Driver Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter driver name" id="driver_name"
                                                        name="driver_name">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="citynameInput" class="form-label">Driver DOB <span
                                                            class="text-danger">*</span></label>
                                                    <input type="date" class="form-control"
                                                        placeholder="Enter driver dob" id="driver_dob"
                                                        name="driver_dob">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="citynameInput" class="form-label">Driver License <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter driver license" id="driver_license"
                                                        name="driver_license">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="citynameInput" class="form-label">Driver License
                                                        State<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter driver license state"
                                                        id="driver_license_state" name="driver_license_state">
                                                </div>
                                            </div>

                                            <!-- Driver Unit 2 -->
                                            <div class="row unit2" id="driver22">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Driver Name2 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver name" id="driver_name2"
                                                            name="driver_name2">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Driver DOB2 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" class="form-control"
                                                            placeholder="Enter driver dob" id="driver_dob2"
                                                            name="driver_dob2">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Driver License2
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver license" id="driver_license2"
                                                            name="driver_license2">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Driver License
                                                            State2 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver license state"
                                                            id="driver_license_state2" name="driver_license_state2">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Driver Unit 3 -->
                                            <div class="row unit3" id="driver33">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Driver Name3 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver name" id="driver_name3"
                                                            name="driver_name3">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Driver DOB3 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" class="form-control"
                                                            placeholder="Enter driver dob" id="driver_dob3"
                                                            name="driver_dob3">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Driver License3
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver license" id="driver_license3"
                                                            name="driver_license3">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Driver License
                                                            State3 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver license state"
                                                            id="driver_license_state3" name="driver_license_state3">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Driver Unit 4 -->
                                            <div class="row unit4" id="driver44">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Driver Name4 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver name" id="driver_name4"
                                                            name="driver_name4">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Driver DOB4 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" class="form-control"
                                                            placeholder="Enter driver dob" id="driver_dob4"
                                                            name="driver_dob4">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Driver License4
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver license" id="driver_license4"
                                                            name="driver_license4">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Driver License
                                                            State4 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver license state"
                                                            id="driver_license_state4" name="driver_license_state4">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Driver Unit 5 -->
                                            <div class="row unit5" id="driver55">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Driver Name5 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver name" id="driver_name5"
                                                            name="driver_name5">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Driver DOB5 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" class="form-control"
                                                            placeholder="Enter driver dob" id="driver_dob5"
                                                            name="driver_dob5">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Driver License5
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver license" id="driver_license5"
                                                            name="driver_license5">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Driver License
                                                            State5 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver license state"
                                                            id="driver_license_state5" name="driver_license_state5">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Driver Unit 6 -->
                                            <div class="row unit6" id="driver66">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="driver_name6" class="form-label">Driver Name6 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver name" id="driver_name6"
                                                            name="driver_name6">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="driver_dob6" class="form-label">Driver DOB6 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" class="form-control"
                                                            placeholder="Enter driver dob" id="driver_dob6"
                                                            name="driver_dob6">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="driver_license6" class="form-label">Driver License6
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver license" id="driver_license6"
                                                            name="driver_license6">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="driver_license_state6" class="form-label">Driver
                                                            License State6 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver license state"
                                                            id="driver_license_state6" name="driver_license_state6">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Driver Unit 7 -->
                                            <div class="row unit7" id="driver77">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="driver_name7" class="form-label">Driver Name7 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver name" id="driver_name7"
                                                            name="driver_name7">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="driver_dob7" class="form-label">Driver DOB7 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" class="form-control"
                                                            placeholder="Enter driver dob" id="driver_dob7"
                                                            name="driver_dob7">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="driver_license7" class="form-label">Driver License7
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver license" id="driver_license7"
                                                            name="driver_license7">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="driver_license_state7" class="form-label">Driver
                                                            License State7 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver license state"
                                                            id="driver_license_state7" name="driver_license_state7">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Driver Unit 8 -->
                                            <div class="row unit8" id="driver88">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="driver_name8" class="form-label">Driver Name8 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver name" id="driver_name8"
                                                            name="driver_name8">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="driver_dob8" class="form-label">Driver DOB8 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" class="form-control"
                                                            placeholder="Enter driver dob" id="driver_dob8"
                                                            name="driver_dob8">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="driver_license8" class="form-label">Driver License8
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver license" id="driver_license8"
                                                            name="driver_license8">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="driver_license_state8" class="form-label">Driver
                                                            License State8 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver license state"
                                                            id="driver_license_state8" name="driver_license_state8">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Driver Unit 9 -->
                                            <div class="row unit9" id="driver99">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="driver_name9" class="form-label">Driver Name9 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver name" id="driver_name9"
                                                            name="driver_name9">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="driver_dob9" class="form-label">Driver DOB9 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" class="form-control"
                                                            placeholder="Enter driver dob" id="driver_dob9"
                                                            name="driver_dob9">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="driver_license9" class="form-label">Driver License9
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver license" id="driver_license9"
                                                            name="driver_license9">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="driver_license_state9" class="form-label">Driver
                                                            License State9 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver license state"
                                                            id="driver_license_state9" name="driver_license_state9">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Driver Unit 10 -->
                                            <div class="row unit10" id="driver101">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="driver_name10" class="form-label">Driver Name10
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver name" id="driver_name10"
                                                            name="driver_name10">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="driver_dob10" class="form-label">Driver DOB10 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" class="form-control"
                                                            placeholder="Enter driver dob" id="driver_dob10"
                                                            name="driver_dob10">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="driver_license10" class="form-label">Driver
                                                            License10 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver license" id="driver_license10"
                                                            name="driver_license10">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="driver_license_state10" class="form-label">Driver
                                                            License State10 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter driver license state"
                                                            id="driver_license_state10" name="driver_license_state10">
                                                    </div>
                                                </div>
                                            </div>
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
                                                    <select id="form_status2" class="form-control" name="form_status"
                                                        required="">
                                                        <option value="Intrested">Intrested</option>
                                                        <option value="Pipeline">Pipeline</option>
                                                    </select>
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-6">
                                                <div class="pt-4">
                                                    <label id="model-form-status" class="form-label">Intrested</label>
                                                    <div class="progress animated-progress custom-progress mb-4"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                        aria-expanded="false" style="cursor:pointer;">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width:100%" ;="" aria-valuenow="100"
                                                            aria-valuemin="0" aria-valuemax="100" id="progress-bar">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" name="redmark" id="coverwell"
                                                            value="2" class="form-check-input"
                                                            onclick="toggleCheckbox('coverwell', 'redmark')">
                                                        Good Form
                                                    </label>
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" name="redmark" id="redmark"
                                                            value="1" class="form-check-input"
                                                            onclick="toggleCheckbox('redmark', 'coverwell')">
                                                        Bad Form
                                                    </label>
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-6 reminder" style="display: none;">
                                                <div class="pb-4">
                                                    <label for="dateInput" class="form-label">Date</label>
                                                    <input type="date" class="form-control" id="dateInput1"
                                                        name="dateInput">

                                                    <label for="timeInput" class="form-label">Time</label>
                                                    <input type="time" class="form-control" id="timeInput1"
                                                        name="timeInput">
                                                    <input type="hidden" name="reminder" id="reminder1"></input>
                                                    <button onclick="setReminder()">Set Reminder</button>
                                                </div>
                                            </div>
                                            <div class="col-12" >                                                                      <!-- Display Comments Section -->
                                                <div class="modal-body" id="commentsBody">
                                                    <!-- Comments will be dynamically populated here -->
                                                </div>
                                                   </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="citynameInput" class="form-label">Comment </label>
                                                    <textarea id="comment" name="comment" class="form-control" rows="4" placeholder="Write a Coment...."
                                                        required=""></textarea>
                                                </div>
                                            </div><!--end col-->

                                            <div class="col-12">
                                                <p>Error/Correction File Upload</p>
                                                <div class="mb-3">
                                                    <input class="form-control" style="margin-left: 10px"
                                                        type="file" value="" name="errorfile">
                                                </div>
                                                <button type="button" id="openerror1"
                                                    style="
                                        margin-bottom: 12px;
                                    "
                                                    class="btn btn-primary">Open file</button>
                                            </div><!--end col-->
                                            <div class="col-12">
                                                <h4>Policy</h4>
                                            </div>
                                            <div class="col-6">

                                                <div class="mb-3">
                                                    <label for="Liability" class="form-label">Liability limit</label>
                                                    <select id="Liability"class="form-control" name="Liability">
                                                        <option value="N/A">N/A</option>
                                                        <option value="$250,000">$250,000</option>
                                                        <option value="$300,000">$300,000</option>
                                                        <option value="$500,000">$500,000</option>
                                                        <option value="$750,000">$750,000</option>
                                                        <option value="$1,000,000">$1,000,000</option>
                                                        <option value="$1,500,000">$1,500,000</option>
                                                        <option value="$1,750,000">$1,750,000</option>
                                                        <option value="$2,000,000">$2,000,000</option>
                                                    </select>
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="MTC" class="form-label">Do you need MTC ?</label>
                                                    <select id="MTC" class="form-control" name="MTC">
                                                        <option value="N/A">N/A</option>
                                                        <option value="$25,000">$25,000</option>
                                                        <option value="$50,000">$50,000</option>
                                                        <option value="$100,000">$100,000</option>
                                                        <option value="$150,000">$150,000</option>
                                                        <option value="$200,000">$200,000</option>
                                                        <option value="$250,000">$250,000</option>  
                                                        <option value="$300,000">$300,000</option>
                                                        <option value="$500,000">$500,000</option>
                                                    </select>
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-7">
                                                <div class="mb-3">
                                                    <label for="ForminputState" class="form-label">Trailer
                                                        interchange</label>
                                                    <select id="interchange" class="form-control" name="interchange">
                                                        <option value="N/A">N/A</option>
                                                        <option value="$1,000">$1,000</option>
                                                        <option value="$2,500">$2,500</option>
                                                        <option value="$5,000">$5,000</option>
                                                        <option value="$10,000">$10,000</option>
                                                        <option value="$15,000">$15,000</option>
                                                        <option value="$25,000">$25,000</option>
                                                        <option value="$30,000">$30,000</option>
                                                        <option value="$40,000">$40,000</option>
                                                        <option value="$50,000">$50,000</option>
                                                        <option value="$60,000">$60,000</option>
                                                        <option value="$75,000">$75,000</option>
                                                        <option value="$100,000">$100,000</option>
                                                    </select>
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" name="physical" id="physicall"
                                                            value="1" class="form-check-input">
                                                        Physical Damage
                                                    </label>
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" name="general" id="generall"
                                                            value="1" class="form-check-input">
                                                        General Liability
                                                    </label>
                                                </div>
                                            </div><!--end col-->
                                            <hr />
                                            <div class="col-12">
                                                <h5>Documents/Files</h5>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <input class="form-control" style="margin-left: 10px"
                                                        type="file" value="" name="file1">
                                                </div>
                                                <button type="button" id="openPdfButton1"
                                                    style="
                                        margin-bottom: 12px;
                                    "
                                                    class="btn btn-primary">Open file</button>
                                            </div><!--end col-->
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <input class="form-control" style="margin-left: 10px"
                                                        type="file" value="" name="file2">
                                                </div>
                                                <button type="button" id="openPdfButton2"
                                                    style="
                                        margin-bottom: 12px;
                                    "
                                                    class="btn btn-primary">Open file</button>
                                            </div><!--end col-->
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <input class="form-control" style="margin-left: 10px"
                                                        type="file" value="" name="file3">
                                                </div>
                                                <button type="button" id="openPdfButton3"
                                                    style="
                                        margin-bottom: 12px;
                                    "
                                                    class="btn btn-primary">Open file</button>
                                            </div><!--end col-->
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <input class="form-control" style="margin-left: 10px"
                                                        type="file" value="" name="file4">
                                                </div>
                                                <button type="button" id="openPdfButton4"
                                                    style="
                                        margin-bottom: 12px;
                                    "
                                                    class="btn btn-primary">Open file</button>
                                            </div><!--end col-->
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <input class="form-control" style="margin-left: 10px"
                                                        type="file" value="" name="file5">
                                                </div>
                                                <button type="button" id="openPdfButton5"
                                                    style="
                                        margin-bottom: 12px;
                                    "
                                                    class="btn btn-primary">Open file</button>
                                            </div><!--end col-->
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <input class="form-control" style="margin-left: 10px"
                                                        type="file" value="" name="file6">
                                                </div>
                                                <button type="button" id="openPdfButton6"
                                                    style="
                                        margin-bottom: 12px;
                                    "
                                                    class="btn btn-primary">Open file</button>
                                            </div><!--end col-->
                                              <div class="col-6">
                                                <div class="mb-3">
                                                    <!-- Hidden File Input -->
                                                    <input 
                                                        id="audioInput" 
                                                        class="form-control" 
                                                        style="display: none;" 
                                                        type="file" 
                                                        accept="audio/*" 
                                                        name="audioFile" 
                                                    >
                                                    <!-- Custom Label for File Input -->
                                                    <label 
                                                        for="audioInput" 
                                                        class="btn btn-secondary" 
                                                        style="margin-left: 10px;"
                                                    >
                                                        Choose Audio
                                                    </label>
                                                    <!-- Display Selected File Name -->
                                                    <span id="audioFileName" style="margin-left: 10px;">No file chosen</span>
                                                </div>  
                                                <div id="audioPlayerContainer" >
                                                    <!-- The audio player will appear here dynamically -->
                                                </div>     
                                            </div><!-- end col -->
                                            <!-- Optional Script to Display Selected File Name -->
                                            <script>
                                                document.getElementById('audioInput').addEventListener('change', function(event) {
                                                    const fileName = event.target.files[0] ? event.target.files[0].name : "No file chosen";
                                                    document.getElementById('audioFileName').textContent = fileName;
                                                });
                                            </script>
                                            <input type="hidden" name="verify_level" value="4">
                                            <div class="col-lg-12">
                                                <div class="text-end">
                                                    <div class="mt-4">
                                                        <div class="hstack gap-2 justify-content-center">
                                                            <a href="javascript:void(0);"
                                                                class="btn btn-link link-danger fw-medium"
                                                                data-bs-dismiss="modal"><i
                                                                    class="ri-close-line me-1 align-middle"></i>
                                                                Close</a>
                                                            <button type="submit"
                                                                class="btn btn-primary">Submit</button>
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
            {{-- modal end --}}


                                <link rel="stylesheet"
                                    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

                                <style>
                                    body {
                                        font-family: Arial, sans-serif;
                                        background-color: #f0f2f5;
                                        margin: 0;
                                        padding: 0;
                                    }

                                    .container {
                                        display: flex;
                                        gap: 20px;
                                        padding: 20px;
                                        overflow-x: auto;
                                    }

                                    .column {
                                        background-color: #ffffff;
                                        border-radius: 8px;
                                        width: 300px;
                                        padding: 15px;
                                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                                        flex-shrink: 0;
                                        max-height: 600px;
                                        overflow-y: auto;
                                        position: relative;
                                    }

                                    .column-header {
                                        display: flex;
                                        justify-content: space-between;
                                        align-items: center;
                                    }

                                    .column h3 {
                                        margin-bottom: 15px;
                                        color: #333;
                                        font-size: 18px;
                                        flex-grow: 1;
                                    }

                                    .lead-count {
                                        color: #007bff;
                                        font-size: 14px;
                                    }

                                    .star-toggle {
                                        color: #ccc;
                                        cursor: pointer;
                                        margin-left: 5px;
                                    }

                                    .star-toggle.active {
                                        color: #ff0;
                                    }

                                    .pagination-controls {
                                        display: flex;
                                        justify-content: space-between;
                                        align-items: center;
                                        margin-bottom: 10px;
                                    }

                                    .pagination-controls .page-info {
                                        font-size: 14px;
                                        color: #888;
                                    }

                                    .pagination-controls button {
                                        background-color: #007bff;
                                        color: #ffffff;
                                        border: none;
                                        padding: 5px 10px;
                                        border-radius: 4px;
                                        cursor: pointer;
                                    }

                                    .pagination-controls button:disabled {
                                        background-color: #cccccc;
                                        cursor: not-allowed;
                                    }

                                    .lead-card {
                                        background-color: #f8f9fc;
                                        color: #333;
                                        padding: 15px;
                                        border-radius: 8px;
                                        margin-bottom: 10px;
                                        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                                        display: flex;
                                        flex-direction: column;
                                        position: relative;
                                        border: 1px solid #e1e4e8;
                                    }

                                    .lead-card:hover {
                                        background-color: #e9ecef;
                                    }

                                    .lead-info {
                                        margin-bottom: 10px;
                                        padding-left: 25px;
                                        position: relative;
                                    }

                                    .lead-info .lead-name {
                                        font-weight: bold;
                                        font-size: 16px;
                                        color: #2c3e50;
                                    }

                                    .lead-name {
                                        width: 180px;
                                        /* Set the desired fixed width */
                                        white-space: nowrap;
                                        /* Prevents text from wrapping */
                                        overflow: hidden;
                                        /* Hides any overflowed text */
                                        text-overflow: ellipsis;
                                        /* Adds "..." for overflowing text */
                                    }

                                    .lead-info .lead-date {
                                        color: #888;
                                        font-size: 14px;
                                    }

                                    .lead-contact {
                                        background-color: #333;
                                        color: #ffffff;
                                        padding: 5px 10px;
                                        border-radius: 12px;
                                        font-size: 14px;
                                        align-self: start;
                                    }

                                    .lead-avatar {
                                        width: 40px;
                                        height: 40px;
                                        border-radius: 50%;
                                        border: 2px solid #007bff;
                                        color: #007bff;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        font-weight: bold;
                                        font-size: 16px;
                                        position: absolute;
                                        top: 15px;
                                        right: 15px;
                                    }

                                    .lead-star {
                                        color: #ccc;
                                        cursor: pointer;
                                        position: absolute;
                                        top: 0;
                                        left: 0;
                                        font-size: 20px;
                                    }

                                    .lead-star.active {
                                        color: #ff0;
                                    }
                                </style>
                                </head>

                                <body>
                                    <div class="container">
                                        <div class="column" id="verified">
                                            <div class="column-header">
                                                <h3>Verified <span class="lead-count" id="verified-count"></span></h3>
                                                <i class="fa fa-star star-toggle" id="verified-star-toggle"></i>
                                            </div>
                                            <div class="pagination-controls">
                                                <button id="verified-prev" disabled>Prev</button>
                                                <div class="page-info" id="verified-page-info"></div>
                                                <button id="verified-next">Next</button>
                                            </div>
                                        </div>
                                        <div class="column" id="new">
                                            <div class="column-header">
                                                <h3>New <span class="lead-count" id="new-count"></span></h3>
                                                <i class="fa fa-star star-toggle" id="new-star-toggle"></i>
                                            </div>
                                            <div class="pagination-controls">
                                                <button id="new-prev" disabled>Prev</button>
                                                <div class="page-info" id="new-page-info"></div>
                                                <button id="new-next">Next</button>
                                            </div>
                                        </div>
                                        <div class="column" id="duplicate">
                                            <div class="column-header">
                                                <h3>Duplicate <span class="lead-count" id="duplicate-count"></span></h3>
                                                <i class="fa fa-star star-toggle" id="duplicate-star-toggle"></i>
                                            </div>
                                            <div class="pagination-controls">
                                                <button id="duplicate-prev" disabled>Prev</button>
                                                <div class="page-info" id="duplicate-page-info"></div>
                                                <button id="duplicate-next">Next</button>
                                            </div>
                                        </div>
                                        <div class="column" id="pending-information">
                                            <div class="column-header">
                                                <h3>Pending Information & Loss Runs <span class="lead-count"
                                                        id="pending-information-count"></span></h3>
                                                <i class="fa fa-star star-toggle"
                                                    id="pending-information-star-toggle"></i>
                                            </div>
                                            <div class="pagination-controls">
                                                <button id="pending-information-prev" disabled>Prev</button>
                                                <div class="page-info" id="pending-information-page-info"></div>
                                                <button id="pending-information-next">Next</button>
                                            </div>
                                        </div>
                                        <div class="column" id="submitted">
                                            <div class="column-header">
                                                <h3>Submitted <span class="lead-count" id="submitted-count"></span></h3>
                                                <i class="fa fa-star star-toggle" id="submitted-star-toggle"></i>
                                            </div>
                                            <div class="pagination-controls">
                                                <button id="submitted-prev" disabled>Prev</button>
                                                <div class="page-info" id="submitted-page-info"></div>
                                                <button id="submitted-next">Next</button>
                                            </div>
                                        </div>
                                        <div class="column" id="dead">
                                            <div class="column-header">
                                                <h3>Dead <span class="lead-count" id="dead-count"></span></h3>
                                                <i class="fa fa-star star-toggle" id="dead-star-toggle"></i>
                                            </div>
                                            <div class="pagination-controls">
                                                <button id="dead-prev" disabled>Prev</button>
                                                <div class="page-info" id="dead-page-info"></div>
                                                <button id="dead-next">Next</button>
                                            </div>
                                        </div>
                                        <div class="column" id="done-count">
                                            <div class="column-header">
                                                <h3>Quoted & Counted <span class="lead-count" id="done-count-count"></span>
                                                </h3>
                                                <i class="fa fa-star star-toggle" id="done-count-star-toggle"></i>
                                            </div>
                                            <div class="pagination-controls">
                                                <button id="done-count-prev" disabled>Prev</button>
                                                <div class="page-info" id="done-count-page-info"></div>
                                                <button id="done-count-next">Next</button>
                                            </div>
                                        </div>
                                        <div class="column" id="sold">
                                            <div class="column-header">
                                                <h3>Sold <span class="lead-count" id="sold-count"></span></h3>
                                                <i class="fa fa-star star-toggle" id="sold-star-toggle"></i>
                                            </div>
                                            <div class="pagination-controls">
                                                <button id="sold-prev" disabled>Prev</button>
                                                <div class="page-info" id="sold-page-info"></div>
                                                <button id="sold-next">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                    <script>
                                        let leadData = []; // Initialize leadData as an empty array

                                        $(document).ready(function() {
                                     // Base URL for your route
let url = "{{ route('leads.verified') }}";

// Get the values of your input fields
let searchInput = $('#search_input').val();
let agent = $('#agent').val();
let date1 = $('#date1').val();
let date2 = $('#date2').val();

// Array to store the query parameters
let queryParams = [];

// Check if each input is not empty and add it to the query parameters
if (searchInput) {
    queryParams.push(`search_input=${encodeURIComponent(searchInput)}`);
}
if (agent) {
    queryParams.push(`agent=${encodeURIComponent(agent)}`);
}
if (date1) {
    queryParams.push(`date1=${encodeURIComponent(date1)}`);
}
if (date2) {
    queryParams.push(`date2=${encodeURIComponent(date2)}`);
}

// If there are query parameters, add them to the URL
if (queryParams.length) {
    url += `?${queryParams.join('&')}`;
}

                                            $.ajax({
                                                url: url,
                                                type: 'GET',
                                                dataType: 'json',
                                                success: function(response) {
                                                    // Map the response to the structure of leadData
                                                    leadData = response.map(lead => ({
                                                        id: lead.id,
                                                        name: lead.company_name,
                                                        status: lead.verify_status ||
                                                        "N/A", // Set default if status is not present
                                                        avatar: lead.company_name ? lead.company_name.charAt(0)
                                                        .toUpperCase() : "N/A", // Set default if avatar is not present
                                                        contact: lead.user_detail ? lead.user_detail.alise_name :
                                                        "N/A", // Set default if contact is not present
                                                        date: lead.date || "N/A", // Set default if date is not present
                                                        starred: lead.star_mark ||
                                                            false // Set default if starred is not present
                                                    }));

                                                    // Render leads for each status after the data has been loaded
                                                    Object.keys(state).forEach(status => renderLeads(state[status], status));
                                                },
                                                error: function(xhr, status, error) {
                                                    $('#result').text('Error loading data: ' + error);
                                                }
                                            });
                                        });

                                        const leadsPerPage = 10;
                                        const state = {
                                            verified: 1,
                                            new: 1,
                                            duplicate: 1,
                                            'pending-information': 1,
                                            submitted: 1,
                                            dead: 1,
                                            'done-count': 1,
                                            sold: 1
                                        };
                                        const starFilterState = {
                                            verified: false,
                                            new: false,
                                            duplicate: false,
                                            'pending-information': false,
                                            submitted: false,
                                            dead: false,
                                            'done-count': false,
                                            sold: false
                                        };

                                        function createLeadCard(lead) {
                                            const card = document.createElement('div');
                                            card.className = 'lead-card';
                                            card.draggable = true;
                                            card.dataset.id = lead.id;

                                            const star = document.createElement('i');
                                            star.className = `fa fa-star lead-star ${lead.starred ? 'active' : ''}`;
                                            star.addEventListener('click', () => {
                                                lead.starred = !lead.starred;
                                                star.classList.toggle('active');

                                                // AJAX request to update star status
                                                $.ajax({
                                                    url: "{{ route('leads.update-status') }}",
                                                    type: 'POST',
                                                    data: {
                                                        id: lead.id,
                                                        starred: lead.starred,
                                                        _token: '{{ csrf_token() }}'
                                                    },
                                                    success: function(response) {
                                                        console.log("Star status updated successfully:", response);
                                                    },
                                                    error: function(xhr, status, error) {
                                                        console.error("Error updating star status:", error);
                                                        alert("Failed to update star status. Please try again.");
                                                    }
                                                });
                                            });

                                            const avatar = document.createElement('div');
                                            avatar.className = 'lead-avatar';
                                            avatar.textContent = lead.avatar;

                                            const info = document.createElement('div');
                                            info.className = 'lead-info';

                                            const leadName = document.createElement('div');
                                            leadName.className = 'lead-name';
                                            leadName.textContent = lead.name;

                                            // Add click event to open modal with details
                                            leadName.addEventListener('click', () => openLeadModal(lead.id));

                                            const leadDate = document.createElement('div');
                                            leadDate.className = 'lead-date';
                                            leadDate.textContent = `Entered on: ${lead.date}`;

                                            info.appendChild(leadName);
                                            info.appendChild(leadDate);

                                            const contact = document.createElement('div');
                                            contact.className = 'lead-contact';
                                            contact.textContent = lead.contact;

                                            card.appendChild(star);
                                            card.appendChild(avatar);
                                            card.appendChild(info);
                                            card.appendChild(contact);

                                            card.addEventListener('dragstart', (e) => {
                                                e.dataTransfer.setData('text/plain', lead.id);
                                            });

                                            return card;
                                        }

                                        function renderLeads(page, status) {
                                            const column = document.getElementById(status);
                                            column.querySelectorAll('.lead-card').forEach(card => card.remove());

                                            let filteredLeads = leadData.filter(lead => lead.status === status);
                                            if (starFilterState[status]) {
                                                filteredLeads = filteredLeads.filter(lead => lead.starred);
                                            }

                                            const starredLeads = filteredLeads.filter(lead => lead.starred);
                                            const nonStarredLeads = filteredLeads.filter(lead => !lead.starred);
                                            const sortedLeads = [...starredLeads, ...nonStarredLeads];

                                            const startIndex = (page - 1) * leadsPerPage;
                                            const endIndex = startIndex + leadsPerPage;
                                            const leadsToShow = sortedLeads.slice(startIndex, endIndex);

                                            leadsToShow.forEach(lead => {
                                                const card = createLeadCard(lead);
                                                column.insertBefore(card, column.querySelector('.pagination-controls'));
                                            });

                                            renderPagination(status, page, Math.ceil(filteredLeads.length / leadsPerPage));
                                            document.getElementById(`${status}-count`).textContent = `(${filteredLeads.length})`;
                                        }

                                        function renderPagination(status, currentPage, totalPages) {
                                            const prevButton = document.getElementById(`${status}-prev`);
                                            const nextButton = document.getElementById(`${status}-next`);
                                            const pageInfo = document.getElementById(`${status}-page-info`);

                                            pageInfo.textContent = `${currentPage}/${totalPages}`;
                                            prevButton.disabled = currentPage === 1;
                                            nextButton.disabled = currentPage === totalPages;

                                            prevButton.onclick = () => {
                                                state[status]--;
                                                renderLeads(state[status], status);
                                            };

                                            nextButton.onclick = () => {
                                                state[status]++;
                                                renderLeads(state[status], status);
                                            };
                                        }

                                        document.querySelectorAll('.column').forEach(column => {
                                            column.addEventListener('dragover', (e) => {
                                                e.preventDefault();
                                            });

                                            column.addEventListener('drop', (e) => {
                                                e.preventDefault();

                                                const leadId = e.dataTransfer.getData('text/plain');
                                                const lead = leadData.find(l => l.id == leadId);
                                                const newStatus = column.id; // Get the ID of the column as the new status
                                                const oldStatus = lead.status; // Save the old status

                                                // Update the lead's status in the data
                                                lead.status = newStatus;

                                                // Perform the AJAX request
                                                $.ajax({
                                                    url: "{{ route('leads.update-status') }}", // Your update status route
                                                    type: 'POST',
                                                    data: {
                                                        id: leadId,
                                                        status: newStatus,
                                                        starred: lead.starred,
                                                        _token: '{{ csrf_token() }}' // Include CSRF token if required
                                                    },
                                                    success: function(response) {
                                                        console.log("Status updated successfully:", response);

                                                        // Re-render the leads in both old and new columns to reflect the change
                                                        renderLeads(state[oldStatus], oldStatus); // Re-render the old column
                                                        renderLeads(state[newStatus],
                                                        newStatus); // Render the new column with the updated lead
                                                    },
                                                    error: function(xhr, status, error) {
                                                        console.error("Error updating status:", error);
                                                        alert("Failed to update lead status. Please try again.");
                                                    }
                                                });
                                            });
                                        });



                                        document.querySelectorAll('.star-toggle').forEach(starToggle => {
                                            starToggle.addEventListener('click', () => {
                                                const columnId = starToggle.id.replace('-star-toggle', '');
                                                starFilterState[columnId] = !starFilterState[columnId];
                                                starToggle.classList.toggle('active');
                                                state[columnId] = 1;
                                                renderLeads(state[columnId], columnId);
                                            });
                                        });

                                        function openLeadModal(leadId) {
                                            const baseLeadUrl = `{{ route('getLeadById', ['id' => '']) }}`;
                                            const leadUrl = `${baseLeadUrl}/${leadId}`;
                                            $.ajax({

                                                url: leadUrl, // Update route if needed
                                                type: 'GET',
                                                dataType: 'json',
                                                success: function(response) {
    // Populate form fields
    $('#company_name').val(response.company_name);
    $('#phone').val(response.phone);
    $('#company_rep1').val(response.company_rep1);
    $('#business_address').val(response.business_address);
    $('#business_city').val(response.business_city);
    $('#business_state').val(response.business_state);
    $('#business_zip').val(response.business_zip);
    $('#dot').val(response.dot);
    $('#mc_docket').val(response.mc_docket);
    $('#data_id').val(response.id);
    $('#email').val(response.email);
    $('#unit_owned2').val(response.unit_owned);
    $('#vin').val(response.vin);
    $('#driver_name').val(response.driver_name);
    $('#driver_dob').val(response.driver_dob);
    $('#driver_license').val(response.driver_license);
    $('#driver_license_state').val(response.driver_license_state);
    $('#vehicle_year').val(response.vehicle_year);
    $('#vehicle_make').val(response.vehicle_make);
    $('#stated_value').val(response.stated_value);

    // Parse commodities string to array
    let commodities = [];
    try {
        commodities = JSON.parse(response.commodities); // Parse if it is a JSON string
    } catch (error) {
        console.error("Error parsing commodities:", error);
        return; // Exit if parsing fails
    }

    // Reset all checkboxes to unchecked state
    const checkboxIds = [
        "building_machinery",
        "buildingmaterials",
        "Dry-Freight-Amazon",
        "Dry-Freight",
        "Reefer_with_seafood_or_flowers",
        "Refrigerated_Goods",
        "Reefer_with_flowers",
        "Fracking-Sand",
        "Hazard",
        "Containerized-Freight",
        "SandGravel",
        "100",
        "HaulsOversizedOverweight"
    ];

    // Uncheck all checkboxes first
    checkboxIds.forEach(id => {
        $('#' + id).prop('checked', false);
    });

    // Commodity checkboxes mapping and updating
    const commoditiesMap = {
        "Building Materials - Machinery": "building_machinery",
        "Building Materials": "buildingmaterials",
        "Dry Freight - Amazon": "Dry-Freight-Amazon",
        "Dry Freight": "Dry-Freight",
        "Reefer with seafood or flowers": "Reefer_with_seafood_or_flowers",
        "Refrigerated Goods": "Refrigerated_Goods",
        "Reefer with flowers": "Reefer_with_flowers",
        "Fracking Sand": "Fracking-Sand",
        "Hazard": "Hazard",
        "Containerized Freight": "Containerized-Freight",
        "Sand & Gravel": "SandGravel",
        "Auto 100%": "100",
        "Hauls Oversized/Overweight": "HaulsOversizedOverweight"
    };

    // Check if commodities is an array and update checkboxes
    if (Array.isArray(commodities)) {
        // Debugging: Log the commodities received
        console.log('Received commodities:', commodities);
        
        Object.keys(commoditiesMap).forEach(commodity => {
            const checkboxId = commoditiesMap[commodity];
            // Debugging: Log checkbox id and whether it should be checked
            const shouldCheck = commodities.includes(commodity);
            console.log(`Setting checkbox ${checkboxId} to ${shouldCheck}`);
            $('#' + checkboxId).prop('checked', shouldCheck);
        });
    } else {
        console.error('Commodities is not an array:', commodities);
    }

                $('#MTC').val(response.MTC);
                $('#Liability').val(response.Liability);
                $('#interchange').val(response.interchange);
               
               $('#physicall').prop('checked', response.physical == 1);
                $('#generall').prop('checked', response.general == 1);

                $('#redmark').prop('checked', response.red_mark == 1);
                $('#coverwell').prop('checked', response.red_mark == 2);

// Display PDF1
var file = response.file1; // Using response.file1
var pdfPath = "{{ asset(':file') }}";
pdfPath = pdfPath.replace(':file', file);

if (file) {
    // Attach click event to open PDF in new tab or window
    $('#openPdfButton1').on('click', function() {
        window.open(pdfPath, '_blank');
    });
} else {
    $('#openPdfButton1').hide();
}

// Display PDF2
var file2 = response.file2; // Using response.file2
var pdfPath2 = "{{ asset(':file2') }}";
pdfPath2 = pdfPath2.replace(':file2', file2);

if (file2) {
    // Attach click event to open PDF in new tab or window
    $('#openPdfButton2').on('click', function() {
        window.open(pdfPath2, '_blank');
    });
} else {
   $('#openPdfButton2').css('display', 'none');
}

// Display PDF3
var file3 = response.file3; // Using response.file3
var pdfPath3 = "{{ asset(':file3') }}";
pdfPath3 = pdfPath3.replace(':file3', file3);

if (file3) {
    // Attach click event to open PDF in new tab or window
    $('#openPdfButton3').on('click', function() {
        window.open(pdfPath3, '_blank');
    });
} else {
   $('#openPdfButton3').css('display', 'none');
}

// Display PDF4
var file4 = response.file4; // Using response.file4
var pdfPath4 = "{{ asset(':file4') }}";
pdfPath4 = pdfPath4.replace(':file4', file4);

if (file4) {
    // Attach click event to open PDF in new tab or window
    $('#openPdfButton4').on('click', function() {
        window.open(pdfPath4, '_blank');
    });
} else {
    $('#openPdfButton4').css('display', 'none');
}

// Display PDF5
var file5 = response.file5; // Using response.file5
var pdfPath5 = "{{ asset(':file5') }}";
pdfPath5 = pdfPath5.replace(':file5', file5);

if (file5) {
    // Attach click event to open PDF in new tab or window
    $('#openPdfButton5').on('click', function() {
        window.open(pdfPath5, '_blank');
    });
} else {
    $('#openPdfButton5').css('display', 'none');
}

// Display PDF6
var file6 = response.file6; // Using response.file6
var pdfPath6 = "{{ asset(':file6') }}";
pdfPath6 = pdfPath6.replace(':file6', file6);

if (file6) {
    // Attach click event to open PDF in new tab or window
    $('#openPdfButton6').on('click', function() {
        window.open(pdfPath6, '_blank');
    });
} else {
   $('#openPdfButton6').css('display', 'none');
}

// Display error file
var errorfile = response.error_file; // Using response.error_file
var errorPath = "{{ asset(':error_file') }}";
errorPath = errorPath.replace(':error_file', errorfile);

if (errorfile) {
    // Attach click event to open PDF in new tab or window
    $('#openerror1').on('click', function() {
        window.open(errorPath, '_blank');
    });
} else {
   $('#openerror1').css('display', 'none');
}
// Display audio file
//  var audio_file = td.data('audio_file'); // Get the audio file path

var audio_file = response.audio_file; // Pass the file name from Laravel
// Build the full audio URL in JavaScript using Blade syntax
var audio_path = "{{ asset('audio/') }}/" + audio_file;  // Construct the full audio URL
console.log(audio_path);  // For debugging
if (audio_file) {
    // Show an audio player dynamically
    var audioPlayerHTML = `
        <audio controls style="width: 100%; margin-top: 10px;">
            <source src="${audio_path}" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>`;
    $('#audioPlayerContainer').html(audioPlayerHTML); // Add the audio player to the container
} else {
    // Hide or remove the audio player if no audio file exists
    $('#audioPlayerContainer').html('<p style="margin-top: 10px;">No audio file available.</p>');
}

                // Retrieve comment data as a raw string
                let commentData = response.comment; 
let commentsHtml = '';

try {
    // Parse the JSON data as a string
    let comments = commentData ? JSON.parse(commentData) : [];
    
    commentsHtml = comments.length
        ? comments.map(comment => `
            <div class="comment mb-2">
                <strong>${comment.agent_name}</strong>
                <small>(${new Date(comment.created_at).toLocaleString()})</small>:
                <p>${comment.comment}</p>
            </div>
        `).join('')
        : '<p>No comments yet. Be the first to comment on this lead!</p>';
} catch (e) {
    console.error("Error parsing comments: ", e);
    $('#comment').val(response.comment);
}

// Populate the modal's comments body with the generated HTML
$('#commentsBody').html(commentsHtml);

// Assuming 'response' is the object containing your data
$('#vin2').val(response.unit_owned.vin2);
$('#driver_name2').val(response.unit_owned.driver_name2);
$('#driver_dob2').val(response.unit_owned.driver_dob2);
$('#driver_license2').val(response.unit_owned.driver_license2);
$('#driver_license_state2').val(response.unit_owned.driver_license_state2);
$('#vehicle_year2').val(response.unit_owned.vehicle_year2);
$('#vehicle_make2').val(response.unit_owned.vehicle_make2);
$('#stated_value2').val(response.unit_owned.stated_value2);

$('#vin3').val(response.unit_owned.vin3);
$('#driver_name3').val(response.unit_owned.driver_name3);
$('#driver_dob3').val(response.unit_owned.driver_dob3);
$('#driver_license3').val(response.unit_owned.driver_license3);
$('#driver_license_state3').val(response.unit_owned.driver_license_state3);
$('#vehicle_year3').val(response.unit_owned.vehicle_year3);
$('#vehicle_make3').val(response.unit_owned.vehicle_make3);
$('#stated_value3').val(response.unit_owned.stated_value3);

$('#vin4').val(response.unit_owned.vin4);
$('#driver_name4').val(response.unit_owned.driver_name4);
$('#driver_dob4').val(response.unit_owned.driver_dob4);
$('#driver_license4').val(response.unit_owned.driver_license4);
$('#driver_license_state4').val(response.unit_owned.driver_license_state4);
$('#vehicle_year4').val(response.unit_owned.vehicle_year4);
$('#vehicle_make4').val(response.unit_owned.vehicle_make4);
$('#stated_value4').val(response.unit_owned.stated_value4);

$('#vin5').val(response.unit_owned.vin5);
$('#driver_name5').val(response.unit_owned.driver_name5);
$('#driver_dob5').val(response.unit_owned.driver_dob5);
$('#driver_license5').val(response.unit_owned.driver_license5);
$('#driver_license_state5').val(response.unit_owned.driver_license_state5);
$('#vehicle_year5').val(response.unit_owned.vehicle_year5);
$('#vehicle_make5').val(response.unit_owned.vehicle_make5);
$('#stated_value5').val(response.unit_owned.stated_value5);

// For Unit 6
$('#vin6').val(response.unit_owned.vin6);
$('#driver_name6').val(response.unit_owned.driver_name6);
$('#driver_dob6').val(response.unit_owned.driver_dob6);
$('#driver_license6').val(response.unit_owned.driver_license6);
$('#driver_license_state6').val(response.unit_owned.driver_license_state6);
$('#vehicle_year6').val(response.unit_owned.vehicle_year6);
$('#vehicle_make6').val(response.unit_owned.vehicle_make6);
$('#stated_value6').val(response.unit_owned.stated_value6);

// For Unit 7
$('#vin7').val(response.unit_owned.vin7);
$('#driver_name7').val(response.unit_owned.driver_name7);
$('#driver_dob7').val(response.unit_owned.driver_dob7);
$('#driver_license7').val(response.unit_owned.driver_license7);
$('#driver_license_state7').val(response.unit_owned.driver_license_state7);
$('#vehicle_year7').val(response.unit_owned.vehicle_year7);
$('#vehicle_make7').val(response.unit_owned.vehicle_make7);
$('#stated_value7').val(response.unit_owned.stated_value7);

// For Unit 8
$('#vin8').val(response.unit_owned.vin8);
$('#driver_name8').val(response.unit_owned.driver_name8);
$('#driver_dob8').val(response.unit_owned.driver_dob8);
$('#driver_license8').val(response.unit_owned.driver_license8);
$('#driver_license_state8').val(response.unit_owned.driver_license_state8);
$('#vehicle_year8').val(response.unit_owned.vehicle_year8);
$('#vehicle_make8').val(response.unit_owned.vehicle_make8);
$('#stated_value8').val(response.unit_owned.stated_value8);

// For Unit 9
$('#vin9').val(response.unit_owned.vin9);
$('#driver_name9').val(response.unit_owned.driver_name9);
$('#driver_dob9').val(response.unit_owned.driver_dob9);
$('#driver_license9').val(response.unit_owned.driver_license9);
$('#driver_license_state9').val(response.unit_owned.driver_license_state9);
$('#vehicle_year9').val(response.unit_owned.vehicle_year9);
$('#vehicle_make9').val(response.unit_owned.vehicle_make9);
$('#stated_value9').val(response.unit_owned.stated_value9);

// For Unit 10
$('#vin10').val(response.unit_owned.vin10);
$('#driver_name10').val(response.unit_owned.driver_name10);
$('#driver_dob10').val(response.unit_owned.driver_dob10);
$('#driver_license10').val(response.unit_owned.driver_license10);
$('#driver_license_state10').val(response.unit_owned.driver_license_state10);
$('#vehicle_year10').val(response.unit_owned.vehicle_year10);
$('#vehicle_make10').val(response.unit_owned.vehicle_make10);
$('#stated_value10').val(response.unit_owned.stated_value10);

// Check and set values and visibility for VINs and Driver Names from response.unit_owned

// Check and toggle visibility for unit 2
var vin2 = response.unit_owned.vin2;
$('#vin2').val(vin2);
if (!vin2) {
    $('#unit22').hide();
} else {
    $('#unit22').show();
}

// Check and toggle visibility for unit 3
var vin3 = response.unit_owned.vin3;
$('#vin3').val(vin3);
if (!vin3) {
    $('#unit33').hide();
} else {
    $('#unit33').show();
}

// Check and toggle visibility for unit 4
var vin4 = response.unit_owned.vin4;
$('#vin4').val(vin4);
if (!vin4) {
    $('#unit44').hide();
} else {
    $('#unit44').show();
}

// Check and toggle visibility for unit 5
var vin5 = response.unit_owned.vin5;
$('#vin5').val(vin5);
if (!vin5) {
    $('#unit55').hide();
} else {
    $('#unit55').show();
}

// Check and toggle visibility for unit 6
var vin6 = response.unit_owned.vin6;
$('#vin6').val(vin6);
if (!vin6) {
    $('#unit66').hide();
} else {
    $('#unit66').show();
}

// Check and toggle visibility for unit 7
var vin7 = response.unit_owned.vin7;
$('#vin7').val(vin7);
if (!vin7) {
    $('#unit77').hide();
} else {
    $('#unit77').show();
}

// Check and toggle visibility for unit 8
var vin8 = response.unit_owned.vin8;
$('#vin8').val(vin8);
if (!vin8) {
    $('#unit88').hide();
} else {
    $('#unit88').show();
}

// Check and toggle visibility for unit 9
var vin9 = response.unit_owned.vin9;
$('#vin9').val(vin9);
if (!vin9) {
    $('#unit99').hide();
} else {
    $('#unit99').show();
}

// Check and toggle visibility for unit 10
var vin10 = response.unit_owned.vin10;
$('#vin10').val(vin10);
if (!vin10) {
    $('#unit101').hide();
} else {
    $('#unit101').show();
}

// Check and toggle visibility for Driver Unit 2
var driver_name2 = response.unit_owned.driver_name2;
$('#driver_name2').val(driver_name2);
if (!driver_name2) {
    $('#driver22').hide();
} else {
    $('#driver22').show();
}

// Check and toggle visibility for Driver Unit 3
var driver_name3 = response.unit_owned.driver_name3;
$('#driver_name3').val(driver_name3);
if (!driver_name3) {
    $('#driver33').hide();
} else {
    $('#driver33').show();
}

// Check and toggle visibility for Driver Unit 4
var driver_name4 = response.unit_owned.driver_name4;
$('#driver_name4').val(driver_name4);
if (!driver_name4) {
    $('#driver44').hide();
} else {
    $('#driver44').show();
}

// Check and toggle visibility for Driver Unit 5
var driver_name5 = response.unit_owned.driver_name5;
$('#driver_name5').val(driver_name5);
if (!driver_name5) {
    $('#driver55').hide();
} else {
    $('#driver55').show();
}

// Check and toggle visibility for Driver Unit 6
var driver_name6 = response.unit_owned.driver_name6;
$('#driver_name6').val(driver_name6);
if (!driver_name6) {
    $('#driver66').hide();
} else {
    $('#driver66').show();
}

// Check and toggle visibility for Driver Unit 7
var driver_name7 = response.unit_owned.driver_name7;
$('#driver_name7').val(driver_name7);
if (!driver_name7) {
    $('#driver77').hide();
} else {
    $('#driver77').show();
}

// Check and toggle visibility for Driver Unit 8
var driver_name8 = response.unit_owned.driver_name8;
$('#driver_name8').val(driver_name8);
if (!driver_name8) {
    $('#driver88').hide();
} else {
    $('#driver88').show();
}

// Check and toggle visibility for Driver Unit 9
var driver_name9 = response.unit_owned.driver_name9;
$('#driver_name9').val(driver_name9);
if (!driver_name9) {
    $('#driver99').hide();
} else {
    $('#driver99').show();
}

// Check and toggle visibility for Driver Unit 10
var driver_name10 = response.unit_owned.driver_name10;
$('#driver_name10').val(driver_name10);
if (!driver_name10) {
    $('#driver101').hide();
} else {
    $('#driver101').show();
}



    // Open modal
    $('#leadModal').modal('show');
},



                                                error: function(xhr, status, error) {
                                                    console.error("Error fetching lead data:", error);
                                                    alert("Failed to load lead details.");
                                                }
                                            });
                                        }
                                    </script>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                </div>
                <!-- Page-body end -->
            </div>
        @endsection
