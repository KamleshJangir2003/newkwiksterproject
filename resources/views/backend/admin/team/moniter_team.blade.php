@extends('backend.common.layout')
@section('css')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-4 card-title mb-0">Moniter Team</div>

                        <div class="col-lg-2">
                            <select id="UserFilter" class="form-select">
                                <option value="">-- Choose name --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->name }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <select id="DesignationFilter" class="form-select">
                                <option value="">-- Select designation --</option>
                                <option value="Manager">Manager</option>
                                <option value="Agent">Agent</option>
                            </select>
                        </div>
                        <div class="col-lg-4"></div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="example"
                        class="table table-bordered dt-responsive nowrap table-striped align-middle text-center"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th data-ordering="false">SR No.</th>
                                <th data-ordering="false">Name</th>
                                <th data-ordering="false">Designation</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        @php
                                            echo $i;
                                            $i++;
                                        @endphp
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->designation }}</td>
                                    <td>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill align-middle"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a href="{{ route('admin.view.moniter.team', encrypt($user->id)) }}"
                                                        class="dropdown-item"><i
                                                            class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                        View</a></li>
                                                <li>
                                                    <a class="dropdown-item remove-item-btn"
                                                        href="{{ route('admin.delete.moniter.team', encrypt($user->id)) }}"
                                                        onclick="return confirm('Are you sure ?')">
                                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                        Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!--end col-->
    </div><!--end row-->
@endsection
@section('js')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>

    <script>
        // Assuming you have initialized DataTable somewhere in your code
        var table = $('#example').DataTable(); // replace 'yourDataTableID' with the actual ID of your DataTable

        // Use 'change' event for the dropdowns
        $('#DesignationFilter, #UserFilter').on('change', function() {
            var designationFilter = $('#DesignationFilter').val();
            var userFilter = $('#UserFilter').val();

            // Apply filters to the correct columns
            table.columns(2).search(designationFilter).draw();
            table.columns(1).search(userFilter).draw();
        });
    </script>
@endsection
