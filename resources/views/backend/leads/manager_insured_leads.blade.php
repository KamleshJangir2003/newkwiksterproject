@extends('backend.common.layout')
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Incoming Leads</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                        <li class="breadcrumb-item active">Incoming Leads</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
    <form action="{{ route('manager.fwd.data.agent') }}" method="post">
        @csrf
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
                                    <button class="btn btn-soft-danger" id="remove-actions" data-bs-toggle="modal"
                                        type="button"><i class="ri-delete-bin-2-line"></i></button>
                                    <button type="button" class="btn btn-info" data-bs-toggle="offcanvas"
                                        href="#offcanvasExample" id="forwardButton"><i
                                            class="ri-filter-3-line align-bottom me-1"></i>
                                        Forward</button>
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
                                            <th scope="col" style="width: 50px;">
                                                <div class="form-check">
                                                    <input class="form-check-input data-checkbox" type="checkbox"
                                                        id="checkAll" value="option">
                                                </div>
                                            </th>
                                            <th class="sort" data-sort="phone">S.No.</th>
                                            <th class="sort" data-sort="name">Name</th>
                                            <th class="sort" data-sort="name">Company Name</th>
                                            <th class="sort" data-sort="phone">Phone</th>
                                            <th class="sort" data-sort="company_name">Company Rep1</th>
                                            <th class="sort" data-sort="leads_score">Insured Date</th>
                                            <th class="sort" data-sort="location">Business Address</th>
                                            <th class="sort" data-sort="name">Business City</th>
                                            <th class="sort" data-sort="name">Business State</th>
                                            <th class="sort" data-sort="name">Business Zip</th>
                                            {{-- <th class="sort" data-sort="name">Dot</th>
                                            <th class="sort" data-sort="name">Mc/Docket</th> --}}
                                            <th class="sort" data-sort="date">Status</th>
                                            <th class="sort" data-sort="date">Created Date</th>
                                            <th class="sort" data-sort="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($datas as $data)
                                            <tr class="data-select-cursor">
                                                <th scope="row">
                                                    <div class="form-check">
                                                        <input class="form-check-input data-checkbox" type="checkbox"
                                                            name="data_id[]" value="{{ $data->id }}">
                                                    </div>
                                                </th>
                                                <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                        class="fw-medium link-primary">#VZ2101</a></td>
                                                <td class="text-center">
                                                    @php
                                                        echo $i;
                                                        $i++;
                                                    @endphp
                                                </td>
                                                <td>
                                                    @if ($data->click_id == auth()->user()->id)
                                                        {{ auth()->user()->name }}<br><span
                                                            class="badge bg-primary bg-primary-subtle text-primary">Manager</span>
                                                    @else
                                                        {{ $data->agent->name }}<br><span
                                                            class="badge bg-success bg-success-subtle text-success">Agent</span>
                                                    @endif
                                                </td>
                                                <td data-bs-toggle="modal" data-bs-target="#newlead">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 ms-2 name">{{ $data->company_name }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="phone">
                                                    {{ $data->phone }}</td>
                                                <td class="company_name">
                                                    {{ $data->company_rep1 }}</td>
                                                <td class="leads_score">
                                                    {{ \Carbon\Carbon::parse($data->insured_date)->format('d M, Y') }}</td>
                                                <td class="location">
                                                    {{ $data->business_address }}</td>
                                                <td class="location">
                                                    {{ $data->business_city }}</td>
                                                <td class="location">
                                                    {{ $data->business_state }}</td>
                                                <td class="phone">
                                                    {{ $data->business_zip }}</td>
                                                {{-- <td class="phone">{{ $data->dot }}</td>
                                                <td class="phone">{{ $data->mc_docket }}</td> --}}
                                                {{-- <td class="tags">
                                            <span class="badge bg-primary-subtle text-primary">Lead</span>
                                            <span class="badge bg-primary-subtle text-primary">Partner</span>
                                        </td> --}}

                                                <td style="width: 150px;" class="dropdown">
                                                    {{ $data->form_status }}
                                                    <div class="progress animated-progress custom-progress mb-4"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                        aria-expanded="false" style="cursor:pointer;">
                                                        <div class="progress-bar bg-{{ $data->form_status === 'Intrested' ? 'success' : ($data->form_status === 'Pipeline' ? 'warning' : ($data->form_status === 'Insured' ? 'primary' : 'danger')) }}"
                                                            role="progressbar"
                                                            style="width: {{ $data->form_status_value }}%"
                                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        </div>

                                                    </div>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item"
                                                            href="{{ route('agent.change.form_status', [($data_id = $data->id), ($form_status = 'Voice Mail'), ($form_status_value = '100')]) }}">Voice
                                                            Mail</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('agent.change.form_status', [($data_id = $data->id), ($form_status = 'Not Intrested'), ($form_status_value = '100')]) }}">Not
                                                            Intrested</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('agent.change.form_status', [($data_id = $data->id), ($form_status = 'Not Connected'), ($form_status_value = '100')]) }}">Not
                                                            Connected</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('agent.change.form_status', [($data_id = $data->id), ($form_status = 'Wrong Number'), ($form_status_value = '100')]) }}">Wrong
                                                            Number</a>
                                                    </div>
                                                </td>
                                                <td class="date">
                                                    {{ \Carbon\Carbon::parse($data->created_at)->format('d M, Y') }}
                                                </td>
                                                <td>
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        <li class="list-inline-item edit btn btn-success"
                                                            data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                            data-bs-placement="top" title="Call">
                                                            <a href="tel:{{ $data->phone }}"
                                                                class="text-white d-inline-block">
                                                                <i class="ri-phone-line fs-16"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
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

                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample"
                                aria-labelledby="offcanvasExampleLabel">
                                <div class="offcanvas-header bg-light">
                                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Leads Forward</h5>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <!--end offcanvas-header-->

                                <div class="offcanvas-body">
                                    <div class="mb-4">
                                        <label for="status-select"
                                            class="form-label text-muted text-uppercase fw-semibold mb-3">Agents</label>
                                        <div class="row g-2">
                                            @foreach ($agents as $agent)
                                                <div class="col-lg-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="agent_id[]"
                                                            value="{{ $agent->id }}">
                                                        <label class="form-check-label"
                                                            for="inlineCheckbox1">{{ $agent->name }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!--end offcanvas-body-->
                                <div class="offcanvas-footer border-top p-3 text-center hstack gap-2">
                                    <button class="btn btn-light w-100" type="reset">Clear</button>
                                    <button type="submit" class="btn btn-primary w-100"><i
                                            class='bx bx-paper-plane'></i>
                                        Send</button>
                                </div>
                                <!--end offcanvas-footer-->
                            </div>
                            <!--end offcanvas-->
                        </div>
                    </div>
                </div>

            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </form>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#forwardButton').hide();

            $('.data-checkbox').on('change', function() {

                var atLeastOneChecked = $('.data-checkbox:checked').length > 0;

                if (atLeastOneChecked) {
                    $('#forwardButton').show();
                } else {
                    $('#forwardButton').hide();
                }
            });
            $('.selectAll').on('change', function() {

                var atLeastOneChecked = $('.data-checkbox:checked').length > 0;


                if (atLeastOneChecked) {
                    $('#forwardButton').show();
                } else {
                    $('#forwardButton').hide();
                }
            });
        });
    </script>

    {{-- Bulk Delete --}}
    <script>
        $(document).ready(function() {
            // When the remove-actions button is clicked
            $("#remove-actions").on("click", function() {
                // Create an array to store the selected data IDs
                var selectedDataIds = [];

                // Iterate through each checked checkbox
                $(".data-checkbox:checked").each(function() {
                    // Get the value (data ID) of the checked checkbox
                    var dataId = $(this).val();

                    // Push the data ID to the array
                    selectedDataIds.push(dataId);
                });

                // Check if any checkboxes are selected
                if (selectedDataIds.length > 0) {
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    // Perform AJAX request to delete the selected items
                    $.ajax({
                        url: "/bulk/delete/leads",
                        type: "POST",
                        data: {
                            _token: csrfToken,
                            data_ids: selectedDataIds
                        }, // Send the selected data IDs to the server
                        success: function(response) {

                            console.log(response);
                            window.location.reload();

                        },
                        error: function(error) {
                            // Handle the error response from the server
                            console.error(error);
                        }
                    });
                } else {
                    // No checkboxes are selected, handle this case as needed
                    alert("Please select at least one item to delete.");
                }
            });
        });
    </script>
@endsection
