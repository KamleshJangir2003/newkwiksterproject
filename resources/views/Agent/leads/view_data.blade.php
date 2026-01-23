@extends('Agent.common.app')
@section('main')
<style>
   .lead-card {
    position: relative !important;
    overflow: visible !important;
}

.lead-status-dropdown .lead-status-menu {
    position: absolute !important;
    top: 100% !important;
    left: 0 !important;
    z-index: 999999 !important;
    
    width: max-content;
    min-width: 180px;
    max-width: 220px;

    padding: 6px 0;
    background: #8a9abd;
    border-radius: 8px;

    max-height: 260px;
    overflow-y: auto;

    display: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.lead-status-dropdown .lead-status-menu.show {
    display: block;
}



</style>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link href="{{ asset('Agent/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <style>
                .slider {
                    background-color: #333;
                    color: #fff;
                    padding: 10px;
                    overflow: hidden;
                }

                .news-ticker {
                    font-size: 20px;
                }

                .black-row td {
                    background-color: rgb(5, 5, 5);
                }

                .green-row td {
                    background-color: rgb(0, 255, 68);
                    color: white;
                }
                .card-body h6 {
  font-size: 14px;
  opacity: 0.85;
}
.card-body p {
  font-size: 15px;
  margin-bottom: 6px;
}

            </style>

            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3 justify-content-between">
                <div class="breadcrumb-title pe-3">Leads </div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Leads data</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex align-items-center ms-auto">
                    <input type="number" class="form-control me-2" style="width:100px" placeholder="Start" id="startNumber"
                        min="1" />
                    <input type="number" class="form-control me-2" style="width:100px" placeholder="End" id="endNumber"
                        min="1" />
                    <button class="btn btn-primary" id="copyButton">Copy Emails</button>
                </div>
            </div>
            <!-- Hidden container to store emails -->
            <div id="emailsContainer" style="display: none;">
                @foreach ($datas as $index => $data)
                    <span class="email" data-index="{{ $index + 1 }}">{{ $data->email }}</span>
                @endforeach
            </div>

            @php
                $currentDate = Carbon\Carbon::now('America/New_York')->toDateString();
                $informations = App\adminmodel\Information::where('duration', '>=', $currentDate)
                    ->where('status', 1)
                    ->get();
            @endphp
            @foreach ($informations as $data)
                @if ($data->agent_id == null || $data->agent_id == session('agent_id'))
                    <div class="slider">
                        <marquee class="news-ticker" behavior="scroll" direction="left" scrollamount="5">
                            {{ $data->text }}
                        </marquee>
                    </div>
                    <br>
                @endif
            @endforeach

            <!--end breadcrumb-->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <!-- <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Company Name 2</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Company Rep1</th>
                                    <th scope="col">State</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead> -->
                            @php
                                $dots = $datas->pluck('dot')->filter()->unique();
                                $phones = $datas->pluck('phone')->filter()->unique();

                                $interestedChecks = App\Models\ExcelData::where('form_status', 'Intrested')
                                    ->where(function ($q) use ($dots, $phones) {
                                        $q->whereIn('dot', $dots)->orWhereIn('phone', $phones);
                                    })
                                    ->select('dot', 'phone', 'click_id')
                                    ->get();

                                // Index for quick lookup
                                $interestedByDot = $interestedChecks->groupBy('dot');
                                $interestedByPhone = $interestedChecks->groupBy('phone');

                                // Preload all user details (one query only)
                                $clickIds = $interestedChecks->pluck('click_id')->unique();
                                $userDetailsMap = App\adminmodel\Users_detailsModal::whereIn('ajent_id', $clickIds)
                                    ->select('ajent_id', 'alise_name')
                                    ->get()
                                    ->keyBy('ajent_id');
                            @endphp
                          <div class="row">
@if (!empty($datas))
  @php $a = 0; @endphp
  @foreach ($datas as $data)
    @php
      $a++;
      $allowedStates = ['AK', 'HI', 'NY', 'NJ'];
      $cardClass = '';

      if (in_array($data->business_state, $allowedStates)) {
          $cardClass = 'black-row';
      }

      $is_intrested = 0;
      $intre_agent_id = null;
      $check = null;

      if (!empty($data->dot) && $interestedByDot->has($data->dot)) {
          $check = $interestedByDot->get($data->dot)->first();
      } elseif (!empty($data->phone) && $interestedByPhone->has($data->phone)) {
          $check = $interestedByPhone->get($data->phone)->first();
      }

      if ($check && isset($userDetailsMap[$check->click_id])) {
          $intre_agent_id = $userDetailsMap[$check->click_id]->alise_name;
          $is_intrested = 1;
          $cardClass = 'green-row';
      }
    @endphp

    <div class="col-12 col-md-6 col-lg-4 d-flex mb-3">
      <div class="card w-100 border-0 shadow-sm rounded-4 {{ $cardClass }} lead-card"
           
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
           data-mail_status="{{ $data->mail_status }}"

           data-bs-target="#exampleFullScreenModal"
           style="cursor:pointer">

        <div class="card-body p-3">
          
        <div class="lead-name-row">
    <p class="mb-1 lead-name">
        <strong>Company -</strong> {{ $data->company_name }}
    </p>

    <div class="btn-group lead-status-dropdown">
        <button type="button"
            class="btn text-white lead-status-btn"
            style="
            @if($data->form_status == 'NEW') background:#119711;
            @elseif($data->form_status == 'Voice Mail') background:#742dc1;
            @elseif($data->form_status == 'Not Connected') background:#e6ca00;color:black;
            @elseif(in_array($data->form_status, ['Not Intrested','Wrong Number','DND'])) background:#d91c1c;
            @else background:#444;
            @endif
            padding:3px 15px;border:none;border-radius:20px;font-size:13px;">
            {{ $data->form_status }}
        </button>

        <div class="dropdown-menu lead-status-menu">

            <a class="dropdown-item lead-status-item update-status" href="javascript:void(0)" data-lead-id="{{ $data->id }}" data-status="Voice Mail">Voice Mail</a>
            <a class="dropdown-item lead-status-item update-status" href="javascript:void(0)" data-lead-id="{{ $data->id }}" data-status="Not Intrested">Not Intrested</a>
            <a class="dropdown-item lead-status-item update-status" href="javascript:void(0)" data-lead-id="{{ $data->id }}" data-status="Insured Leads">Insured Leads</a>
            <a class="dropdown-item lead-status-item update-status" href="javascript:void(0)" data-lead-id="{{ $data->id }}" data-status="Not Connected">Not Connected</a>
            <a class="dropdown-item lead-status-item update-status" href="javascript:void(0)" data-lead-id="{{ $data->id }}" data-status="Wrong Number">Wrong Number</a>
            <a class="dropdown-item lead-status-item update-status" href="javascript:void(0)" data-lead-id="{{ $data->id }}" data-status="WON">WON</a>
            <a class="dropdown-item lead-status-item update-status" href="javascript:void(0)" data-lead-id="{{ $data->id }}" data-status="DND">DND</a>
        </div>
    </div>
</div>

<p class="mb-1"
   style="cursor:pointer; color:#0d6efd;"
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
   data-mail_status="{{ $data->mail_status }}"
>
    <strong>Name -</strong> {{ $data->company_rep1 }}
</p>

<p class="mb-1"><strong>Date -</strong> {{ \Carbon\Carbon::parse($data->updated_at)->format('d-m-y') }}</p>
<p class="mb-1"><strong>Location -</strong> {{ $data->business_city }}, {{ $data->business_state }}</p>
<p class="mb-1"><strong>Phone -</strong> {{ $data->phone }}</p>




<div class="d-flex gap-3 mt-2">

    <!-- Call Button -->
    <a href="tel:{{ $data->phone }}"
       title="Call"
       onclick="event.stopPropagation();"
       class="action-btn call-btn">
        <i class="bi bi-telephone"></i>
    </a>

    <!-- Mail Button -->
    @if (!empty($data->email))
        <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ urlencode(trim($data->email)) }}"
           target="_blank"
           title="Send Email"
           onclick="event.stopPropagation();"
           class="action-btn mail-btn">
            <i class="lni lni-envelope"></i>
        </a>
    @endif

</div>
<style>
    
    .action-btn {
    width: 38px;
    height: 38px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: #fff;
    font-size: 18px;
    transition: all 0.2s ease-in-out;
}

/* Call Button - Green */
.call-btn {
    background-color: #28a745;
}
.call-btn:hover {
    background-color: #218838;
    transform: scale(1.05);
}

/* Mail Button - Dark Green */
.mail-btn {
    background-color: #198754;
}
.mail-btn:hover {
    background-color: #146c43;
    transform: scale(1.05);
}

</style>
 <!-- <div class="btn-group lead-status-dropdown">
    <button type="button"
        class="btn text-white lead-status-btn"
        style="
        @if($data->form_status == 'NEW') background:#119711;
        @elseif($data->form_status == 'Voice Mail') background:#742dc1;
        @elseif($data->form_status == 'Not Connected') background:#e6ca00;color:black;
        @elseif(in_array($data->form_status, ['Not Intrested','Wrong Number','DND'])) background:#d91c1c;
        @else background:#444;
        @endif
        padding:3px 15px;border:none;border-radius:20px;font-size:13px;">
        {{ $data->form_status }}
    </button>

    <div class="dropdown-menu lead-status-menu dropdown-menu-end">
        <a class="dropdown-item lead-status-item update-status" href="javascript:void(0)" data-lead-id="{{ $data->id }}" data-status="Voice Mail">Voice Mail</a>
        <a class="dropdown-item lead-status-item update-status" href="javascript:void(0)" data-lead-id="{{ $data->id }}" data-status="Not Intrested">Not Intrested</a>
        <a class="dropdown-item lead-status-item update-status" href="javascript:void(0)" data-lead-id="{{ $data->id }}" data-status="Not Connected">Not Connected</a>
        <a class="dropdown-item lead-status-item update-status" href="javascript:void(0)" data-lead-id="{{ $data->id }}" data-status="Wrong Number">Wrong Number</a>
        <a class="dropdown-item lead-status-item update-status" href="javascript:void(0)" data-lead-id="{{ $data->id }}" data-status="WON">WON</a>
        <a class="dropdown-item lead-status-item update-status" href="javascript:void(0)" data-lead-id="{{ $data->id }}" data-status="DND">DND</a>
    </div>
</div> -->

<style>
    /* Lead Status Dropdown – isolated fix */
.lead-status-dropdown .lead-status-menu {
  
    white-space: normal !important;
    min-width: 240px;
}

.lead-status-dropdown .lead-status-item {
    display: block !important;
    width: 100%;
    text-align: left;
    padding: 8px 15px;
    font-size: 14px;
}
.lead-name-row {
    display: flex;
    align-items: center;
    justify-content: space-between; /* 🔥 name left, button right */
    gap: 10px;
}

.lead-name {
    margin: 0;
    font-size: 10px;
    flex: 1; /* name left me rahe */
}

/* mobile safe */
@media (max-width: 576px) {
    .lead-name-row {
        flex-wrap: wrap;
    }

    .lead-status-dropdown {
        margin-left: auto;
    }
}
.lead-status-dropdown {
    position: relative;
}

/* default hidden */
.lead-status-dropdown .lead-status-menu {
    display: none;
    position: absolute;
    top: 100%;

    /* 🔥 LEFT align instead of RIGHT */
    left: 0;
    right: auto;

    min-width: 240px;
    background: #8a9abd;
    border-radius: 6px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    white-space: normal;

    z-index: 99999;
}

.lead-status-dropdown .lead-status-menu.show {
    display: block;
}

.lead-status-dropdown .lead-status-item {
    display: block;
    width: 100%;
    padding: 8px 15px;
    font-size: 14px;
}






</style>





@if ($is_intrested == 1)
  <h6 class="fw-bold mb-1 text-success">Lead By:</h6>
  <p class="text-success fw-semibold mb-2">{{ $intre_agent_id }}</p>
@endif

          <!-- Date -->
           

          <!-- STATUS BUTTON WITH DROPDOWN -->
          
         

        </div>
        
      </div>
    </div>
  


  @endforeach
@endif
</div>

<!-- Pagination Links -->
<div class="d-flex justify-content-center mt-4">
    {{ $datas->appends(request()->query())->links() }}
</div>

<style>
.black-row { background:#1a1a1a !important; color:white !important; }
.green-row { background:#e8f8e8 !important; border-left:5px solid #119711 !important; }
.lead-card:hover { transform:translateY(-3px); transition:0.2s; }

/* Lead Card Container - Set to relative positioning */
.lead-card {
    position: relative !important;
}

/* Dropdown Menu - Absolute positioning with high z-index */
.lead-status-dropdown .lead-status-menu {
    position: absolute !important;
    top: 100% !important;
    left: 0 !important;
    z-index: 9999 !important;
}
</style>

                            <!-- <tfoot>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Company Name</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Company Rep1</th>
                                    <th scope="col">State</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </tfoot> -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <input type="hidden" value="{{ $id }}" id="manager_id" name="manager_id">
    {{-- modal start --}}
    <div class="modal fade" id="exampleFullScreenModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
               <div class="modal-header border-bottom d-flex align-items-center justify-content-between">
    
    <div class="d-flex align-items-center">
        <h4 class="mb-0">Lead</h4>

       
    </div>
     <!-- ADD BUTTON (Lead ke side me) -->
          <button class="btn btn-sm btn-primary ms-2" onclick="openScriptModal()">
    Script
</button>
<style>
.custom-modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.6);
    z-index: 9999;
}

.custom-modal-content {
    background: #fff;
    width: 80%;
    max-width: 900px;
    margin: 5% auto;
    border-radius: 8px;
    max-height: 85vh;
    overflow-y: auto;
}

.custom-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    border-bottom: 1px solid #ddd;
}

.custom-modal-body {
    padding: 16px;
}

.close-btn {
    cursor: pointer;
    font-size: 22px;
}
.custom-modal {
    transition: 0.3s ease-in-out;
}

</style>




<!-- Script Modal -->
 <div id="scriptModal" class="custom-modal">
    <div class="custom-modal-content">

        <div class="custom-modal-header">
            <h5>Trucking Insurance Call Script</h5>
            <span class="close-btn" onclick="closeScriptModal()">×</span>
        </div>

        <div class="custom-modal-body">

            <h6>1. Opening – Introduction</h6>
            <p>
                Hi, good morning/afternoon. Is this <b>[Customer Name]</b>?<br>
                My name is <b>[Your Name]</b>. I got a query that you are looking for a trucking insurance quote.
            </p>

            <hr>

            <h6>2. Business Verification</h6>
            <ul>
                <li>DOT Number / MC Number</li>
                <li>Company Name</li>
                <li>Operating Authority Active?</li>
                <li>Years in Business</li>
            </ul>

            <hr>

            <h6>3. Truck & Fleet Details</h6>
            <ul>
                <li>Number of Trucks</li>
                <li>VIN Number(s)</li>
                <li>Truck Make, Model & Year</li>
                <li>Estimated Truck Value</li>
                <li>Radius of Operation</li>
            </ul>

            <hr>

            <h6>4. Driver Information</h6>
            <ul>
                <li>Full Name</li>
                <li>Date of Birth</li>
                <li>Driver License Number</li>
                <li>State of Issuance</li>
                <li>Years of CDL Experience</li>
            </ul>

            <hr>

            <h6>5. Cargo & Operation Type</h6>
            <ul>
                <li>Type of Cargo (Dry Van, Reefer, Flatbed, etc.)</li>
                <li>Intrastate / Interstate</li>
                <li>Any Hazmat? (Yes / No)</li>
            </ul>

            <hr>

            <h6>6. Insurance Coverage Requirements</h6>
            <ul>
                <li>Auto Liability – $1 Million</li>
                <li>Cargo Insurance – $100,000</li>
                <li>Physical Damage (Comp & Collision)</li>
                <li>Non-Trucking Liability (Bobtail)</li>
            </ul>

            <hr>

            <h6>7. Claims & Loss History</h6>
            <p>
                Have you had any claims or losses in the past 3 to 5 years?
            </p>

            <hr>

            <h6>8. Current Insurance Status</h6>
            <ul>
                <li>Current Insurance Company Name</li>
                <li>Policy Expiration Date</li>
                <li>Reason for Shopping</li>
            </ul>

            <hr>

            <h6>9. Payment & Binding</h6>
            <ul>
                <li>Down Payment Required</li>
                <li>Monthly Installments Available</li>
                <li>Payment Mode (Card / ACH)</li>
            </ul>

            <hr>

            <h6>10. Wrap-Up & Closing</h6>
            <p>
                Thank you for your time. We will prepare the best quote for you and get back shortly.<br>
                Have a great day!
            </p>

        </div>

    </div>
</div>



            <style>
                #scriptModal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: none;
    justify-content: center;
    align-items: center;
}

                .modal-header {
    display: flex;
  
}

.modal-header .btn-primary {
    margin-left: auto !important;
    position: relative;
    right: -450px;
}


            </style>

    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


                <div class="modal-body">
                    <form action="{{ route('agent_update_leads') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="data_id" value="" id="data_id">
                        <input type="hidden" name="forword_id" value="" id="forword_id">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="row border-end border-primary">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="firstNameinput" class="form-label">Company Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter company name"
                                                id="company_name" name="company_name" required>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="lastNameinput" class="form-label">Phone <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter phone number"
                                                id="phone" name="phone" required>
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
                                                id="company_rep1" name="company_rep1" required>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="emailidInput" class="form-label">Business Address <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter business address" id="business_address"
                                                name="business_address" required>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="address1ControlTextarea" class="form-label">Business City <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter business city"
                                                id="business_city" name="business_city" required>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Business State <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter business state"
                                                id="business_state" name="business_state" required>
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
                                            <input type="number" class="form-control" placeholder="Enter DOT"
                                                id="dot" name="dot" required>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">MC/Docket <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter MC"
                                                id="mc_docket" name="mc_docket"required>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-12 mb-3">
                                        <h5>Commodities</h5>
                                        <div class="row">
                                            <div class="col-6">

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Building Materials - Machinery">
                                                <label for="citynameInput" class="form-label"> Building Materials -
                                                    Machinery</label>

                                            </div>
                                            <div class="col-6">

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Building Materials">
                                                <label for="citynameInput" class="form-label"> Building Materials</label>

                                            </div>
                                            <div class="col-6">

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Dry Freight - Amazon">
                                                <label for="citynameInput" class="form-label"> Dry Freight -
                                                    Amazon</label>

                                            </div>
                                            <div class="col-6">

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Dry Freight">
                                                <label for="citynameInput" class="form-label"> Dry Freight</label>

                                            </div>
                                            <div class="col-6">

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Reefer with seafood or flowers">
                                                <label for="citynameInput" class="form-label"> Reefer with seafood or
                                                    flowers</label>

                                            </div>
                                            <div class="col-6">

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Refrigerated Goods">
                                                <label for="citynameInput" class="form-label"> Refrigerated Goods</label>

                                            </div>
                                            <div class="col-6">

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Reefer with flowers">
                                                <label for="citynameInput" class="form-label"> Reefer with flowers</label>

                                            </div>
                                            <div class="col-6">

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Reefer with flowers">
                                                <label for="citynameInput" class="form-label"> Fracking Sand</label>

                                            </div>
                                            <div class="col-6">

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Hazard">
                                                <label for="citynameInput" class="form-label"> Hazard</label>

                                            </div>
                                            <div class="col-6">

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Containerized Freight">
                                                <label for="citynameInput" class="form-label"> Containerized
                                                    Freight</label>

                                            </div>
                                            <div class="col-6">

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Sand &amp; Gravel">
                                                <label for="citynameInput" class="form-label"> Sand &amp; Gravel</label>

                                            </div>
                                            <div class="col-6">

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Auto 100%">
                                                <label for="citynameInput" class="form-label"> Auto 100%</label>

                                            </div>
                                            <div class="col-6">

                                                <input type="checkbox" class="form-check-input" name="commodities[]"
                                                    value="Hauls Oversized/Overweight">
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
                                                <option value="Intrested">Intrested</option>
                                                <option value="Pipeline">Pipeline</option>
                                            </select>
                                            
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="pt-4">
    

 <div class="mt-2">
    <h6 class="mb-2">Form On</h6>

   <div class="d-flex gap-3 align-items-center">

    <div class="form-check d-flex align-items-center gap-2">
        <input class="form-check-input" type="radio"
               name="contact_mode"
               id="callCheck"
               value="Call"
               {{ old('contact_mode', $data->mail_status ?? '') == 'Call' ? 'checked' : '' }}
               required>
        <label class="form-check-label" for="callCheck">Call</label>
    </div>

    <div class="form-check d-flex align-items-center gap-2">
        <input class="form-check-input" type="radio"
               name="contact_mode"
               id="emailCheck"
               value="Email"
               {{ old('contact_mode', $data->mail_status ?? '') == 'Email' ? 'checked' : '' }}
               required>
        <label class="form-check-label" for="emailCheck">Email</label>
    </div>

</div>

</div>






</div>

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
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Comment </label>
                                            <textarea id="comment" name="comment" class="form-control" rows="4" placeholder="Write a Coment...."
                                                required=""></textarea>
                                        </div>
                                    </div><!--end col-->

                                    <h4>Policy</h4>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="ForminputState" class="form-label">Liability limit</label>
                                            <select id="form_status" class="form-select" name="Liability"
                                                required="">
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
                                            <label for="ForminputState" class="form-label">Do you need MTC ?</label>
                                            <select id="form_status" class="form-select" name="MTC"
                                                required="">
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
                                            <label for="ForminputState" class="form-label">Trailer interchange</label>
                                            <select id="form_status" class="form-select" name="interchange"
                                                required="">
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
                                                <input type="checkbox" name="Physical" value="1"
                                                    class="form-check-input">
                                                Physical Damage
                                            </label>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-check-label">
                                                <input type="checkbox" name="general" value="1"
                                                    class="form-check-input">
                                                General Liability
                                            </label>
                                        </div>
                                          <div class="col-12">
                                        <div class="mb-3">
                                            <label for="owner_dob" class="form-label">Owner Dob <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control"
                                                placeholder="Enter driver dob" id="owner_dob"
                                                name="owner_dob">
                                        </div>
                                    </div><!--end col-->
                                    </div><!--end col-->
                                    <hr />
                                    <h5>Loss Runs/Docs Files</h5>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <input class="form-control" style="margin-left: 10px" type="file"
                                                value="" name="file1">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <input class="form-control" style="margin-left: 10px" type="file"
                                                value="" name="file2">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <input class="form-control" style="margin-left: 10px" type="file"
                                                value="" name="file3">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <input class="form-control" style="margin-left: 10px" type="file"
                                                value="" name="file4">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <input class="form-control" style="margin-left: 10px" type="file"
                                                value="" name="file5">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <input class="form-control" style="margin-left: 10px" type="file"
                                                value="" name="file6">
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
    <!--end page wrapper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.update-status').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Close dropdown immediately
                $('.lead-status-menu').removeClass('show');
                
                var leadId = $(this).data('lead-id');
                var status = $(this).data('status');
                var managerfwd = $('#manager_id').val();
                var $clickedItem = $(this);
                var $button = $clickedItem.closest('.lead-status-dropdown').find('.lead-status-btn');

                // Immediate UI update
                $button.text(status);
                
                var color = '#119711';
                var textColor = '#fff';
                
                switch (status) {
                    case 'Voice Mail':
                        color = '#742dc1';
                        break;
                    case 'Not Intrested':
                    case 'Wrong Number':
                    case 'DND':
                        color = '#d91c1c';
                        break;
                    case 'Not Connected':
                        color = '#e6ca00';
                        textColor = '#000';
                        break;
                    case 'WON':
                        color = '#00ff72';
                        break;
                    case 'Insured Leads':
                        color = '#17a2b8';
                        break;
                }
                
                $button.attr('style', `background:${color};color:${textColor};padding:3px 15px;border:none;border-radius:20px;font-size:13px;`);

                $.ajax({
                    url: '{{ route('agent_status_update') }}',
                    method: 'POST',
                    data: {
                        lead_id: leadId,
                        status: status,
                        mangerfwd: managerfwd,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Status to route mapping
                        const statusRoutes = {
                            'Voice Mail': 'VoiceMail',
                            'Not Intrested': 'NotInterested', 
                            'Not Connected': 'NotConnected',
                            'Wrong Number': 'WrongNumber',
                            'WON': 'WON',
                            'DND': 'DND',
                            'Insured Leads': 'InsuredLeads'
                        };
                        
                        if (statusRoutes[status]) {
                            const redirectUrl = '{{ url("/agent") }}/' + statusRoutes[status] + '/leads';
                            window.location.href = redirectUrl;
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
                // 🔥🔥 RADIO BUTTON FIX (ADD THIS) 🔥🔥
    modal.find('input[name="contact_mode"]').prop('checked', false);

    if (td.data('mail_status') === 'Call') {
        modal.find('#callCheck').prop('checked', true);
    }

    if (td.data('mail_status') === 'Mail') {
        modal.find('#emailCheck').prop('checked', true);
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
                    '#exampleFullScreenModal #company_name', '#exampleFullScreenModal #phone',
                    '#exampleFullScreenModal #company_rep1',
                    '#exampleFullScreenModal #business_address',
                    '#exampleFullScreenModal #business_city',
                    '#exampleFullScreenModal #business_state', '#exampleFullScreenModal #business_zip',
                    '#exampleFullScreenModal #dot', '#exampleFullScreenModal #vin',
                    '#exampleFullScreenModal #driver_name', '#exampleFullScreenModal #driver_dob',
                    '#exampleFullScreenModal #driver_license',
                    '#exampleFullScreenModal #driver_license_state', '#exampleFullScreenModal #vin2',
                    '#exampleFullScreenModal #driver_name2', '#exampleFullScreenModal #driver_dob2',
                    '#exampleFullScreenModal #driver_license2',
                    '#exampleFullScreenModal #driver_license_state2', '#exampleFullScreenModal #vin3',
                    '#exampleFullScreenModal #driver_name3', '#exampleFullScreenModal #driver_dob3',
                    '#exampleFullScreenModal #driver_license3',
                    '#exampleFullScreenModal #driver_license_state3', '#exampleFullScreenModal #vin4',
                    '#exampleFullScreenModal #driver_name4', '#exampleFullScreenModal #driver_dob4',
                    '#exampleFullScreenModal #driver_license4',
                    '#exampleFullScreenModal #driver_license_state4', '#exampleFullScreenModal #vin5',
                    '#exampleFullScreenModal #driver_name5', '#exampleFullScreenModal #driver_dob5',
                    '#exampleFullScreenModal #driver_license5',
                    '#exampleFullScreenModal #driver_license_state5'
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
    {{-- phone number copy --}}
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
    {{-- phone number copy --}}
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
                sendRequest(leadId, status, managerfwd, $td);
            });

            function sendRequest(leadId, status, managerfwd, $td) {
                $.ajax({
                    url: '{{ route('agent_mailstatus_update') }}',
                    method: 'POST',
                    data: {
                        lead_id: leadId,
                        status: status,
                        mangerfwd: managerfwd,
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
        document.getElementById('copyButton').addEventListener('click', function() {
            const startNumber = parseInt(document.getElementById('startNumber').value);
            const endNumber = parseInt(document.getElementById('endNumber').value);

            if (isNaN(startNumber) || isNaN(endNumber) || startNumber <= 0 || endNumber <= 0 || startNumber > endNumber) {
                alert('Please enter valid start and end numbers.');
                return;
            }

            const leadCards = Array.from(document.querySelectorAll('.lead-card'));
            const emailsToCopy = [];

            leadCards.forEach((card, index) => {
                const cardNumber = index + 1;
                if (cardNumber >= startNumber && cardNumber <= endNumber) {
                    const email = card.getAttribute('data-email');
                    if (email && email.trim()) {
                        emailsToCopy.push(email.trim());
                    }
                }
            });

            if (emailsToCopy.length === 0) {
                alert('No emails found in the specified range.');
                return;
            }

            const emailsText = emailsToCopy.join('\n');
            navigator.clipboard.writeText(emailsText)
                .then(() => {
                    alert(`Copied ${emailsToCopy.length} emails successfully!`);
                })
                .catch(err => {
                    console.error('Clipboard write failed:', err);
                    alert('Failed to copy emails.');
                });
        });
    </script>


    
<script>
$(document).on('click', '.lead-status-btn', function (e) {
    e.preventDefault();
    e.stopPropagation();

    let $menu = $(this).next('.lead-status-menu');

    // agar ye dropdown already open hai → close
    if ($menu.hasClass('show')) {
        $menu.removeClass('show');
        return;
    }

    // pehle sab close karo
    $('.lead-status-menu').removeClass('show');

    // sirf current open karo
    $menu.addClass('show');
});

// dropdown ke andar click pe band na ho
$(document).on('click', '.lead-status-menu', function (e) {
    e.stopPropagation();
});

// bahar click pe sab band
$(document).on('click', function () {
    $('.lead-status-menu').removeClass('show');
});

// dropdown item click pe close
$(document).on('click', '.update-status', function () {
    $('.lead-status-menu').removeClass('show');
});
</script>
<script>
<script>
$(document).on('click', '.update-status', function () {

    const status = $(this).data('status');

    // STATUS → URL MAP
    const statusRoutes = {
        'Voice Mail': 'VoiceMail',
        'Not Intrested': 'NotInterested',
        'Not Connected': 'NotConnected',
        'Wrong Number': 'WrongNumber',
        'WON': 'WON',
        'DND': 'DND'
    };

    if (!statusRoutes[status]) {
        alert('Invalid status selected');
        return;
    }

    const baseUrl = "{{ url('/admin') }}/";
    const redirectUrl = baseUrl + statusRoutes[status] + '/leads';

    // optional success message
    alert('Status updated successfully ✔');

    window.location.href = redirectUrl;
});
</script>

</script>
<script>
$(document).on('click', '.status-link', function () {

    const status = $(this).data('status');
    const baseUrl = "{{ url('/admin') }}/";

    alert('Status updated successfully ✔');

    window.location.href = baseUrl + status + '/leads';
});
</script>
<script>
function openScriptModal() {
    document.getElementById('scriptModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeScriptModal() {
    document.getElementById('scriptModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}
</script>
<script>
function openScriptModal() {
    document.getElementById("scriptModal").style.display = "block";
}

function closeScriptModal() {
    document.getElementById("scriptModal").style.display = "none";
}

// Modal ke bahar click karne par close
window.onclick = function(event) {
    let modal = document.getElementById("scriptModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
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
        });
    });
</script>













@endsection
