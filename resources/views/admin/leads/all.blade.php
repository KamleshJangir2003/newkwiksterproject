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
            .modal-dialog {
    max-width: 650px; /* default for all screen sizes */
    margin: 30px auto;
}

@media (min-width: 576px) {
    .modal-dialog {
        /* Optional override if you want a different value above 576px */
        max-width: 650px; /* or change this if needed */
    }
}
        /* CSS */
        .search-box {
            position: relative;
        }

        .state-input {
            background-color: white;
            cursor: pointer;
        }

        .search-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #6c757d;
        }

        .states-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 10px;
            padding: 10px;
        }

        .state-option {
            padding: 8px 12px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .state-option:hover {
            background-color: #f8f9fa;
        }

        .state-option.selected {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }

        .selected-states-preview {
            margin-top: 10px;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .modal-body {
            max-height: 70vh;
            overflow-y: auto;
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
                                <h4>All Leads</h4>
                                <div class="card" id="leadsList">
                                    <div class="card-header border-0">
                                        <form method="get">
                                            <div class="row g-4 align-items-center">
                                                <div class="col-sm-2">
                                                    <div class="search-box">
                                                        <input type="text" name="search_input"
                                                            class="form-control search" placeholder="Search for..."
                                                            value="{{ isset($_GET['search_input']) ? $_GET['search_input'] : '' }}">
                                                        <i class="ri-search-line search-icon"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="search-box">
                                                        <input type="text" name="row_pegi" class="form-control search"
                                                            placeholder="Select rows"
                                                            value="{{ isset($_GET['row_pegi']) ? $_GET['row_pegi'] : '' }}">
                                                        <i class="ri-search-line search-icon"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="search-box">
                                                        <input type="text" class="form-control state-input"
                                                            placeholder="Select states..." readonly
                                                            onclick="openStatesModal()">
                                                        <i class="ri-search-line search-icon"></i>
                                                        <input type="hidden" name="state[]" id="selectedStates">
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="statesModal" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Select States</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="states-container">
                                                                    <!-- States will be populated here by JavaScript -->
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-primary"
                                                                    onclick="applyStateSelection()">Apply</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="search-box">
                                                        <input type="date" name="date1" class="form-control search"
                                                            placeholder="Search for..."
                                                            value="{{ isset($_GET['date1']) ? $_GET['date1'] : '' }}">
                                                        <i class="ri-search-line search-icon"></i>
                                                    </div>
                                                </div>
                                                <p style="margin-bottom:0px">To</p>
                                                <div class="col-sm-2">
                                                    <div class="search-box">
                                                        <input type="date" name="date2" class="form-control search"
                                                            placeholder="Search for..."
                                                            value="{{ isset($_GET['date2']) ? $_GET['date2'] : '' }}">
                                                        <i class="ri-search-line search-icon"></i>
                                                    </div>
                                                </div>
                                                <button type="submit" class=" btn-success" style="margin-right:5px"><i
                                                        class="ti-search"></i></button>
                                                @php
                                                    $id = request()->route('id'); // or decode manually if needed
                                                    $batch = request()->route('batch');
                                                @endphp

                                                <button type="button" class="btn-danger"
                                                    onclick="window.location.href='{{ route('all_tab_view_data', ['id' => $id, 'batch' => $batch]) }}'">
                                                    <i class="fa-solid fa-circle-xmark"></i> clear
                                                </button>

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
                                                <button type="button" class="btn btn-success add-btn" id="create-btn"
                                                    data-toggle="modal" data-target="#import_leads"><i
                                                        class="ri-add-line align-bottom me-1"></i> Import
                                                    Leads</button>
                                                <button type="button" class="btn btn-dark add-btn" id="create-btn"
                                                    data-toggle="modal"><i class="ri-add-line align-bottom me-1"></i>
                                                    Total :- {{ $total }}
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
                                                                    @php
                                                                        $alise = App\adminmodel\Users_detailsModal::where(
                                                                            'ajent_id',
                                                                            $agent->id,
                                                                        )
                                                                            ->select('alise_name')
                                                                            ->first();

                                                                    @endphp

                                                                    <div class="col-sm-6">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <input type="radio"
                                                                                    aria-label="Radio button for following text input"
                                                                                    name="agent_id"
                                                                                    value="{{ $agent->id }}">
                                                                                <label class="form-check-label"
                                                                                    for="inlineCheckbox1"
                                                                                    style="padding:1px">{{ $agent->name }}({{ $alise->alise_name ?? 'Unknown' }})</label>
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
                                                        <p style="padding:5px;border:1px black solid">DOT | MC_DOCKET |
                                                            COMPANY_NAME | CUSTOMER_REP | PHONE_NUMBER | ADDRESS | CITY |
                                                            STATE | ZIP_CODE | EMAIL </p>
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
                                                        <th scope="col">Company Name</th>
                                                        <th scope="col">Phone</th>
                                                        <th scope="col">Company Rep1</th>
                                                        <th scope="col">Business Address</th>
                                                        <th scope="col">Business City</th>
                                                        <th scope="col">Business State</th>
                                                        <th scope="col">Business Zip</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Created Date</th>
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
                                                                <th scope="row">{{ $a }}</th>
                                                                <td>{{ $data->company_name }}</td>
                                                                <td>{{ $data->phone }}</td>
                                                                <td>{{ $data->company_rep1 }}</td>
                                                                <td>{{ $data->business_address }}</td>
                                                                <td>{{ $data->business_city }}</td>
                                                                <td>{{ $data->business_state }}</td>
                                                                <td>{{ $data->business_zip }}</td>

                                                                @if ($data->form_status == 'NEW')
                                                                    <td>
                                                                        <button class="custom-button"
                                                                            id="dropdownMenuButton" data-toggle="dropdown"
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
                                                                            id="dropdownMenuButton" data-toggle="dropdown"
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
                                                                            id="dropdownMenuButton" data-toggle="dropdown"
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
                                                                            id="dropdownMenuButton" data-toggle="dropdown"
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
                                                                            id="dropdownMenuButton" data-toggle="dropdown"
                                                                            aria-haspopup="true" aria-expanded="false"
                                                                            style="background-color:#00ff72;color:white; padding: 2px 15px;border: none;">
                                                                            <i class='bx bxs-circle me-1'></i>WON
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
                                                                                href="{{ route('update_lead_status', [base64_encode($data->id), base64_encode('DND')]) }}">DND</a>
                                                                        </div>
                                                                    </td>
                                                                @endif
                                                                <td>{{ $data->created_at }}</td>
                                                                <td>
                                                                    <div class="btn-group" id="btns<?php echo $a; ?>">
                                                                        <a href="tel:{{ $data->phone }}"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            title="Call">
                                                                            <i class="ti-headphone-alt"
                                                                                style="font-size:20px;margin-right:10px"></i>
                                                                        </a>
                                                                    </div>
                                                                    <div class="btn-group" id="btns<?php echo $a; ?>">
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
                                                            <td colspan="12"
                                                                style="text-align: center; vertical-align: middle;">
                                                                <!-- Content to be centered -->
                                                                <div style="display: inline-block;">
                                                                    <!-- Ensure inline-block display -->
                                                                    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                                                                    <lottie-player
                                                                        src="https://lottie.host/461c3ab8-f91d-4dd3-9695-9f8c28b25030/TU3aEfjPmx.json"
                                                                        background="#FFFFFF" speed="1"
                                                                        style="width: 100px; height: 100px; display: block; margin: 0 auto;"
                                                                        loop autoplay direction="1"
                                                                        mode="normal"></lottie-player>
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
                var forwardButton = document.getElementById('forwardButton', 'delete_selected');
                if (document.querySelector('.data-checkbox:checked')) {
                    forwardButton.removeAttribute('style');
                    delete_selected.removeAttribute('style');
                } else {
                    forwardButton.style.display = 'none';
                    delete_selected.style.display = 'none';
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
            hiddenInput.value = selectedIds.join(','); // Join selected IDs with a comma
            hiddenInput1.value = selectedIds.join(','); // Join selected IDs with a comma
        }
    </script>
    <script>
        // JavaScript
       const states = [
    { code: 'AL', name: 'Alabama' },
    { code: 'AK', name: 'Alaska' },
    { code: 'AZ', name: 'Arizona' },
    { code: 'AR', name: 'Arkansas' },
    { code: 'CA', name: 'California' },
    { code: 'CO', name: 'Colorado' },
    { code: 'CT', name: 'Connecticut' },
    { code: 'DE', name: 'Delaware' },
    { code: 'FL', name: 'Florida' },
    { code: 'GA', name: 'Georgia' },
    { code: 'HI', name: 'Hawaii' },
    { code: 'ID', name: 'Idaho' },
    { code: 'IL', name: 'Illinois' },
    { code: 'IN', name: 'Indiana' },
    { code: 'IA', name: 'Iowa' },
    { code: 'KS', name: 'Kansas' },
    { code: 'KY', name: 'Kentucky' },
    { code: 'LA', name: 'Louisiana' },
    { code: 'ME', name: 'Maine' },
    { code: 'MD', name: 'Maryland' },
    { code: 'MA', name: 'Massachusetts' },
    { code: 'MI', name: 'Michigan' },
    { code: 'MN', name: 'Minnesota' },
    { code: 'MS', name: 'Mississippi' },
    { code: 'MO', name: 'Missouri' },
    { code: 'MT', name: 'Montana' },
    { code: 'NE', name: 'Nebraska' },
    { code: 'NV', name: 'Nevada' },
    { code: 'NH', name: 'New Hampshire' },
    { code: 'NJ', name: 'New Jersey' },
    { code: 'NM', name: 'New Mexico' },
    { code: 'NY', name: 'New York' },
    { code: 'NC', name: 'North Carolina' },
    { code: 'ND', name: 'North Dakota' },
    { code: 'OH', name: 'Ohio' },
    { code: 'OK', name: 'Oklahoma' },
    { code: 'OR', name: 'Oregon' },
    { code: 'PA', name: 'Pennsylvania' },
    { code: 'RI', name: 'Rhode Island' },
    { code: 'SC', name: 'South Carolina' },
    { code: 'SD', name: 'South Dakota' },
    { code: 'TN', name: 'Tennessee' },
    { code: 'TX', name: 'Texas' },
    { code: 'UT', name: 'Utah' },
    { code: 'VT', name: 'Vermont' },
    { code: 'VA', name: 'Virginia' },
    { code: 'WA', name: 'Washington' },
    { code: 'WV', name: 'West Virginia' },
    { code: 'WI', name: 'Wisconsin' },
    { code: 'WY', name: 'Wyoming' }
];


        let selectedStates = [];

        function openStatesModal() {
            // Initialize with previously selected states
            const stateInput = document.getElementById('selectedStates');
            selectedStates = stateInput.value ? stateInput.value.split(',') : [];

            // Populate modal with states
            const container = document.querySelector('.states-container');
            container.innerHTML = '';

            states.forEach(state => {
                const isSelected = selectedStates.includes(state.code);
                const stateElement = document.createElement('div');
                stateElement.className = `state-option ${isSelected ? 'selected' : ''}`;
                stateElement.innerHTML = `
      <div>${state.name}</div>
      <small>${state.code}</small>
    `;
                stateElement.dataset.code = state.code;
                stateElement.onclick = () => toggleStateSelection(state.code, stateElement);
                container.appendChild(stateElement);
            });

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('statesModal'));
            modal.show();
        }

        function toggleStateSelection(stateCode, element) {
            const index = selectedStates.indexOf(stateCode);

            if (index === -1) {
                selectedStates.push(stateCode);
                element.classList.add('selected');
            } else {
                selectedStates.splice(index, 1);
                element.classList.remove('selected');
            }
        }

        function applyStateSelection() {
            // Update hidden input
            document.getElementById('selectedStates').value = selectedStates.join(',');

            // Update visible input
            const stateNames = states
                .filter(state => selectedStates.includes(state.code))
                .map(state => state.name);

            document.querySelector('.state-input').value = stateNames.join(', ') || 'Select states...';

            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('statesModal'));
            modal.hide();
        }
    </script>

    </div>
    </div>
@endsection
