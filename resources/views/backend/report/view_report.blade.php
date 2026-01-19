@extends('backend.common.layout')
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Team</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                        <li class="breadcrumb-item active">Team</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="leadsList">
                <div class="card-header border-0">

                    <div class="row g-4 align-items-center">
                        <div class="col-sm-3">
                            <div class="search-box">
                                <input type="text" class="form-control search" placeholder="Search for...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-sm-auto ms-auto">
                            <div class="hstack gap-2">
                                <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i
                                        class="ri-delete-bin-2-line"></i></button>
                                <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal"
                                    id="create-btn" data-bs-target="#showModal"><i
                                        class="ri-add-line align-bottom me-1"></i> Add Team</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card">
                            <table class="table align-middle" id="customerTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>S.No.</th>
                                        <th class="sort" data-sort="date">Date</th>
                                        <th class="sort" data-sort="name">Name</th>
                                        <th>Intrested</th>
                                        <th>Pipeline</th>
                                        <th>Total Call</th>
                                        <th>Call Connect</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @php
                                        $i=1;
                                    @endphp
                                    @foreach ($datas as $report)
                                        @foreach ($report as $data)
                                            <tr>
                                                <td class="text-center">
                                                    @php
                                                        echo $i;
                                                        $i++;
                                                    @endphp
                                                </td>
                                                <td class="date">
                                                    {{$data->created_at}}
                                                    {{-- {{ \Carbon\Carbon::parse($data->created_at)->format('d M, Y') }} --}}
                                                </td>
                                                <td class="name">
                                                    @php
                                                        $user = \App\Models\User::find($data->user_id);
                                                    @endphp
                                                
                                                    @if($user)
                                                        {{ $user->name }}
                                                    @else
                                                        User not found
                                                    @endif
                                                </td>
                                                
                                                <td>{{ $data->intrested }}</td>
                                                <td>{{ $data->pipeline }}</td>
                                                <td>{{ $data->total_call }}</td>
                                                <td>{{ $data->call_connect }}</td>
                                                <td><a href="{{route('delete.report',$data->id)}}" class="text-danger fs-4" onclick="return confirm('Are you sure ?')"><i class='bx bxs-trash'></i></a></td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#121331,secondary:#08a88a"
                                        style="width:75px;height:75px"></lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted mb-0">We've searched more than 150+ leads We
                                        did not find any leads for you search.</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <div class="pagination-wrap hstack gap-2">
                                <a class="page-item pagination-prev disabled" href="#">
                                    Previous
                                </a>
                                <ul class="pagination listjs-pagination mb-0"></ul>
                                <a class="page-item pagination-next" href="#">
                                    Next
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end modal -->
            </div>
        </div>

    </div>
    <!--end col-->
    </div>
@endsection
