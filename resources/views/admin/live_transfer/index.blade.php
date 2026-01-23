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
                                            <button type="button"  class=" btn-danger" onclick="window.location.href='{{route('live_transfer')}}'"><i class="fa-solid fa-circle-xmark"></i>clear</button>
                                               
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
                                                        <button type="button" class="btn btn-success add-btn" id="download-btn"   
    onclick="window.location.href='{{ route('instersted_download', [
        'search_input' => request()->get('search_input', ''), 
        'row_pegi' => request()->get('row_pegi', '2'), 
        'state' => request()->get('state', ''), 
        'date1' => request()->get('date1', ''), 
        'date2' => request()->get('date2', '')
    ]) }}'">
    Excel
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
                                                                        data-file5="{{ $data->file5 }}" data-file6="{{ $data->file6 }}" data-error_file="{{ $data->error_file }}"
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
                                                                         data-redmark="{{ $data->red_mark }}"
                                                                         data-mail_status="{{ $data->mail_status }}"
                                                                        data-loss-runs="{{ $data->loss_runs }}"

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
                                <form action="{{ route('intrested_check') }}" method="POST" enctype="multipart/form-data">
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
                                                
                                                <!-- Vehicle & Driver Information -->
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label for="ForminputState" class="form-label">Unit Owned <span
                                                                class="text-danger">*</span></label>
                                                        <select id="unit_owned2" class="form-control" name="unit_owned">
                                                            <option value="1" selected>1</option>
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
                                                        <input type="date" class="form-control" placeholder="mm/dd/yyyy"
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
                                                        <label for="citynameInput" class="form-label">Driver License State <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" placeholder="Enter driver license state"
                                                            id="driver_license_state" name="driver_license_state">
                                                    </div>
                                                </div><!--end col-->
                                                
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Vehicle Year</label>
                                                        <input type="number" class="form-control" placeholder="YYYY"
                                                            id="vehicle_year" name="vehicle_year">
                                                    </div>
                                                </div><!--end col-->
                                                
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Vehicle Make</label>
                                                        <input type="text" class="form-control" placeholder="Enter Vehicle make..."
                                                            id="vehicle_make" name="vehicle_make">
                                                    </div>
                                                </div><!--end col-->
                                                
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Stated Value</label>
                                                        <input type="text" class="form-control" placeholder="Enter stated value"
                                                            id="stated_value" name="stated_value">
                                                    </div>
                                                </div><!--end col-->
                                                
                                                <!-- Live Transfer Option -->
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Live Transfer <span class="text-danger">*</span></label>
                                                        <div class="d-flex gap-3">
                                                            <label class="live-transfer-option">
                                                                <input type="radio" name="live_transfer" value="yes" class="live-transfer-radio">
                                                                <span class="custom-checkbox"></span>
                                                                Yes
                                                            </label>
                                                            <label class="live-transfer-option">
                                                                <input type="radio" name="live_transfer" value="no" class="live-transfer-radio">
                                                                <span class="custom-checkbox"></span>
                                                                No
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div><!--end col-->

<style>
.live-transfer-option {
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    font-size: 14px;
}

.live-transfer-option input[type="radio"] {
    display: none;
}

.live-transfer-option .custom-checkbox {
    width: 22px;
    height: 22px;
    border: 2px solid #bfbfbf;
    border-radius: 4px;
    position: relative;
}

.live-transfer-option input[type="radio"]:checked + .custom-checkbox {
    background: #16a34a;
    border-color: #16a34a;
}

.live-transfer-option input[type="radio"]:checked + .custom-checkbox::after {
    content: "✓";
    color: #fff;
    font-size: 16px;
    font-weight: bold;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -55%);
}
</style>

<script>
$(document).on('change', '.live-transfer-radio', function() {
    let leadId = $('#data_id').val();
    let liveTransferValue = $(this).val();
    
    if (leadId) {
        $.ajax({
            url: '{{ route("update_live_transfer") }}',
            method: 'POST',
            data: {
                lead_id: leadId,
                live_transfer: liveTransferValue,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log('Live transfer updated successfully');
            },
            error: function(xhr, status, error) {
                console.error('Error updating live transfer:', error);
            }
        });
    }
});
</script>
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
                                                    <div class="pt-0">
                                           <label id="model-form-status" class="form-label">Form on</label>

<div class="d-flex gap-3 lock-contact-mode">

    <label class="call-mail-option">
        <input type="radio"
               name="contact_mode"
               value="Call"
               id="callCheck">
        <span class="custom-checkbox"></span>
         Call
    </label>

    <label class="call-mail-option">
        <input type="radio"
               name="contact_mode"
               value="Email"
               id="emailCheck">
        <span class="custom-checkbox"></span>
         Email
    </label>

</div>
<style>
    .call-mail-option {
    display: flex;
    align-items: center;
   
    cursor: pointer;
    font-size: 14px;
}

/* hide default radio */
.call-mail-option input[type="radio"] {
    display: none;
}

/* custom checkbox */
.custom-checkbox {
    width: 22px;              /* size */
    height: 22px;
    border: 2px solid #bfbfbf;
    border-radius: 4px;
    display: inline-block;
    position: relative;
    transition: all 0.2s ease;
}

/* checked state */
.call-mail-option input[type="radio"]:checked + .custom-checkbox {
    background: #16a34a;
    border-color: #16a34a;
}

/* check mark */
.call-mail-option input[type="radio"]:checked + .custom-checkbox::after {
    content: "✓";
    color: #fff;
    font-size: 16px;
    font-weight: bold;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -55%);
}

/* admin read-only */
.lock-contact-mode {
    pointer-events: none;
    opacity: 0.95;
}

</style>

<style>
    .lock-contact-mode {
    pointer-events: none !important;
}

.lock-contact-mode label {
    cursor: not-allowed !important;
}

.lock-contact-mode input {
    pointer-events: none;
    opacity: 1;   /* tick clearly dikhe */
}
.call-mail-option input[type="radio"] {
    transform: scale(1.4);   /* size control */
    margin-right: 6px;
    cursor: pointer;
}



</style>




                                        </div>
                                                </div><!--end col-->
                                               <!-- Good / Bad Form -->
<div class="col-6">
    <div class="mb-3">
        <label class="form-check-label">
            <input type="checkbox" name="redmark" id="coverwell" value="2"
                   class="form-check-input"
                   onclick="toggleCheckbox('coverwell', 'redmark')">
            Good Form
        </label>
    </div>
</div>

<div class="col-6">
    <div class="mb-3">
        <label class="form-check-label">
            <input type="checkbox" name="redmark" id="redmark" value="1"
                   class="form-check-input"
                   onclick="toggleCheckbox('redmark', 'coverwell')">
            Bad Form
        </label>
    </div>
</div>

<!-- ✅ LOSS RUNS ADDED HERE -->
<div class="col-6">
    <div class="mb-3">
        <label class="form-label">
            Loss Runs <span class="text-danger">*</span>
        </label>

        <div class="d-flex gap-3">
<label class="loss-option">
    <input type="radio" name="loss_runs" value="yes">
    <span class="custom-checkbox"></span>
    Yes
</label>

<label class="loss-option">
    <input type="radio" name="loss_runs" value="no">
    <span class="custom-checkbox"></span>
    No
</label>




        </div>

        <!-- ✅ VALIDATION ERROR MESSAGE (YAHI SHOW HOGA) -->
        @error('loss_runs')
            <small class="text-danger d-block mt-1">
                {{ $message }}
            </small>
        @enderror
    </div>
</div>

</div>
<style>
.loss-option {
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    font-size: 14px;
}

/* hide default radio */
.loss-option input[type="radio"] {
    display: none;
}

/* box */
.loss-option .custom-checkbox {
    width: 22px;
    height: 22px;
    border: 2px solid #bfbfbf;
    border-radius: 4px;
    position: relative;
}

/* checked */
.loss-option input[type="radio"]:checked + .custom-checkbox {
    background: #dc2626;
    border-color: #dc2626;
}

/* tick */
.loss-option input[type="radio"]:checked + .custom-checkbox::after {
    content: "✓";
    color: #fff;
    font-size: 16px;
    font-weight: bold;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -55%);
}
</style>

                                                 <div class="col-12" >                                                                      <!-- Display Comments Section -->
                                                    <div class="modal-body" id="commentsBody">
                                                        <!-- Comments will be dynamically populated here -->
                                                    </div>
                                                       </div>
                                                <div class="col-12" >
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Comment </label>
                                                        <textarea id="comment" name="comment" class="form-control" rows="4" placeholder="Write a Coment...."
                                                            required=""></textarea>
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
                  // 🔥 LOSS RUNS AUTO SET
    modal.find('input[name="loss_runs"]').prop('checked', false);

   let lossRuns = td.data('lossRuns'); // camelCase


    if (lossRuns === 'yes') {
        modal.find('input[name="loss_runs"][value="yes"]').prop('checked', true);
    }

    if (lossRuns === 'no') {
        modal.find('input[name="loss_runs"][value="no"]').prop('checked', true);
    }
               
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
                
                // Vehicle & Driver Information
                modal.find('#unit_owned2').val(td.data('unit_owned'));
                modal.find('#vin').val(td.data('vin'));
                modal.find('#driver_name').val(td.data('driver_name'));
                modal.find('#driver_dob').val(td.data('driver_dob'));
                modal.find('#driver_license').val(td.data('driver_license'));
                modal.find('#driver_license_state').val(td.data('driver_license_state'));
                modal.find('#vehicle_year').val(td.data('vehicle_year'));
                modal.find('#vehicle_make').val(td.data('vehicle_make'));
                modal.find('#stated_value').val(td.data('stated_value'));

// ---- FORM ON (CALL / EMAIL) AUTO SELECT ----
modal.find('input[name="contact_mode"]').prop('checked', false);

let mode = td.data('mail_status');

if (mode) {
    mode = mode.toString().trim().toLowerCase();

    if (mode === 'call') {
        modal.find('#callCheck').prop('checked', true);
    }

    if (mode === 'email') {
        modal.find('#emailCheck').prop('checked', true);
    }
}

               // Set the checkbox states
            $('#coverwell').prop('checked', !!td.data('is_cover_well'));
            $('#redmark').prop('checked', !!td.data('redmark'));

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

            });
        });
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