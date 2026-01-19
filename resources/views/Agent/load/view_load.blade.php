@extends('Agent.common.app')
@section('main')
    <style>
        .headings {
            display: flex;
            justify-content: space-around;
            margin-bottom: 10px;
        }

        .heading {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            cursor: pointer;
            width: 100px;
            /* Adjust this width as necessary */
        }

        .heading h2 {
            margin: 0;
            font-size: 1rem;
            text-align: center;
        }

        .arrow {
            font-size: 1.5rem;
        }

        .boxes {
            display: flex;
            justify-content: space-between;
            overflow: hidden;
        }

        .box {
            padding: 10px;
            background-color: #e0e0e0;
            border: 1px solid #ddd;
            display: none;
            flex: 1;
            box-sizing: border-box;
            transition: transform 0.3s ease-in-out;
        }

        .box p {
            margin: 0;
        }

        /* Different colors for each box */
        #box1 {
            background-color: #ffcccb;
        }

        #box2 {
            background-color: #add8e6;
        }

        #box3 {
            background-color: #90ee90;
        }

        #box4 {
            background-color: #ffd700;
        }

        #box5 {
            background-color: #d3d3d3;
        }

        #box6 {
            background-color: #ffa07a;
        }
    </style>
    <div class="page-wrapper">
        <div class="page-content">
             <!--add lead modal -->
    <div class="modal fade" id="exampleLargeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Lead</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('store_load_lead') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="firstNameinput" class="form-label">Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter name"
                                        id="company_name" name="name">
                                </div>
                            </div><!--end col-->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="lastNameinput" class="form-label">Company Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter Company Name"
                                        id="phone" name="company_name">
                                </div>
                            </div><!--end col-->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="firstNameinput" class="form-label">Dot <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter Dot"
                                        id="company_name" name="dot">
                                </div>
                            </div><!--end col-->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="lastNameinput" class="form-label">Mc No. <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter Mc No."
                                        id="phone" name="mc">
                                </div>
                            </div><!--end col-->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="lastNameinput" class="form-label">Phone No. <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" placeholder="Enter phone number"
                                        id="phone" name="phone">
                                </div>
                            </div><!--end col-->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="ForminputState" class="form-label">Load Category <span
                                            class="text-danger">*</span></label>
                                    <select id="unit_owned" class="form-select" name="category">
                                        <option selected="Incoming">Incoming</option>
                                        <option value="Insured">Insured</option>
                                        <option value="factoring">factoring</option>
                                        <option value="Load">Load</option>
                                        <option value="On Board">On Board</option>
                                        <option value="Roaster">Roaster</option>
                                    </select>
                                </div>
                            </div><!--end col-->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="file1" class="form-label">File/Pdf <span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="file1" name="file1">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="lastNameinput" class="form-label">File/Pdf <span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control" placeholder="Enter phone number"
                                        id="phone" name="file2">
                                </div>
                            </div><!--end col-->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="lastNameinput" class="form-label">File/Pdf <span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control" placeholder="Enter phone number"
                                        id="phone" name="file3">
                                </div>
                            </div><!--end col-->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="lastNameinput" class="form-label">File/Pdf <span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control" placeholder="Enter phone number"
                                        id="phone" name="file4">
                                </div>
                            </div><!--end col-->

                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label for="ForminputState" class="form-label">Information <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" height="500px" type="text" name="notepad" id="editor"></textarea>
                                </div>
                            </div><!--end col-->
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!--End lead modal -->
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Load</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Leads</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="javascript:;" class="btn btn-primary radius-30 mt-2 mt-lg-0" data-bs-toggle="modal"
                            data-bs-target="#exampleLargeModal"><i class="bx bxs-plus-square"></i>New Lead</a>
                    </div>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-6">
            <div class="col">
                <div class="card radius-10 border-start border-0 border-4 border-info">
                    <div class="card-body" id="incoming_box" style="cursor: pointer;">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Incoming</p>
                                <p class="mb-0 font-13">{{ $incomings->count() }} lead</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 border-start border-0 border-4 border-danger">
                    <div class="card-body" id="insured_box" style="cursor: pointer;">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Insured</p>

                                <p class="mb-0 font-13">{{ $insureds->count() }} lead</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 border-start border-0 border-4 border-success">
                    <div class="card-body" id="factoring_box" style="cursor: pointer;">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">factoring</p>

                                <p class="mb-0 font-13">{{ $factoings->count() }} leads</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 border-start border-0 border-4 border-warning">
                    <div class="card-body" id="load_box" style="cursor: pointer;">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Load</p>
                                <p class="mb-0 font-13">{{ $loads->count() }} leads</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 border-start border-0 border-4 border-warning">
                    <div class="card-body" id="board_box" style="cursor: pointer;">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">On Board</p>
                                <p class="mb-0 font-13">{{ $boards->count() }} leads</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 border-start border-0 border-4 border-warning">
                    <div class="card-body" id="roaster_box" style="cursor: pointer;">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Roaster</p>

                                <p class="mb-0 font-13">{{ $roasters->count() }} leads</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div><!--end row-->
        {{-- ================================incoming data ======================== --}}
        <div class="incoming" id="incoming_data" style="display: none;">
            <h5>Incoming</h5>
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Dot</th>
                            <th scope="col">Mc No.</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($incomings))
                            @php $a = 0; @endphp
                            @foreach ($incomings as $data)
                                @php $a++; @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td data-bs-toggle="modal" data-bs-target="#incomingmodal-{{ $data->id }}">
                                        {{ $data->company }}</td>
                                    <td>{{ $data->dot }}</td>
                                    <td>{{ $data->mc }}</td>
                                    <td>{{ $data->phone }}</td>
                                    <td>{{ $data->created_at }}</td>
                                    <td>
                                        <button class="delete-button"
                                            onclick="deleteLoadLead('{{ route('delete_load_leads', $data->id) }}')"
                                            style="  background-color: #ff4c4c;color:white;border:none ">Delete</button>
                                    </td>


                                </tr>
                                <!--add incoming modal -->
                                <div class="modal fade" id="incomingmodal-{{ $data->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Incoming Lead</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('store_load_lead') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="firstNameinput" class="form-label">Name <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter name" id="company_name"
                                                                    name="name" value="{{ $data->name }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">Company Name
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter Company Name" id="phone"
                                                                    name="company_name" value="{{ $data->company }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="firstNameinput" class="form-label">Dot <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter Dot" id="company_name"
                                                                    name="dot" value="{{ $data->dot }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">Mc No. <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter Mc No." id="phone"
                                                                    name="mc" value="{{ $data->mc }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">Phone No.
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="number" class="form-control"
                                                                    placeholder="Enter phone number" id="phone"
                                                                    name="phone" value="{{ $data->phone }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="ForminputState" class="form-label">Load
                                                                    Category <span class="text-danger">*</span></label>
                                                                <select id="unit_owned" class="form-select"
                                                                    name="category">
                                                                    <option value="Incoming"
                                                                        {{ $data['category'] == 'Incoming' ? 'selected' : '' }}>
                                                                        Incoming</option>
                                                                    <option value="Insured"
                                                                        {{ $data['category'] == 'Insured' ? 'selected' : '' }}>
                                                                        Insured</option>
                                                                    <option value="factoring"
                                                                        {{ $data['category'] == 'factoring' ? 'selected' : '' }}>
                                                                        factoring</option>
                                                                    <option value="Load"
                                                                        {{ $data['category'] == 'Load' ? 'selected' : '' }}>
                                                                        Load</option>
                                                                    <option value="On Board"
                                                                        {{ $data['category'] == 'On Board' ? 'selected' : '' }}>
                                                                        On Board</option>
                                                                    <option value="Roaster"
                                                                        {{ $data['category'] == 'Roaster' ? 'selected' : '' }}>
                                                                        Roaster</option>
                                                                </select>
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="file1" class="form-label">File/Pdf <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="file" class="form-control" id="file1"
                                                                    name="file1">
                                                            </div>
                                                            @if (!empty($data->file1))
                                                                <p>
                                                                    <a id="fileDownloadLink" target="_blank"
                                                                        href="{{ asset($data->file1) }}">Open File</a>
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">File/Pdf
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control"
                                                                    placeholder="Enter phone number" id="phone"
                                                                    name="file2">
                                                            </div>
                                                            @if (!empty($data->file2))
                                                                <p>
                                                                    <a id="fileDownloadLink" target="_blank"
                                                                        href="{{ asset($data->file2) }}">Open File</a>
                                                                </p>
                                                            @endif
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">File/Pdf
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control"
                                                                    placeholder="Enter phone number" id="phone"
                                                                    name="file3">
                                                            </div>
                                                            @if (!empty($data->file3))
                                                                <p>
                                                                    <a id="fileDownloadLink" target="_blank"
                                                                        href="{{ asset($data->file3) }}">Open File</a>
                                                                </p>
                                                            @endif
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">File/Pdf
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control"
                                                                    placeholder="Enter phone number" id="phone"
                                                                    name="file4">
                                                            </div>
                                                            @if (!empty($data->file4))
                                                                <p>
                                                                    <a id="fileDownloadLink" target="_blank"
                                                                        href="{{ asset($data->file4) }}">Open File</a>
                                                                </p>
                                                            @endif
                                                        </div><!--end col-->
                                                        <input type="hidden" name="id" value="{{$data->id}}">
                                                        <div class="col-sm-12">
                                                            <div class="mb-3">
                                                                <label for="ForminputState" class="form-label">Information
                                                                    <span class="text-danger">*</span></label>
                                                                <textarea class="form-control" height="500px" type="text" name="notepad" id="editor">{{ strip_tags($data->note) }}</textarea>
                                                            </div>
                                                        </div><!--end col-->
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--End incoming modal -->
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Dot</th>
                            <th scope="col">Mc No.</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- ================================insured data ======================== --}}
        <div class="insured" id="insured_data" style="display: none;">
            <h5>Insured</h5>
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Dot</th>
                            <th scope="col">Mc No.</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($insureds))
                            @php $a = 0; @endphp
                            @foreach ($insureds as $data)
                                @php $a++; @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td data-bs-toggle="modal" data-bs-target="#insuredgmodal-{{ $data->id }}">
                                        {{ $data->company }}</td>
                                    <td>{{ $data->dot }}</td>
                                    <td>{{ $data->mc }}</td>
                                    <td>{{ $data->phone }}</td>
                                    <td>{{ $data->created_at }}</td>
                                    <td>
                                        <button class="delete-button"
                                            onclick="deleteLoadLead('{{ route('delete_load_leads', $data->id) }}')"
                                            style="  background-color: #ff4c4c;color:white;border:none ">Delete</button>
                                    </td>


                                </tr>
                                <!--add incoming modal -->
                                <div class="modal fade" id="insuredgmodal-{{ $data->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Incoming Lead</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('store_load_lead') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="firstNameinput" class="form-label">Name <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter name" id="company_name"
                                                                    name="name" value="{{ $data->name }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">Company Name
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter Company Name" id="phone"
                                                                    name="company_name" value="{{ $data->company }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="firstNameinput" class="form-label">Dot <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter Dot" id="company_name"
                                                                    name="dot" value="{{ $data->dot }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">Mc No. <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter Mc No." id="phone"
                                                                    name="mc" value="{{ $data->mc }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">Phone No.
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="number" class="form-control"
                                                                    placeholder="Enter phone number" id="phone"
                                                                    name="phone" value="{{ $data->phone }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="ForminputState" class="form-label">Load
                                                                    Category <span class="text-danger">*</span></label>
                                                                <select id="unit_owned" class="form-select"
                                                                    name="category">
                                                                    <option value="Incoming"
                                                                        {{ $data['category'] == 'Incoming' ? 'selected' : '' }}>
                                                                        Incoming</option>
                                                                    <option value="Insured"
                                                                        {{ $data['category'] == 'Insured' ? 'selected' : '' }}>
                                                                        Insured</option>
                                                                    <option value="factoring"
                                                                        {{ $data['category'] == 'factoring' ? 'selected' : '' }}>
                                                                        factoring</option>
                                                                    <option value="Load"
                                                                        {{ $data['category'] == 'Load' ? 'selected' : '' }}>
                                                                        Load</option>
                                                                    <option value="On Board"
                                                                        {{ $data['category'] == 'On Board' ? 'selected' : '' }}>
                                                                        On Board</option>
                                                                    <option value="Roaster"
                                                                        {{ $data['category'] == 'Roaster' ? 'selected' : '' }}>
                                                                        Roaster</option>
                                                                </select>
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="file1" class="form-label">File/Pdf <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="file" class="form-control" id="file1"
                                                                    name="file1">
                                                            </div>
                                                            @if (!empty($data->file1))
                                                                <p>
                                                                    <a id="fileDownloadLink" target="_blank"
                                                                        href="{{ asset($data->file1) }}">Open File</a>
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">File/Pdf
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control"
                                                                    placeholder="Enter phone number" id="phone"
                                                                    name="file2">
                                                            </div>
                                                            @if (!empty($data->file2))
                                                                <p>
                                                                    <a id="fileDownloadLink" target="_blank"
                                                                        href="{{ asset($data->file2) }}">Open File</a>
                                                                </p>
                                                            @endif
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">File/Pdf
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control"
                                                                    placeholder="Enter phone number" id="phone"
                                                                    name="file3">
                                                            </div>
                                                            @if (!empty($data->file3))
                                                                <p>
                                                                    <a id="fileDownloadLink" target="_blank"
                                                                        href="{{ asset($data->file3) }}">Open File</a>
                                                                </p>
                                                            @endif
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">File/Pdf
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control"
                                                                    placeholder="Enter phone number" id="phone"
                                                                    name="file4">
                                                            </div>
                                                            @if (!empty($data->file4))
                                                                <p>
                                                                    <a id="fileDownloadLink" target="_blank"
                                                                        href="{{ asset($data->file4) }}">Open File</a>
                                                                </p>
                                                            @endif
                                                        </div><!--end col-->
                                                        <input type="hidden" name="id" value="{{$data->id}}">
                                                        <div class="col-sm-12">
                                                            <div class="mb-3">
                                                                <label for="ForminputState" class="form-label">Information
                                                                    <span class="text-danger">*</span></label>
                                                                <textarea class="form-control" height="500px" type="text" name="notepad" id="editor">{{ strip_tags($data->note) }}</textarea>
                                                            </div>
                                                        </div><!--end col-->
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--End incoming modal -->
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Dot</th>
                            <th scope="col">Mc No.</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- ================================factoring data ======================== --}}
        <div class="factoring" id="factoring_data" style="display: none;">
            <h5>Factoring</h5>
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Dot</th>
                            <th scope="col">Mc No.</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($factoings))
                            @php $a = 0; @endphp
                            @foreach ($factoings as $data)
                                @php $a++; @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td data-bs-toggle="modal" data-bs-target="#insuredgmodal-{{ $data->id }}">
                                        {{ $data->company }}</td>
                                    <td>{{ $data->dot }}</td>
                                    <td>{{ $data->mc }}</td>
                                    <td>{{ $data->phone }}</td>
                                    <td>{{ $data->created_at }}</td>
                                    <td>
                                        <button class="delete-button"
                                            onclick="deleteLoadLead('{{ route('delete_load_leads', $data->id) }}')"
                                            style="  background-color: #ff4c4c;color:white;border:none ">Delete</button>
                                    </td>


                                </tr>
                                <!--add incoming modal -->
                                <div class="modal fade" id="insuredgmodal-{{ $data->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Incoming Lead</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('store_load_lead') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="firstNameinput" class="form-label">Name <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter name" id="company_name"
                                                                    name="name" value="{{ $data->name }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">Company Name
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter Company Name" id="phone"
                                                                    name="company_name" value="{{ $data->company }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="firstNameinput" class="form-label">Dot <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter Dot" id="company_name"
                                                                    name="dot" value="{{ $data->dot }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">Mc No. <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter Mc No." id="phone"
                                                                    name="mc" value="{{ $data->mc }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">Phone No.
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="number" class="form-control"
                                                                    placeholder="Enter phone number" id="phone"
                                                                    name="phone" value="{{ $data->phone }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="ForminputState" class="form-label">Load
                                                                    Category <span class="text-danger">*</span></label>
                                                                <select id="unit_owned" class="form-select"
                                                                    name="category">
                                                                    <option value="Incoming"
                                                                        {{ $data['category'] == 'Incoming' ? 'selected' : '' }}>
                                                                        Incoming</option>
                                                                    <option value="Insured"
                                                                        {{ $data['category'] == 'Insured' ? 'selected' : '' }}>
                                                                        Insured</option>
                                                                    <option value="factoring"
                                                                        {{ $data['category'] == 'factoring' ? 'selected' : '' }}>
                                                                        factoring</option>
                                                                    <option value="Load"
                                                                        {{ $data['category'] == 'Load' ? 'selected' : '' }}>
                                                                        Load</option>
                                                                    <option value="On Board"
                                                                        {{ $data['category'] == 'On Board' ? 'selected' : '' }}>
                                                                        On Board</option>
                                                                    <option value="Roaster"
                                                                        {{ $data['category'] == 'Roaster' ? 'selected' : '' }}>
                                                                        Roaster</option>
                                                                </select>
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="file1" class="form-label">File/Pdf <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="file" class="form-control" id="file1"
                                                                    name="file1">
                                                            </div>
                                                            @if (!empty($data->file1))
                                                                <p>
                                                                    <a id="fileDownloadLink" target="_blank"
                                                                        href="{{ asset($data->file1) }}">Open File</a>
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">File/Pdf
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control"
                                                                    placeholder="Enter phone number" id="phone"
                                                                    name="file2">
                                                            </div>
                                                            @if (!empty($data->file2))
                                                                <p>
                                                                    <a id="fileDownloadLink" target="_blank"
                                                                        href="{{ asset($data->file2) }}">Open File</a>
                                                                </p>
                                                            @endif
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">File/Pdf
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control"
                                                                    placeholder="Enter phone number" id="phone"
                                                                    name="file3">
                                                            </div>
                                                            @if (!empty($data->file3))
                                                                <p>
                                                                    <a id="fileDownloadLink" target="_blank"
                                                                        href="{{ asset($data->file3) }}">Open File</a>
                                                                </p>
                                                            @endif
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">File/Pdf
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control"
                                                                    placeholder="Enter phone number" id="phone"
                                                                    name="file4">
                                                            </div>
                                                            @if (!empty($data->file4))
                                                                <p>
                                                                    <a id="fileDownloadLink" target="_blank"
                                                                        href="{{ asset($data->file4) }}">Open File</a>
                                                                </p>
                                                            @endif
                                                        </div><!--end col-->
                                                        <input type="hidden" name="id" value="{{$data->id}}">
                                                        <div class="col-sm-12">
                                                            <div class="mb-3">
                                                                <label for="ForminputState" class="form-label">Information
                                                                    <span class="text-danger">*</span></label>
                                                                <textarea class="form-control" height="500px" type="text" name="notepad" id="editor">{{ strip_tags($data->note) }}</textarea>
                                                            </div>
                                                        </div><!--end col-->
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--End incoming modal -->
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Dot</th>
                            <th scope="col">Mc No.</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- ================================load data ======================== --}}
        <div class="load" id="load_data" style="display: none;">
            <h5>Load</h5>
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Dot</th>
                            <th scope="col">Mc No.</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($loads))
                            @php $a = 0; @endphp
                            @foreach ($loads as $data)
                                @php $a++; @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td data-bs-toggle="modal" data-bs-target="#insuredgmodal-{{ $data->id }}">
                                        {{ $data->company }}</td>
                                    <td>{{ $data->dot }}</td>
                                    <td>{{ $data->mc }}</td>
                                    <td>{{ $data->phone }}</td>
                                    <td>{{ $data->created_at }}</td>
                                    <td>
                                        <button class="delete-button"
                                            onclick="deleteLoadLead('{{ route('delete_load_leads', $data->id) }}')"
                                            style="  background-color: #ff4c4c;color:white;border:none ">Delete</button>
                                    </td>


                                </tr>
                                <!--add incoming modal -->
                                <div class="modal fade" id="insuredgmodal-{{ $data->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Incoming Lead</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('store_load_lead') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="firstNameinput" class="form-label">Name <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter name" id="company_name"
                                                                    name="name" value="{{ $data->name }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">Company Name
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter Company Name" id="phone"
                                                                    name="company_name" value="{{ $data->company }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="firstNameinput" class="form-label">Dot <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter Dot" id="company_name"
                                                                    name="dot" value="{{ $data->dot }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">Mc No. <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter Mc No." id="phone"
                                                                    name="mc" value="{{ $data->mc }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">Phone No.
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="number" class="form-control"
                                                                    placeholder="Enter phone number" id="phone"
                                                                    name="phone" value="{{ $data->phone }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="ForminputState" class="form-label">Load
                                                                    Category <span class="text-danger">*</span></label>
                                                                <select id="unit_owned" class="form-select"
                                                                    name="category">
                                                                    <option value="Incoming"
                                                                        {{ $data['category'] == 'Incoming' ? 'selected' : '' }}>
                                                                        Incoming</option>
                                                                    <option value="Insured"
                                                                        {{ $data['category'] == 'Insured' ? 'selected' : '' }}>
                                                                        Insured</option>
                                                                    <option value="factoring"
                                                                        {{ $data['category'] == 'factoring' ? 'selected' : '' }}>
                                                                        factoring</option>
                                                                    <option value="Load"
                                                                        {{ $data['category'] == 'Load' ? 'selected' : '' }}>
                                                                        Load</option>
                                                                    <option value="On Board"
                                                                        {{ $data['category'] == 'On Board' ? 'selected' : '' }}>
                                                                        On Board</option>
                                                                    <option value="Roaster"
                                                                        {{ $data['category'] == 'Roaster' ? 'selected' : '' }}>
                                                                        Roaster</option>
                                                                </select>
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="file1" class="form-label">File/Pdf <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="file" class="form-control" id="file1"
                                                                    name="file1">
                                                            </div>
                                                            @if (!empty($data->file1))
                                                                <p>
                                                                    <a id="fileDownloadLink" target="_blank"
                                                                        href="{{ asset($data->file1) }}">Open File</a>
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">File/Pdf
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control"
                                                                    placeholder="Enter phone number" id="phone"
                                                                    name="file2">
                                                            </div>
                                                            @if (!empty($data->file2))
                                                                <p>
                                                                    <a id="fileDownloadLink" target="_blank"
                                                                        href="{{ asset($data->file2) }}">Open File</a>
                                                                </p>
                                                            @endif
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">File/Pdf
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control"
                                                                    placeholder="Enter phone number" id="phone"
                                                                    name="file3">
                                                            </div>
                                                            @if (!empty($data->file3))
                                                                <p>
                                                                    <a id="fileDownloadLink" target="_blank"
                                                                        href="{{ asset($data->file3) }}">Open File</a>
                                                                </p>
                                                            @endif
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">File/Pdf
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control"
                                                                    placeholder="Enter phone number" id="phone"
                                                                    name="file4">
                                                            </div>
                                                            @if (!empty($data->file4))
                                                                <p>
                                                                    <a id="fileDownloadLink" target="_blank"
                                                                        href="{{ asset($data->file4) }}">Open File</a>
                                                                </p>
                                                            @endif
                                                        </div><!--end col-->
                                                        <input type="hidden" name="id" value="{{$data->id}}">
                                                        <div class="col-sm-12">
                                                            <div class="mb-3">
                                                                <label for="ForminputState" class="form-label">Information
                                                                    <span class="text-danger">*</span></label>
                                                                <textarea class="form-control" height="500px" type="text" name="notepad" id="editor">{{ strip_tags($data->note) }}</textarea>
                                                            </div>
                                                        </div><!--end col-->
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--End incoming modal -->
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Dot</th>
                            <th scope="col">Mc No.</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- ================================board data ======================== --}}
        <div class="board" id="board_data" style="display: none;">
            <h5>On Board</h5>
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Dot</th>
                            <th scope="col">Mc No.</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($boards))
                            @php $a = 0; @endphp
                            @foreach ($boards as $data)
                                @php $a++; @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td data-bs-toggle="modal" data-bs-target="#insuredgmodal-{{ $data->id }}">
                                        {{ $data->company }}</td>
                                    <td>{{ $data->dot }}</td>
                                    <td>{{ $data->mc }}</td>
                                    <td>{{ $data->phone }}</td>
                                    <td>{{ $data->created_at }}</td>
                                    <td>
                                        <button class="delete-button"
                                            onclick="deleteLoadLead('{{ route('delete_load_leads', $data->id) }}')"
                                            style="  background-color: #ff4c4c;color:white;border:none ">Delete</button>
                                    </td>

                                </tr>
                                <!--add incoming modal -->
                                <div class="modal fade" id="insuredgmodal-{{ $data->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Incoming Lead</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('store_load_lead') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="firstNameinput" class="form-label">Name <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter name" id="company_name"
                                                                    name="name" value="{{ $data->name }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">Company Name
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter Company Name" id="phone"
                                                                    name="company_name" value="{{ $data->company }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="firstNameinput" class="form-label">Dot <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter Dot" id="company_name"
                                                                    name="dot" value="{{ $data->dot }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">Mc No. <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter Mc No." id="phone"
                                                                    name="mc" value="{{ $data->mc }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">Phone No.
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="number" class="form-control"
                                                                    placeholder="Enter phone number" id="phone"
                                                                    name="phone" value="{{ $data->phone }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="ForminputState" class="form-label">Load
                                                                    Category <span class="text-danger">*</span></label>
                                                                <select id="unit_owned" class="form-select"
                                                                    name="category">
                                                                    <option value="Incoming"
                                                                        {{ $data['category'] == 'Incoming' ? 'selected' : '' }}>
                                                                        Incoming</option>
                                                                    <option value="Insured"
                                                                        {{ $data['category'] == 'Insured' ? 'selected' : '' }}>
                                                                        Insured</option>
                                                                    <option value="factoring"
                                                                        {{ $data['category'] == 'factoring' ? 'selected' : '' }}>
                                                                        factoring</option>
                                                                    <option value="Load"
                                                                        {{ $data['category'] == 'Load' ? 'selected' : '' }}>
                                                                        Load</option>
                                                                    <option value="On Board"
                                                                        {{ $data['category'] == 'On Board' ? 'selected' : '' }}>
                                                                        On Board</option>
                                                                    <option value="Roaster"
                                                                        {{ $data['category'] == 'Roaster' ? 'selected' : '' }}>
                                                                        Roaster</option>
                                                                </select>
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="file1" class="form-label">File/Pdf <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="file" class="form-control" id="file1"
                                                                    name="file1">
                                                            </div>
                                                            @if (!empty($data->file1))
                                                                <p>
                                                                    <a id="fileDownloadLink" target="_blank"
                                                                        href="{{ asset($data->file1) }}">Open File</a>
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">File/Pdf
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control"
                                                                    placeholder="Enter phone number" id="phone"
                                                                    name="file2">
                                                            </div>
                                                            @if (!empty($data->file2))
                                                                <p>
                                                                    <a id="fileDownloadLink" target="_blank"
                                                                        href="{{ asset($data->file2) }}">Open File</a>
                                                                </p>
                                                            @endif
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">File/Pdf
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control"
                                                                    placeholder="Enter phone number" id="phone"
                                                                    name="file3">
                                                            </div>
                                                            @if (!empty($data->file3))
                                                                <p>
                                                                    <a id="fileDownloadLink" target="_blank"
                                                                        href="{{ asset($data->file3) }}">Open File</a>
                                                                </p>
                                                            @endif
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">File/Pdf
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control"
                                                                    placeholder="Enter phone number" id="phone"
                                                                    name="file4">
                                                            </div>
                                                            @if (!empty($data->file4))
                                                                <p>
                                                                    <a id="fileDownloadLink" target="_blank"
                                                                        href="{{ asset($data->file4) }}">Open File</a>
                                                                </p>
                                                            @endif
                                                        </div><!--end col-->
                                                        <input type="hidden" name="id" value="{{$data->id}}">
                                                        <div class="col-sm-12">
                                                            <div class="mb-3">
                                                                <label for="ForminputState" class="form-label">Information
                                                                    <span class="text-danger">*</span></label>
                                                                <textarea class="form-control" height="500px" type="text" name="notepad" id="editor">{{ strip_tags($data->note) }}</textarea>
                                                            </div>
                                                        </div><!--end col-->
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--End incoming modal -->
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Dot</th>
                            <th scope="col">Mc No.</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        {{-- ================================roaster data ======================== --}}
        <div class="roaster" id="roaster_data" style="display: none;">
            <h5>Roaster</h5>
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Dot</th>
                            <th scope="col">Mc No.</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($roasters))
                            @php $a = 0; @endphp
                            @foreach ($roasters as $data)
                                @php $a++; @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td data-bs-toggle="modal" data-bs-target="#insuredgmodal-{{ $data->id }}">
                                        {{ $data->company }}</td>
                                    <td>{{ $data->dot }}</td>
                                    <td>{{ $data->mc }}</td>
                                    <td>{{ $data->phone }}</td>
                                    <td>{{ $data->created_at }}</td>
                                    <td>
                                        <button class="delete-button"
                                            onclick="deleteLoadLead('{{ route('delete_load_leads', $data->id) }}')"
                                            style="  background-color: #ff4c4c;color:white;border:none ">Delete</button>
                                    </td>


                                </tr>
                                <!--add incoming modal -->
                                <div class="modal fade" id="insuredgmodal-{{ $data->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Incoming Lead</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('store_load_lead') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="firstNameinput" class="form-label">Name
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter name" id="company_name"
                                                                    name="name" value="{{ $data->name }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">Company
                                                                    Name
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter Company Name" id="phone"
                                                                    name="company_name" value="{{ $data->company }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="firstNameinput" class="form-label">Dot <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter Dot" id="company_name"
                                                                    name="dot" value="{{ $data->dot }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">Mc No.
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter Mc No." id="phone"
                                                                    name="mc" value="{{ $data->mc }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">Phone No.
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="number" class="form-control"
                                                                    placeholder="Enter phone number" id="phone"
                                                                    name="phone" value="{{ $data->phone }}">
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="ForminputState" class="form-label">Load
                                                                    Category <span class="text-danger">*</span></label>
                                                                <select id="unit_owned" class="form-select"
                                                                    name="category">
                                                                    <option value="Incoming"
                                                                        {{ $data['category'] == 'Incoming' ? 'selected' : '' }}>
                                                                        Incoming</option>
                                                                    <option value="Insured"
                                                                        {{ $data['category'] == 'Insured' ? 'selected' : '' }}>
                                                                        Insured</option>
                                                                    <option value="factoring"
                                                                        {{ $data['category'] == 'factoring' ? 'selected' : '' }}>
                                                                        factoring</option>
                                                                    <option value="Load"
                                                                        {{ $data['category'] == 'Load' ? 'selected' : '' }}>
                                                                        Load</option>
                                                                    <option value="On Board"
                                                                        {{ $data['category'] == 'On Board' ? 'selected' : '' }}>
                                                                        On Board</option>
                                                                    <option value="Roaster"
                                                                        {{ $data['category'] == 'Roaster' ? 'selected' : '' }}>
                                                                        Roaster</option>
                                                                </select>
                                                            </div>
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="file1" class="form-label">File/Pdf <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="file" class="form-control"
                                                                    id="file1" name="file1">
                                                            </div>
                                                            @if (!empty($data->file1))
                                                                <p>
                                                                    <a id="fileDownloadLink" target="_blank"
                                                                        href="{{ asset($data->file1) }}">Open File</a>
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">File/Pdf
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control"
                                                                    placeholder="Enter phone number" id="phone"
                                                                    name="file2">
                                                            </div>
                                                            @if (!empty($data->file2))
                                                                <p>
                                                                    <a id="fileDownloadLink" target="_blank"
                                                                        href="{{ asset($data->file2) }}">Open File</a>
                                                                </p>
                                                            @endif
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">File/Pdf
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control"
                                                                    placeholder="Enter phone number" id="phone"
                                                                    name="file3">
                                                            </div>
                                                            @if (!empty($data->file3))
                                                                <p>
                                                                    <a id="fileDownloadLink" target="_blank"
                                                                        href="{{ asset($data->file3) }}">Open File</a>
                                                                </p>
                                                            @endif
                                                        </div><!--end col-->
                                                        <div class="col-sm-6">
                                                            <div class="mb-3">
                                                                <label for="lastNameinput" class="form-label">File/Pdf
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control"
                                                                    placeholder="Enter phone number" id="phone"
                                                                    name="file4">
                                                            </div>
                                                            @if (!empty($data->file4))
                                                                <p>
                                                                    <a id="fileDownloadLink" target="_blank"
                                                                        href="{{ asset($data->file4) }}">Open File</a>
                                                                </p>
                                                            @endif
                                                        </div><!--end col-->
                                                        <input type="hidden" name="id" value="{{$data->id}}">
                                                        <div class="col-sm-12">
                                                            <div class="mb-3">
                                                                <label for="ForminputState"
                                                                    class="form-label">Information
                                                                    <span class="text-danger">*</span></label>
                                                                <textarea class="form-control" height="500px" type="text" name="notepad" id="editor">{{ strip_tags($data->note) }}</textarea>
                                                            </div>
                                                        </div><!--end col-->
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--End incoming modal -->
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Dot</th>
                            <th scope="col">Mc No.</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!--end page content -->
    </div>
   
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        function closeAllBoxes() {
            var boxes = ['incoming_data', 'insured_data', 'factoring_data', 'load_data', 'board_data', 'roaster_data'];
            boxes.forEach(function(box) {
                document.getElementById(box).style.display = 'none';
            });
        }

        document.getElementById('incoming_box').addEventListener('click', function() {
            closeAllBoxes();
            var incomingData = document.getElementById('incoming_data');
            incomingData.style.display = 'block';
        });

        document.getElementById('insured_box').addEventListener('click', function() {
            closeAllBoxes();
            var insuredData = document.getElementById('insured_data');
            insuredData.style.display = 'block';
        });

        document.getElementById('factoring_box').addEventListener('click', function() {
            closeAllBoxes();
            var factoringData = document.getElementById('factoring_data');
            factoringData.style.display = 'block';
        });

        document.getElementById('load_box').addEventListener('click', function() {
            closeAllBoxes();
            var loadData = document.getElementById('load_data');
            loadData.style.display = 'block';
        });

        document.getElementById('board_box').addEventListener('click', function() {
            closeAllBoxes();
            var boardData = document.getElementById('board_data');
            boardData.style.display = 'block';
        });

        document.getElementById('roaster_box').addEventListener('click', function() {
            closeAllBoxes();
            var roasterData = document.getElementById('roaster_data');
            roasterData.style.display = 'block';
        });
    </script>
    <script>
        function deleteLoadLead(url) {
            if (confirm('Are you sure you want to delete this lead?')) {
                window.location.href = url;
            }
        }
    </script>
@endsection
