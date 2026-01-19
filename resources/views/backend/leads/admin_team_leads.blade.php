@extends('backend.common.layout')
@section('css')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
@endsection
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Team Leads</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                        <li class="breadcrumb-item active">Team Leads</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-2">
            <select id="DesignationFilter" class="form-select">
                <option value="">-- Select designation --</option>
                <option value="Manager">Manager</option>
                <option value="Agent">Agent</option>
            </select>
        </div>
        <div class="col-lg-2">
            <select id="AgentFilter" class="form-select">
                <option value="">-- Select Agent --</option>
                @foreach ($agents as $agent)
                    <option value="{{ $agent->name }}">{{ $agent->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-2">
            <select id="LeadsFilter" class="form-select">
                <option value="">-- Choose Status --</option>
                <option value="Intrested">Intrested</option>
                <option value="Pipeline">Pipeline</option>
                <option value="Voice Mail">Voice Mail</option>
                <option value="Not Intrested">Not Intrested</option>
                <option value="Not Connected">Not Connected</option>
                <option value="Wrong Number">Wrong Number</option>
                <option value="Insured">Insured</option>
            </select>
        </div>
        <div class="col-lg-3"></div>
    </div>
    {{-- Team Leads --}}
    <div class="row">
        <div class="col-lg-12">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Company Name</th>
                        <th>Phone</th>
                        <th>Company Rep1</th>
                        <th>Business Address</th>
                        <th>Business City</th>
                        <th>Business State</th>
                        <th>Business Zip</th>
                        <th>Dot</th>
                        <th>Mc/Docket</th>
                        <th>Updated Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($datas as $data)
                        <tr>
                            <td>
                                @php
                                    echo $i;
                                    $i++;
                                @endphp
                            </td>
                            <td>{{ $data->user->name }}</td>
                            <td>{{ $data->user->designation }}</td>
                            <td>{{ $data->company_name }}</td>
                            <td>{{ $data->phone }}</td>
                            <td>{{ $data->company_rep1 }}</td>
                            <td>{{ $data->business_address }}</td>
                            <td>{{ $data->business_city }}</td>
                            <td>{{ $data->business_state }}</td>
                            <td>{{ $data->business_zip }}</td>
                            <td>{{ $data->dot }}</td>
                            <td>{{ $data->mc_docket }}</td>
                            <td>{{ $data->updated_at }}</td>
                            <td>
                                {{ $data->form_status }}
                                {{-- style="width: 150px;" class="dropdown" <div class="progress animated-progress custom-progress mb-4" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;">
                                    <div class="progress-bar bg-{{ $data->form_status === 'Intrested' ? 'success' : ($data->form_status === 'Pipeline' ? 'warning' : 'danger') }}"
                                        role="progressbar" style="width: {{ $data->form_status_value }}%"
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
                                </div> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- /Team Leads --}}
@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'colvis']
            });

            table.buttons().container()
                .appendTo('#example_wrapper .col-md-6:eq(0)');
            // Get the search data for the first column and add to the select list
            $('#DesignationFilter, #AgentFilter, #LeadsFilter').on('change', function() {
                var designationFilter = $('#DesignationFilter').val();
                var agentFilter = $('#AgentFilter').val();
                var leadsFilter = $('#LeadsFilter').val();

                // Apply filters to the correct columns
                table.columns(2).search(designationFilter).draw();
                table.columns(1).search(agentFilter).draw();
                table.columns(13).search(leadsFilter).draw();
            });
        });
    </script>
@endsection
