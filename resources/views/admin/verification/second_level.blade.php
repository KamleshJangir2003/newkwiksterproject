@extends('admin.common.app')
@section('css')
    <style>
        .pagination nav {
            display: inline-block;
        }

        .pagination nav div {
            display: inline-block;
        }

        .pagination nav div span {
            display: inline-block;
            margin-top: 10px;
        }

        .pagination nav div a {
            display: inline-block;
            font-size: 15px;
            min-width: 40px;
            width: auto;
            background-color: #004274 !important;
            color: white;
        }

        .pagination nav div p {
            display: none;
        }
    </style>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Additional styling for dropdown */
        .dropdown-menu {
            min-width: auto;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.15);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
    </style>
@endsection
@section('main')
<style>
    .clickable-cell {
    cursor: pointer;
}
    </style>
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
                                <!-- End show success and error messages -->
                                <div class="card" id="leadsList">
                                    <div class="card-header border-0">
                                        <form method="get">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-sm-2">
                                                <div class="search-box">
                                                    <input type="text" name="search_input" class="form-control search" placeholder="Search for..." value="{{ isset($_GET['search_input']) ? $_GET['search_input'] : '' }}">
                                                    <i class="ri-search-line search-icon"></i>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="search-box">
                                                    <input type="text" name="row_pegi" class="form-control search" placeholder="Select rows" value="{{ isset($_GET['row_pegi']) ? $_GET['row_pegi'] : '' }}">
                                                    <i class="ri-search-line search-icon"></i>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="search-box">
                                                    @php
                                                    $users = App\Models\User::where('is_active',1)->where('status',1)->get();
                                                    @endphp
                                                    <select name="state" class="form-control search">
                                                        <option value="">search Agent</option>
                                                        @foreach($users as $user)
                                                        @php
                                                            $userDetails = App\adminmodel\Users_detailsModal::where('ajent_id', $user->id)->first();
                                                            $name = !empty($userDetails) ? $userDetails->alise_name : $user->name;
                                                        @endphp
                                                        <option value="{{ $user->id }}" {{ isset($_GET['state']) && $_GET['state'] == $user->id ? 'selected' : '' }}>
                                                            {{ $name }}
                                                        </option>
                                                    @endforeach
                                                    </select>
                                                    <i class="ri-search-line search-icon"></i>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="search-box">
                                                    <input type="date" name="date1" class="form-control search" placeholder="Search for..." value="{{ isset($_GET['date1']) ? $_GET['date1'] : '' }}">
                                                    <i class="ri-search-line search-icon"></i>
                                                </div>
                                            </div>
                                            <p style="margin-bottom:0px">To</p>
                                            <div class="col-sm-2">
                                                <div class="search-box">
                                                    <input type="date" name="date2" class="form-control search" placeholder="Search for..." value="{{ isset($_GET['date2']) ? $_GET['date2'] : '' }}">
                                                    <i class="ri-search-line search-icon"></i>
                                                </div>
                                            </div>
                                            <button type="submit" class=" btn-success" style="margin-right:5px"><i class="ti-search"></i></button> 
                                            <button type="button"  class=" btn-danger" onclick="window.location.href='{{route('newinterstedleads')}}'"><i class="fa-solid fa-circle-xmark"></i>clear</button>
                                               
                                            </form>

                                            <div class="col-sm-auto ms-auto" style="margin-top: 10px">
                                                <div class="hstack gap-2">
                                                    <button type="button" class="btn btn-info" data-bs-toggle="offcanvas"
                                                        href="#offcanvasExample" id="forwardButton" style="display: none;"
                                                        data-toggle="modal" data-target="#forword_leads"><i
                                                            class="ri-filter-3-line align-bottom me-1"></i>
                                                        Forward</button>
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="offcanvas"
                                                        href="#offcanvasExample" id="delete_selected" style="display: none;"
                                                        data-toggle="modal" data-target="#delete_leads"><i
                                                        class="ti-trash"></i>
                                                        Delete</button>
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas"
                                                        href="#offcanvasExample" id="submit_selected" style="display: none;"
                                                        data-toggle="modal" data-target="#submit_leads">
                                                        Submit</button>
                                                    <button type="button" class="btn btn-success add-btn" id="create-btn"
                                                        data-toggle="modal" data-target="#import_leads"><i
                                                            class="ri-add-line align-bottom me-1"></i> Import
                                                        Leads</button>
                                                        <button type="button" class="btn btn-success add-btn" id="download-btn"   onclick="window.location.href='{{ route('instersted_download', ['date1' => isset($_GET['date1']) ? $_GET['date1'] : '', 'date2' => isset($_GET['date2']) ? $_GET['date2'] : '']) }}'"
                                                        > Excel
                                                        </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- forward Modal -->
                                    <div class="modal fade" id="forword_leads" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Leads Forword</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('forword_leads') }}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="input-group">

                                                            <div class="row mb-3">
                                                                @if (!empty($agents))
                                                                    @foreach ($agents as $agent)
                                                                        <div class="col-sm-6">
                                                                            <div class="input-group-prepend">
                                                                                <div class="input-group-text">
                                                                                    <input type="radio"
                                                                                        aria-label="Radio button for following text input"
                                                                                        name="agent_id"
                                                                                        value="{{ $agent->id }}">
                                                                                    <label class="form-check-label"
                                                                                        for="inlineCheckbox1"
                                                                                        style="padding:1px">{{ $agent->name }}</label>
                                                                                </div>
                                                                            </div>
                                                                        </div><br><br>
                                                                    @endforeach
                                                                @endif
                                                                <input type="hidden" name="leadid[]">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Forward</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end forwordmodal -->
                                    <!-- start deletemodal -->
                                    <div class="modal fade" id="delete_leads" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">delete lead</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('bluckdelete') }}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <h4>Are you Sure ..??</h4>
                                                    </div>
                                                    <input type="hidden" name="leadids[]">
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end deletemodal -->
                                    <!-- start Submit Model -->
                                    <div class="modal fade" id="submit_leads" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Submit lead</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('submitformstore') }}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <h5>Are you Sure ..??</h5>
                                                    </div>
                                                    <input type="hidden" name="leadidss[]">
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end Submit emodal -->

                                    <!-- import leads model -->
                                    <div class="modal fade" id="import_leads" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Import Leads</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card-body">
                                                        <form action="{{ route('import') }}" method="post"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="row mb-3">
                                                                <div class="col-sm-3">
                                                                    <h6 class="mb-0">File Name</h6>
                                                                </div>
                                                                <div class="col-sm-9 text-secondary">
                                                                    <input type="text" class="form-control"
                                                                        name="batch_name" value="" required>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-sm-3">
                                                                    <h6 class="mb-0">Excel file</h6>
                                                                </div>
                                                                <div class="col-sm-9 text-secondary">
                                                                    <input type="file" class="form-control"
                                                                        name="excel_file" required>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!--End import leads model -->

                                    <div class="table-responsive">
                                        <div class="form-group row">
                                            <div class="form-group" style="width:100%; margin-left:30px">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">
                                                                <input type="checkbox" id="selectAllCheckbox"
                                                                    class="data-checkbox" onchange="updateLeadIds()">
                                                            </th>
                                                            <th scope="col">S.No.</th>
                                                            <th scope="col">Agent Name</th>
                                                            <th scope="col">Company Name</th>
                                                            <th scope="col">Phone</th>
                                                            <th scope="col">Company Rep1</th>
                                                            <th scope="col">Business Address</th>
                                                            <th scope="col">Business City</th>
                                                            <th scope="col">Business State</th>
                                                            <th scope="col">Business Zip</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col"> Date</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($datas->isNotEmpty())
                                                            @php $a = 0;   @endphp
                                                            @foreach ($datas as $data)
                                                                @php $a++; @endphp
                                                                <tr>
                                                                    <th scope="col">
                                                                        <input type="checkbox" class="data-checkbox"
                                                                            value="{{ $data->id }}"
                                                                            onchange="updateLeadIds()">
                                                                    </th>
                                                                    
                                                                    <th scope="row">
                                                                        {{ $a }}
                                                                        @if($data->red_mark == 1)
                                                                        <span style="color: red;">{R}</span>
                                                                        @endif
                                                                    </th>
                                                                    <th>
                                                                        @php
                                                                        $user = App\adminmodel\Users_detailsModal::where('ajent_id',$data->click_id)->first();
                                                                        if(!empty($user)){
                                                                            $name = $user->alise_name;
                                                                        }
                                                                        else{
                                                                            $name =  $data->click_id;
                                                                        }
                                                                        @endphp
                                                                        {{$name}}
                                                                    </th>
                                                                    <td>{{ $data->company_name }}</td>
                                                                    <td>{{ $data->phone }}</td>
                                                                    @php
                                                                    $unit = App\Models\unitOwned::where('data_id',$data->id)->first();
                                                                @endphp
                                                                    <td class="clickable-cell" data-bs-toggle="modal" data-company-name="{{ $data->company_name }}"
                                                                        data-phone="{{ $data->phone }}" data-id="{{ $data->id }}"
                                                                        data-company-rep1="{{ $data->company_rep1 }}"
                                                                        data-business-address="{{ $data->business_address }}"
                                                                        data-business-city="{{ $data->business_city }}"
                                                                        data-business-state="{{ $data->business_state }}"
                                                                        data-business-zip="{{ $data->business_zip }}"
                                                                        data-dot="{{ $data->dot }}" data-mc_docket="{{ $data->mc_docket }}"
                                                                        data-email="{{ $data->email }}" data-commodities="{{ $data->commodities }}"
                                                                        data-unit_owned="{{ $data->unit_owned }}" data-vin="{{ $data->vin }}"
                                                                        data-driver_name="{{ $data->driver_name }}" data-driver_dob="{{ $data->driver_dob }}"
                                                                        data-driver_license="{{ $data->driver_license }}" data-driver_license_state="{{ $data->driver_license_state }}"
                                                                        data-vehicle_year="{{ $data->vehicle_year }}" data-vehicle_make="{{ $data->vehicle_make }}"
                                                                        data-stated_value="{{ $data->stated_value }}" data-is_cover_well="{{ $data->is_cover_well }}"
                                                                        data-comment="{{ $data->comment }}" data-Liability="{{ $data->Liability }}"
                                                                        data-MTC="{{ $data->MTC }}" data-interchange="{{ $data->interchange }}"
                                                                        data-file1="{{ $data->file1 }}" data-file2="{{ $data->file2 }}"
                                                                        data-file3="{{ $data->file3 }}" data-file4="{{ $data->file4 }}"
                                                                        data-file5="{{ $data->file5 }}" data-file6="{{ $data->file6 }}" data-error_file="{{ $data->error_file }}" data-audio_file="{{ $data->audio }}"
                                                                        data-physical="{{ $data->physical }}" data-general="{{ $data->general }}"
                                                                        {{-- unit owned --}}
                                                                        data-vin2="{{ $unit->vin2 }}"
                                                                        data-driver_name2="{{ $unit->driver_name2 }}" 
                                                                        data-driver_dob2="{{ $unit->driver_dob2 }}"
                                                                        data-driver_license2="{{ $unit->driver_license2 }}" 
                                                                        data-driver_license_state2="{{ $unit->driver_license_state2 }}"
                                                                        data-vehicle_year2="{{ $unit->vehicle_year2 }}" 
                                                                        data-vehicle_make2="{{ $unit->vehicle_make2 }}"
                                                                        data-stated_value2="{{ $unit->stated_value2 }}"
                        
                                                                        data-vin3="{{ $unit->vin3 }}"
                                                                        data-driver_name3="{{ $unit->driver_name3 }}" 
                                                                        data-driver_dob3="{{ $unit->driver_dob3 }}"
                                                                        data-driver_license3="{{ $unit->driver_license3 }}" 
                                                                        data-driver_license_state3="{{ $unit->driver_license_state3 }}"
                                                                        data-vehicle_year3="{{ $unit->vehicle_year3 }}" 
                                                                        data-vehicle_make3="{{ $unit->vehicle_make3 }}"
                                                                        data-stated_value3="{{ $unit->stated_value3 }}"
                        
                                                                        data-vin4="{{ $unit->vin4 }}"
                                                                        data-driver_name4="{{ $unit->driver_name4 }}" 
                                                                        data-driver_dob4="{{ $unit->driver_dob4 }}"
                                                                        data-driver_license4="{{ $unit->driver_license4 }}" 
                                                                        data-driver_license_state4="{{ $unit->driver_license_state4 }}"
                                                                        data-vehicle_year4="{{ $unit->vehicle_year4 }}" 
                                                                        data-vehicle_make4="{{ $unit->vehicle_make4 }}"
                                                                        data-stated_value4="{{ $unit->stated_value4 }}"
                        
                                                                        data-vin5="{{ $unit->vin5 }}"
                                                                        data-driver_name5="{{ $unit->driver_name5 }}" 
                                                                        data-driver_dob5="{{ $unit->driver_dob5 }}"
                                                                        data-driver_license5="{{ $unit->driver_license5 }}" 
                                                                        data-driver_license_state5="{{ $unit->driver_license_state5 }}"
                                                                        data-vehicle_year5="{{ $unit->vehicle_year5 }}" 
                                                                        data-vehicle_make5="{{ $unit->vehicle_make5 }}"
                                                                        data-stated_value5="{{ $unit->stated_value5 }}"

                                                                        data-vin6="{{ $unit->vin6 }}"
                                                                        data-driver_name6="{{ $unit->driver_name6 }}" 
                                                                        data-driver_dob6="{{ $unit->driver_dob6 }}"
                                                                        data-driver_license6="{{ $unit->driver_license6 }}" 
                                                                        data-driver_license_state6="{{ $unit->driver_license_state6 }}"
                                                                        data-vehicle_year6="{{ $unit->vehicle_year6 }}" 
                                                                        data-vehicle_make6="{{ $unit->vehicle_make6 }}"
                                                                        data-stated_value6="{{ $unit->stated_value6 }}"
                                                                        
                                                                        data-vin7="{{ $unit->vin7 }}"
                                                                        data-driver_name7="{{ $unit->driver_name7 }}" 
                                                                        data-driver_dob7="{{ $unit->driver_dob7 }}"
                                                                        data-driver_license7="{{ $unit->driver_license7 }}" 
                                                                        data-driver_license_state7="{{ $unit->driver_license_state7 }}"
                                                                        data-vehicle_year7="{{ $unit->vehicle_year7 }}" 
                                                                        data-vehicle_make7="{{ $unit->vehicle_make7 }}"
                                                                        data-stated_value7="{{ $unit->stated_value7 }}"
                                                                        
                                                                        data-vin8="{{ $unit->vin8 }}"
                                                                        data-driver_name8="{{ $unit->driver_name8 }}" 
                                                                        data-driver_dob8="{{ $unit->driver_dob8 }}"
                                                                        data-driver_license8="{{ $unit->driver_license8 }}" 
                                                                        data-driver_license_state8="{{ $unit->driver_license_state8 }}"
                                                                        data-vehicle_year8="{{ $unit->vehicle_year8 }}" 
                                                                        data-vehicle_make8="{{ $unit->vehicle_make8 }}"
                                                                        data-stated_value8="{{ $unit->stated_value8 }}"
                                                                        
                                                                        data-vin9="{{ $unit->vin9 }}"
                                                                        data-driver_name9="{{ $unit->driver_name9 }}" 
                                                                        data-driver_dob9="{{ $unit->driver_dob9 }}"
                                                                        data-driver_license9="{{ $unit->driver_license9 }}" 
                                                                        data-driver_license_state9="{{ $unit->driver_license_state9 }}"
                                                                        data-vehicle_year9="{{ $unit->vehicle_year9 }}" 
                                                                        data-vehicle_make9="{{ $unit->vehicle_make9 }}"
                                                                        data-stated_value9="{{ $unit->stated_value9 }}"
                                                                        
                                                                        data-vin10="{{ $unit->vin10 }}"
                                                                        data-driver_name10="{{ $unit->driver_name10 }}" 
                                                                        data-driver_dob10="{{ $unit->driver_dob10 }}"
                                                                        data-driver_license10="{{ $unit->driver_license10 }}" 
                                                                        data-driver_license_state10="{{ $unit->driver_license_state10 }}"
                                                                        data-vehicle_year10="{{ $unit->vehicle_year10 }}" 
                                                                        data-vehicle_make10="{{ $unit->vehicle_make10 }}"
                                                                        data-stated_value10="{{ $unit->stated_value10 }}"

                                                                         data-redmark="{{ $data->red_mark }}"
                                                                        data-bs-target="#exampleFullScreenModal">
                                                                        {{ $data->company_rep1 }}</td>
                                                                    <td>{{ $data->business_address }}</td>
                                                                    <td>{{ $data->business_city }}</td>
                                                                    <td>{{ $data->business_state }}</td>
                                                                    <td>{{ $data->business_zip }}</td>

                                                                    @if ($data->form_status == 'NEW')
                                                                        <td>
                                                                            <button class="custom-button"
                                                                                id="dropdownMenuButton"
                                                                                data-toggle="dropdown"
                                                                                aria-haspopup="true" aria-expanded="false"
                                                                                style="background-color:#119711;color:white; padding: 2px 15px;border: none;">
                                                                                <i class='bx bxs-circle me-1'></i>NEW
                                                                            </button>
                                                                            <div class="dropdown-menu"
                                                                                aria-labelledby="dropdownMenuButton">
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('Voice Mail')]) }}">Voice
                                                                                    Mail</a>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('Not Intrested')]) }}">Not
                                                                                    Intrested</a>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('Not Connected')]) }}">Not
                                                                                    Connected</a>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('Wrong Number')]) }}">Wrong
                                                                                    Number</a>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('WON')]) }}">WON</a>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('DND')]) }}">DND</a>
                                                                            </div>
                                                                        </td>
                                                                    @elseif($data->form_status == 'Voice Mail')
                                                                        <td>
                                                                            <button class="custom-button"
                                                                                id="dropdownMenuButton"
                                                                                data-toggle="dropdown"
                                                                                aria-haspopup="true" aria-expanded="false"
                                                                                style="background-color:#742dc1;color:white; padding: 2px 15px;border: none;">
                                                                                <i class='bx bxs-circle me-1'></i>Voice
                                                                                Mail
                                                                            </button>
                                                                            <div class="dropdown-menu"
                                                                                aria-labelledby="dropdownMenuButton">
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('NEW')]) }}">New</a>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('Not Intrested')]) }}">Not
                                                                                    Intrested</a>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('Not Connected')]) }}">Not
                                                                                    Connected</a>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('Wrong Number')]) }}">Wrong
                                                                                    Number</a>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('WON')]) }}">WON</a>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('DND')]) }}">DND</a>
                                                                            </div>
                                                                        </td>
                                                                    @elseif($data->form_status == 'Not Intrested' || $data->form_status == 'Wrong Number' || $data->form_status == 'DND')
                                                                        <td>
                                                                            <button class="custom-button"
                                                                                id="dropdownMenuButton"
                                                                                data-toggle="dropdown"
                                                                                aria-haspopup="true" aria-expanded="false"
                                                                                style="background-color:#d91c1c;color:white; padding: 2px 15px;border: none;">
                                                                                <i
                                                                                    class='bx bxs-circle me-1'></i>{{ $data->form_status }}
                                                                            </button>
                                                                            <div class="dropdown-menu"
                                                                                aria-labelledby="dropdownMenuButton">
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('NEW')]) }}">New</a>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('Voice Mail')]) }}">Voice
                                                                                    Mail</a>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('Not Intrested')]) }}">Not
                                                                                    Intrested</a>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('Not Connected')]) }}">Not
                                                                                    Connected</a>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('Wrong Number')]) }}">Wrong
                                                                                    Number</a>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('WON')]) }}">WON</a>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('DND')]) }}">DND</a>
                                                                            </div>
                                                                        </td>
                                                                    @elseif($data->form_status == 'Not Connected')
                                                                        <td>
                                                                            <button class="custom-button"
                                                                                id="dropdownMenuButton"
                                                                                data-toggle="dropdown"
                                                                                aria-haspopup="true" aria-expanded="false"
                                                                                style="background-color:#e6ca00;color:white; padding: 2px 15px;border: none;">
                                                                                <i class='bx bxs-circle me-1'></i>Not
                                                                                Connected
                                                                            </button>
                                                                            <div class="dropdown-menu"
                                                                                aria-labelledby="dropdownMenuButton">
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('NEW')]) }}">New</a>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('Voice Mail')]) }}">Voice
                                                                                    Mail</a>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('Not Intrested')]) }}">Not
                                                                                    Intrested</a>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('Wrong Number')]) }}">Wrong
                                                                                    Number</a>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('WON')]) }}">WON</a>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('DND')]) }}">DND</a>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td>
                                                                            <button class="custom-button"
                                                                                id="dropdownMenuButton"
                                                                                data-toggle="dropdown"
                                                                                aria-haspopup="true" aria-expanded="false"
                                                                                style="background-color:#00ff72;color:white; padding: 2px 15px;border: none;">
                                                                                <i class='bx bxs-circle me-1'></i>{{$data->form_status}}
                                                                            </button>
                                                                          
                                                                        </td>
                                                                    @endif
                                                                    <td>{{ $data->updated_at }}</td>
                                                                    <td>
                                                                        <div class="btn-group"
                                                                            id="btns<?php echo $a; ?>">
                                                                            <a href="tel:{{ $data->phone }}"
                                                                                data-toggle="tooltip" data-placement="top"
                                                                                title="Call">
                                                                                <i class="ti-headphone-alt"
                                                                                    style="font-size:20px;margin-right:10px"></i>
                                                                            </a>
                                                                        </div>
                                                                        <div class="btn-group"
                                                                            id="btns<?php echo $a; ?>">
                                                                            <a href="javascript:();" class="dCnf"
                                                                                mydata="<?php echo $a; ?>"
                                                                                data-toggle="tooltip" data-placement="top"
                                                                                title="Delete"><i class="ti-trash"
                                                                                    style="font-size:20px"></i></a>
                                                                        </div>
                                                                        <div style="display:none"
                                                                            id="cnfbox<?php echo $a; ?>">
                                                                            <p> Are you sure ..?</p>
                                                                            <a href="{{ route('delete_lead', base64_encode($data->id)) }}"
                                                                                class="btn btn-danger">Yes</a>
                                                                            <a href="javascript:();"
                                                                                class="cans btn btn-default"
                                                                                mydatas="<?php echo $a; ?>">No</a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                             @endforeach
                                                         @else
                                                         <tr>
                                                            <td colspan="12" style="text-align: center; vertical-align: middle;">
                                                                <!-- Content to be centered -->
                                                                <div style="display: inline-block;"> <!-- Ensure inline-block display -->
                                                                    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                                                                    <lottie-player src="https://lottie.host/461c3ab8-f91d-4dd3-9695-9f8c28b25030/TU3aEfjPmx.json" background="#FFFFFF" speed="1" style="width: 100px; height: 100px; display: block; margin: 0 auto;" loop autoplay direction="1" mode="normal"></lottie-player>
                                                                </div>
                                                                <p>No leads found</p>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        
                                                    </tbody>
                                                </table>
                                                {{ $datas->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                    </div>
                    <!-- Page-body end -->
                </div>
                {{-- modal start --}}
    <div class="modal fade" id="exampleFullScreenModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog " style="max-width: 100%; margin: 30px;">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h4>Lead</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                </div>
                <div class="modal-body" style="padding:40px">
                    <form action="{{ route('intrested_check') }}" method="POST" enctype="multipart/form-data"  onsubmit="return confirmSubmit()">
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
                                                id="business_zip" name="business_zip">
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
                                                            <select class="form-control" id="unit_owned2" name="unit_owned" >
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
                                            <input type="text" class="form-control" placeholder="Enter stated value"
                                                id="stated_value" name="stated_value">
                                        </div>
                                    </div><!--end col-->

                                    <div class="row unit2" id="unit22">
                                       
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


                                    <div class="row unit3" id="unit33">
                                     
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


                                   <!-- Driver Unit 4 -->
<div class="row unit4" id="unit44">
    <div class="col-6">
        <div class="mb-3">
            <label for="citynameInput" class="form-label">VIN4 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter VIN" id="vin4" name="vin4">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="citynameInput" class="form-label">Vehicle Year4 </label>
            <input type="number" class="form-control" placeholder="YYYY" id="vehicle_year4" name="vehicle_year4">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="citynameInput" class="form-label">Vehicle Make4 </label>
            <input type="text" class="form-control" placeholder="Enter Vehicle make..." id="vehicle_make4"
                name="vehicle_make4">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="citynameInput" class="form-label">Stated Value4 </label>
            <input type="text" class="form-control" placeholder="Enter stated value" id="stated_value4"
                name="stated_value4">
        </div>
    </div>
</div>

<!-- Driver Unit 5 -->
<div class="row unit5" id="unit55">
    <div class="col-6">
        <div class="mb-3">
            <label for="citynameInput" class="form-label">VIN5 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter VIN" id="vin5" name="vin5">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="citynameInput" class="form-label">Vehicle Year5 </label>
            <input type="number" class="form-control" placeholder="YYYY" id="vehicle_year5" name="vehicle_year5">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="citynameInput" class="form-label">Vehicle Make5 </label>
            <input type="text" class="form-control" placeholder="Enter Vehicle make..." id="vehicle_make5"
                name="vehicle_make5">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="citynameInput" class="form-label">Stated Value5 </label>
            <input type="text" class="form-control" placeholder="Enter stated value" id="stated_value5"
                name="stated_value5">
        </div>
    </div>
</div>

<!-- Driver Unit 6 -->
<div class="row unit6" id="unit66">
    <div class="col-6">
        <div class="mb-3">
            <label for="vin6" class="form-label">VIN6 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter VIN" id="vin6" name="vin6">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="vehicle_year6" class="form-label">Vehicle Year6 </label>
            <input type="number" class="form-control" placeholder="YYYY" id="vehicle_year6" name="vehicle_year6">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="vehicle_make6" class="form-label">Vehicle Make6 </label>
            <input type="text" class="form-control" placeholder="Enter Vehicle make..." id="vehicle_make6"
                name="vehicle_make6">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="stated_value6" class="form-label">Stated Value6 </label>
            <input type="text" class="form-control" placeholder="Enter stated value" id="stated_value6"
                name="stated_value6">
        </div>
    </div>
</div>

<!-- Driver Unit 7 -->
<div class="row unit7" id="unit77">
    <div class="col-6">
        <div class="mb-3">
            <label for="vin7" class="form-label">VIN7 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter VIN" id="vin7" name="vin7">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="vehicle_year7" class="form-label">Vehicle Year7 </label>
            <input type="number" class="form-control" placeholder="YYYY" id="vehicle_year7" name="vehicle_year7">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="vehicle_make7" class="form-label">Vehicle Make7 </label>
            <input type="text" class="form-control" placeholder="Enter Vehicle make..." id="vehicle_make7"
                name="vehicle_make7">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="stated_value7" class="form-label">Stated Value7 </label>
            <input type="text" class="form-control" placeholder="Enter stated value" id="stated_value7"
                name="stated_value7">
        </div>
    </div>
</div>

<!-- Driver Unit 8 -->
<div class="row unit8" id="unit88">
    <div class="col-6">
        <div class="mb-3">
            <label for="vin8" class="form-label">VIN8 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter VIN" id="vin8" name="vin8">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="vehicle_year8" class="form-label">Vehicle Year8 </label>
            <input type="number" class="form-control" placeholder="YYYY" id="vehicle_year8" name="vehicle_year8">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="vehicle_make8" class="form-label">Vehicle Make8 </label>
            <input type="text" class="form-control" placeholder="Enter Vehicle make..." id="vehicle_make8"
                name="vehicle_make8">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="stated_value8" class="form-label">Stated Value8 </label>
            <input type="text" class="form-control" placeholder="Enter stated value" id="stated_value8"
                name="stated_value8">
        </div>
    </div>
</div>

<!-- Driver Unit 9 -->
<div class="row unit9" id="unit99">
    <div class="col-6">
        <div class="mb-3">
            <label for="vin9" class="form-label">VIN9 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter VIN" id="vin9" name="vin9">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="vehicle_year9" class="form-label">Vehicle Year9 </label>
            <input type="number" class="form-control" placeholder="YYYY" id="vehicle_year9" name="vehicle_year9">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="vehicle_make9" class="form-label">Vehicle Make9 </label>
            <input type="text" class="form-control" placeholder="Enter Vehicle make..." id="vehicle_make9"
                name="vehicle_make9">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="stated_value9" class="form-label">Stated Value9 </label>
            <input type="text" class="form-control" placeholder="Enter stated value" id="stated_value9"
                name="stated_value9">
        </div>
    </div>
</div>

<!-- Driver Unit 10 -->
<div class="row unit10" id="unit101">
    <div class="col-6">
        <div class="mb-3">
            <label for="vin10" class="form-label">VIN10 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter VIN" id="vin10" name="vin10">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="vehicle_year10" class="form-label">Vehicle Year10 </label>
            <input type="number" class="form-control" placeholder="YYYY" id="vehicle_year10" name="vehicle_year10">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="vehicle_make10" class="form-label">Vehicle Make10 </label>
            <input type="text" class="form-control" placeholder="Enter Vehicle make..." id="vehicle_make10"
                name="vehicle_make10">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="stated_value10" class="form-label">Stated Value10 </label>
            <input type="text" class="form-control" placeholder="Enter stated value" id="stated_value10"
                name="stated_value10">
        </div>
    </div>
</div>
<!-- Driver Unit 1 -->
<div class="col-6">
    <div class="mb-3">
        <label for="citynameInput" class="form-label">Driver Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" placeholder="Enter driver name" id="driver_name" name="driver_name">
    </div>
</div>
<div class="col-6">
    <div class="mb-3">
        <label for="citynameInput" class="form-label">Driver DOB <span class="text-danger">*</span></label>
        <input type="date" class="form-control" placeholder="Enter driver dob" id="driver_dob" name="driver_dob">
    </div>
</div>
<div class="col-6">
    <div class="mb-3">
        <label for="citynameInput" class="form-label">Driver License <span class="text-danger">*</span></label>
        <input type="text" class="form-control" placeholder="Enter driver license" id="driver_license" name="driver_license">
    </div>
</div>
<div class="col-6">
    <div class="mb-3">
        <label for="citynameInput" class="form-label">Driver License State<span class="text-danger">*</span></label>
        <input type="text" class="form-control" placeholder="Enter driver license state" id="driver_license_state" name="driver_license_state">
    </div>
</div>

<!-- Driver Unit 2 -->
<div class="row unit2" id="driver22">
    <div class="col-6">
        <div class="mb-3">
            <label for="citynameInput" class="form-label">Driver Name2 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver name" id="driver_name2" name="driver_name2">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="citynameInput" class="form-label">Driver DOB2 <span class="text-danger">*</span></label>
            <input type="date" class="form-control" placeholder="Enter driver dob" id="driver_dob2" name="driver_dob2">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="citynameInput" class="form-label">Driver License2 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver license" id="driver_license2" name="driver_license2">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="citynameInput" class="form-label">Driver License State2 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver license state" id="driver_license_state2" name="driver_license_state2">
        </div>
    </div>
</div>

<!-- Driver Unit 3 -->
<div class="row unit3" id="driver33">
    <div class="col-6">
        <div class="mb-3">
            <label for="citynameInput" class="form-label">Driver Name3 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver name" id="driver_name3" name="driver_name3">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="citynameInput" class="form-label">Driver DOB3 <span class="text-danger">*</span></label>
            <input type="date" class="form-control" placeholder="Enter driver dob" id="driver_dob3" name="driver_dob3">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="citynameInput" class="form-label">Driver License3 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver license" id="driver_license3" name="driver_license3">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="citynameInput" class="form-label">Driver License State3 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver license state" id="driver_license_state3" name="driver_license_state3">
        </div>
    </div>
</div>

<!-- Driver Unit 4 -->
<div class="row unit4" id="driver44">
    <div class="col-6">
        <div class="mb-3">
            <label for="citynameInput" class="form-label">Driver Name4 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver name" id="driver_name4" name="driver_name4">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="citynameInput" class="form-label">Driver DOB4 <span class="text-danger">*</span></label>
            <input type="date" class="form-control" placeholder="Enter driver dob" id="driver_dob4" name="driver_dob4">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="citynameInput" class="form-label">Driver License4 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver license" id="driver_license4" name="driver_license4">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="citynameInput" class="form-label">Driver License State4 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver license state" id="driver_license_state4" name="driver_license_state4">
        </div>
    </div>
</div>

<!-- Driver Unit 5 -->
<div class="row unit5" id="driver55">
    <div class="col-6">
        <div class="mb-3">
            <label for="citynameInput" class="form-label">Driver Name5 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver name" id="driver_name5" name="driver_name5">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="citynameInput" class="form-label">Driver DOB5 <span class="text-danger">*</span></label>
            <input type="date" class="form-control" placeholder="Enter driver dob" id="driver_dob5" name="driver_dob5">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="citynameInput" class="form-label">Driver License5 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver license" id="driver_license5" name="driver_license5">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="citynameInput" class="form-label">Driver License State5 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver license state" id="driver_license_state5" name="driver_license_state5">
        </div>
    </div>
</div>

<!-- Driver Unit 6 -->
<div class="row unit6" id="driver66">
    <div class="col-6">
        <div class="mb-3">
            <label for="driver_name6" class="form-label">Driver Name6 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver name" id="driver_name6" name="driver_name6">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="driver_dob6" class="form-label">Driver DOB6 <span class="text-danger">*</span></label>
            <input type="date" class="form-control" placeholder="Enter driver dob" id="driver_dob6" name="driver_dob6">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="driver_license6" class="form-label">Driver License6 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver license" id="driver_license6" name="driver_license6">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="driver_license_state6" class="form-label">Driver License State6 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver license state" id="driver_license_state6" name="driver_license_state6">
        </div>
    </div>
</div>

<!-- Driver Unit 7 -->
<div class="row unit7" id="driver77">
    <div class="col-6">
        <div class="mb-3">
            <label for="driver_name7" class="form-label">Driver Name7 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver name" id="driver_name7" name="driver_name7">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="driver_dob7" class="form-label">Driver DOB7 <span class="text-danger">*</span></label>
            <input type="date" class="form-control" placeholder="Enter driver dob" id="driver_dob7" name="driver_dob7">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="driver_license7" class="form-label">Driver License7 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver license" id="driver_license7" name="driver_license7">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="driver_license_state7" class="form-label">Driver License State7 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver license state" id="driver_license_state7" name="driver_license_state7">
        </div>
    </div>
</div>

<!-- Driver Unit 8 -->
<div class="row unit8" id="driver88">
    <div class="col-6">
        <div class="mb-3">
            <label for="driver_name8" class="form-label">Driver Name8 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver name" id="driver_name8" name="driver_name8">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="driver_dob8" class="form-label">Driver DOB8 <span class="text-danger">*</span></label>
            <input type="date" class="form-control" placeholder="Enter driver dob" id="driver_dob8" name="driver_dob8">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="driver_license8" class="form-label">Driver License8 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver license" id="driver_license8" name="driver_license8">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="driver_license_state8" class="form-label">Driver License State8 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver license state" id="driver_license_state8" name="driver_license_state8">
        </div>
    </div>
</div>

<!-- Driver Unit 9 -->
<div class="row unit9" id="driver99">
    <div class="col-6">
        <div class="mb-3">
            <label for="driver_name9" class="form-label">Driver Name9 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver name" id="driver_name9" name="driver_name9">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="driver_dob9" class="form-label">Driver DOB9 <span class="text-danger">*</span></label>
            <input type="date" class="form-control" placeholder="Enter driver dob" id="driver_dob9" name="driver_dob9">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="driver_license9" class="form-label">Driver License9 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver license" id="driver_license9" name="driver_license9">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="driver_license_state9" class="form-label">Driver License State9 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver license state" id="driver_license_state9" name="driver_license_state9">
        </div>
    </div>
</div>

<!-- Driver Unit 10 -->
<div class="row unit10" id="driver101">
    <div class="col-6">
        <div class="mb-3">
            <label for="driver_name10" class="form-label">Driver Name10 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver name" id="driver_name10" name="driver_name10">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="driver_dob10" class="form-label">Driver DOB10 <span class="text-danger">*</span></label>
            <input type="date" class="form-control" placeholder="Enter driver dob" id="driver_dob10" name="driver_dob10">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="driver_license10" class="form-label">Driver License10 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver license" id="driver_license10" name="driver_license10">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="driver_license_state10" class="form-label">Driver License State10 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Enter driver license state" id="driver_license_state10" name="driver_license_state10">
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
                                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"
                                                style="cursor:pointer;">
                                                <div class="progress-bar bg-info" role="progressbar" style="width:100%"
                                                    ;="" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                                                    id="progress-bar">
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-check-label">
                                                <input type="checkbox" name="redmark" id="coverwell" value="2" class="form-check-input" onclick="toggleCheckbox('coverwell')">
                                                Good Form
                                            </label>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-check-label">
                                                <input type="checkbox" name="redmark" id="redmark" value="1" class="form-check-input" onclick="toggleCheckbox('redmark')">
                                                Bad Form
                                            </label>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-check-label">
                                                <input type="checkbox" name="redmark" id="duplicate" value="3" class="form-check-input" onclick="toggleCheckbox('duplicate')">
                                                Duplicate Form
                                            </label>
                                        </div>
                                    </div><!--end col-->
                                    
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
                                    <div class="col-12" >
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
                                    <div class="col-12">
                                        <h4>Policy</h4>
                                        </div>
                                    <div class="col-6">
                                       
                                        <div class="mb-3">
                                            <label for="Liability" class="form-label">Liability limit</label>
                                            <select id="Liability"class="form-control" name="Liability"
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
                                            <select id="MTC" class="form-control" name="MTC"
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
                                            <select id="interchange" class="form-control" name="interchange"
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
                                    <h5>Documents/Files</h5>
                                    </div>
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
                                    <input type="hidden" name="verify_level" value="3">
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

            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.dCnf').click(function(e) {
                    e.preventDefault();
                    var mydata = $(this).attr('mydata');
                    $('#cnfbox' + mydata).show();
                });

                $('.cans').click(function(e) {
                    e.preventDefault();
                    var mydata = $(this).attr('mydatas');
                    $('#cnfbox' + mydata).hide();
                });
            });
        </script>
        <script>
            document.getElementById('selectAllCheckbox').addEventListener('change', function() {
                var checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = this.checked;
                }, this);
            });
        </script>
        <script>
            document.querySelectorAll('.data-checkbox').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    var forwardButton = document.getElementById('forwardButton');
                    var deleteButton = document.getElementById('delete_selected');
                    var submitButton = document.getElementById('submit_selected');
        
                    if (document.querySelector('.data-checkbox:checked')) {
                        forwardButton.removeAttribute('style');
                        deleteButton.removeAttribute('style');
                        submitButton.removeAttribute('style');
                    } else {
                        forwardButton.style.display = 'none';
                        deleteButton.style.display = 'none';
                        submitButton.style.display = 'none';
                    }
                });
            });
        </script>
        <script>
            document.getElementById('selectAllCheckbox').addEventListener('change', function() {
                var checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = this.checked;
                }, this);
                updateLeadIds(); // Call the function after selecting all checkboxes
            });

            function updateLeadIds() {
                var selectedIds = [];
                var checkboxes = document.querySelectorAll('tbody input[type="checkbox"]:checked');
                checkboxes.forEach(function(checkbox) {
                    selectedIds.push(checkbox.value);
                });
                var hiddenInput = document.querySelector('input[name="leadid[]"]');
                var hiddenInput1 = document.querySelector('input[name="leadids[]"]');
                var hiddenInput2 = document.querySelector('input[name="leadidss[]"]');
                hiddenInput.value = selectedIds.join(','); // Join selected IDs with a comma
                hiddenInput1.value = selectedIds.join(','); // Join selected IDs with a comma
                hiddenInput2.value = selectedIds.join(','); // Join selected IDs with a comma
            }
        </script>
    </div>
    </div>
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
var vin2 = td.data('vin2');
modal.find('#vin2').val(vin2);
if (!vin2) {
    $('#unit22').hide();
} else {
    $('#unit22').show();
}

// Check and toggle visibility for unit 3
var vin3 = td.data('vin3');
modal.find('#vin3').val(vin3);
if (!vin3) {
    $('#unit33').hide();
} else {
    $('#unit33').show();
}

// Check and toggle visibility for unit 4
var vin4 = td.data('vin4');
modal.find('#vin4').val(vin4);
if (!vin4) {
    $('#unit44').hide();
} else {
    $('#unit44').show();
}

// Check and toggle visibility for unit 5
var vin5 = td.data('vin5');
modal.find('#vin5').val(vin5);
if (!vin5) {
    $('#unit55').hide();
} else {
    $('#unit55').show();
}

// Check and toggle visibility for unit 6
var vin6 = td.data('vin6');
modal.find('#vin6').val(vin6);
if (!vin6) {
    $('#unit66').hide();
} else {
    $('#unit66').show();
}

// Check and toggle visibility for unit 7
var vin7 = td.data('vin7');
modal.find('#vin7').val(vin7);
if (!vin7) {
    $('#unit77').hide();
} else {
    $('#unit77').show();
}

// Check and toggle visibility for unit 8
var vin8 = td.data('vin8');
modal.find('#vin8').val(vin8);
if (!vin8) {
    $('#unit88').hide();
} else {
    $('#unit88').show();
}

// Check and toggle visibility for unit 9
var vin9 = td.data('vin9');
modal.find('#vin9').val(vin9);
if (!vin9) {
    $('#unit99').hide();
} else {
    $('#unit99').show();
}

// Check and toggle visibility for unit 10
var vin10 = td.data('vin10');
modal.find('#vin10').val(vin10);
if (!vin10) {
    $('#unit101').hide();
} else {
    $('#unit101').show();
}

// Check and toggle visibility for Driver Unit 2
var driver_name2 = td.data('driver_name2');
modal.find('#driver_name2').val(driver_name2);
if (!driver_name2) {
    $('#driver22').hide();
} else {
    $('#driver22').show();
}

// Check and toggle visibility for Driver Unit 3
var driver_name3 = td.data('driver_name3');
modal.find('#driver_name3').val(driver_name3);
if (!driver_name3) {
    $('#driver33').hide();
} else {
    $('#driver33').show();
}

// Check and toggle visibility for Driver Unit 4
var driver_name4 = td.data('driver_name4');
modal.find('#driver_name4').val(driver_name4);
if (!driver_name4) {
    $('#driver44').hide();
} else {
    $('#driver44').show();
}

// Check and toggle visibility for Driver Unit 5
var driver_name5 = td.data('driver_name5');
modal.find('#driver_name5').val(driver_name5);
if (!driver_name5) {
    $('#driver55').hide();
} else {
    $('#driver55').show();
}

// Check and toggle visibility for Driver Unit 6
var driver_name6 = td.data('driver_name6');
modal.find('#driver_name6').val(driver_name6);
if (!driver_name6) {
    $('#driver66').hide();
} else {
    $('#driver66').show();
}

// Check and toggle visibility for Driver Unit 7
var driver_name7 = td.data('driver_name7');
modal.find('#driver_name7').val(driver_name7);
if (!driver_name7) {
    $('#driver77').hide();
} else {
    $('#driver77').show();
}

// Check and toggle visibility for Driver Unit 8
var driver_name8 = td.data('driver_name8');
modal.find('#driver_name8').val(driver_name8);
if (!driver_name8) {
    $('#driver88').hide();
} else {
    $('#driver88').show();
}

// Check and toggle visibility for Driver Unit 9
var driver_name9 = td.data('driver_name9');
modal.find('#driver_name9').val(driver_name9);
if (!driver_name9) {
    $('#driver99').hide();
} else {
    $('#driver99').show();
}

// Check and toggle visibility for Driver Unit 10
var driver_name10 = td.data('driver_name10');
modal.find('#driver_name10').val(driver_name10);
if (!driver_name10) {
    $('#driver101').hide();
} else {
    $('#driver101').show();
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

                $('#redmark').prop('checked', td.data('redmark') == 1);
                $('#coverwell').prop('checked', td.data('redmark') == 2);
                
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
      // Function to allow only one checkbox to be selected at a time
function toggleCheckbox(currentCheckboxId) {
    const checkboxes = document.getElementsByName('redmark');

    checkboxes.forEach((checkbox) => {
        if (checkbox.id !== currentCheckboxId) {
            checkbox.checked = false;
        }
    });
}

    </script>
    <script>
        function confirmSubmit() {
            return confirm("Are you sure you want to submit the form?");
        }
        </script>
@endsection
