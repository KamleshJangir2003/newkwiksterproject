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
                        <div class="col-lg-5 card-title mb-0">Moniter Team</div>

                        <div class="col-lg-2 text-center">
                            <input type="date" value="" id="DateFilter" class="form-control">
                        </div>
                        <div class="col-lg-5"></div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="example"
                        class="table table-bordered dt-responsive nowrap table-striped align-middle text-center"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th data-ordering="false">SR No.</th>
                                <th data-ordering="false">Login Time</th>
                                <th data-ordering="false">Logout Time</th>
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
                                    <td class="text-success fw-bold">{{ \Carbon\Carbon::parse($data->login_time)->format('d/m/y H:i:s') }}</td>
                                    <td class="text-danger fw-bold">{{ \Carbon\Carbon::parse($data->logout_time)->format('d/m/y H:i:s') }}</td>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
        // Assuming you have initialized DataTable somewhere in your code
        var table = $('#example').DataTable(); // replace 'yourDataTableID' with the actual ID of your DataTable
    
        // Use 'change' event for the date input
        $('#DateFilter').on('change', function() {
            var dateFilter = $('#DateFilter').val();
    
            // Format the date to match the expected format "d/m/y H:i:s"
            var formattedDate = moment(dateFilter).format('DD/MM/YY');
    
            // Apply filters to the correct columns
            table.columns(1).search(formattedDate).draw();
        });
    </script>
@endsection
