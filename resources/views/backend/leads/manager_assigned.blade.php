@extends('backend.common.layout')
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Assigned Leads</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                        <li class="breadcrumb-item active">Assigned Leads</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row row-cols-xxl-5 row-cols-lg-3 row-cols-md-2 row-cols-1">
        @foreach ($groupedExcelData as $batchId => $excelData)
            <div class="col-lg-3">
                <!--end card-->
                <div class="collapse show" id="leadDiscovered">
                    <div class="card mb-1">
                        <div class="card-body">
                            <a class="d-flex align-items-center" data-bs-toggle="collapse"
                                href="#leadDiscovered{{ $batchId }}" role="button" aria-expanded="false"
                                aria-controls="leadDiscovered{{ $batchId }}">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('assets/images/giftbox.png') }}" alt=""
                                        class="avatar-xs rounded-circle" />
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">{{ count($excelData) }} Data to
                                        <small class="badge bg-primary-subtle text-primary">
                                            @php
                                                $firstUserData = $excelData->first()->managerfwdsingle->user ?? null;
                                                $userName = optional($firstUserData)->name ?? 'N/A';
                                            @endphp {{ $userName }} (Agent)
                                        </small>
                                    </h6>
                                    <p class="text-muted mb-0">
                                        {{ $excelData->first() && $excelData->first()->managerfwdsingle
    ? $excelData->first()->managerfwdsingle->created_at->format('H:i:s') . ' - ' . $excelData->first()->managerfwdsingle->created_at->format('d/m/y')
    : 'N/A' }}



                                            
                                           
                                    </p>
                                </div>
                            </a>
                        </div>
                        <div class="collapse border-top border-top-dashed" id="leadDiscovered{{ $batchId }}">
                            <div class="card-footer hstack gap-2">
                                <a class="btn btn-primary btn-sm w-100"
                                    href="{{ route('manager.view.assigned.leads', encrypt($batchId)) }}"><i
                                        class="ri-question-answer-line align-bottom me-1"></i>
                                    View Data</a>
                                <a class="btn btn-danger btn-sm w-100"
                                    href="{{ route('manager.delete.assigned.leads', encrypt($batchId)) }}"  onclick="return confirm('Are you sure ?');"><i
                                        class="ri-question-answer-line align-bottom me-1"></i>
                                    Delete Data</a>
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                </div>
            </div>
            <!--end col-->
        @endforeach
    </div>
    <!--end row-->
@endsection
