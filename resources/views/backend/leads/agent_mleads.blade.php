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
                                                <td class="masterdata-select" data-id="{{ $data->id }}">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 ms-2 name">{{ $data->company_name }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="phone masterdata-select" data-id="{{ $data->id }}">
                                                    {{ $data->phone }}</td>
                                                <td class="company_name data-select" data-id="{{ $data->id }}">
                                                    {{ $data->company_rep1 }}</td>
                                                <td class="location masterdata-select" data-id="{{ $data->id }}">
                                                    {{ $data->business_address }}</td>
                                                <td class="location masterdata-select" data-id="{{ $data->id }}">
                                                    {{ $data->business_city }}</td>
                                                <td class="location masterdata-select" data-id="{{ $data->id }}">
                                                    {{ $data->business_state }}</td>
                                                <td class="phone masterdata-select" data-id="{{ $data->id }}">
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
                                                    <!--<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">-->
                                                    <!--    <a class="dropdown-item"-->
                                                    <!--        href="{{ route('agent.change.form_status', [($data_id = $data->id), ($form_status = 'Voice Mail'), ($form_status_value = '100')]) }}">Voice-->
                                                    <!--        Mail</a>-->
                                                    <!--    <a class="dropdown-item"-->
                                                    <!--        href="{{ route('agent.change.form_status', [($data_id = $data->id), ($form_status = 'Not Intrested'), ($form_status_value = '100')]) }}">Not-->
                                                    <!--        Intrested</a>-->
                                                    <!--    <a class="dropdown-item"-->
                                                    <!--        href="{{ route('agent.change.form_status', [($data_id = $data->id), ($form_status = 'Not Connected'), ($form_status_value = '100')]) }}">Not-->
                                                    <!--        Connected</a>-->
                                                    <!--    <a class="dropdown-item"-->
                                                    <!--        href="{{ route('agent.change.form_status', [($data_id = $data->id), ($form_status = 'Wrong Number'), ($form_status_value = '100')]) }}">Wrong-->
                                                    <!--        Number</a>-->
                                                    <!--</div>-->
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
    
    <!--Master File Data Start-->
<script>
    $(document).ready(function() {
        $('.masterdata-select').on('click', function() {
            var dataId = $(this).data('id');

            // Make an AJAX request to fetch data based on the data ID
            $.ajax({
                url: '/get/masterfile/data/' + dataId, // Replace with your actual API endpoint
                type: 'GET',
                success: function(data) {
                    // Update modal content with fetched data
                    updateModal(data);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        function updateModal(data) {
            // Check if data is defined
            if (!data) {
                console.error('Data is undefined');
                return;
            }

            // Update modal content with the fetched data 
            $('#data_id1').val(data.id);
            $('#company_name1').val(data.company_name);
            $('#phone1').val(data.phone);
            $('#email1').val(data.email);
            $('#company_rep11').val(data.company_rep1);
            $('#business_address1').val(data.business_address);
            $('#business_city1').val(data.business_city);
            $('#business_state1').val(data.business_state);
            $('#business_zip1').val(data.business_zip);
            $('#dot1').val(data.dot);
            $('#mc_docket1').val(data.mc_docket);

            // Set the selected option for form_status and unit_owned
            $('#form_status1').val(data.form_status).prop('selected', true);
            $('#reminder1').val(data.reminder);

            $('#unit_owned1').val(data.unit_owned).prop('selected', true);
            // Open
            var value = data.unit_owned;
            if (value == '2') {
                $('.unit2').show();
                $('.unit3').hide();
                $('.unit4').hide();
                $('.unit5').hide();
            } else if (value == '3') {
                $('.unit2').show();
                $('.unit3').show();
                $('.unit4').hide();
                $('.unit5').hide();
            } else if (value == '4') {
                $('.unit2').show();
                $('.unit3').show();
                $('.unit4').show();
                $('.unit5').hide();
            } else if (value == '5') {
                $('.unit2').show();
                $('.unit3').show();
                $('.unit4').show();
                $('.unit5').show();
            } else if (value == '1') {
                $('.unit2').hide();
                $('.unit3').hide();
                $('.unit4').hide();
                $('.unit5').hide();
            }
            // Close

            $('#vin1').val(data.vin);
            $('#driver_name1').val(data.driver_name);
            $('#driver_dob1').val(data.driver_dob);
            $('#driver_license1').val(data.driver_license);
            $('#driver_license_state1').val(data.driver_license_state);
            $('#vehicle_year1').val(data.vehicle_year);
            $('#vehicle_make1').val(data.vehicle_make);
            $('#stated_value1').val(data.stated_value);
            // 2
            $('#vin21').val(data.vin2);
            $('#driver_name21').val(data.driver_name2);
            $('#driver_dob21').val(data.driver_dob2);
            $('#driver_license21').val(data.driver_license2);
            $('#driver_license_state21').val(data.driver_license_state2);
            $('#vehicle_year21').val(data.vehicle_year2);
            $('#vehicle_make21').val(data.vehicle_make2);
            $('#stated_value21').val(data.stated_value2);
            // 3
            $('#vin31').val(data.vin3);
            $('#driver_name31').val(data.driver_name3);
            $('#driver_dob31').val(data.driver_dob3);
            $('#driver_license31').val(data.driver_license3);
            $('#driver_license_state31').val(data.driver_license_state3);
            $('#vehicle_year31').val(data.vehicle_year3);
            $('#vehicle_make31').val(data.vehicle_make3);
            $('#stated_value31').val(data.stated_value3);
            // 4
            $('#vin41').val(data.vin4);
            $('#driver_name41').val(data.driver_name4);
            $('#driver_dob41').val(data.driver_dob4);
            $('#driver_license41').val(data.driver_license4);
            $('#driver_license_state41').val(data.driver_license_state4);
            $('#vehicle_year41').val(data.vehicle_year4);
            $('#vehicle_make41').val(data.vehicle_make4);
            $('#stated_value41').val(data.stated_value4);
            // 5
            $('#vin51').val(data.vin5);
            $('#driver_name51').val(data.driver_name5);
            $('#driver_dob51').val(data.driver_dob5);
            $('#driver_license51').val(data.driver_license5);
            $('#driver_license_state51').val(data.driver_license_state5);
            $('#vehicle_year51').val(data.vehicle_year5);
            $('#vehicle_make51').val(data.vehicle_make5);
            $('#stated_value51').val(data.stated_value5);

            $('#comment1').val(data.comment);

            $('#progress-bar1').removeClass('bg-success bg-warning bg-info bg-danger').addClass(
                getProgressBarClass(data.form_status));
            $('#progress-bar1').css('width', data.form_status_value + '%');
            $('#model-form-status1').text(data.form_status);
            // ... update other fields ...

            // Show the modal
            $('#masterleaddata').modal('show');
        }

        function getProgressBarClass(formStatus) {
            switch (formStatus) {
                case 'Intrested':
                    return 'bg-success';
                case 'Pipeline':
                    return 'bg-warning';
                case 'NEW':
                    return 'bg-info';
                default:
                    return 'bg-danger';
            }
        }

        $('#form_status1').on('change', function() {
            var status = $(this).val();
            if (status == 'Intrested') { // Corrected 'Intrested' to 'Interested'
                $('#company_name1').prop('required', true);
                $('#phone1').prop('required', true);
                $('#company_rep11').prop('required', true);
                $('#business_address1').prop('required', true);
                $('#business_city1').prop('required', true);
                $('#business_state1').prop('required', true);
                $('#business_zip1').prop('required', true);
                $('#dot1').prop('required', true);
                $('#mc_docket1').prop('required', true);
                $('#unit_owned1').prop('required', true);
                $('#vin1').prop('required', true);
                $('#driver_name1').prop('required', true);
                $('#driver_dob1').prop('required', true);
                $('#driver_license1').prop('required', true);
                $('#driver_license_state1').prop('required', true);
            } else if (status == 'Pipeline') {
                $('#company_name1').prop('required', false);
                $('#phone1').prop('required', false);
                $('#company_rep11').prop('required', false);
                $('#business_address1').prop('required', false);
                $('#business_city1').prop('required', false);
                $('#business_state1').prop('required', false);
                $('#business_zip1').prop('required', false);
                $('#dot1').prop('required', false);
                $('#mc_docket1').prop('required', false);
                $('#unit_owned1').prop('required', false);
                $('#vin1').prop('required', false);
                $('#driver_name1').prop('required', false);
                $('#driver_dob1').prop('required', false);
                $('#driver_license1').prop('required', false);
                $('#driver_license_state1').prop('required', false);
            }
        });

        // Single Lead Form
        $('#form_status_single1').on('change', function() {
            var status = $(this).val();
            if (status == 'Intrested') { // Corrected 'Intrested' to 'Interested'
                $('#company_name_single1').prop('required', true);
                $('#phone_single1').prop('required', true);
                $('#company_rep_single11').prop('required', true);
                $('#business_address_single1').prop('required', true);
                $('#business_city_single1').prop('required', true);
                $('#business_state_single1').prop('required', true);
                $('#business_zip_single1').prop('required', true);
                $('#dot_single1').prop('required', true);
                $('#mc_docket_single1').prop('required', true);
                $('#unit_owned_single1').prop('required', true);
                $('#vin_single1').prop('required', true);
                $('#driver_name_single1').prop('required', true);
                $('#driver_dob_single1').prop('required', true);
                $('#driver_license_single1').prop('required', true);
                $('#driver_license_state_single1').prop('required', true);
            } else if (status == 'Pipeline') {
                $('#company_name_single1').prop('required', false);
                $('#phone_single1').prop('required', false);
                $('#company_rep_single11').prop('required', false);
                $('#business_address_single1').prop('required', false);
                $('#business_city_single1').prop('required', false);
                $('#business_state_single1').prop('required', false);
                $('#business_zip_single1').prop('required', false);
                $('#dot_single1').prop('required', false);
                $('#mc_docket_single1').prop('required', false);
                $('#unit_owned_single1').prop('required', false);
                $('#vin_single1').prop('required', false);
                $('#driver_name_single1').prop('required', false);
                $('#driver_dob_single1').prop('required', false);
                $('#driver_license_single1').prop('required', false);
                $('#driver_license_state_single1').prop('required', false);
            }
        });
    });
    
    $(document).ready(function() {
        $('.unit2').hide();
        $('.unit3').hide();
        $('.unit4').hide();
        $('.unit5').hide();
        $('#unit_owned1').on('change', function() {
            var value = $(this).val();
            if (value == '2') {
                $('.unit2').show();
                $('.unit3').hide();
                $('.unit4').hide();
                $('.unit5').hide();
            } else if (value == '3') {
                $('.unit2').show();
                $('.unit3').show();
                $('.unit4').hide();
                $('.unit5').hide();
            } else if (value == '4') {
                $('.unit2').show();
                $('.unit3').show();
                $('.unit4').show();
                $('.unit5').hide();
            } else if (value == '5') {
                $('.unit2').show();
                $('.unit3').show();
                $('.unit4').show();
                $('.unit5').show();
            } else if (value == '1') {
                $('.unit2').hide();
                $('.unit3').hide();
                $('.unit4').hide();
                $('.unit5').hide();
            }
        });
    });
</script>
<!--Master File Data End-->

@endsection
