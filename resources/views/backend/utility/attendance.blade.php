<!DOCTYPE html>
<html>

<head>
    <title>Attendance Code</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<style>
    .dt-button{
        margin-left: 20px !important;
    }
    .dataTables_filter{
        margin-right: 20px !important;
    }
    .dataTables_wrapper {
        margin-top:100px;
    }
    .p-f{
        position: fixed !important;
    }
    table.dataTable tbody th, table.dataTable tbody td {
        padding: 0px !important;
    }
    .tableFixHead {
      overflow: auto;
      height: 100%;
      width:100%;
    }
    
    .tableFixHead table {
      border-collapse: collapse;
      width: 100%;
    }
    
    .tableFixHead th,
    .tableFixHead td {
      padding: 8px 16px;
    }
    
    
    td:first-child, th:first-child {
      position:sticky !important;
      left:0 !important;
      z-index:1 !important;
    min-width: 75px;
      background-color:white;
    }
    td:nth-child(2),th:nth-child(2)  { 
    position:sticky !important;
      left:80px !important;
      z-index:1 !important;
      background-color:white;
      }
    .tableFixHead th {
      position: sticky !important;
      top: 0 !important;
      background: #eee !important;
      z-index:2 !important
    }
    th:first-child , th:nth-child(2) {
      z-index:3 !important
      }
</style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 p-0">
                <div class="text-center bg-dark text-white p-4 w-100 fs-4 fw-bold " style="position: fixed;">ATTENDANCE SHEET</div>
                <div class="tableFixHead">
                    <table id="example" class="display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Employee Name</th>
                                @for ($day = 1; $day <= now()->daysInMonth; $day++)
                                    <th>
                                        <div class="date-header text-center mt-2" style="height:40px;width:120px;">
                                            {{ now()->startOfMonth()->addDays($day - 1)->format('d-m-y-D') }}
                                        </div>
                                    </th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i=1;
                            @endphp
                            @foreach ($employees as $employee)
                                <tr>
                                    <td class="text-center fw-bold">
                                        @php
                                       echo $i;
                                       $i++;
                                        @endphp
                                    </td>
                                    <td>
                                        <div class="employee-name-header" style="width:130px;font-size: 12px;padding-left: 12px;">
                                            <h6 style="font-size: 12px;">{{ $employee->name }} 
                                            @if($employee->role=='1')
                                            (Manager)
                                            @else
                                            (Agent)
                                            @endif
                                            </h6>
                                        </div>
                                    </td>
                                    @for ($day = 1; $day <= now()->daysInMonth; $day++)
                                        <td class="text-center">
                                           
                                                <div class="dropdown">
                                                    <button class="btn btn-success dropdown-toggle-one status-button"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false" style="font-size: 12px;">
                                                        @php
                                                            $date = now()
                                                                ->startOfMonth()
                                                                ->addDays($day - 1)
                                                                ->format('d-m-y');
                                                            $attendance = $employee->attendances->firstWhere('day', $date);
                                                            $status = $attendance ? $attendance->status : '';
                                                        @endphp
                                                        {{ $status ?: 'Select' }}
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item editstatus" data-id="{{ $employee->id }}"
                                                            data-status="P" data-day="{{ $date }}"
                                                            href="javascript:void(0);">Present</a>
                                                        <a class="dropdown-item editstatus" data-id="{{ $employee->id }}"
                                                            data-status="A" data-day="{{ $date }}"
                                                            href="javascript:void(0);">Absent</a>
                                                        <a class="dropdown-item editstatus" data-id="{{ $employee->id }}"
                                                            data-status="H" data-day="{{ $date }}"
                                                            href="javascript:void(0);">Holiday</a>
                                                        <a class="dropdown-item editstatus" data-id="{{ $employee->id }}"
                                                            data-status="HD" data-day="{{ $date }}"
                                                            href="javascript:void(0);">Half Day</a>
                                                    </div>
                                                </div>
                                            
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
    
                        </tbody>
    
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Your Blade file -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.editstatus').on('click', function(e) {
                e.preventDefault();

                var id = $(this).data('id');
                var status = $(this).data('status');
                var day = $(this).data('day');
                var cell = $(this).closest('td');

                $.ajax({
                    method: 'POST',
                    url: '/updatestatus',
                    data: {
                        id: id,
                        status: status,
                        day: day
                    },
                    success: function(response) {
                        console.log(response);

                        // Update the button text
                        var dropdownButton = cell.find('.status-button');
                        dropdownButton.text(response.updatedStatus || 'Select');

                        // Update the button class based on the new status
                        dropdownButton.removeClass('btn-success btn-danger btn-info btn-primary');
                        if (response.updatedStatus === 'P') {
                            dropdownButton.addClass('btn-success');
                        } else if (response.updatedStatus === 'A') {
                            dropdownButton.addClass('btn-danger');
                        } else if (response.updatedStatus === 'H') {
                            dropdownButton.addClass('btn-info');
                        }else if (response.updatedStatus === 'HD') {
                            dropdownButton.addClass('btn-primary');
                        }
                    },
                    error: function(error) {
                        console.error('Error updating status', error);
                    }
                });
            });

            // Initialize colors based on initial status
            $('.btn.dropdown-toggle-one').each(function() {
                var dropdownButton = $(this);
                var status = dropdownButton.text().trim();
                dropdownButton.removeClass('btn-success btn-danger btn-info btn-primary');
                if (status === 'P') {
                    dropdownButton.addClass('btn-success');
                } else if (status === 'A') {
                    dropdownButton.addClass('btn-danger');
                } else if (status === 'H') {
                    dropdownButton.addClass('btn-info');
                }else if (status === 'HD') {
                    dropdownButton.addClass('btn-primary');
                }
            });
        });
    </script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ],
                pageLength: 20
            });

        });
    </script>


</body>

</html>
