@extends('Agent.common.app')
@section('main')
    <link href="{{ asset('Agent/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <style>
        .red-row {
            background-color: #FFA500 !important;
        }
        .violet-row {
            background-color: #ff0000 !important;
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
                            <li class="breadcrumb-item active" aria-current="page">{{$title}} data</li>
                        </ol>
                    </nav>
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
                                <tr>
                                    @if($title !== 'Bind')
                                    <!-- <th scope="col">History</th> -->
                                    @endif
                                    <th scope="col">#</th>
                                    <th scope="col">Company Name</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Company Rep1</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($datas))
                                    @php $a = 0; @endphp
                                    @foreach ($datas as $data)
                                        @php $a++; @endphp
                                        <tr>
                                            @if($title !== 'Bind')
                                           <!-- <th style="cursor: pointer;">
    <span 
        style="background-color: green;color:white;padding:10px"
        onclick="event.stopPropagation();"
    >View</span>
</th> -->

                                            @endif
                                            <th scope="row" class="<?php 
                                            if (!empty($data->red_mark)) {
                                                echo $data->red_mark == 1 ? 'red-row' : ($data->red_mark == 3 ? 'violet-row' : '');
                                            }
                                        ?>">                                               
                                                {{ $a }}</th>
                                            <td class="<?php 
                                            if (!empty($data->red_mark)) {
                                                echo $data->red_mark == 1 ? 'red-row' : ($data->red_mark == 3 ? 'violet-row' : '');
                                            }
                                        ?>">
                                                {{ $data->company_name }} @if(!empty($data->mail_status))
                                                @if($data->mail_status == 'Mail')
                                                <i class="lni lni-envelope" style="pedding:5px;color:crimson"></i>
                                                @elseif($data->mail_status == 2)
                                                <i class="lni lni-envelope" style="pedding:5px;color:crimson"></i>
                                                <i class="lni lni-bubble"  style="pedding:5px;color:crimson"></i>
                                                @else
                                                <i class="lni lni-bubble"  style="pedding:5px;color:crimson"></i>
                                                @endif
                                                @endif
                                            </td>
                                            <td class="phone_copy" onclick="copyPhoneNumber()" style="<?php 
                                            if (!empty($data->red_mark)) {
                                                echo $data->red_mark == 1 ? 'background-color: #FFA500 !important;' : ($data->red_mark == 3 ? 'background-color: #ff0000 !important;' : '');
                                            }
                                        ?>">{{ $data->phone }}<br><span
                                                    class="copy-indicator"
                                                    style="display:none;padding:5px;background-color:rgb(172, 169, 169);margin-top:5px;">copied!</span>
                                            </td>
                                            @php
                                                $unit = App\Models\unitOwned::where('data_id',$data->id)->first();
                                            @endphp
                                            <td class="<?php 
                                            if (!empty($data->red_mark)) {
                                                echo $data->red_mark == 1 ? 'red-row' : ($data->red_mark == 3 ? 'violet-row' : '');
                                            }
                                        ?>" data-bs-toggle="modal" data-company-name="{{ $data->company_name }}"
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
                                                @if(!empty($unit))
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
                                               @endif


                                                data-bs-target="#exampleFullScreenModal">
                                                {{ $data->company_rep1 }} </td>
                                            @if ($data->form_status == 'NEW')
                                                <td class="<?php 
                                            if (!empty($data->red_mark)) {
                                                echo $data->red_mark == 1 ? 'red-row' : ($data->red_mark == 3 ? 'violet-row' : '');
                                            }
                                        ?>">
                                                    <div class="ms-auto">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-success"
                                                                data-bs-toggle="dropdown"style="background-color:#119711;color:white; padding: 2px 15px;border: none;">NEW</button>
                                                            </button>
                                                            <div
                                                                class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="Voice Mail">Voice Mail</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="Not Intrested">Not
                                                                    Interested</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="Not Connected">Not
                                                                    Connected</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="Wrong Number">Wrong
                                                                    Number</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="WON">WON</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="DND">DND</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            @elseif($data->form_status == 'Voice Mail')
                                                <td>
                                                    <div class="ms-auto">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-success"
                                                                data-bs-toggle="dropdown"style="background-color:#742dc1;color:white; padding: 2px 15px;border: none;">Voice
                                                                Mail</button> </button>
                                                            <div
                                                                class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="NEW">New</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="Not Intrested">Not
                                                                    Interested</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="Not Connected">Not
                                                                    Connected</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="Wrong Number">Wrong
                                                                    Number</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="WON">WON</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="DND">DND</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            @elseif($data->form_status == 'Not Intrested' || $data->form_status == 'Wrong Number' || $data->form_status == 'DND')
                                                <td>
                                                    <div class="ms-auto">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-success"
                                                                data-bs-toggle="dropdown"style="background-color:#d91c1c;color:white; padding: 2px 15px;border: none;">{{ $data->form_status }}</button>
                                                            </button>
                                                            <div
                                                                class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="NEW">New</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="Voice Mail">Voice Mail</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="Not Intrested">Not
                                                                    Interested</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="Not Connected">Not
                                                                    Connected</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="Wrong Number">Wrong
                                                                    Number</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="WON">WON</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="DND">DND</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            @elseif($data->form_status == 'Not Connected')
                                                <td>
                                                    <div class="ms-auto">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-success"
                                                                data-bs-toggle="dropdown"style="background-color:#e6ca00;color:white; padding: 2px 15px;border: none;">Not
                                                                Connected</button> </button>
                                                            <div
                                                                class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="NEW">New</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="Voice Mail">Voice Mail</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="Not Intrested">Not
                                                                    Interested</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="Wrong Number">Wrong
                                                                    Number</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="WON">WON</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="DND">DND</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            @else
                                                <td class="<?php 
                                            if (!empty($data->red_mark)) {
                                                echo $data->red_mark == 1 ? 'red-row' : ($data->red_mark == 3 ? 'violet-row' : '');
                                            }
                                        ?>">
                                                    <div class="ms-auto">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-success"
                                                                data-bs-toggle="dropdown"style="background-color:#00ff72;color:white; padding: 2px 15px;border: none;">{{ $data->form_status }}</button>
                                                            </button>
                                                              @if( $data->form_status !== 'Intrested')
                                                            <div
                                                                class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="NEW">New</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="Voice Mail">Voice Mail</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="Not Intrested">Not
                                                                    Interested</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="Not Connected">Not
                                                                    Connected</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="Wrong Number">Wrong
                                                                    Number</a>
                                                                <a class="dropdown-item update-status"
                                                                    href="#"data-lead-id="{{ $data->id }}"
                                                                    data-status="DND">DND</a>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                            <td class="<?php 
                                            if (!empty($data->red_mark)) {
                                                echo $data->red_mark == 1 ? 'red-row' : ($data->red_mark == 3 ? 'violet-row' : '');
                                            }
                                        ?>">{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-y') }}</td>
                                            <td class="<?php 
                                            if (!empty($data->red_mark)) {
                                                echo $data->red_mark == 1 ? 'red-row' : ($data->red_mark == 3 ? 'violet-row' : '');
                                            }
                                        ?>">
                                                <div class="btn-group" id="btns<?php echo $a; ?>">
                                                    <a href="tel:{{ $data->phone }}" data-toggle="tooltip"
                                                        data-placement="top" title="Call">
                                                        <i class="lni lni-phone"
                                                            style="font-size:20px;margin-left:10px"></i>
                                                    </a>
                                                </div>
                                                @if (!empty($data->email))
                                                <div class="btn-group">
                                                    <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $data->email }}" class="btn-mail" data-lead-id="{{ $data->id }}" target="_blank"><i class="lni lni-envelope"
                                                        style="font-size:20px;margin-left:10px"></i></a>
                                                </div>
                                                @endif
                                                <div class="btn-group">
                                                    <a href="#" class="btn-message" data-lead-id="{{ $data->id }}"><i class="lni lni-bubble"
                                                        style="font-size:20px;margin-left:10px"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    @if($title !== 'Bind')
                                    <!-- <th scope="col">History</th> -->
                                    @endif
                                    <th scope="col">#</th>
                                    <th scope="col">Company Name</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Company Rep1</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
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
                                                id="business_zip" name="business_zip">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">DOT <span
                                                    class="text-danger">*</span></label>
                                           <input type="number" 
       class="form-control" 
       placeholder="Enter DOT"
       id="dot" 
       name="dot" 
       required>

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
                                            <label for="owner_dob" class="form-label">Owner DOB <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control"
                                                placeholder="Enter driver dob" id="owner_dob"
                                                name="owner_dob">
                                        </div>
                                    </div>
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
    <div class="mb-3">
        <label class="form-label">Mode On</label>

        <select name="mail_status" class="form-select" disabled>
            <option value="Call"
                {{ ($data->mail_status ?? '') === 'Call' ? 'selected' : '' }}>
                Call
            </option>

            <option value="Email"
                {{ ($data->mail_status ?? '') === 'Email' ? 'selected' : '' }}>
                Email
            </option>
        </select>

        <!-- disabled select submit nahi hota -->
        <input type="hidden" name="mail_status" value="{{ $data->mail_status }}">
    </div>
</div>
<!--end col-->
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

                modal.find('#comment').val(td.data('comment'));
                modal.find('#MTC').val(td.data('mtc'));
                modal.find('#Liability').val(td.data('liability'));
                modal.find('#interchange').val(td.data('interchange'));
               // Set the checkbox states
            $('#coverwell').prop('checked', !!td.data('is_cover_well'));
            $('#redmark').prop('checked', !!td.data('redmark'));
            $('#physicall').prop('checked', td.data('physical') == 1);
            $('#generall').prop('checked', td.data('general') == 1);

console.log(td.data());
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
                if (input.id !== "vehicle_year5" && input.id !== "vehicle_make5" && input.id !== "stated_value5" && input.id !== "vehicle_year2" && input.id !== "vehicle_make2" && input.id !== "stated_value2" && input.id !== "vehicle_year3" && input.id !== "vehicle_make3" && input.id !== "stated_value3" && input.id !== "vehicle_year4" && input.id !== "vehicle_make4" && input.id !== "stated_value4") {
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

        // Toggle required attribute based on display status
        toggleRequiredBasedOnDisplay("unit22", document.getElementById("unit22").style.display !== "none");
        toggleRequiredBasedOnDisplay("unit33", document.getElementById("unit33").style.display !== "none");
        toggleRequiredBasedOnDisplay("unit44", document.getElementById("unit44").style.display !== "none");
        toggleRequiredBasedOnDisplay("unit55", document.getElementById("unit55").style.display !== "none");
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
                if (input.id !== "vehicle_year5" && input.id !== "vehicle_make5" && input.id !== "stated_value5" && input.id !== "vehicle_year2" && input.id !== "vehicle_make2" && input.id !== "stated_value2" && input.id !== "vehicle_year3" && input.id !== "vehicle_make3" && input.id !== "stated_value3" && input.id !== "vehicle_year4" && input.id !== "vehicle_make4" && input.id !== "stated_value4") {
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

        // Toggle required attribute based on display status
        toggleRequiredBasedOnDisplay("driver22", document.getElementById("driver22").style.display !== "none");
        toggleRequiredBasedOnDisplay("driver33", document.getElementById("driver33").style.display !== "none");
        toggleRequiredBasedOnDisplay("driver44", document.getElementById("driver44").style.display !== "none");
        toggleRequiredBasedOnDisplay("driver55", document.getElementById("driver55").style.display !== "none");
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


@endsection
