<!-- staticBackdrop Modal -->
<div class="modal fade" id="leaddata" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h4>Lead</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('agent.update.data') }}" method="POST">
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
                                        <input type="email" class="form-control" placeholder="example@gmail.com"
                                            id="email" name="email">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="compnayNameinput" class="form-label">Company Rep1 <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter company rep..."
                                            id="company_rep1" name="company_rep1">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="emailidInput" class="form-label">Business Address <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter business address"
                                            id="business_address" name="business_address">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="address1ControlTextarea" class="form-label">Business City <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter business city"
                                            id="business_city" name="business_city">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">Business State <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter business state"
                                            id="business_state" name="business_state">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">Business ZIP <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter business zip"
                                            id="business_zip" name="business_zip">
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
                                <div class="col-12 mb-3">
                                    <h5>Commodities</h5>
                                    <div class="row">
                                        <div class="col-6">
                                          
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Building Materials - Machinery">
                                           <label for="citynameInput" class="form-label"> Building Materials - Machinery</label>
                                           
                                        </div>
                                        <div class="col-6">
                                           
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Building Materials">
                                           <label for="citynameInput" class="form-label"> Building Materials</label>
                                           
                                        </div>
                                        <div class="col-6">
                                           
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Dry Freight - Amazon">
                                           <label for="citynameInput" class="form-label"> Dry Freight - Amazon</label>
                                           
                                        </div>
                                        <div class="col-6">
                                           
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Dry Freight">
                                           <label for="citynameInput" class="form-label"> Dry Freight</label>
                                           
                                        </div>
                                        <div class="col-6">
                                           
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Reefer with seafood or flowers">
                                           <label for="citynameInput" class="form-label"> Reefer with seafood or flowers</label>
                                           
                                        </div>
                                        <div class="col-6">
                                           
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Refrigerated Goods">
                                           <label for="citynameInput" class="form-label"> Refrigerated Goods</label>
                                           
                                        </div>
                                        <div class="col-6">
                                          
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Reefer with flowers">
                                           <label for="citynameInput" class="form-label"> Reefer with flowers</label>
                                           
                                        </div>
                                        <div class="col-6">
                                           
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Reefer with flowers">
                                           <label for="citynameInput" class="form-label"> Fracking Sand</label>
                                           
                                        </div>
                                        <div class="col-6">
                                           
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Hazard">
                                           <label for="citynameInput" class="form-label"> Hazard</label>
                                           
                                        </div>
                                        <div class="col-6">
                                          
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Containerized Freight">
                                           <label for="citynameInput" class="form-label"> Containerized Freight</label>
                                          
                                        </div>
                                        <div class="col-6">
                                          
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Sand & Gravel">
                                           <label for="citynameInput" class="form-label"> Sand & Gravel</label>
                                           
                                        </div>
                                        <div class="col-6">
                                           
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Auto 100%">
                                           <label for="citynameInput" class="form-label"> Auto 100%</label>
                                          
                                        </div>
                                        <div class="col-6">
                                           
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Hauls Oversized/Overweight">
                                           <label for="citynameInput" class="form-label"> Hauls Oversized/Overweight</label>
                                           
                                        </div>
                                    </div>
                                </div><!--end col-->
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="ForminputState" class="form-label">Unit Owned <span
                                                class="text-danger">*</span></label>
                                        <select id="unit_owned" class="form-select" name="unit_owned">
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
                                        <input type="text" class="form-control" placeholder="Enter driver name"
                                            id="driver_name" name="driver_name">
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
                                        <input type="text" class="form-control" placeholder="Enter driver license"
                                            id="driver_license" name="driver_license">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">Driver License State<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter driver license"
                                            id="driver_license_state" name="driver_license_state">
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
                                        <input type="text" class="form-control" placeholder="Enter stated value"
                                            id="stated_value" name="stated_value">
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
                                            <input type="date" class="form-control" placeholder="Enter driver dob"
                                                id="driver_dob2" name="driver_dob2">
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
                                            <label for="citynameInput" class="form-label">Driver License State2<span
                                                    class="text-danger">*</span></label>
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
                                            <input type="date" class="form-control" placeholder="Enter driver dob"
                                                id="driver_dob3" name="driver_dob3">
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
                                            <label for="citynameInput" class="form-label">Driver License State3<span
                                                    class="text-danger">*</span></label>
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
                                            <input type="date" class="form-control" placeholder="Enter driver dob"
                                                id="driver_dob4" name="driver_dob4">
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
                                            <label for="citynameInput" class="form-label">Driver License State4<span
                                                    class="text-danger">*</span></label>
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
                                            <input type="date" class="form-control" placeholder="Enter driver dob"
                                                id="driver_dob5" name="driver_dob5">
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
                                            <label for="citynameInput" class="form-label">Driver License State5<span
                                                    class="text-danger">*</span></label>
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
                                        <select id="form_status" class="form-select" name="form_status" required>
                                            <option value="Intrested">Intrested</option>
                                            <option value="Pipeline">Pipeline</option>
                                        </select>
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="pt-4">
                                        <label id="model-form-status" class="form-label"></label>
                                        <div class="progress animated-progress custom-progress mb-4"
                                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"
                                            style="cursor:pointer;">
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
                                                <a href="javascript:void(0);"
                                                    class="btn btn-link link-danger fw-medium"
                                                    data-bs-dismiss="modal"><i
                                                        class="ri-close-line me-1 align-middle"></i>
                                                    Close</a>
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
<!-- staticBackdrop Modal -->
<div class="modal fade" id="importleads" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h4>Import Leads</h4>
            </div>
            <div class="modal-body">
                <form action="{{ url('/import') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Default File Input Example -->
                     <div >
                         <label for="formFile" class="form-label">Batch Name</label>
                                <input type="text" class="form-control" name="batch_name"
                                    placeholder="Enter Batch Name" required>
                            </div>
                    <div class="mt-2">
                        <label for="formFile" class="form-label">Upload File (.xlsx)</label>
                        <input class="form-control" type="file" id="formFile" name="excel_file" required>
                    </div>
                    <div class="col-lg-12">
                        <div class="text-end">
                            <div class="mt-4">
                                <div class="hstack gap-2 justify-content-center">
                                    <a href="javascript:void(0);" class="btn btn-link link-danger fw-medium"
                                        data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                        Close</a>
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                </form>
            </div>
        </div>
    </div>
</div>


{{-- Add Client Form --}}
<!-- staticBackdrop Modal -->
<div class="modal fade" id="addClientForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h4>Add Client Form</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('store.client.form') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="" name="agentId" class="clientFormAgentId">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="india_agent_name" class="form-label">India Agent Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control india_agent_name" placeholder="Enter india agent name..."
                                    name="india_agent_name" required>
                            </div>
                        </div><!--end col-->
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Customer Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control customer_name" placeholder="Enter customer name..."
                                    name="customer_name" required>
                            </div>
                        </div><!--end col-->
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone<span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control phone" placeholder="Enter phone number..."
                                    id="phone" name="phone" required>
                            </div>
                        </div><!--end col-->
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="company_name" class="form-label">Company name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control client_company_name" placeholder="Enter company name..."
                                    id="company_name" name="company_name">
                            </div>
                        </div><!--end col-->
                        <div class="col-6">
    <div class="mb-3">
        <label for="pdf" class="form-label">Pdf</label>
        <input type="file" class="form-control" id="pdf" name="pdf[]" multiple >
    </div>
</div><!--end col-->
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="" class="form-label">Select Customer <span
                                        class="text-danger">*</span></label>
                                <div class="custom-select">
                                    <select id="mySelect" class="chosen-select fetch-data" data-placeholder="Select an option"
                                        name="customer_id">
                                        <option value="">--select--</option>
                                        @if (isset($customers) && count($customers) > 0)
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id ?? '' }}">{{ $customer->phone ?? '' }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div><!--end col-->
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="comment" class="form-label">Comment <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" id="comment" name="comment" placeholder="Write comment..." rows="3"
                                    required></textarea>
                            </div>
                        </div><!--end col-->
                        <div class="col-lg-12">
                            <div class="text-end">
                                <div class="mt-4">
                                    <div class="hstack gap-2 justify-content-center">
                                        <a href="javascript:void(0);" class="btn btn-link link-danger fw-medium"
                                            data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                            Close</a>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div><!--end col-->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- /Add Client Form --}}

{{-- Create Offer --}}
<div class="modal fade zoomIn" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-primary">
                <h5 class="modal-title text-white" id="exampleModalLabel">Create Offer</h5>
                <button type="button" class="btn-close text-white bg-white" data-bs-dismiss="modal"
                    aria-label="Close" id="close-modal"></button>
            </div>
            <form class="tablelist-form" autocomplete="off" action="{{ route('admin.store.offer') }}"
                method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <label for="projectName-field" class="form-label">Offer <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="projectName-field" class="form-control"
                                placeholder="Create offer......" name="offers" required />
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" id="close-modal"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="add-btn">Add</button>
                        <!-- <button type="button" class="btn btn-success" id="edit-btn">Update Task</button> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end modal-->
{{-- /Create Offer --}}

{{-- Single lead --}}
<!-- staticBackdrop Modal -->
<div class="modal fade" id="newlead" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h4>Lead</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('agent.store.single.data') }}" method="POST">
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
                                            id="company_name_single" name="company_name">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="lastNameinput" class="form-label">Phone <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" placeholder="Enter phone number"
                                            id="phone_single" name="phone">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email </label>
                                        <input type="email" class="form-control" placeholder="example@gmail.com"
                                            id="email_single" name="email">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="compnayNameinput" class="form-label">Company Rep1 <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter company rep..."
                                            id="company_rep1_single" name="company_rep1">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="emailidInput" class="form-label">Business Address <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control"
                                            placeholder="Enter business address" id="business_address_single"
                                            name="business_address">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="address1ControlTextarea" class="form-label">Business City <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter business city"
                                            id="business_city_single" name="business_city">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">Business State <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter business state"
                                            id="business_state_single" name="business_state">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">Business ZIP <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter business zip"
                                            id="business_zip_single" name="business_zip">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">DOT <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter DOT"
                                            id="dot_single" name="dot" required>
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">MC/Docket <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter MC"
                                            id="mc_docket_single" name="mc_docket">
                                    </div>
                                </div><!--end col-->
                                <div class="col-12 mb-3">
                                    <h5>Commodities</h5>
                                    <div class="row">
                                        <div class="col-6">
                                          
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Building Materials - Machinery">
                                           <label for="citynameInput" class="form-label"> Building Materials - Machinery</label>
                                           
                                        </div>
                                        <div class="col-6">
                                           
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Building Materials">
                                           <label for="citynameInput" class="form-label"> Building Materials</label>
                                           
                                        </div>
                                        <div class="col-6">
                                           
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Dry Freight - Amazon">
                                           <label for="citynameInput" class="form-label"> Dry Freight - Amazon</label>
                                           
                                        </div>
                                        <div class="col-6">
                                           
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Dry Freight">
                                           <label for="citynameInput" class="form-label"> Dry Freight</label>
                                           
                                        </div>
                                        <div class="col-6">
                                           
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Reefer with seafood or flowers">
                                           <label for="citynameInput" class="form-label"> Reefer with seafood or flowers</label>
                                           
                                        </div>
                                        <div class="col-6">
                                           
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Refrigerated Goods">
                                           <label for="citynameInput" class="form-label"> Refrigerated Goods</label>
                                           
                                        </div>
                                        <div class="col-6">
                                          
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Reefer with flowers">
                                           <label for="citynameInput" class="form-label"> Reefer with flowers</label>
                                           
                                        </div>
                                        <div class="col-6">
                                           
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Reefer with flowers">
                                           <label for="citynameInput" class="form-label"> Fracking Sand</label>
                                           
                                        </div>
                                        <div class="col-6">
                                           
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Hazard">
                                           <label for="citynameInput" class="form-label"> Hazard</label>
                                           
                                        </div>
                                        <div class="col-6">
                                          
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Containerized Freight">
                                           <label for="citynameInput" class="form-label"> Containerized Freight</label>
                                          
                                        </div>
                                        <div class="col-6">
                                          
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Sand & Gravel">
                                           <label for="citynameInput" class="form-label"> Sand & Gravel</label>
                                           
                                        </div>
                                        <div class="col-6">
                                           
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Auto 100%">
                                           <label for="citynameInput" class="form-label"> Auto 100%</label>
                                          
                                        </div>
                                        <div class="col-6">
                                           
                                           <input type="checkbox" class="form-check-input" name="commodities[]" value="Hauls Oversized/Overweight">
                                           <label for="citynameInput" class="form-label"> Hauls Oversized/Overweight</label>
                                           
                                        </div>
                                    </div>
                                </div><!--end col-->
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="ForminputState" class="form-label">Unit Owned <span
                                                class="text-danger">*</span></label>
                                        <select id="unit_owned_single" class="form-select" name="unit_owned">
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
                                            id="vin_single" name="vin">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">Driver Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter driver name"
                                            id="driver_name_single" name="driver_name">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">Driver DOB <span
                                                class="text-danger">*</span></label>
                                        <input type="date" class="form-control" placeholder="Enter driver dob"
                                            id="driver_dob_single" name="driver_dob">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">Driver License <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter driver license"
                                            id="driver_license_single" name="driver_license">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">Driver License State<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter driver license"
                                            id="driver_license_state_single" name="driver_license_state">
                                    </div>
                                </div><!--end col-->

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">Vehicle Year </label>
                                        <input type="number" class="form-control" placeholder="YYYY"
                                            id="vehicle_year_single" name="vehicle_year">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">Vehicle Make </label>
                                        <input type="text" class="form-control"
                                            placeholder="Enter Vehicle make..." id="vehicle_make"
                                            name="vehicle_make_single">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">Stated Value </label>
                                        <input type="text" class="form-control" placeholder="Enter stated value"
                                            id="stated_value_single" name="stated_value">
                                    </div>
                                </div><!--end col-->
                                {{-- 2 --}}
                                <div class="row unitsingle2">
                                    <hr class=" border border-2 border-primary">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">VIN2 <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter VIN"
                                                id="vin_single2" name="vin2">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver Name2 <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver name" id="driver_name_single2"
                                                name="driver_name2">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver DOB2 <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control"
                                                placeholder="Enter driver dob" id="driver_dob_single2"
                                                name="driver_dob2">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver License2 <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver license" id="driver_license_single2"
                                                name="driver_license2">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver License State2<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver license" id="driver_license_state_single2"
                                                name="driver_license_state2">
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Vehicle Year2 </label>
                                            <input type="number" class="form-control" placeholder="YYYY"
                                                id="vehicle_year_single2" name="vehicle_year2">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Vehicle Make2 </label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter Vehicle make..." id="vehicle_make_single2"
                                                name="vehicle_make2">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Stated Value2 </label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter stated value" id="stated_value_single2"
                                                name="stated_value2">
                                        </div>
                                    </div><!--end col-->
                                </div>
                                {{-- /2 --}}
                                {{-- 3 --}}
                                <div class="row unitsingle3">
                                    <hr class=" border border-2 border-primary">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">VIN3 <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter VIN"
                                                id="vin_single3" name="vin3">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver Name3 <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver name" id="driver_name_single3"
                                                name="driver_name3">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver DOB3 <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control"
                                                placeholder="Enter driver dob" id="driver_dob_single3"
                                                name="driver_dob3">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver License3 <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver license" id="driver_license_single3"
                                                name="driver_license3">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver License State3<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver license" id="driver_license_state_single3"
                                                name="driver_license_state3">
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Vehicle Year3 </label>
                                            <input type="number" class="form-control" placeholder="YYYY"
                                                id="vehicle_year_single3" name="vehicle_year3">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Vehicle Make3 </label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter Vehicle make..." id="vehicle_make_single3"
                                                name="vehicle_make3">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Stated Value3 </label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter stated value" id="stated_value_single3"
                                                name="stated_value3">
                                        </div>
                                    </div><!--end col-->
                                </div>
                                {{-- /3 --}}
                                {{-- 4 --}}
                                <div class="row unitsingle4">
                                    <hr class=" border border-2 border-primary">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">VIN4 <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter VIN"
                                                id="vin_single4" name="vin4">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver Name4 <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver name" id="driver_name_single4"
                                                name="driver_name4">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver DOB4 <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control"
                                                placeholder="Enter driver dob" id="driver_dob_single4"
                                                name="driver_dob4">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver License4 <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver license" id="driver_license_single4"
                                                name="driver_license4">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver License State4<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver license" id="driver_license_state_single4"
                                                name="driver_license_state4">
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Vehicle Year4 </label>
                                            <input type="number" class="form-control" placeholder="YYYY"
                                                id="vehicle_year_single4" name="vehicle_year4">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Vehicle Make4 </label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter Vehicle make..." id="vehicle_make_single4"
                                                name="vehicle_make4">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Stated Value4 </label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter stated value" id="stated_value_single4"
                                                name="stated_value4">
                                        </div>
                                    </div><!--end col-->
                                </div>
                                {{-- /4 --}}
                                {{-- 5 --}}
                                <div class="row unitsingle5">
                                    <hr class=" border border-2 border-primary">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">VIN5 <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter VIN"
                                                id="vin_single5" name="vin5">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver Name5 <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver name" id="driver_name_single5"
                                                name="driver_name5">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver DOB5 <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control"
                                                placeholder="Enter driver dob" id="driver_dob_single5"
                                                name="driver_dob5">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver License5 <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver license" id="driver_license_single5"
                                                name="driver_license5">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver License State5<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver license" id="driver_license_state_single5"
                                                name="driver_license_state5">
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Vehicle Year5 </label>
                                            <input type="number" class="form-control" placeholder="YYYY"
                                                id="vehicle_year_single5" name="vehicle_year5">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Vehicle Make5 </label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter Vehicle make..." id="vehicle_make_single5"
                                                name="vehicle_make5">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Stated Value5 </label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter stated value" id="stated_value_single5"
                                                name="stated_value5">
                                        </div>
                                    </div><!--end col-->
                                </div>
                                {{-- /4 --}}

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
                                        <select id="form_status_single" class="form-select" name="form_status"
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
                                                <a href="javascript:void(0);"
                                                    class="btn btn-link link-danger fw-medium"
                                                    data-bs-dismiss="modal"><i
                                                        class="ri-close-line me-1 align-middle"></i>
                                                    Close</a>
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
<!-- staticBackdrop Modal -->
{{-- /Single lead --}}


{{-- Insured Form --}}
<div class="modal fade zoomIn" id="insuredModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-primary">
                <h5 class="modal-title text-white" id="exampleModalLabel">Insured Lead</h5>
                <button type="button" class="btn-close text-white bg-white" data-bs-dismiss="modal"
                    aria-label="Close" id="close-modal"></button>
            </div>
            <form class="tablelist-form" autocomplete="off" action="{{ route('agent.store.insuredform') }}"
                method="POST">
                @csrf
                <input type="hidden" id="insured_id" value="" name="insured_id">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <label for="projectName-field" class="form-label">Status <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="form_status" value="Insured"
                                readonly />
                        </div>
                        <!--end col-->
                        <div class="col-lg-6">
                            <label for="projectName-field" class="form-label">Date<span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="insured_date" required />
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" id="close-modal"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="add-btn">Add</button>
                        <!-- <button type="button" class="btn btn-success" id="edit-btn">Update Task</button> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end modal-->
{{-- /Insured Form --}}

<!--Master Data Modal Start-->
<div class="modal fade" id="masterleaddata" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h4>Lead</h4>
            </div>
            <div class="modal-body">
                <form action="{{ url('/update/masterfile/data/') }}" method="POST">
                        @csrf
                        <input type="hidden" name="data_id" value="" id="data_id1">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="row border-end border-primary">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="firstNameinput" class="form-label">Company Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter company name"
                                            id="company_name1" name="company_name">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="lastNameinput" class="form-label">Phone <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" placeholder="Enter phone number"
                                            id="phone1" name="phone">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email </label>
                                        <input type="email" class="form-control" placeholder="example@gmail.com"
                                            id="email1" name="email">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="compnayNameinput" class="form-label">Company Rep1 <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter company rep..."
                                            id="company_rep11" name="company_rep1">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="emailidInput" class="form-label">Business Address <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter business address"
                                            id="business_address1" name="business_address">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="address1ControlTextarea" class="form-label">Business City <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter business city"
                                            id="business_city1" name="business_city">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">Business State <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter business state"
                                            id="business_state1" name="business_state">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">Business ZIP <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter business zip"
                                            id="business_zip1" name="business_zip">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">DOT <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter DOT"
                                            id="dot1" name="dot" required>
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">MC/Docket <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter MC"
                                            id="mc_docket1" name="mc_docket">
                                    </div>
                                </div><!--end col-->
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="ForminputState" class="form-label">Unit Owned <span
                                                class="text-danger">*</span></label>
                                        <select id="unit_owned1" class="form-select" name="unit_owned">
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
                                            id="vin1" name="vin">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">Driver Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter driver name"
                                            id="driver_name1" name="driver_name">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">Driver DOB <span
                                                class="text-danger">*</span></label>
                                        <input type="date" class="form-control" placeholder="Enter driver dob"
                                            id="driver_dob1" name="driver_dob">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">Driver License <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter driver license"
                                            id="driver_license1" name="driver_license">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">Driver License State<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter driver license"
                                            id="driver_license_state1" name="driver_license_state">
                                    </div>
                                </div><!--end col-->

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">Vehicle Year </label>
                                        <input type="number" class="form-control" placeholder="YYYY"
                                            id="vehicle_year1" name="vehicle_year">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">Vehicle Make </label>
                                        <input type="text" class="form-control"
                                            placeholder="Enter Vehicle make..." id="vehicle_make1"
                                            name="vehicle_make">
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">Stated Value </label>
                                        <input type="text" class="form-control" placeholder="Enter stated value"
                                            id="stated_value1" name="stated_value">
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
                                                id="vin21" name="vin2">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver Name2 <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver name" id="driver_name21"
                                                name="driver_name2">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver DOB2 <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control" placeholder="Enter driver dob"
                                                id="driver_dob21" name="driver_dob2">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver License2 <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver license" id="driver_license21"
                                                name="driver_license2">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver License State2<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver license" id="driver_license_state21"
                                                name="driver_license_state2">
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Vehicle Year2 </label>
                                            <input type="number" class="form-control" placeholder="YYYY"
                                                id="vehicle_year21" name="vehicle_year2">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Vehicle Make2 </label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter Vehicle make..." id="vehicle_make21"
                                                name="vehicle_make2">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Stated Value2 </label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter stated value" id="stated_value21"
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
                                                id="vin31" name="vin3">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver Name3 <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver name" id="driver_name31"
                                                name="driver_name3">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver DOB3 <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control" placeholder="Enter driver dob"
                                                id="driver_dob31" name="driver_dob3">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver License3 <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver license" id="driver_license31"
                                                name="driver_license3">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver License State3<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver license" id="driver_license_state31"
                                                name="driver_license_state3">
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Vehicle Year3 </label>
                                            <input type="number" class="form-control" placeholder="YYYY"
                                                id="vehicle_year31" name="vehicle_year3">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Vehicle Make3 </label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter Vehicle make..." id="vehicle_make31"
                                                name="vehicle_make3">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Stated Value3 </label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter stated value" id="stated_value31"
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
                                                id="vin41" name="vin4">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver Name4 <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver name" id="driver_name41"
                                                name="driver_name4">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver DOB4 <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control" placeholder="Enter driver dob"
                                                id="driver_dob41" name="driver_dob4">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver License4 <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver license" id="driver_license41"
                                                name="driver_license4">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver License State4<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver license" id="driver_license_state41"
                                                name="driver_license_state4">
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Vehicle Year4 </label>
                                            <input type="number" class="form-control" placeholder="YYYY"
                                                id="vehicle_year41" name="vehicle_year4">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Vehicle Make4 </label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter Vehicle make..." id="vehicle_make41"
                                                name="vehicle_make4">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Stated Value4 </label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter stated value" id="stated_value41"
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
                                                id="vin51" name="vin5">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver Name5 <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver name" id="driver_name51"
                                                name="driver_name5">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver DOB5 <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control" placeholder="Enter driver dob"
                                                id="driver_dob51" name="driver_dob5">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver License5 <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver license" id="driver_license51"
                                                name="driver_license5">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver License State5<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter driver license" id="driver_license_state51"
                                                name="driver_license_state5">
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Vehicle Year5 </label>
                                            <input type="number" class="form-control" placeholder="YYYY"
                                                id="vehicle_year51" name="vehicle_year5">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Vehicle Make5 </label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter Vehicle make..." id="vehicle_make51"
                                                name="vehicle_make5">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Stated Value5 </label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter stated value" id="stated_value51"
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
                                        <select id="form_status1" class="form-select" name="form_status" required>
                                            <option value="Intrested">Intrested</option>
                                            <option value="Pipeline">Pipeline</option>
                                        </select>
                                    </div>
                                </div><!--end col-->
                                <div class="col-6">
                                    <div class="pt-4">
                                        <label id="model-form-status" class="form-label"></label>
                                        <div class="progress animated-progress custom-progress mb-4"
                                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"
                                            style="cursor:pointer;">
                                            <div class="progress-bar" role="progressbar" style="width:100%";
                                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                                                id="progress-bar1">
                                            </div>
                                        </div>
                                    </div>
                                </div><!--end col-->
                                <div class="col-6 reminder">
                                    <div class="pb-4">
                                        <label for="citynameInput" class="form-label">Reminder</label>
                                        <input type="datetime-local" class="form-control" id="reminder1"
                                            name="reminder">
                                    </div>
                                </div><!--end col-->
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">Comment </label>
                                        <textarea id="comment1" name="comment" class="form-control" rows="4" placeholder="Write a Coment...."
                                            required></textarea>
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-12">
                                    <div class="text-end">
                                        <div class="mt-4">
                                            <div class="hstack gap-2 justify-content-center">
                                                <a href="javascript:void(0);"
                                                    class="btn btn-link link-danger fw-medium"
                                                    data-bs-dismiss="modal"><i
                                                        class="ri-close-line me-1 align-middle"></i>
                                                    Close</a>
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
<!--Master Data Modal End-->
<!-- Default Modals -->
<div id="UpdateClientPDF" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Update PDF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <form action="{{url('/update/client/pdf')}}" method="post" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
              <input type="hidden" name="id" value="" id="clientPdf_id">
              <input type="file" class="form-control" name="pdf[]"  multiple>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary ">Save Changes</button>
            </div>
            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
