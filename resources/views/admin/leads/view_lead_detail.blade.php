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
                    <div class="page-body" style="background-color: white">
                        <div class="row">
                            <div class="col-lg-12">

                                <style>
                                    /* Custom card styling */
                                    .card-custom {
                                        border: 1px solid #ddd;
                                        border-radius: 5px;
                                        margin-bottom: 20px;
                                        padding: 15px;
                                        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                                    }
                                
                                    /* Accordion button styling */
                                    .accordion-button {
                                        display: flex;
                                        justify-content: space-between;
                                        align-items: center;
                                        cursor: pointer;
                                        background-color: #f1f1f1;
                                        padding: 10px; /* Reduced padding */
                                        border: none;
                                        width: 100%;
                                        text-align: left;
                                        font-weight: normal; /* Normal weight */
                                        font-size: 16px; /* Adjusted font size */
                                    }
                                
                                    .accordion-button:focus {
                                        outline: none;
                                    }
                                
                                    /* Collapse content styling */
                                    .collapse {
                                        max-height: 0;
                                        overflow: hidden;
                                        transition: max-height 0.3s ease-out;
                                    }
                                
                                    .collapse.show {
                                        max-height: 1000px; /* Set high value to show the content */
                                        transition: max-height 0.3s ease-in;
                                    }
                                
                                    /* Status dot styling */
                                    .status-dot {
                                        display: inline-block;
                                        width: 10px; /* Smaller dot */
                                        height: 10px;
                                        border-radius: 50%;
                                        margin-right: 10px;
                                    }
                                
                                    .status-dot.active {
                                        background-color: green;
                                    }
                                
                                    .status-dot.pipeline {
                                        background-color: orange;
                                    }
                                
                                    /* Layout and typography adjustments */
                                    .d-flex {
                                        display: flex;
                                        justify-content: space-between;
                                        align-items: center;
                                        margin-bottom: 10px;
                                    }
                                
                                    .card-title {
                                        font-size: 1em; /* Adjusted font size */
                                        margin-bottom: 10px;
                                    }
                                
                                    .accordion-header strong {
                                        font-size: 14px; /* Smaller strong text size */
                                    }
                                
                                    .accordion-body strong {
                                        font-size: 14px; /* Normal-sized status text */
                                    }
                                    
                                    .accordion-header span {
                                        font-size: 14px; /* Reduced font size for date and other details */
                                    }
                                
                                </style>
                                
                                <!-- HTML Structure -->
                                <div class="container mt-5">
                                    <!-- Lead Accordion -->
                                    <div id="leadAccordion">
                                        <!-- Single Lead Item -->
                                        <div class="accordion-item card-custom">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button" onclick="toggleAccordion('collapseOne')">
                                                    <span style="margin-right: auto;"><span class="status-dot active"></span>
                                                        <strong>Company Name:</strong> {{ $excel_data->company_name }}</span>
                                                    <span style="margin-left: auto;"><strong>Created At:</strong>
                                                        {{ \Carbon\Carbon::parse($excel_data->created_at)->format('d M Y') }}</span>
                                                </button>
                                            </h2>
                                            @if ($historys)
                                            <div id="collapseOne" class="collapse show">
                                                <div class="accordion-body">
                                                    <!-- Lead History Details -->
                                                    <h5 class="card-title">Lead History</h5>
                                
                                                    <!-- Single Lead History Item -->
                                                    @foreach ($historys as $data)
                                                    <div class="d-flex">
                                                        <div>
                                                            <strong>Status:</strong> {{ $data->status }}
                                                        </div>
                                                        <div>
                                                            @php
                                                            $userDetails = App\adminmodel\Users_detailsModal::where('ajent_id', $data->user_id)->first();
                                                            @endphp
                                                            <strong>Changed By: </strong> {{ $userDetails->alise_name }} <br>
                                                            <strong>Status Change Date:</strong>
                                                            {{ \Carbon\Carbon::parse($data->status_date)->format('d M Y, h:i A') }}
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                
                                        @if ($duplicates)
                                        <!-- Duplicates -->
                                        @foreach ($duplicates as $duplicate)
                                        <div class="accordion-item card-custom">
                                            <h2 class="accordion-header" id="headingTwo{{ $duplicate->id }}">
                                                <button class="accordion-button" onclick="toggleAccordion('collapseTwo{{ $duplicate->id }}')">
                                                    <span style="margin-right: auto;">
                                                        <span class="status-dot pipeline"></span>
                                                        <strong>Company Name:</strong> {{ $duplicate->company_name }}
                                                    </span>
                                                    <span style="margin-left: auto;">
                                                        <strong>Created At:</strong>
                                                        {{ \Carbon\Carbon::parse($duplicate->created_at)->format('d M Y') }}
                                                    </span>
                                                </button>
                                            </h2>
                                
                                            <div id="collapseTwo{{ $duplicate->id }}" class="collapse">
                                                <div class="accordion-body">
                                                    @php
                                                    $history2 = App\Models\LeadStatusHistory::where('lead_id', $duplicate->id)
                                                    ->latest('created_at')
                                                    ->get();
                                                    @endphp
                                                    @if ($history2->isNotEmpty())
                                                    <!-- Lead History Details -->
                                                    <h5 class="card-title">Lead History</h5>
                                                    <!-- Single Lead History Item -->
                                                    @foreach($history2 as $data)
                                                    <div class="d-flex">
                                                        <div>
                                                            <strong>Status:</strong> {{ $data->status }}
                                                        </div>
                                                        <div>
                                                            @php
                                                            $userDetails = App\adminmodel\Users_detailsModal::where('ajent_id', $data->user_id)->first();
                                                            @endphp
                                                            <strong>Changed By: </strong> {{ $userDetails->alise_name }} <br>
                                                            <strong>Status Change Date:</strong>
                                                            {{ \Carbon\Carbon::parse($data->status_date)->format('d M Y, h:i A') }}
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- JavaScript for Accordion -->
                                <script>
                                    function toggleAccordion(id) {
                                        var element = document.getElementById(id);
                                        if (element.classList.contains('show')) {
                                            element.classList.remove('show');
                                        } else {
                                            element.classList.add('show');
                                        }
                                    }
                                </script>
                                
                                    
                                   
                                    

                                 

                              
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
      
@endsection
