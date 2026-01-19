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
    .card-custom {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        margin-bottom: 20px;
        transition: transform 0.3s ease;
    }
    .card-custom:hover {
        transform: scale(1.02);
    }
    .status-dot {
        height: 15px;
        width: 15px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 10px;
    }
    .status-dot.active {
        background-color: #28a745;
    }
    .status-dot.not-interested {
        background-color: #dc3545;
    }
    .status-dot.pipeline {
        background-color: #ffc107;
    }
    .accordion-button {
        text-align: left;
        font-weight: bold;
        font-size: 16px;
        display: flex;
        justify-content: space-between;
        padding: 15px;
        border: none;
        width: 100%;
        background-color: #f8f9fa;
        color: #343a40;
        border-bottom: 1px solid #e9ecef;
    }
    .accordion-button:focus {
        outline: none;
        box-shadow: none;
    }
    .accordion-button:hover {
        background-color: #e9ecef;
    }
    .accordion-body {
        padding: 10px 15px;
        background-color: #f8f9fa;
    }
    .accordion-item {
        margin-bottom: 10px;
        border: none;
    }
</style>

<div class="page-wrapper">
    <div class="page-content">

        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Leads</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Lead detail</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
                <div class="text-white">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
                <div class="text-white">{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="container mt-5">

                    <div class="accordion" id="leadAccordion">

                        <!-- MAIN LEAD -->
                        <div class="accordion-item card-custom">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button d-flex justify-content-between align-items-center"
                                    type="button"
                                    data-toggle="collapse"
                                    data-target="#collapseOne"
                                    aria-expanded="true"
                                    aria-controls="collapseOne">

                                    <span style="margin-right: auto;">
                                        <span class="status-dot active"></span>
                                        <strong>Company Name:</strong> {{$excel_data->company_name}}
                                    </span>

                                    <span style="margin-left: auto;">
                                        <strong>Created At:</strong>
                                        {{ \Carbon\Carbon::parse($excel_data->created_at)->format('d M Y') }}
                                    </span>
                                </button>
                            </h2>

                            @if($historys)
                            <div id="collapseOne" class="collapse show"
                                 aria-labelledby="headingOne"
                                 data-parent="#leadAccordion">

                                <div class="accordion-body">
                                    <h5 class="card-title">Lead History</h5>

                                    @foreach($historys as $data)
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <strong>Status:</strong> {{$data->status}}
                                        </div>

                                        <div>
                                            @php
                                            $userDetails = App\adminmodel\Users_detailsModal::where('ajent_id', $data->user_id)->first();
                                            @endphp

                                            <strong>Changed By: </strong>
                                            {{ $userDetails ? $userDetails->alise_name : 'User Not Found' }}
                                            <br>

                                            <strong>Status Change Date:</strong>
                                            {{ \Carbon\Carbon::parse($data->status_date)->format('d M Y, h:i A') }}
                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- DUPLICATE LEADS -->
                        @if($duplicates)
                        @foreach ($duplicates as $duplicate)
                        <div class="accordion-item card-custom">
                            <h2 class="accordion-header" id="headingTwo{{ $duplicate->id }}">
                                <button class="accordion-button d-flex justify-content-between align-items-center"
                                    type="button"
                                    data-toggle="collapse"
                                    data-target="#collapseTwo{{ $duplicate->id }}"
                                    aria-expanded="false"
                                    aria-controls="collapseTwo{{ $duplicate->id }}">

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

                            <div id="collapseTwo{{ $duplicate->id }}"
                                 class="collapse"
                                 aria-labelledby="headingTwo{{ $duplicate->id }}"
                                 data-parent="#leadAccordion">

                                <div class="accordion-body">

                                    @php
                                        $history2 = App\Models\LeadStatusHistory::where('lead_id', $duplicate->id)
                                            ->latest('created_at')
                                            ->get();
                                    @endphp

                                    @if ($history2->isNotEmpty())
                                        <h5 class="card-title">Lead History</h5>

                                        @foreach($history2 as $data)
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <strong>Status:</strong> {{ $data->status }}
                                            </div>

                                            <div>
                                                @php
                                                $userDetails = App\adminmodel\Users_detailsModal::where('ajent_id', $data->user_id)->first();
                                                @endphp

                                                <strong>Changed By: </strong>
                                                {{ $userDetails ? $userDetails->alise_name : 'User Not Found' }}
                                                <br>

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
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection
