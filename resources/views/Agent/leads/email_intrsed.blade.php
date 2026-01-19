@extends('Agent.common.app')
@section('main')
    <link href="{{ asset('Agent/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Leads</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Email Verified forms</li>
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
                                    <th scope="col">S.No.</th>
                                    <th scope="col">Company Name</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Trucks</th>
                                    <th scope="col">Drivers</th>
                                    <th scope="col">Comment</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Status</th>                                  
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($datas))
                                    @php $a = 0; @endphp
                                    @foreach ($datas as $data)
                                        @php $a++; @endphp
                                        <tr>
                                            <th scope="row">
                                                {{ $a }}
                                            </th>
                                            <td>{{ $data->company_name }}</td>
                                            <td>{{ $data->phone }}</td>
                                            <td>{{ $data->email }}</td>
                                            <td>{{ $data->trucks }}</td>
                                            <td>{{ $data->drivers }}</td>
                                            <td>{{ $data->Comment }}</td>
                                            <td>{{ $data->updated_at }}</td>
                                            @if ($data->status == 1)
                                                <td>
                                                    <button class="custom-button"
                                                        id="dropdownMenuButton"
                                                        data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false"
                                                        style="background-color:#119711;color:white; padding: 2px 15px;border: none;">
                                                        <i class='bx bxs-circle me-1'></i>NEW
                                                    </button>                                                  
                                                </td>
                                            @elseif($data->status == 2)
                                                <td>
                                                    <button class="custom-button"
                                                        id="dropdownMenuButton"
                                                        data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false"
                                                        style="background-color:#119711;color:white; padding: 2px 15px;border: none;">
                                                        <i class='bx bxs-circle me-1'></i>Good Form
                                                    </button>                                                  
                                                </td>
                                                @else
                                                <td>
                                                    <button class="custom-button"
                                                        id="dropdownMenuButton"
                                                        data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false"
                                                        style="background-color:#ff0000;color:white; padding: 2px 15px;border: none;">
                                                        <i class='bx bxs-circle me-1'></i>Bad Form
                                                    </button>                                                   
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col">S.No.</th>
                                    <th scope="col">Company Name</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Trucks</th>
                                    <th scope="col">Drivers</th>
                                    <th scope="col">Comment</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Status</th>
                                   
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

    <script>
        $(document).ready(function() {
            $('.update-status').on('click', function() {
                var leadId = $(this).data('lead-id');
                var status = $(this).data('status');
                var managerfwd = $('#manager_id').val();
                var $td = $(this).closest('td');

                $.ajax({
                    url: '{{ route('agent_status_update') }}',
                    method: 'POST',
                    data: {
                        lead_id: leadId,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $td.find('.btn')
                            .text(response.status)
                            .css('background-color', getStatusColor(response.status));

                        function getStatusColor(status) {
                            switch (status) {
                                case 'Voice Mail':
                                    return '#742dc1'; // Light green

                                case 'Not Intrested':
                                    return '#d91c1c'; // Black

                                case 'Wrong Number':
                                    return '#d91c1c';

                                case 'DND':
                                    return '#d91c1c'; // Red

                                case 'Not Connected':
                                    return '#e6ca00';

                                case 'WON':
                                    return '#00ff72';

                                default:
                                    return '#ffffff'; // Default background color
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error response if needed
                        console.error(error);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#exampleFullScreenModal').on('show.bs.modal', function(event) {
                var modal = $(this);
                var td = $(event.relatedTarget);

                modal.find('#company_name').val(td.data('company-name'));
                modal.find('#phone').val(td.data('phone'));
                modal.find('#company_rep1').val(td.data('company-rep1'));
                modal.find('#business_address').val(td.data('business-address'));
                modal.find('#business_city').val(td.data('business-city'));
                modal.find('#business_state').val(td.data('business-state'));
                modal.find('#business_zip').val(td.data('business-zip'));
                modal.find('#dot').val(td.data('dot'));
                modal.find('#mc_docket').val(td.data('mc_docket'));
                modal.find('#data_id').val(td.data('id'));
                modal.find('#email').val(td.data('email'));
                modal.find('#forword_id').val($('#manager_id').val());
                modal.find('#commodities').val(td.data('commodities'));
                modal.find('#unit_owned2').val(td.data('unit_owned'));
                modal.find('#vin').val(td.data('vin'));
                modal.find('#driver_name').val(td.data('driver_name'));
                modal.find('#driver_dob').val(td.data('driver_dob'));
                modal.find('#driver_license').val(td.data('driver_license'));
                modal.find('#driver_license_state').val(td.data('driver_license_state'));
                modal.find('#vehicle_year').val(td.data('vehicle_year'));
                modal.find('#vehicle_make').val(td.data('vehicle_make'));
                modal.find('#stated_value').val(td.data('stated_value'));

                modal.find('#vin2').val(td.data('vin2'));
                modal.find('#driver_name2').val(td.data('driver_name2'));
                modal.find('#driver_dob2').val(td.data('driver_dob2'));
                modal.find('#driver_license2').val(td.data('driver_license2'));
                modal.find('#driver_license_state2').val(td.data('driver_license_state2'));
                modal.find('#vehicle_year2').val(td.data('vehicle_year2'));
                modal.find('#vehicle_make2').val(td.data('vehicle_make2'));
                modal.find('#stated_value2').val(td.data('stated_value2'));

                modal.find('#vin3').val(td.data('vin3'));
                modal.find('#driver_name3').val(td.data('driver_name3'));
                modal.find('#driver_dob3').val(td.data('driver_dob3'));
                modal.find('#driver_license3').val(td.data('driver_license3'));
                modal.find('#driver_license_state3').val(td.data('driver_license_state3'));
                modal.find('#vehicle_year3').val(td.data('vehicle_year3'));
                modal.find('#vehicle_make3').val(td.data('vehicle_make3'));
                modal.find('#stated_value3').val(td.data('stated_value3'));

                modal.find('#vin4').val(td.data('vin4'));
                modal.find('#driver_name4').val(td.data('driver_name4'));
                modal.find('#driver_dob4').val(td.data('driver_dob4'));
                modal.find('#driver_license4').val(td.data('driver_license4'));
                modal.find('#driver_license_state4').val(td.data('driver_license_state4'));
                modal.find('#vehicle_year4').val(td.data('vehicle_year4'));
                modal.find('#vehicle_make4').val(td.data('vehicle_make4'));
                modal.find('#stated_value4').val(td.data('stated_value4'));

                modal.find('#vin5').val(td.data('vin5'));
                modal.find('#driver_name5').val(td.data('driver_name5'));
                modal.find('#driver_dob5').val(td.data('driver_dob5'));
                modal.find('#driver_license5').val(td.data('driver_license5'));
                modal.find('#driver_license_state5').val(td.data('driver_license_state5'));
                modal.find('#vehicle_year5').val(td.data('vehicle_year5'));
                modal.find('#vehicle_make5').val(td.data('vehicle_make5'));
                modal.find('#stated_value5').val(td.data('stated_value5'));

                modal.find('#comment').val(td.data('comment'));
                modal.find('#MTC').val(td.data('mtc'));
                modal.find('#Liability').val(td.data('liability'));
                modal.find('#interchange').val(td.data('interchange'));
                // Set the checkbox states
                $('#coverwell').prop('checked', !!td.data('is_cover_well'));
                $('#redmark').prop('checked', !!td.data('redmark'));
                $('#physicall').prop('checked', td.data('physical') == 1);
                $('#generall').prop('checked', td.data('general') == 1);

                console.log(td.data());
                // Handle commodities data (assuming it's already an array)
                var commodities = td.data('commodities');

                if (Array.isArray(commodities) && commodities.includes("Building Materials - Machinery")) {
                    // $('#building_machinery').prop('checked', true);
                    $('#building_machinery').prop('checked', !!td.data('commodities'));
                }
                if (Array.isArray(commodities) && commodities.includes("Building Materials")) {
                    // $('#building_machinery').prop('checked', true);
                    $('#buildingmaterials').prop('checked', !!td.data('commodities'));
                }
                if (Array.isArray(commodities) && commodities.includes("Dry Freight - Amazon")) {
                    // $('#building_machinery').prop('checked', true);
                    $('#Dry-Freight-Amazon').prop('checked', !!td.data('commodities'));
                }
                if (Array.isArray(commodities) && commodities.includes("Dry Freight")) {
                    // $('#building_machinery').prop('checked', true);
                    $('#Dry-Freight').prop('checked', !!td.data('commodities'));
                }
                if (Array.isArray(commodities) && commodities.includes("Reefer with seafood or flowers")) {
                    // $('#building_machinery').prop('checked', true);
                    $('#Reefer_with_seafood_or_flowers').prop('checked', !!td.data('commodities'));
                }
                if (Array.isArray(commodities) && commodities.includes("Refrigerated Goods")) {
                    // $('#building_machinery').prop('checked', true);
                    $('#Refrigerated_Goods').prop('checked', !!td.data('commodities'));
                }
                if (Array.isArray(commodities) && commodities.includes("Reefer with flowers")) {
                    // $('#building_machinery').prop('checked', true);
                    $('#Reefer_with_flowers').prop('checked', !!td.data('commodities'));
                }
                if (Array.isArray(commodities) && commodities.includes("Fracking Sand")) {
                    // $('#building_machinery').prop('checked', true);
                    $('#Fracking-Sand').prop('checked', !!td.data('commodities'));
                }
                if (Array.isArray(commodities) && commodities.includes("Hazard")) {
                    // $('#building_machinery').prop('checked', true);
                    $('#Hazard').prop('checked', !!td.data('commodities'));
                }
                if (Array.isArray(commodities) && commodities.includes("Containerized Freight")) {
                    // $('#building_machinery').prop('checked', true);
                    $('#Containerized-Freight').prop('checked', !!td.data('commodities'));
                }
                if (Array.isArray(commodities) && commodities.includes("Sand & Gravel")) {
                    // $('#building_machinery').prop('checked', true);
                    $('#SandGravel').prop('checked', !!td.data('commodities'));
                }
                if (Array.isArray(commodities) && commodities.includes("Auto 100%")) {
                    // $('#building_machinery').prop('checked', true);
                    $('#100').prop('checked', !!td.data('commodities'));
                }
                if (Array.isArray(commodities) && commodities.includes("Hauls Oversized/Overweight")) {
                    // $('#building_machinery').prop('checked', true);
                    $('#HaulsOversizedOverweight').prop('checked', !!td.data('commodities'));
                }


                // Display PDF
                var file = td.data('file1');
                var pdfPath = "{{ asset(':file') }}";
                pdfPath = pdfPath.replace(':file', file);

                if (file) {
                    // Attach click event to open PDF in new tab or window
                    $('#openPdfButton1').on('click', function() {
                        window.open(pdfPath, '_blank');
                    });
                } else {
                    modal.find('#openPdfButton1').hide();
                }
                // Display PDF2
                var file2 = td.data('file2');
                var pdfPath2 = "{{ asset(':file2') }}";
                pdfPath2 = pdfPath2.replace(':file2', file2);

                if (file2) {
                    // Attach click event to open PDF in new tab or window
                    $('#openPdfButton2').on('click', function() {
                        window.open(pdfPath2, '_blank');
                    });
                } else {
                    modal.find('#openPdfButton2').css('display', 'none');
                }
                // Display PDF3
                var file3 = td.data('file3');
                var pdfPath3 = "{{ asset(':file3') }}";
                pdfPath3 = pdfPath3.replace(':file3', file3);

                if (file3) {
                    // Attach click event to open PDF in new tab or window
                    $('#openPdfButton3').on('click', function() {
                        window.open(pdfPath3, '_blank');
                    });
                } else {
                    modal.find('#openPdfButton3').css('display', 'none');
                }
                // Display PDF4
                var file4 = td.data('file4');
                var pdfPath4 = "{{ asset(':file4') }}";
                pdfPath4 = pdfPath4.replace(':file4', file4);

                if (file4) {
                    // Attach click event to open PDF in new tab or window
                    $('#openPdfButton4').on('click', function() {
                        window.open(pdfPath4, '_blank');
                    });
                } else {
                    modal.find('#openPdfButton4').css('display', 'none');
                }
                // Display PDF5
                var file5 = td.data('file5');
                var pdfPath5 = "{{ asset(':file5') }}";
                pdfPath5 = pdfPath5.replace(':file5', file5);

                if (file5) {
                    // Attach click event to open PDF in new tab or window
                    $('#openPdfButton5').on('click', function() {
                        window.open(pdfPath5, '_blank');
                    });
                } else {
                    modal.find('#openPdfButton5').css('display', 'none');
                }
                // Display PDF6
                var file6 = td.data('file6');
                var pdfPath6 = "{{ asset(':file6') }}";
                pdfPath6 = pdfPath6.replace(':file6', file6);

                if (file6) {
                    // Attach click event to open PDF in new tab or window
                    $('#openPdfButton6').on('click', function() {
                        window.open(pdfPath6, '_blank');
                    });
                } else {
                    modal.find('#openPdfButton6').css('display', 'none');
                }
                // Display error file
                var errorfile = td.data('error_file');
                var errorPath6 = "{{ asset(':error_file') }}";
                errorPath6 = errorPath6.replace(':error_file', errorfile);

                if (errorfile) {
                    // Attach click event to open PDF in new tab or window
                    $('#openerror1').on('click', function() {
                        window.open(errorPath6, '_blank');
                    });
                } else {
                    modal.find('#openerror1').css('display', 'none');
                }



            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#form_status2').change(function() {
                var isPipeline = $(this).val() === 'Pipeline';

                // Toggle visibility of elements with class 'reminder'
                $('.reminder').toggle(isPipeline);

                // Define an array of IDs for fields to toggle 'required' attribute
                var fieldIds = [
                    '#exampleFullScreenModal #company_name', '#exampleFullScreenModal #phone',
                    '#exampleFullScreenModal #company_rep1',
                    '#exampleFullScreenModal #business_address',
                    '#exampleFullScreenModal #business_city',
                    '#exampleFullScreenModal #business_state', '#exampleFullScreenModal #business_zip',
                    '#exampleFullScreenModal #dot', '#exampleFullScreenModal #vin',
                    '#exampleFullScreenModal #driver_name', '#exampleFullScreenModal #driver_dob',
                    '#exampleFullScreenModal #driver_license',
                    '#exampleFullScreenModal #driver_license_state', '#exampleFullScreenModal #vin2',
                    '#exampleFullScreenModal #driver_name2', '#exampleFullScreenModal #driver_dob2',
                    '#exampleFullScreenModal #driver_license2',
                    '#exampleFullScreenModal #driver_license_state2', '#exampleFullScreenModal #vin3',
                    '#exampleFullScreenModal #driver_name3', '#exampleFullScreenModal #driver_dob3',
                    '#exampleFullScreenModal #driver_license3',
                    '#exampleFullScreenModal #driver_license_state3', '#exampleFullScreenModal #vin4',
                    '#exampleFullScreenModal #driver_name4', '#exampleFullScreenModal #driver_dob4',
                    '#exampleFullScreenModal #driver_license4',
                    '#exampleFullScreenModal #driver_license_state4', '#exampleFullScreenModal #vin5',
                    '#exampleFullScreenModal #driver_name5', '#exampleFullScreenModal #driver_dob5',
                    '#exampleFullScreenModal #driver_license5',
                    '#exampleFullScreenModal #driver_license_state5'
                ];

                // Set or remove 'required' attribute based on isPipeline
                fieldIds.forEach(function(id) {
                    var $field = $(id);
                    if (isPipeline) {
                        $field.removeAttr('required');
                    } else {
                        $field.attr('required', 'required');
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var phoneCells = document.querySelectorAll('.phone_copy');

            phoneCells.forEach(function(cell) {
                cell.addEventListener('click', function() {
                    var phoneNumber = this.innerText.trim();

                    // Create a temporary input element
                    var tempInput = document.createElement('input');
                    tempInput.value = phoneNumber;
                    document.body.appendChild(tempInput);

                    // Select and copy the phone number from the temporary input element
                    tempInput.select();
                    document.execCommand('copy');

                    // Remove the temporary input element
                    document.body.removeChild(tempInput);

                    // Show copy indicator
                    var copyIndicator = event.target.querySelector('.copy-indicator');
                    copyIndicator.style.display = 'inline'; // Make the indicator visible

                    // Hide copy indicator after 2 seconds
                    setTimeout(function() {
                        copyIndicator.style.display = 'none'; // Hide the indicator
                    }, 1000);
                });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const unitSelect2 = document.getElementById("unit_owned2");

            // Function to toggle 'required' attribute based on display status
            function toggleRequiredBasedOnDisplay(elementId, isDisplayed) {
                const element = document.getElementById(elementId);
                if (element) {
                    const inputs = element.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => {
                        // Check if the input is not one of the specific IDs to exclude
                        if (input.id !== "vehicle_year5" && input.id !== "vehicle_make5" && input.id !==
                            "stated_value5" && input.id !== "vehicle_year2" && input.id !==
                            "vehicle_make2" && input.id !== "stated_value2" && input.id !==
                            "vehicle_year3" && input.id !== "vehicle_make3" && input.id !==
                            "stated_value3" && input.id !== "vehicle_year4" && input.id !==
                            "vehicle_make4" && input.id !== "stated_value4") {
                            if (isDisplayed) {
                                input.setAttribute('required', 'required');
                            } else {
                                input.removeAttribute('required');
                            }
                        }
                    });
                }
            }

            // Event listener for select change
            unitSelect2.addEventListener("change", function() {
                const selectedValue = parseInt(unitSelect2.value);

                // Toggle display of elements based on selected value
                document.getElementById("unit22").style.display = selectedValue >= 2 ? "" : "none";
                document.getElementById("unit33").style.display = selectedValue >= 3 ? "" : "none";
                document.getElementById("unit44").style.display = selectedValue >= 4 ? "" : "none";
                document.getElementById("unit55").style.display = selectedValue >= 5 ? "" : "none";

                // Toggle required attribute based on display status
                toggleRequiredBasedOnDisplay("unit22", document.getElementById("unit22").style.display !==
                    "none");
                toggleRequiredBasedOnDisplay("unit33", document.getElementById("unit33").style.display !==
                    "none");
                toggleRequiredBasedOnDisplay("unit44", document.getElementById("unit44").style.display !==
                    "none");
                toggleRequiredBasedOnDisplay("unit55", document.getElementById("unit55").style.display !==
                    "none");
            });

            // Trigger change event on page load if needed
            unitSelect2.dispatchEvent(new Event('change'));
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const unitSelect2 = document.getElementById("drivers_state2");

            // Function to toggle 'required' attribute based on display status
            function toggleRequiredBasedOnDisplay(elementId, isDisplayed) {
                const element = document.getElementById(elementId);
                if (element) {
                    const inputs = element.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => {
                        // Check if the input is not one of the specific IDs to exclude
                        if (input.id !== "vehicle_year5" && input.id !== "vehicle_make5" && input.id !==
                            "stated_value5" && input.id !== "vehicle_year2" && input.id !==
                            "vehicle_make2" && input.id !== "stated_value2" && input.id !==
                            "vehicle_year3" && input.id !== "vehicle_make3" && input.id !==
                            "stated_value3" && input.id !== "vehicle_year4" && input.id !==
                            "vehicle_make4" && input.id !== "stated_value4") {
                            if (isDisplayed) {
                                input.setAttribute('required', 'required');
                            } else {
                                input.removeAttribute('required');
                            }
                        }
                    });
                }
            }

            // Event listener for select change
            unitSelect2.addEventListener("change", function() {
                const selectedValue = parseInt(unitSelect2.value);

                // Toggle display of elements based on selected value
                document.getElementById("driver22").style.display = selectedValue >= 2 ? "" : "none";
                document.getElementById("driver33").style.display = selectedValue >= 3 ? "" : "none";
                document.getElementById("driver44").style.display = selectedValue >= 4 ? "" : "none";
                document.getElementById("driver55").style.display = selectedValue >= 5 ? "" : "none";

                // Toggle required attribute based on display status
                toggleRequiredBasedOnDisplay("driver22", document.getElementById("driver22").style
                    .display !== "none");
                toggleRequiredBasedOnDisplay("driver33", document.getElementById("driver33").style
                    .display !== "none");
                toggleRequiredBasedOnDisplay("driver44", document.getElementById("driver44").style
                    .display !== "none");
                toggleRequiredBasedOnDisplay("driver55", document.getElementById("driver55").style
                    .display !== "none");
            });

            // Trigger change event on page load if needed
            unitSelect2.dispatchEvent(new Event('change'));
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.btn-mail').click(function() {
                var leadId = $(this).data('lead-id');
                var status = 'Mail';
                var managerfwd = $('#manager_id').val();
                var $td = $(this).closest('tr');
                sendRequest(leadId, status, managerfwd, $td);
            });

            $('.btn-message').click(function() {
                var leadId = $(this).data('lead-id');
                var status = 'Message';
                var managerfwd = $('#manager_id').val();
                var $td = $(this).closest('tr');
                sendRequest(leadId, status, managerfwd, $td);
            });

            function sendRequest(leadId, status, managerfwd, $td) {
                $.ajax({
                    url: '{{ route('agent_mailstatus_update') }}',
                    method: 'POST',
                    data: {
                        lead_id: leadId,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $td.find('.btn')
                            .text(response.status)
                            .css('background-color', getStatusColor(response.status));

                        function getStatusColor(status) {
                            switch (status) {
                                case 'Mail':
                                    return '#742dc1'; // Light green

                                case 'Message':
                                    return '#742dc1'; // Black
                                default:
                                    return '#ffffff'; // Default background color
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error response if needed
                        console.error(error);
                    }
                });
            }
        });
    </script>
    <script>
        // Get references to the date input and time input fields
        const dateInput = document.getElementById('dateInput1');
        const timeInput = document.getElementById('timeInput1');
        const reminderInput = document.getElementById('reminder1');

        // Event listener to update the reminder input when either date or time changes
        dateInput.addEventListener('input', updateReminder);
        timeInput.addEventListener('input', updateReminder);

        function updateReminder() {
            // Get the value of date and time inputs
            const dateValue = dateInput.value;
            const timeValue = timeInput.value;

            // Combine date and time values with a "/"
            const reminderValue = `${dateValue} ${timeValue}`;

            // Update the value of the reminder input
            reminderInput.value = reminderValue;
        }
    </script>


@endsection
