@extends('Agent.common.app')
@section('main')
    <link href="{{ asset('Agent/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <style>
        .red-row {
            background-color: #ff6666 !important;
        }
    </style>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Loads</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Intrested loads</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">S.no.</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">phone</th>
                                    <th scope="col">email</th>
                                    <th scope="col">dot</th>
                                    <th scope="col">mc_docket</th>
                                    <th scope="col">equipment</th>
                                    <th scope="col">address</th>
                                    <th scope="col">city</th>
                                    <th scope="col">state</th>
                                    <th scope="col">zip</th>
                                    <th scope="col">certificate</th>
                                    <th scope="col">license</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($datas))
                                    @php $a = 0; @endphp
                                    @foreach ($datas as $data)
                                        @php
                                            $name = $data->first_name . ' ' . $data->last_name;
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $name ?? 0 }} <a href="{{ route('view_load_pdfs', $data->id) }}"
                                                    target="_blank">
                                                    <button>PDF</button>
                                                </a></td>
                                            <td>{{ $data->phone ?? 0 }}</td>
                                            <td>{{ $data->email ?? 0 }}</td>
                                            <td>{{ $data->dot ?? 0 }}</td>
                                            <td>{{ $data->mc_docket ?? 0 }}</td>
                                            <td>{{ $data->equipment ?? 0 }}</td>
                                            <td>{{ $data->address ?? 0 }}</td>
                                            <td>{{ $data->city ?? 0 }}</td>
                                            <td>{{ $data->state ?? 0 }}</td>
                                            <td>{{ $data->zip ?? 0 }}</td>
                                            @if (!empty($data->certificate))
                                                @php
                                                    $certificateUrl = asset($data->certificate);
                                                @endphp
                                                <td>
                                                    <a href="{{ $certificateUrl }}" target="_blank">
                                                        <button>View File</button>
                                                    </a>
                                                </td>
                                            @else
                                                <td>No file found</td>
                                            @endif
                                            @if (!empty($data->license))
                                                @php
                                                    $licenseUrl = asset($data->license);
                                                @endphp
                                                <td>
                                                    <a href="{{ $licenseUrl }}" target="_blank">
                                                        <button>View File</button>
                                                    </a>
                                                </td>
                                            @else
                                                <td>No file found</td>
                                            @endif
                                            <td>{{ $data->created_at ? $data->created_at->format('d-m-Y') : '0' }}</td>
                                            <td>
                                                @if (!empty($data->phone))
                                                    <div class="btn-group" id="btns<?php echo $a; ?>">
                                                        <a href="tel:{{ $data->phone }}" data-toggle="tooltip"
                                                            data-placement="top" title="Call">
                                                            <i class="lni lni-phone"
                                                                style="font-size:20px;margin-left:10px"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col">S.no.</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">phone</th>
                                    <th scope="col">email</th>
                                    <th scope="col">dot</th>
                                    <th scope="col">mc_docket</th>
                                    <th scope="col">equipment</th>
                                    <th scope="col">address</th>
                                    <th scope="col">city</th>
                                    <th scope="col">state</th>
                                    <th scope="col">zip</th>
                                    <th scope="col">certificate</th>
                                    <th scope="col">license</th>
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
    <!--end page wrapper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
