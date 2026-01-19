@extends('backend.common.layout')
@section('css')
<style>
      .pagination nav {
            display: inline-block;
        }

        .pagination nav div {
            display: inline-block;
        }

        .pagination nav div span {
            display: inline-block;
            margin-top:10px;
        }

        .pagination nav div a {
            display: inline-block;
            font-size: 15px;
            min-width: 40px;
            width: auto;
            background-color: #004274 !important;
            color: white;
        }

        .pagination nav div p {
            display: none;
        }
</style>
@endsection
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
                            <div class="col-sm-3">
                                <div class="d-flex">
                                    <label for="startDate">Start Date:</label>
                                    <input type="date" id="startDate" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="d-flex">
                                    <label for="startDate">End Date:</label>
                                    <input type="date" id="endDate" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="">
                                    <button id="filterButton" class="btn btn-primary">Filter</button>
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
                                            <th class="sort" data-sort="phone">S.No.</th>
                                            <th class="sort" data-sort="name">Company Name</th>
                                            <th class="sort" data-sort="phone">Phone</th>
                                            <th class="sort" data-sort="company_name">Company Rep1</th>
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
                                            <tr class="data-select-cursor"  data-date="{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-y') }}">
                                                <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                        class="fw-medium link-primary">#VZ2101</a></td>
                                                <td class="text-center">
                                                    @php
                                                        echo $i;
                                                        $i++;
                                                    @endphp
                                                </td>
                                                <td class="data-select" data-id="{{ $data->id }}">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 ms-2 name">{{ $data->company_name }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="phone data-select" data-id="{{ $data->id }}">
                                                    {{ $data->phone }}</td>
                                                <td class="company_name data-select" data-id="{{ $data->id }}">
                                                    {{ $data->company_rep1 }}</td>
                                                <td class="location data-select" data-id="{{ $data->id }}">
                                                    {{ $data->business_address }}</td>
                                                <td class="location data-select" data-id="{{ $data->id }}">
                                                    {{ $data->business_city }}</td>
                                                <td class="location data-select" data-id="{{ $data->id }}">
                                                    {{ $data->business_state }}</td>
                                                <td class="phone data-select" data-id="{{ $data->id }}">
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
                                                        <div class="progress-bar bg-{{ $data->form_status === 'Intrested' ? 'success' : ($data->form_status === 'Pipeline' ? 'warning' : 'danger') }}"
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
                                                            <a class="dropdown-item"
                                                                href="{{ route('agent.change.form_status', [($data_id = $data->id), ($form_status = 'WON'), ($form_status_value = '100')]) }}">WON</a>
                                                        <a class="dropdown-item"
                                                                href="{{ route('agent.change.form_status', [($data_id = $data->id), ($form_status = 'DND'), ($form_status_value = '100')]) }}">DND</a>
                                                    </div>
                                                </td>
                                                <td class="date">
                                                    {{ \Carbon\Carbon::parse($data->updated_at)->format('d/m/y H:i:s') }}
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
                            <div class="d-flex justify-content-end mt-3 d-none">
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
                         <div class="pagination">
    {{ $datas->links() }}
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
            var baseUrl = "{{ asset('') }}";
            $('#showEditModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var userId = button.data('user-id'); // Extract user ID from data attribute

                // Make an AJAX request to fetch user data based on the user ID
                $.ajax({
                    url: '/admin/get/team/' + userId,
                    type: 'GET',
                    success: function(data) {
                        // Update modal fields with the fetched data
                        $('#id').val(data.id);
                        $('#name').val(data.name);
                        $('#image-input').val(''); // To clear the file input
                        $('#img').attr('src', baseUrl + data.profile);
                        $('#phone').val(data.phone);
                        $('#email').val(data.email);
                        $('.gender-radio[value="' + data.gender + '"]').prop('checked', true);
                        $('#designation').val(data.designation); // Corrected line
                    },
                    error: function(error) {
                        console.log('Error fetching user data:', error);
                    }
                });
            });

        });
    </script>
@endsection
