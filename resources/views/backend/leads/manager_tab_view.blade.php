@extends('backend.common.layout')
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Tab View</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                        <li class="breadcrumb-item active">Tab View</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row row-cols-xxl-5 row-cols-lg-3 row-cols-md-2 row-cols-1">
      @php
    $userIds = array_unique($excelData->pluck('0.rel_id')->toArray());
    $users = \App\Models\User::whereIn('id', $userIds)->get()->keyBy('id');
@endphp

       @foreach($excelData as $batchName => $data)
            <div class="col-lg-3">
                <!--end card-->
                <div class="collapse show" id="leadDiscovered">
                    <div class="card mb-1">
                        <div class="card-body">
                            <a class="d-flex align-items-center" data-bs-toggle="collapse"
                                href="#leadDiscovered{{ $data[0]->id }}" role="button" aria-expanded="false"
                                aria-controls="leadDiscovered{{ $data[0]->id }}">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('assets/images/giftbox.png') }}" alt=""
                                        class="avatar-xs rounded-circle" />
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1"> 
                                    @if(isset($users[$data[0]->rel_id]))
                {{ $users[$data[0]->rel_id]->name }}
            @else
                User not found
            @endif
                                    </h6>
                                    <p class="text-muted mb-0">
                                         File Name : {{ $batchName }}
                                         <br>
                                         Data : {{ count($data) }}
                                         <br>
                                         Date : {{ $data[0]->created_at }}
                                    </p>
                                </div>
                            </a>
                        </div>
                        <div class="collapse border-top border-top-dashed" id="leadDiscovered{{ $data[0]->id }}">
                            <div class="card-footer hstack gap-2">
                                
                                <a class="btn btn-primary btn-sm w-100"
                                    href="{{ route('manager.tab.leads.view', encrypt($batchName)) }}"><i
                                        class="ri-question-answer-line align-bottom me-1"></i>
                                    View Data</a>
                                    <a class="btn btn-danger btn-sm w-100"
                                    href="{{ route('manager.tab.leads.delete', encrypt($batchName)) }}"  onclick="return confirm('Are you sure ?');"><i
                                        class="ri-question-answer-line align-bottom me-1"></i>
                                    Delete Data</a>
                                    
                            </div>
                            <div class="card-footer hstack gap-2">
                                
                               <!--<a class="btn btn-success btn-sm w-100"-->
                               <!--     href="{{ url('/data/export', encrypt($batchName)) }}"  onclick="return confirm('Are you sure ?');"><i-->
                               <!--         class="ri-question-answer-line align-bottom me-1"></i>-->
                               <!--     Download</a>-->
                                    <a class="btn btn-warning btn-sm w-100"
                                    href="{{url('/delete/duplicate/entry',encrypt($batchName))}}"  onclick="return confirm('Are you sure ?');"><i
                                        class="ri-question-answer-line align-bottom me-1"></i>
                                     Duplicate</a>
                                    
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
