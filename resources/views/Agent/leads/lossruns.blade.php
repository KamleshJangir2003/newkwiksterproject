@extends('Agent.common.app')
@section('main')
    <link href="{{ asset('Agent/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <style>
        .red-row {
            background-color: #FFA500 !important;
            color: #ffffff !important;
        }
        .violet-row {
            background-color: #ff0000 !important;
            color: #ffffff !important;
        }
    </style>
    <style>
        .lead-card{
    background:#fff;
    border-radius:12px;
    box-shadow:0 0 10px rgba(0,0,0,0.08);
    padding:15px;
    border-left:5px solid #0d6efd;
}

.red-card{
    border-left:5px solid #ff0000;
}

.violet-card{
    border-left:5px solid #742dc1;
}

.lead-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-bottom:1px solid #eee;
    padding-bottom:8px;
    margin-bottom:8px;
}

.lead-body p{
    margin:5px 0;
}

.lead-footer{
    border-top:1px solid #eee;
    padding-top:8px;
}

.actions i{
    font-size:18px;
    margin-left:10px;
    cursor:pointer;
}

    </style>
    <style>
        .call-mail-option {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    border: 1px solid #ddd;
    padding: 6px 9px;
    border-radius: 8px;
}

/* Checkbox hide but still clickable */
.call-mail-option input {
    position: absolute;
    opacity: 0;
}

/* Custom checkbox box */
.custom-checkbox {
    width: 18px;
    height: 18px;
    border: 2px solid #999;
    border-radius: 4px;
    display: inline-block;
    position: relative;
    pointer-events: none;   /* <-- IMPORTANT */
}

/* When checked */
.call-mail-option input:checked + .custom-checkbox {
    border-color: green;
    background: green;
}

/* Tick inside box */
.call-mail-option input:checked + .custom-checkbox::after {
    content: "✓";
    color: white;
    font-weight: bold;
    position: absolute;
    top: -2px;
    left: 3px;
}

    </style>
    <style>
        .company-name {
    max-width: 100%;
    white-space: nowrap;        /* ek line me rakhe */
    overflow: hidden;           /* bahar ka text hide */
    text-overflow: ellipsis;    /* ... laga de */
}

    </style>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Leads</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Loss Runs Required data</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-2" style="margin-left: 50px">
                    <div class="single-input" style="display: flex; align-items: center;">
                        <!-- Red indicator for Duplicate -->
                        
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="single-input" style="display: flex; align-items: center;">
                        <!-- Orange indicator for Error -->
                        
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->
          
            
            <!-- show success and error messages -->
            @if (session('success'))
                <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
                    <div class="text-white">{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
                    <div class="text-white">{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <!-- End show success and error messages -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <!-- <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Company Name</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Company Rep1</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr> -->
                            </thead>
                          <div class="row">
@foreach($datas as $key => $data)

<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-4">
    <div class="lead-card {{ $data->red_mark == 1 ? 'red-card' : ($data->red_mark == 3 ? 'violet-card' : '') }}">

        <!-- HEADER -->
       <div class="lead-header">
    <h5 class="company-name" title="{{ $data->company_name }}">
        {{ $data->company_name }}
    </h5>

    @if(!empty($data->mail_status))
        <i class="lni lni-envelope text-danger"></i>
    @endif
</div>


        <!-- BODY -->
        <div class="lead-body">

            <p>
                <strong>Phone:</strong> 
                <span class="phone_copy" onclick="copyPhoneNumber()">
                    {{ $data->phone }}
                </span>
            </p>

            <!-- 👉 YAHI AAPKA PURANA WORKING TRIGGER (same data attributes) -->
            <p>
                <strong>Rep:</strong>
                <span 
                    class="open-modal text-primary"
                    style="cursor:pointer;"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleFullScreenModal"

                    data-company-name="{{ $data->company_name }}"
                    data-phone="{{ $data->phone }}"
                    data-id="{{ $data->id }}"
                    data-company-rep1="{{ $data->company_rep1 }}"
                    data-business-address="{{ $data->business_address }}"
                    data-business-city="{{ $data->business_city }}"
                    data-business-state="{{ $data->business_state }}"
                    data-business-zip="{{ $data->business_zip }}"
                    data-dot="{{ $data->dot }}"
                    data-mc_docket="{{ $data->mc_docket }}"
                    data-email="{{ $data->email }}"
                    data-commodities="{{ $data->commodities }}"
                    data-unit_owned="{{ $data->unit_owned }}"
                    data-vin="{{ $data->vin }}"
                    data-driver_name="{{ $data->driver_name }}"
                    data-driver_dob="{{ $data->driver_dob }}"
                    data-driver_license="{{ $data->driver_license }}"
                    data-driver_license_state="{{ $data->driver_license_state }}"
                    data-vehicle_year="{{ $data->vehicle_year }}"
                    data-vehicle_make="{{ $data->vehicle_make }}"
                    data-stated_value="{{ $data->stated_value }}"
                    data-is_cover_well="{{ $data->is_cover_well }}"
                    data-comment="{{ $data->comment }}"
                    data-Liability="{{ $data->Liability }}"
                    data-MTC="{{ $data->MTC }}"
                    data-interchange="{{ $data->interchange }}"
                    data-file1="{{ $data->file1 }}"
                    data-file2="{{ $data->file2 }}"
                    data-file3="{{ $data->file3 }}"
                    data-file4="{{ $data->file4 }}"
                    data-file5="{{ $data->file5 }}"
                    data-file6="{{ $data->file6 }}"
                    data-error_file="{{ $data->error_file }}"
                    data-audio_file="{{ $data->audio }}"
                    data-physical="{{ $data->physical }}"
                    data-general="{{ $data->general }}"
                    data-language="{{ $data->language }}"
                    data-owner_dob="{{ $data->owner_dob }}"
                    data-verify_level="{{ $data->verify_level }}"
                    data-mail_status="{{ $data->mail_status }}"
                >
                    {{ $data->company_rep1 }}
                </span>
            </p>

            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($data->created_at)->format('d-m-y') }}</p>
        </div>

        <!-- FOOTER (STATUS + ACTIONS) -->
        <div class="lead-footer d-flex justify-content-between align-items-center">

            <!-- STATUS DROPDOWN (SAME WORKING) -->
            <div class="btn-group stop-click">
                <button class="btn btn-sm btn-success dropdown-toggle" data-bs-toggle="dropdown">
                    {{ $data->form_status }}
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item update-status" data-lead-id="{{ $data->id }}" data-status="NEW">NEW</a>
                    <a class="dropdown-item update-status" data-lead-id="{{ $data->id }}" data-status="Voice Mail">Voice Mail</a>
                    <a class="dropdown-item update-status" data-lead-id="{{ $data->id }}" data-status="Not Connected">Not Connected</a>
                    <a class="dropdown-item update-status" data-lead-id="{{ $data->id }}" data-status="Wrong Number">Wrong Number</a>
                    <a class="dropdown-item update-status" data-lead-id="{{ $data->id }}" data-status="WON">WON</a>
                    <a class="dropdown-item update-status" data-lead-id="{{ $data->id }}" data-status="DND">DND</a>
                </div>
            </div>

            <!-- ACTION ICONS (SAME WORKING) -->
            <div class="actions">
                <a href="tel:{{ $data->phone }}"><i class="lni lni-phone"></i></a>

                @if(!empty($data->email))
                <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $data->email }}" target="_blank">
                    <i class="lni lni-envelope"></i>
                </a>
                @endif

                <!-- <a href="#" class="btn-message" data-lead-id="{{ $data->id }}">
                    <i class="lni lni-bubble"></i>
                </a> -->
            </div>

        </div>
    </div>
</div>

@endforeach
</div>

                            <tfoot>
                                <!-- <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Company Name</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Company Rep1</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr> -->
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <input type="hidden" value="{{ $id }}" id="manager_id" name="manager_id"> --}}
    {{-- modal start --}}
    <div class="modal fade" id="exampleFullScreenModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h4>Lead</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('agent_update_leads') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="data_id" value="" id="data_id">
                        {{-- <input type="hidden" name="forword_id" value="" id="forword_id"> --}}
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
                                            <input type="text" class="form-control" placeholder="Enter phone number"
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
                                            <input type="text" class="form-control"
                                                placeholder="Enter business address" id="business_address"
                                                name="business_address">
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
                                                id="business_zip" name="business_zip" required>
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

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Building Materials - Machinery" id="building_machinery">
                                                <label for="citynameInput" class="form-label"> Building Materials -
                                                    Machinery</label>

                                            </div>
                                            <div class="col-6">

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Building Materials" id="buildingmaterials">
                                                <label for="citynameInput" class="form-label"> Building Materials</label>

                                            </div>
                                            <div class="col-6">

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Dry Freight - Amazon" id="Dry-Freight-Amazon">
                                                <label for="citynameInput" class="form-label"> Dry Freight -
                                                    Amazon</label>

                                            </div>
                                            <div class="col-6">

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Dry Freight" id="Dry-Freight">
                                                <label for="citynameInput" class="form-label"> Dry Freight</label>

                                            </div>
                                            <div class="col-6">

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Reefer with seafood or flowers" id="Reefer_with_seafood_or_flowers">
                                                <label for="citynameInput" class="form-label"> Reefer with seafood or
                                                    flowers</label>

                                            </div>
                                            <div class="col-6">

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Refrigerated Goods" id="Refrigerated_Goods">
                                                <label for="citynameInput" class="form-label"> Refrigerated Goods</label>

                                            </div>
                                            <div class="col-6">

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Reefer with flowers" id="Reefer_with_flowers">
                                                <label for="citynameInput" class="form-label"> Reefer with flowers</label>

                                            </div>
                                            <div class="col-6">

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Fracking Sand" id="Fracking-Sand">
                                                <label for="citynameInput" class="form-label"> Fracking Sand</label>

                                            </div>
                                            <div class="col-6">

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Hazard" id="Hazard">
                                                <label for="citynameInput" class="form-label"> Hazard</label>

                                            </div>
                                            <div class="col-6">

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Containerized Freight" id="Containerized-Freight">
                                                <label for="citynameInput" class="form-label"> Containerized
                                                    Freight</label>

                                            </div>
                                            <div class="col-6">

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Sand &amp; Gravel" id="SandGravel">
                                                <label for="citynameInput" class="form-label"> Sand &amp; Gravel</label>

                                            </div>
                                            <div class="col-6">

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Auto 100%" id="100">
                                                <label for="citynameInput" class="form-label"> Auto 100%</label>

                                            </div>
                                            <div class="col-6">

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Hauls Oversized/Overweight" id="HaulsOversizedOverweight">
                                                <label for="citynameInput" class="form-label"> Hauls
                                                    Oversized/Overweight</label>

                                            </div>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="ForminputState" class="form-label">Unit Owned <span
                                                    class="text-danger">*</span></label>
                                            <select id="unit_owned2" class="form-select" name="unit_owned">
                                                <option value="1" selected>1</option>
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
                                            <input type="text" class="form-control" placeholder="Enter stated value"
                                                id="stated_value" name="stated_value">
                                        </div>
                                    </div><!--end col-->

                                    <div class="row unit2" id="unit22" style="display: none;">
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


                                    <div class="row unit3" id="unit33" style="display: none;">
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


                                    <div class="row unit4" id="unit44" style="display: none;">
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


                                    <div class="row unit5" id="unit55" style="display: none;">
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

                                    <!-- Driver Unit 6 -->
                                    <div class="row unit6" id="unit66" style="display: none;">
                                        <hr class="border border-2 border-primary">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="vin6" class="form-label">VIN6 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter VIN"
                                                    id="vin6" name="vin6">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="vehicle_year6" class="form-label">Vehicle Year6 </label>
                                                <input type="number" class="form-control" placeholder="YYYY"
                                                    id="vehicle_year6" name="vehicle_year6">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="vehicle_make6" class="form-label">Vehicle Make6 </label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter Vehicle make..." id="vehicle_make6"
                                                    name="vehicle_make6">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="stated_value6" class="form-label">Stated Value6 </label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter stated value" id="stated_value6"
                                                    name="stated_value6">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Driver Unit 7 -->
                                    <div class="row unit7" id="unit77" style="display: none;">
                                        <hr class="border border-2 border-primary">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="vin7" class="form-label">VIN7 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter VIN"
                                                    id="vin7" name="vin7">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="vehicle_year7" class="form-label">Vehicle Year7 </label>
                                                <input type="number" class="form-control" placeholder="YYYY"
                                                    id="vehicle_year7" name="vehicle_year7">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="vehicle_make7" class="form-label">Vehicle Make7 </label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter Vehicle make..." id="vehicle_make7"
                                                    name="vehicle_make7">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="stated_value7" class="form-label">Stated Value7 </label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter stated value" id="stated_value7"
                                                    name="stated_value7">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Driver Unit 8 -->
                                    <div class="row unit8" id="unit88" style="display: none;">
                                        <hr class="border border-2 border-primary">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="vin8" class="form-label">VIN8 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter VIN"
                                                    id="vin8" name="vin8">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="vehicle_year8" class="form-label">Vehicle Year8 </label>
                                                <input type="number" class="form-control" placeholder="YYYY"
                                                    id="vehicle_year8" name="vehicle_year8">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="vehicle_make8" class="form-label">Vehicle Make8 </label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter Vehicle make..." id="vehicle_make8"
                                                    name="vehicle_make8">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="stated_value8" class="form-label">Stated Value8 </label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter stated value" id="stated_value8"
                                                    name="stated_value8">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Driver Unit 9 -->
                                    <div class="row unit9" id="unit99" style="display: none;">
                                        <hr class="border border-2 border-primary">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="vin9" class="form-label">VIN9 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter VIN"
                                                    id="vin9" name="vin9">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="vehicle_year9" class="form-label">Vehicle Year9 </label>
                                                <input type="number" class="form-control" placeholder="YYYY"
                                                    id="vehicle_year9" name="vehicle_year9">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="vehicle_make9" class="form-label">Vehicle Make9 </label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter Vehicle make..." id="vehicle_make9"
                                                    name="vehicle_make9">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="stated_value9" class="form-label">Stated Value9 </label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter stated value" id="stated_value9"
                                                    name="stated_value9">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Driver Unit 10 -->
                                    <div class="row unit10" id="unit101" style="display: none;">
                                        <hr class="border border-2 border-primary">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="vin10" class="form-label">VIN10 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter VIN"
                                                    id="vin10" name="vin10">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="vehicle_year10" class="form-label">Vehicle Year10 </label>
                                                <input type="number" class="form-control" placeholder="YYYY"
                                                    id="vehicle_year10" name="vehicle_year10">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="vehicle_make10" class="form-label">Vehicle Make10 </label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter Vehicle make..." id="vehicle_make10"
                                                    name="vehicle_make10">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="stated_value10" class="form-label">Stated Value10 </label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter stated value" id="stated_value10"
                                                    name="stated_value10">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="ForminputState" class="form-label">Drivers<span
                                                    class="text-danger">*</span></label>
                                            <select id="drivers_state2" class="form-select" name="drivers_state">
                                                <option value="1" selected>1</option>
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
                                    </div>
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
                                    <div class="row unit2" id="driver22" style="display: '';">
                                        <hr class=" border border-2 border-primary">
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
                                    </div>
                                    <div class="row unit3" id="driver33" style="display: none;">
                                        <hr class=" border border-2 border-primary">
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
                                    </div>

                                    <div class="row unit4" id="driver44" style="display: none;">
                                        <hr class=" border border-2 border-primary">
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
                                                <label for="citynameInput" class="form-label">Driver License State4<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver license" id="driver_license_state4"
                                                    name="driver_license_state4">
                                            </div>
                                        </div><!--end col-->
                                    </div>
                                    <div class="row unit5" id="driver55" style="display: none;">
                                        <hr class=" border border-2 border-primary">

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
                                                <label for="citynameInput" class="form-label">Driver License State5<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver license" id="driver_license_state5"
                                                    name="driver_license_state5">
                                            </div>
                                        </div><!--end col-->
                                    </div>
                                    <!-- Driver Unit 6 -->
                                    <div class="row unit6" id="driver66" style="display: none;">
                                        <hr class="border border-2 border-primary">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_name6" class="form-label">Driver Name6 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver name" id="driver_name6"
                                                    name="driver_name6">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_dob6" class="form-label">Driver DOB6 <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" class="form-control"
                                                    placeholder="Enter driver dob" id="driver_dob6"
                                                    name="driver_dob6">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license6" class="form-label">Driver License6 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver license" id="driver_license6"
                                                    name="driver_license6">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license_state6" class="form-label">Driver License
                                                    State6 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver license state" id="driver_license_state6"
                                                    name="driver_license_state6">
                                            </div>
                                        </div><!--end col-->
                                    </div>


                                    <div class="row unit7" id="driver77" style="display: none;">
                                        <hr class="border border-2 border-primary">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_name7" class="form-label">Driver Name7 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver name" id="driver_name7"
                                                    name="driver_name7">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_dob7" class="form-label">Driver DOB7 <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" class="form-control"
                                                    placeholder="Enter driver dob" id="driver_dob7"
                                                    name="driver_dob7">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license7" class="form-label">Driver License7 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver license" id="driver_license7"
                                                    name="driver_license7">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license_state7" class="form-label">Driver License
                                                    State7 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver license state" id="driver_license_state7"
                                                    name="driver_license_state7">
                                            </div>
                                        </div><!--end col-->
                                    </div>

                                    <!-- Driver Unit 8 -->
                                    <div class="row unit8" id="driver88" style="display: none;">
                                        <hr class="border border-2 border-primary">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_name8" class="form-label">Driver Name8 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver name" id="driver_name8"
                                                    name="driver_name8">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_dob8" class="form-label">Driver DOB8 <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" class="form-control"
                                                    placeholder="Enter driver dob" id="driver_dob8"
                                                    name="driver_dob8">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license8" class="form-label">Driver License8 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver license" id="driver_license8"
                                                    name="driver_license8">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license_state8" class="form-label">Driver License
                                                    State8 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver license state" id="driver_license_state8"
                                                    name="driver_license_state8">
                                            </div>
                                        </div><!--end col-->
                                    </div>

                                    <!-- Driver Unit 9 -->
                                    <div class="row unit9" id="driver99" style="display: none;">
                                        <hr class="border border-2 border-primary">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_name9" class="form-label">Driver Name9 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver name" id="driver_name9"
                                                    name="driver_name9">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_dob9" class="form-label">Driver DOB9 <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" class="form-control"
                                                    placeholder="Enter driver dob" id="driver_dob9"
                                                    name="driver_dob9">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license9" class="form-label">Driver License9 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver license" id="driver_license9"
                                                    name="driver_license9">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license_state9" class="form-label">Driver License
                                                    State9 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver license state" id="driver_license_state9"
                                                    name="driver_license_state9">
                                            </div>
                                        </div><!--end col-->
                                    </div>

                                    <!-- Driver Unit 10 -->
                                    <div class="row unit10" id="driver101" style="display: none;">
                                        <hr class="border border-2 border-primary">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_name10" class="form-label">Driver Name10 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver name" id="driver_name10"
                                                    name="driver_name10">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_dob10" class="form-label">Driver DOB10 <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" class="form-control"
                                                    placeholder="Enter driver dob" id="driver_dob10"
                                                    name="driver_dob10">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license10" class="form-label">Driver License10 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver license" id="driver_license10"
                                                    name="driver_license10">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license_state10" class="form-label">Driver License
                                                    State10 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter driver license state" id="driver_license_state10"
                                                    name="driver_license_state10">
                                            </div>
                                        </div><!--end col-->
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
                                            <select id="form_status2" class="form-select" name="form_status"
                                                required="">
                                                <option value="Intrested">Interested</option>
                                                <option value="Pipeline">Pipeline</option>
                                            </select>
                                            
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="pt-0">
                                           <label id="model-form-status" class="form-label">Form on</label>

<div class="d-flex gap-3 lock-contact-mode">

    <label class="call-mail-option">
        <input type="radio"
               name="contact_mode"
               value="Call"
               id="callCheck"
               {{ ($data->mail_status ?? '') === 'Call' ? 'checked' : '' }}
               disabled>
        <span class="custom-checkbox"></span>
        <i class="fa fa-phone"></i> Call
    </label>

    <label class="call-mail-option">
        <input type="radio"
               name="contact_mode"
               value="Email"
               id="emailCheck"
               {{ ($data->mail_status ?? '') === 'Email' ? 'checked' : '' }}
               disabled>
        <span class="custom-checkbox"></span>
        <i class="fa fa-envelope"></i> Email
    </label>

</div>
<style>
    .lock-contact-mode {
    pointer-events: none !important;
}

.lock-contact-mode label {
    cursor: not-allowed !important;
}

.lock-contact-mode input {
    pointer-events: none !important;
}

</style>




                                        </div>
                                    </div><!--end col-->
                                    {{-- <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-check-label">
                                                <input type="checkbox" name="CoverWell" id="coverwell" value="1" class="form-check-input">
                                                Cover Well
                                            </label>
                                        </div>
                                    </div><!--end col--> --}}
                                    <div class="col-6 reminder" style="display: none;">
                                        <div class="pb-4">
                                            <label for="dateInput" class="form-label">Date</label>
                                            <input type="date" class="form-control" id="dateInput1"  name="dateInput">
                                            
                                            <label for="timeInput" class="form-label">Time</label>
                                            <input type="time" class="form-control" id="timeInput1"  name="timeInput">
                                            <input type="hidden" name="reminder" id="reminder1"></input>
                                            <button onclick="setReminder()">Set Reminder</button>
                                        </div>
                                    </div>
                                      <!-- Display Comments Section -->
<div class="modal-body" id="commentsBody">
                <!-- Comments will be dynamically populated here -->
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
                                            type="file" value=""
                                            name="errorfile">
                                        </div>
                                        <button type="button" id="openerror1" style="
                                        margin-bottom: 12px;
                                    " class="btn btn-primary">Open file</button>
                                    </div><!--end col-->

                                    <h4>Policy</h4>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="Liability" class="form-label">Liability limit</label>
                                            <select id="Liability" class="form-select" name="Liability"
                                                >
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
                                    </div><!--end col--> <div class="col-6">
                                        <div class="mb-3">
                                            <label for="MTC" class="form-label">Do you need MTC ?</label>
                                            <select id="MTC" class="form-select" name="MTC"
                                                >
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
                                    </div><!--end col--> <div class="col-7">
                                        <div class="mb-3">
                                            <label for="ForminputState" class="form-label">Trailer interchange</label>
                                            <select id="interchange" class="form-select" name="interchange"
                                                >
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
                                                <input type="checkbox" name="physical" id="physicall" value="1" class="form-check-input">
                                                Physical Damage
                                            </label>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-check-label">
                                                <input type="checkbox" name="general" id="generall" value="1" class="form-check-input">
                                                General Liability
                                            </label>
                                        </div>
                                    </div><!--end col-->
                                    <hr/>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="owner_dob" class="form-label">Owner Dob <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control"
                                                placeholder="Enter driver dob" id="owner_dob"
                                                name="owner_dob">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-check-label">
                                                <input type="radio" name="language" id="english" value="english" class="form-check-input" checked>
                                                English
                                            </label>
                                        </div>
                                    </div><!--end col-->
                                    
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-check-label">
                                                <input type="radio" name="language" id="hindi" value="hindi" class="form-check-input">
                                                हिन्दी (Hindi)
                                            </label>
                                        </div>
                                    </div><!--end col-->
                                    
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-check-label">
                                                <input type="radio" name="language" id="spanish" value="spanish" class="form-check-input">
                                                Español (Spanish)
                                            </label>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-check-label">
                                                <input type="radio" name="language" id="english_spanish" value="english_spanish" class="form-check-input">
                                                English - Spanish
                                            </label>
                                        </div>
                                    </div><!--end col-->
                                    <hr/>
                                    <h5>Loss Runs/Docs Files</h5>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <input class="form-control" style="margin-left: 10px"
                                            type="file" value=""
                                            name="file1">
                                        </div>
                                        <button type="button" id="openPdfButton1" style="
                                        margin-bottom: 12px;
                                    " class="btn btn-primary">Open file</button>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <input class="form-control" style="margin-left: 10px"
                                            type="file" value="" 
                                            name="file2">
                                        </div>
                                        <button type="button" id="openPdfButton2" style="
                                        margin-bottom: 12px;
                                    " class="btn btn-primary">Open file</button>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <input class="form-control" style="margin-left: 10px"
                                            type="file" value=""
                                            name="file3">
                                        </div>
                                        <button type="button" id="openPdfButton3" style="
                                        margin-bottom: 12px;
                                    " class="btn btn-primary">Open file</button>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <input class="form-control" style="margin-left: 10px"
                                            type="file" value=""
                                            name="file4">
                                        </div>
                                        <button type="button" id="openPdfButton4" style="
                                        margin-bottom: 12px;
                                    " class="btn btn-primary">Open file</button>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <input class="form-control" style="margin-left: 10px"
                                            type="file" value=""
                                            name="file5">
                                        </div>
                                        <button type="button" id="openPdfButton5" style="
                                        margin-bottom: 12px;
                                    " class="btn btn-primary">Open file</button>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <input class="form-control" style="margin-left: 10px"
                                            type="file" value="" 
                                            name="file6">
                                        </div>
                                        <button type="button" id="openPdfButton6" style="
                                        margin-bottom: 12px;
                                    " class="btn btn-primary">Open file</button>
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
    {{-- modal end --}}
    <!--end page wrapper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.update-status').on('click', function() {
                var leadId = $(this).data('lead-id');
                var status = $(this).data('status');
                var managerfwd = $('#manager_id').val();
                var $td = $(this).closest('td');

                $.ajax({
                    url: '{{ route('agent_status_update') }}',
                    method: 'POST',
                    data: {
                        lead_id: leadId,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $td.find('.btn')
                            .text(response.status)
                            .css('background-color', getStatusColor(response.status));

                        function getStatusColor(status) {
                            switch (status) {
                                case 'Voice Mail':
                                    return '#742dc1'; // Light green

                                case 'Not Intrested':
                                    return '#d91c1c'; // Black

                                case 'Wrong Number':
                                    return '#d91c1c';

                                case 'DND':
                                    return '#d91c1c'; // Red

                                case 'Not Connected':
                                    return '#e6ca00';

                                case 'WON':
                                    return '#00ff72';

                                default:
                                    return '#ffffff'; // Default background color
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error response if needed
                        console.error(error);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#exampleFullScreenModal').on('show.bs.modal', function(event) {
                var modal = $(this);
                var td = $(event.relatedTarget);
               
                modal.find('#company_name').val(td.data('company-name'));
                modal.find('#phone').val(td.data('phone'));
                modal.find('#company_rep1').val(td.data('company-rep1'));
                modal.find('#business_address').val(td.data('business-address'));
                modal.find('#business_city').val(td.data('business-city'));
                modal.find('#business_state').val(td.data('business-state'));
                modal.find('#business_zip').val(td.data('business-zip'));
                modal.find('#dot').val(td.data('dot'));
                modal.find('#mc_docket').val(td.data('mc_docket'));
                modal.find('#data_id').val(td.data('id'));
                modal.find('#email').val(td.data('email'));
                modal.find('#forword_id').val($('#manager_id').val());
                modal.find('#commodities').val(td.data('commodities'));
                modal.find('#unit_owned2').val(td.data('unit_owned'));
                modal.find('#vin').val(td.data('vin'));
                modal.find('#driver_name').val(td.data('driver_name'));
                modal.find('#driver_dob').val(td.data('driver_dob'));
                modal.find('#driver_license').val(td.data('driver_license'));
                modal.find('#driver_license_state').val(td.data('driver_license_state'));
                modal.find('#vehicle_year').val(td.data('vehicle_year'));
                modal.find('#vehicle_make').val(td.data('vehicle_make'));
                modal.find('#stated_value').val(td.data('stated_value'));

                modal.find('#vin2').val(td.data('vin2'));
modal.find('#driver_name2').val(td.data('driver_name2'));
modal.find('#driver_dob2').val(td.data('driver_dob2'));
modal.find('#driver_license2').val(td.data('driver_license2'));
modal.find('#driver_license_state2').val(td.data('driver_license_state2'));
modal.find('#vehicle_year2').val(td.data('vehicle_year2'));
modal.find('#vehicle_make2').val(td.data('vehicle_make2'));
modal.find('#stated_value2').val(td.data('stated_value2'));

modal.find('#vin3').val(td.data('vin3'));
modal.find('#driver_name3').val(td.data('driver_name3'));
modal.find('#driver_dob3').val(td.data('driver_dob3'));
modal.find('#driver_license3').val(td.data('driver_license3'));
modal.find('#driver_license_state3').val(td.data('driver_license_state3'));
modal.find('#vehicle_year3').val(td.data('vehicle_year3'));
modal.find('#vehicle_make3').val(td.data('vehicle_make3'));
modal.find('#stated_value3').val(td.data('stated_value3'));

modal.find('#vin4').val(td.data('vin4'));
modal.find('#driver_name4').val(td.data('driver_name4'));
modal.find('#driver_dob4').val(td.data('driver_dob4'));
modal.find('#driver_license4').val(td.data('driver_license4'));
modal.find('#driver_license_state4').val(td.data('driver_license_state4'));
modal.find('#vehicle_year4').val(td.data('vehicle_year4'));
modal.find('#vehicle_make4').val(td.data('vehicle_make4'));
modal.find('#stated_value4').val(td.data('stated_value4'));

modal.find('#vin5').val(td.data('vin5'));
modal.find('#driver_name5').val(td.data('driver_name5'));
modal.find('#driver_dob5').val(td.data('driver_dob5'));
modal.find('#driver_license5').val(td.data('driver_license5'));
modal.find('#driver_license_state5').val(td.data('driver_license_state5'));
modal.find('#vehicle_year5').val(td.data('vehicle_year5'));
modal.find('#vehicle_make5').val(td.data('vehicle_make5'));
modal.find('#stated_value5').val(td.data('stated_value5'));

// For Unit 6
modal.find('#vin6').val(td.data('vin6'));
modal.find('#driver_name6').val(td.data('driver_name6'));
modal.find('#driver_dob6').val(td.data('driver_dob6'));
modal.find('#driver_license6').val(td.data('driver_license6'));
modal.find('#driver_license_state6').val(td.data('driver_license_state6'));
modal.find('#vehicle_year6').val(td.data('vehicle_year6'));
modal.find('#vehicle_make6').val(td.data('vehicle_make6'));
modal.find('#stated_value6').val(td.data('stated_value6'));

// For Unit 7
modal.find('#vin7').val(td.data('vin7'));
modal.find('#driver_name7').val(td.data('driver_name7'));
modal.find('#driver_dob7').val(td.data('driver_dob7'));
modal.find('#driver_license7').val(td.data('driver_license7'));
modal.find('#driver_license_state7').val(td.data('driver_license_state7'));
modal.find('#vehicle_year7').val(td.data('vehicle_year7'));
modal.find('#vehicle_make7').val(td.data('vehicle_make7'));
modal.find('#stated_value7').val(td.data('stated_value7'));

// For Unit 8
modal.find('#vin8').val(td.data('vin8'));
modal.find('#driver_name8').val(td.data('driver_name8'));
modal.find('#driver_dob8').val(td.data('driver_dob8'));
modal.find('#driver_license8').val(td.data('driver_license8'));
modal.find('#driver_license_state8').val(td.data('driver_license_state8'));
modal.find('#vehicle_year8').val(td.data('vehicle_year8'));
modal.find('#vehicle_make8').val(td.data('vehicle_make8'));
modal.find('#stated_value8').val(td.data('stated_value8'));

// For Unit 9
modal.find('#vin9').val(td.data('vin9'));
modal.find('#driver_name9').val(td.data('driver_name9'));
modal.find('#driver_dob9').val(td.data('driver_dob9'));
modal.find('#driver_license9').val(td.data('driver_license9'));
modal.find('#driver_license_state9').val(td.data('driver_license_state9'));
modal.find('#vehicle_year9').val(td.data('vehicle_year9'));
modal.find('#vehicle_make9').val(td.data('vehicle_make9'));
modal.find('#stated_value9').val(td.data('stated_value9'));

// For Unit 10
modal.find('#vin10').val(td.data('vin10'));
modal.find('#driver_name10').val(td.data('driver_name10'));
modal.find('#driver_dob10').val(td.data('driver_dob10'));
modal.find('#driver_license10').val(td.data('driver_license10'));
modal.find('#driver_license_state10').val(td.data('driver_license_state10'));
modal.find('#vehicle_year10').val(td.data('vehicle_year10'));
modal.find('#vehicle_make10').val(td.data('vehicle_make10'));
modal.find('#stated_value10').val(td.data('stated_value10'));




// ---- FORM ON (CALL / EMAIL) AUTO SELECT ----
modal.find('input[name="contact_mode"]').prop('checked', false);

if (td.data('mail_status') === 'Call') {
    modal.find('#callCheck').prop('checked', true);
}
if (td.data('mail_status') === 'Email') {
    modal.find('#emailCheck').prop('checked', true);
}


                // modal.find('#comment').val(td.data('comment'));
                modal.find('#MTC').val(td.data('mtc'));
                modal.find('#Liability').val(td.data('liability'));
                modal.find('#interchange').val(td.data('interchange'));
               // Set the checkbox states
            $('#coverwell').prop('checked', !!td.data('is_cover_well'));
            $('#redmark').prop('checked', !!td.data('redmark'));
            $('#physicall').prop('checked', td.data('physical') == 1);
            $('#generall').prop('checked', td.data('general') == 1);

            modal.find('#owner_dob').val(td.data('owner_dob'));
        var languageValue = td.data('language');
// Uncheck all radio buttons first
modal.find('input[name="language"]').prop('checked', false);
// Check the appropriate radio button based on the value
if (languageValue) {
    modal.find('input[name="language"][value="' + languageValue + '"]').prop('checked', true);
}
            
            // Retrieve comment data as a raw string
let commentData = td.attr('data-comment'); 
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
  modal.find('#comment').val(td.data('comment'));
}

// Populate the modal's comments body with the generated HTML
$('#commentsBody').html(commentsHtml);

var verifyLevel = td.data('verify_level');
    if (verifyLevel === 3 || verifyLevel === 4) {
        modal.find('.btn-primary[type="submit"]').hide();
    } else {
        modal.find('.btn-primary[type="submit"]').show(); // Show button for other levels
    }


           // Handle commodities data (assuming it's already an array)
           var commodities = td.data('commodities');
         
            if (Array.isArray(commodities) && commodities.includes("Building Materials - Machinery")) {
                // $('#building_machinery').prop('checked', true);
                $('#building_machinery').prop('checked', !!td.data('commodities'));
            } 
            if (Array.isArray(commodities) && commodities.includes("Building Materials")) {
                // $('#building_machinery').prop('checked', true);
                $('#buildingmaterials').prop('checked', !!td.data('commodities'));
            } 
            if (Array.isArray(commodities) && commodities.includes("Dry Freight - Amazon")) {
                // $('#building_machinery').prop('checked', true);
                $('#Dry-Freight-Amazon').prop('checked', !!td.data('commodities'));
            } 
            if (Array.isArray(commodities) && commodities.includes("Dry Freight")) {
                // $('#building_machinery').prop('checked', true);
                $('#Dry-Freight').prop('checked', !!td.data('commodities'));
            } 
            if (Array.isArray(commodities) && commodities.includes("Reefer with seafood or flowers")) {
                // $('#building_machinery').prop('checked', true);
                $('#Reefer_with_seafood_or_flowers').prop('checked', !!td.data('commodities'));
            } 
            if (Array.isArray(commodities) && commodities.includes("Refrigerated Goods")) {
                // $('#building_machinery').prop('checked', true);
                $('#Refrigerated_Goods').prop('checked', !!td.data('commodities'));
            } 
            if (Array.isArray(commodities) && commodities.includes("Reefer with flowers")) {
                // $('#building_machinery').prop('checked', true);
                $('#Reefer_with_flowers').prop('checked', !!td.data('commodities'));
            } 
            if (Array.isArray(commodities) && commodities.includes("Fracking Sand")) {
                // $('#building_machinery').prop('checked', true);
                $('#Fracking-Sand').prop('checked', !!td.data('commodities'));
            } 
            if (Array.isArray(commodities) && commodities.includes("Hazard")) {
                // $('#building_machinery').prop('checked', true);
                $('#Hazard').prop('checked', !!td.data('commodities'));
            } 
            if (Array.isArray(commodities) && commodities.includes("Containerized Freight")) {
                // $('#building_machinery').prop('checked', true);
                $('#Containerized-Freight').prop('checked', !!td.data('commodities'));
            } 
            if (Array.isArray(commodities) && commodities.includes("Sand & Gravel")) {
                // $('#building_machinery').prop('checked', true);
                $('#SandGravel').prop('checked', !!td.data('commodities'));
            } 
            if (Array.isArray(commodities) && commodities.includes("Auto 100%")) {
                // $('#building_machinery').prop('checked', true);
                $('#100').prop('checked', !!td.data('commodities'));
            } 
            if (Array.isArray(commodities) && commodities.includes("Hauls Oversized/Overweight")) {
                // $('#building_machinery').prop('checked', true);
                $('#HaulsOversizedOverweight').prop('checked', !!td.data('commodities'));
            } 


        // Display PDF
        var file = td.data('file1');
        var pdfPath = "{{ asset(':file') }}";
            pdfPath = pdfPath.replace(':file', file);

            if (file) {
            // Attach click event to open PDF in new tab or window
            $('#openPdfButton1').on('click', function() {
                window.open(pdfPath, '_blank');
            });
            } else {
                modal.find('#openPdfButton1').hide();
            }
               // Display PDF2
        var file2 = td.data('file2');
        var pdfPath2 = "{{ asset(':file2') }}";
            pdfPath2 = pdfPath2.replace(':file2', file2);

            if (file2) {
            // Attach click event to open PDF in new tab or window
            $('#openPdfButton2').on('click', function() {
                window.open(pdfPath2, '_blank');
            });
            } else {
                modal.find('#openPdfButton2').css('display', 'none');
            }
              // Display PDF3
        var file3 = td.data('file3');
        var pdfPath3 = "{{ asset(':file3') }}";
        pdfPath3 = pdfPath3.replace(':file3', file3);

            if (file3) {
            // Attach click event to open PDF in new tab or window
            $('#openPdfButton3').on('click', function() {
                window.open(pdfPath3, '_blank');
            });
            } else {
                modal.find('#openPdfButton3').css('display', 'none');
            }
              // Display PDF4
        var file4 = td.data('file4');
        var pdfPath4 = "{{ asset(':file4') }}";
        pdfPath4 = pdfPath4.replace(':file4', file4);

            if (file4) {
            // Attach click event to open PDF in new tab or window
            $('#openPdfButton4').on('click', function() {
                window.open(pdfPath4, '_blank');
            });
            } else {
                modal.find('#openPdfButton4').css('display', 'none');
            }
              // Display PDF5
        var file5 = td.data('file5');
        var pdfPath5 = "{{ asset(':file5') }}";
        pdfPath5 = pdfPath5.replace(':file5', file5);

            if (file5) {
            // Attach click event to open PDF in new tab or window
            $('#openPdfButton5').on('click', function() {
                window.open(pdfPath5, '_blank');
            });
            } else {
                modal.find('#openPdfButton5').css('display', 'none');
            }
              // Display PDF6
        var file6 = td.data('file6');
        var pdfPath6 = "{{ asset(':file6') }}";
        pdfPath6 = pdfPath6.replace(':file6', file6);

            if (file6) {
            // Attach click event to open PDF in new tab or window
            $('#openPdfButton6').on('click', function() {
                window.open(pdfPath6, '_blank');
            });
            } else {
                modal.find('#openPdfButton6').css('display', 'none');
            }
            // Display error file
        var errorfile = td.data('error_file');
        var errorPath6 = "{{ asset(':error_file') }}";
        errorPath6 = errorPath6.replace(':error_file', errorfile);

            if (errorfile) {
            // Attach click event to open PDF in new tab or window
            $('#openerror1').on('click', function() {
                window.open(errorPath6, '_blank');
            });
            } else {
                modal.find('#openerror1').css('display', 'none');
            }
 // Display audio file
//  var audio_file = td.data('audio_file'); // Get the audio file path

var audio_file = td.data('audio_file'); // Pass the file name from Laravel
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


            });
        });
    </script>
   <script>
    $(document).ready(function() {
        $('#form_status2').change(function() {
            var isPipeline = $(this).val() === 'Pipeline';
            
            // Toggle visibility of elements with class 'reminder'
            $('.reminder').toggle(isPipeline);
            
            // Define an array of IDs for fields to toggle 'required' attribute
            var fieldIds = [
                '#exampleFullScreenModal #company_name', '#exampleFullScreenModal #phone', '#exampleFullScreenModal #company_rep1', '#exampleFullScreenModal #business_address', '#exampleFullScreenModal #business_city', 
                '#exampleFullScreenModal #business_state', '#exampleFullScreenModal #business_zip', '#exampleFullScreenModal #dot', '#exampleFullScreenModal #vin', '#exampleFullScreenModal #driver_name', '#exampleFullScreenModal #driver_dob', 
                '#exampleFullScreenModal #driver_license', '#exampleFullScreenModal #driver_license_state', '#exampleFullScreenModal #vin2', '#exampleFullScreenModal #driver_name2', '#exampleFullScreenModal #driver_dob2', 
                '#exampleFullScreenModal #driver_license2', '#exampleFullScreenModal #driver_license_state2', '#exampleFullScreenModal #vin3', '#exampleFullScreenModal #driver_name3', '#exampleFullScreenModal #driver_dob3', 
                '#exampleFullScreenModal #driver_license3', '#exampleFullScreenModal #driver_license_state3', '#exampleFullScreenModal #vin4', '#exampleFullScreenModal #driver_name4', '#exampleFullScreenModal #driver_dob4', 
                '#exampleFullScreenModal #driver_license4', '#exampleFullScreenModal #driver_license_state4', '#exampleFullScreenModal #vin5', '#exampleFullScreenModal #driver_name5', '#exampleFullScreenModal #driver_dob5', 
                '#exampleFullScreenModal #driver_license5', '#exampleFullScreenModal #driver_license_state5'
            ];
            
            // Set or remove 'required' attribute based on isPipeline
            fieldIds.forEach(function(id) {
                var $field = $(id);
                if (isPipeline) {
                    $field.removeAttr('required');
                } else {
                    $field.attr('required', 'required');
                }
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var phoneCells = document.querySelectorAll('.phone_copy');

        phoneCells.forEach(function(cell) {
            cell.addEventListener('click', function() {
                var phoneNumber = this.innerText.trim();

                // Create a temporary input element
                var tempInput = document.createElement('input');
                tempInput.value = phoneNumber;
                document.body.appendChild(tempInput);

                // Select and copy the phone number from the temporary input element
                tempInput.select();
                document.execCommand('copy');

                // Remove the temporary input element
                document.body.removeChild(tempInput);

                // Show copy indicator
                var copyIndicator = event.target.querySelector('.copy-indicator');
                copyIndicator.style.display = 'inline'; // Make the indicator visible

                // Hide copy indicator after 2 seconds
                setTimeout(function() {
                    copyIndicator.style.display = 'none'; // Hide the indicator
                }, 1000);
            });
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const unitSelect2 = document.getElementById("unit_owned2");

        // Function to toggle 'required' attribute based on display status
        function toggleRequiredBasedOnDisplay(elementId, isDisplayed) {
            const element = document.getElementById(elementId);
            if (element) {
                const inputs = element.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    // Check if the input is not one of the specific IDs to exclude
                    if (input.id !== "vehicle_year5" && input.id !== "vehicle_make5" && input.id !==
                        "stated_value5" && input.id !== "vehicle_year2" && input.id !==
                        "vehicle_make2" && input.id !== "stated_value2" && input.id !==
                        "vehicle_year3" && input.id !== "vehicle_make3" && input.id !==
                        "stated_value3" && input.id !== "vehicle_year4" && input.id !==
                        "vehicle_make4" && input.id !== "stated_value4") {
                        if (isDisplayed) {
                            input.setAttribute('required', 'required');
                        } else {
                            input.removeAttribute('required');
                        }
                    }
                });
            }
        }

        // Event listener for select change
        unitSelect2.addEventListener("change", function() {
            const selectedValue = parseInt(unitSelect2.value);

            // Toggle display of elements based on selected value
            document.getElementById("unit22").style.display = selectedValue >= 2 ? "" : "none";
            document.getElementById("unit33").style.display = selectedValue >= 3 ? "" : "none";
            document.getElementById("unit44").style.display = selectedValue >= 4 ? "" : "none";
            document.getElementById("unit55").style.display = selectedValue >= 5 ? "" : "none";
            document.getElementById("unit66").style.display = selectedValue >= 6 ? "" : "none";
            document.getElementById("unit77").style.display = selectedValue >= 7 ? "" : "none";
            document.getElementById("unit88").style.display = selectedValue >= 8 ? "" : "none";
            document.getElementById("unit99").style.display = selectedValue >= 9 ? "" : "none";
            document.getElementById("unit101").style.display = selectedValue >= 10 ? "" : "none";

            // Toggle required attribute based on display status
            toggleRequiredBasedOnDisplay("unit22", document.getElementById("unit22").style.display !==
                "none");
            toggleRequiredBasedOnDisplay("unit33", document.getElementById("unit33").style.display !==
                "none");
            toggleRequiredBasedOnDisplay("unit44", document.getElementById("unit44").style.display !==
                "none");
            toggleRequiredBasedOnDisplay("unit55", document.getElementById("unit55").style.display !==
                "none");
                toggleRequiredBasedOnDisplay("unit66", document.getElementById("unit66").style.display !==
                "none");
                toggleRequiredBasedOnDisplay("unit77", document.getElementById("unit77").style.display !==
                "none");
                toggleRequiredBasedOnDisplay("unit88", document.getElementById("unit88").style.display !==
                "none");
                toggleRequiredBasedOnDisplay("unit99", document.getElementById("unit99").style.display !==
                "none");
                toggleRequiredBasedOnDisplay("unit101", document.getElementById("unit101").style.display !==
                "none");
        });

        // Trigger change event on page load if needed
        unitSelect2.dispatchEvent(new Event('change'));
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const unitSelect2 = document.getElementById("drivers_state2");

        // Function to toggle 'required' attribute based on display status
        function toggleRequiredBasedOnDisplay(elementId, isDisplayed) {
            const element = document.getElementById(elementId);
            if (element) {
                const inputs = element.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    // Check if the input is not one of the specific IDs to exclude
                    if (input.id !== "vehicle_year5" && input.id !== "vehicle_make5" && input.id !==
                        "stated_value5" && input.id !== "vehicle_year2" && input.id !==
                        "vehicle_make2" && input.id !== "stated_value2" && input.id !==
                        "vehicle_year3" && input.id !== "vehicle_make3" && input.id !==
                        "stated_value3" && input.id !== "vehicle_year4" && input.id !==
                        "vehicle_make4" && input.id !== "stated_value4") {
                        if (isDisplayed) {
                            input.setAttribute('required', 'required');
                        } else {
                            input.removeAttribute('required');
                        }
                    }
                });
            }
        }

        // Event listener for select change
        unitSelect2.addEventListener("change", function() {
            const selectedValue = parseInt(unitSelect2.value);

            // Toggle display of elements based on selected value
            document.getElementById("driver22").style.display = selectedValue >= 2 ? "" : "none";
            document.getElementById("driver33").style.display = selectedValue >= 3 ? "" : "none";
            document.getElementById("driver44").style.display = selectedValue >= 4 ? "" : "none";
            document.getElementById("driver55").style.display = selectedValue >= 5 ? "" : "none";
            document.getElementById("driver66").style.display = selectedValue >= 6 ? "" : "none";
            document.getElementById("driver77").style.display = selectedValue >= 7 ? "" : "none";
            document.getElementById("driver88").style.display = selectedValue >= 8 ? "" : "none";
            document.getElementById("driver99").style.display = selectedValue >= 9 ? "" : "none";
            document.getElementById("driver101").style.display = selectedValue >= 10 ? "" : "none";

            // Toggle required attribute based on display status
            toggleRequiredBasedOnDisplay("driver22", document.getElementById("driver22").style
                .display !== "none");
            toggleRequiredBasedOnDisplay("driver33", document.getElementById("driver33").style
                .display !== "none");
            toggleRequiredBasedOnDisplay("driver44", document.getElementById("driver44").style
                .display !== "none");
            toggleRequiredBasedOnDisplay("driver55", document.getElementById("driver55").style
                .display !== "none");
            toggleRequiredBasedOnDisplay("driver66", document.getElementById("driver66").style
                .display !== "none");
            toggleRequiredBasedOnDisplay("driver77", document.getElementById("driver77").style
                .display !== "none");
            toggleRequiredBasedOnDisplay("driver88", document.getElementById("driver88").style
                .display !== "none");
            toggleRequiredBasedOnDisplay("driver99", document.getElementById("driver99").style
                .display !== "none");
            toggleRequiredBasedOnDisplay("driver101", document.getElementById("driver101").style
                .display !== "none");
        });

        // Trigger change event on page load if needed
        unitSelect2.dispatchEvent(new Event('change'));
    });
</script>
    <script>
        $(document).ready(function() {
    $('.btn-mail').click(function() {
               var leadId = $(this).data('lead-id');
                var status = 'Mail';
                var managerfwd = $('#manager_id').val();
                var $td = $(this).closest('tr');
        sendRequest(leadId, status, managerfwd, $td);
    });

    $('.btn-message').click(function() {
        var leadId = $(this).data('lead-id');
                var status = 'Message';
                var managerfwd = $('#manager_id').val();
                var $td = $(this).closest('tr');
        sendRequest(leadId, status, managerfwd ,$td);
    });

    function sendRequest(leadId, status,managerfwd,$td) {
        $.ajax({
                    url: '{{ route('agent_mailstatus_update') }}',
                    method: 'POST',
                    data: {
                        lead_id: leadId,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $td.find('.btn')
                            .text(response.status)
                            .css('background-color', getStatusColor(response.status));

                        function getStatusColor(status) {
                            switch (status) {
                                case 'Mail':
                                    return '#742dc1'; // Light green

                                case 'Message':
                                    return '#742dc1'; // Black
                                default:
                                    return '#ffffff'; // Default background color
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error response if needed
                        console.error(error);
                    }
                });
    }
});
        </script>
        <script>
            // Get references to the date input and time input fields
            const dateInput = document.getElementById('dateInput1');
            const timeInput = document.getElementById('timeInput1');
            const reminderInput = document.getElementById('reminder1');
        
            // Event listener to update the reminder input when either date or time changes
            dateInput.addEventListener('input', updateReminder);
            timeInput.addEventListener('input', updateReminder);
        
            function updateReminder() {
                // Get the value of date and time inputs
                const dateValue = dateInput.value;
                const timeValue = timeInput.value;
        
                // Combine date and time values with a "/"
                const reminderValue = `${dateValue} ${timeValue}`;
        
                // Update the value of the reminder input
                reminderInput.value = reminderValue;
            }
        </script>
      <script>
document.querySelectorAll('.call-mail-option').forEach(label => {
    label.addEventListener('click', function() {
        // Pehle sabko uncheck karo
        document.querySelectorAll('.call-mail-option').forEach(el => {
            el.querySelector('input').checked = false;
            el.classList.remove('checked');
        });

        // Ab sirf clicked wale ko check karo
        const checkbox = this.querySelector('input');
        checkbox.checked = true;
        this.classList.add('checked');
    });
});
</script>




@endsection
