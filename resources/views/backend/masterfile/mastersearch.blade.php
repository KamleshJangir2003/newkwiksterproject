@extends('backend.masterfile.layout')
@section('content')
    <div class="row py-5 pl-2 pr-2">
        <div class="col-12">
            <table id="example" class="table table-hover responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>S.no.</th>
                        <th>Company Name</th>
                        <th>Phone</th>
                        <th>Company Rep</th>
                        <th>Businness Addess</th>
                        <th>Businness City</th>
                        <th>Businness State</th>
                        <th>Businness Zip</th>
                    </tr>
                </thead>
                <tbody>


                    <tr class="clickrow">
                        <td>1</td>
                        <td class="data-select" data-id="{{ $data->id }}">{{ $data->company_name }}</td>
                        <td class="data-select" data-id="{{ $data->id }}">{{ $data->phone }}</td>
                        <td class="data-select" data-id="{{ $data->id }}">{{ $data->company_rep1 }}</td>
                        <td class="data-select" data-id="{{ $data->id }}">{{ $data->business_address }}
                        </td>
                        <td class="data-select" data-id="{{ $data->id }}">{{ $data->business_city }}</td>
                        <td class="data-select" data-id="{{ $data->id }}">{{ $data->business_state }}</td>
                        <td class="data-select" data-id="{{ $data->id }}">{{ $data->business_zip }}</td>
                    </tr>


                    {{-- <tr>
                    <td>
                        <a href="#">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-pink mr-3">JR</div>

                                <div class="">
                                    <p class="font-weight-bold mb-0">Julie Richards</p>
                                    <p class="text-muted mb-0">julie_89@example.com</p>
                                </div>
                            </div>
                        </a>
                    </td>
                    <td> (937) 874 6878</td>
                    <td>Investment Banker</td>
                    <td>13/01/1989</td>
                    <td>
                        <div class="badge badge-success badge-success-alt">Enabled</div>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-icon" type="button" id="dropdownMenuButton2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-horizontal-rounded" data-toggle="tooltip"
                                    data-placement="top" title="Actions"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <a class="dropdown-item" href="#"><i class="bx bxs-pencil mr-2"></i>
                                    Edit
                                    Profile</a>
                                <a class="dropdown-item text-danger" href="#"><i
                                        class="bx bxs-trash mr-2"></i> Remove</a>
                            </div>
                        </div>
                    </td>
                </tr> --}}
                </tbody>
            </table>
        </div>
    </div>
    
@endsection
