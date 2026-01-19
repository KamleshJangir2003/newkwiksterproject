@extends('backend.client.common.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            
                               
                           
                        </div>
                        {{-- <div class="col-sm-3">
                            <div class="d-flex">
                                <label for="startDate">End Date:</label>
                                <input type="date" id="endDate" class="form-control">
                            </div>
                        </div> --}}
                        {{-- <div class="col-sm-2">
                            <div class="">
                                <button id="filterButton" class="btn btn-primary">Filter</button>
                            </div>
                        </div> --}}
                        <div class="col-sm-2">
                            <input type="date" id="startDate" class="form-control">
                        </div>
                        <div class="col-lg-2">
                            <h5 class="card-title mb-0">
                                <select class="form-select" id="agentFilter">
    <option value="">-- Select Agent --</option>
    @foreach ($client_form->unique('india_agent_name') as $data)
        <option value="{{ $data->india_agent_name }}">{{ $data->india_agent_name }}</option>
    @endforeach
</select>
                            </h5>
                        </div>
                        <div class="col-lg-2">
                            <h5 class="card-title mb-0">
                                <select class="form-select" id="statusFilter">
                                    <option value="">-- Select Status --</option>
                                    <option value="Pipeline">Pipeline</option>
                                    <option value="Sold">Sold</option>
                                    <option value="Lost">Lost</option>
                                    <option value="Cancel">Cancel</option>
                                </select>
                            </h5>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%;font-size: 10px;">
                        <thead>
                            <tr>
                                <th data-ordering="false">SR No.</th>
                                <th data-ordering="false">Upload Date</th>
                                <th data-ordering="false">India Agent Name</th>
                                <th data-ordering="false">Customer Name</th>
                                <th data-ordering="false">Phone</th>
                                <th>Company Name</th>
                                <th>PDF</th>
                                <th>Step</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>S/M/H/D</th>
                                <th>Action</th>
                                <th>Last Update</th>
                            </tr>
                        </thead>
                        <tbody id="TableBody">
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($client_form as $data)
                                <tr class="@if ($data->priority == '1') pulse @endif"
                                    data-date="{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-y') }}">
                                    <td class="text-center">
                                        <input type="hidden" class="id" value="{{ $data->id }}">
                                        @php
                                            echo $i;
                                            $i++;
                                        @endphp
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($data->upload_date)->format('d/m/y') }}
                                    </td>
                                    <td>{{ $data->india_agent_name }}</td>
                                    <td>{{ $data->customer_name }}</td>
                                    <td>{{ $data->phone }}</td>
                                    <td>{{ $data->company_name }}</td>
                                    <td class="@if ($data->step == 'NEW') pulse @endif">
                                         @if ($data->pdf)
            @php $pdfPaths = json_decode($data->pdf); @endphp
            @if (is_array($pdfPaths))
                @foreach ($pdfPaths as $pdfPath)
                @php
                        $filenameWithTimestamp = pathinfo($pdfPath, PATHINFO_FILENAME);
                        $filenameWithoutTimestamp = preg_replace('/^\d+_/', '', $filenameWithTimestamp);
                    @endphp
                    <a href="{{ asset($pdfPath) }}" download>{{$filenameWithoutTimestamp}}</a>
                    <br>
                @endforeach
            @else
                <span class="text-danger">Invalid PDF data</span>
            @endif
        @else
            No PDFs available
        @endif
                                    </td>
                                    <td style="width: 150px;" class="dropdown">
                                        {{ $data->step ?? 'NEW' }}
                                        <div class="progress animated-progress custom-progress mb-4" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;">
                                            <div class="progress-bar bg-{{ $data->step === 'Not Connected' ? 'primary' : ($data->step === 'Contacted' ? 'warning' : ($data->step === 'Quotation Sent' ? 'success' : ($data->step === 'Closing' ? 'danger' : 'info'))) }}"
                                                role="progressbar" style="width: {{ $data->step_value ?? 100 }}%"
                                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item"
                                                href="{{ route('change.step.status', [($data_id = $data->id), ($step = 'Not Connected'), ($step_value = '25')]) }}">Not
                                                Connected</a>
                                            <a class="dropdown-item"
                                                href="{{ route('change.step.status', [($data_id = $data->id), ($step = 'Contacted'), ($step_value = '50')]) }}">Contacted</a>
                                            <a class="dropdown-item"
                                                href="{{ route('change.step.status', [($data_id = $data->id), ($step = 'Quotation Sent'), ($step_value = '75')]) }}">Quotation
                                                Sent</a>
                                            <a class="dropdown-item"
                                                href="{{ route('change.step.status', [($data_id = $data->id), ($step = 'Closing'), ($step_value = '100')]) }}">Closing
                                            </a>
                                        </div>
                                    </td>
                                    @if ($data->status == 'Pipeline')
                                        <td class="bg-warning">{{ $data->status ?? 'NULL' }}</td>
                                    @elseif($data->status == 'Sold')
                                        <td class="bg-success">{{ $data->status ?? 'NULL' }}</td>
                                    @elseif($data->status == 'Lost')
                                        <td class="bg-danger">{{ $data->status ?? 'NULL' }}</td>
                                    @elseif($data->status == 'Cancel')
                                        <td class="bg-danger">{{ $data->status ?? 'NULL' }}</td>
                                    @else
                                        <td> {{ $data->status ?? 'NULL' }}</td>
                                    @endif
                                    <td>
                                        @if ($data->priority == '1')
                                            <span class="badge bg-danger bg-danger-subtle text-danger">
                                                {{ $data->priority == '1' ? 'High' : 'Normal' }}
                                            </span>
                                        @elseif($data->priority == '0')
                                            <span class="badge bg-success bg-success-subtle text-success">
                                                {{ $data->priority == '0' ? 'Normal' : 'High' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $timeDifference = \Carbon\Carbon::parse($data->created_at)->diffInSeconds();
                                        @endphp

                                        @if ($timeDifference < 60)
                                            <span
                                                class="badge bg-success-subtle text-success">{{ $data->created_at->diffForHumans() }}</span>
                                        @elseif ($timeDifference < 3600)
                                            <span
                                                class="badge bg-primary-subtle text-primary">{{ $data->created_at->diffForHumans() }}</span>
                                        @else
                                            <span
                                                class="badge bg-danger-subtle text-danger">{{ $data->created_at->diffForHumans() }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-soft-secondary btn-sm data-select" type="button"
                                            data-id="{{ $data->customer_id }}" data-clientdataid="{{ $data->id }}">
                                            <i class='bx bx-dots-vertical'></i>
                                        </button>
                                       <!-- Dropdown Variant -->

    <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{$data->approved_declined ??'Select'}}</button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{url('/client/form/approve/Approved/'.$data->id)}}">Approve</a>
        <a class="dropdown-item" href="{{url('/client/form/approve/Declined/'.$data->id)}}">Decline</a>
    </div>
    <button class="btn btn-soft-secondary btn-sm addClientPdf ml-2"
                                                            type="button" data-id="{{ $data->customer_id }}"
                                                            data-clientdataid="{{ $data->id }}">
                                                            PDF
                                                        </button>

                                    </td>
                                    <td>
                                        {{ $data->updated_at }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!--end col-->
    </div><!--end row-->

    {{-- Action Modal  --}}
    {{-- Client Panel Action --}}
    <!-- staticBackdrop Modal -->
    <div class="modal fade" id="clientPanelAction" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h4>Customer Details</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4 border-bottom border-primary">
                            <table class="table">
                                <tr>
                                    <td class="fw-bold">Company Name</td>
                                    <td id="company_name"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Phone</td>
                                    <td id="phone"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Email</td>
                                    <td id="email"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Company Rep1</td>
                                    <td id="company_rep1"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Business Address</td>
                                    <td id="business_address"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Business City</td>
                                    <td id="business_city"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Business State</td>
                                    <td id="business_state"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Business Zip</td>
                                    <td id="business_zip"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Dot</td>
                                    <td id="dot"></td>
                                </tr>

                            </table>
                        </div>
                        <div class="col-lg-4 border-end border-bottom border-primary">
                            <table class="table">
                                <tr>
                                    <td class="fw-bold">Mc/Docket</td>
                                    <td id="mc_docket"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">VIN</td>
                                    <td id="vin"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Driver Name</td>
                                    <td id="driver_name"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Driver Dob</td>
                                    <td id="driver_dob"></td>
                                <tr>
                                    <td class="fw-bold">Driver License</td>
                                    <td id="driver_license"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Unit Owned</td>
                                    <td id="unit_owned"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Vehicle Year</td>
                                    <td id="vehicle_year"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Vehicle Make</td>
                                    <td id="vehicle_make"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Stated Value</td>
                                    <td id="stated_value"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-4 border-bottom border-primary">
                            <!-- Start User chat -->
                            <div class="user-chat w-100 overflow-hidden">

                                <div class="chat-content d-lg-flex">
                                    <!-- start chat conversation section -->
                                    <div class="w-100 overflow-hidden position-relative">
                                        <!-- conversation user -->
                                        <div class="position-relative">
                                            <div class="position-relative" id="users-chat">
                                                <div class="p-3 user-chat-topbar">
                                                    <div class="row align-items-center">
                                                        <div class="col-sm-12 col-12">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0 d-block d-lg-none me-3">
                                                                    <a href="javascript: void(0);"
                                                                        class="user-chat-remove fs-18 p-1"><i
                                                                            class="ri-arrow-left-s-line align-bottom"></i></a>
                                                                </div>
                                                                <div class="flex-grow-1 overflow-hidden">
                                                                    <div class="d-flex align-items-center">
                                                                        <div
                                                                            class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-3 ms-0">
                                                                            <img src="{{ asset('assets/images/users/multi-user.jpg') }}"
                                                                                class="rounded-circle avatar-xs"
                                                                                alt="">
                                                                            <span class="user-status"></span>
                                                                        </div>
                                                                        <div class="flex-grow-1 overflow-hidden">
                                                                            <h5 class="text-truncate mb-0 fs-16"><a
                                                                                    class="text-reset username"
                                                                                    data-bs-toggle="offcanvas"
                                                                                    href="#userProfileCanvasExample"
                                                                                    aria-controls="userProfileCanvasExample">Comment</a>
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- end chat user head -->
                                                <div class="chat-conversation p-3 p-lg-4 " id="chat-conversation"
                                                    data-simplebar>
                                                    <ul class="list-unstyled chat-conversation-list"
                                                        id="users-conversation">

                                                    </ul>
                                                    <!-- end chat-conversation-list -->
                                                </div>
                                                <div class="alert alert-warning alert-dismissible copyclipboard-alert px-4 fade show "
                                                    id="copyClipBoard" role="alert">
                                                    Message copied
                                                </div>
                                            </div>

                                            <!-- end chat-conversation -->

                                            <div class="chat-input-section p-3 p-lg-4">
                                                <form id="chatinput-form" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" value="" id="clientData_id">
                                                    <div class="row g-0 align-items-center">
                                                        <div class="col">
                                                            <div class="chat-input-feedback">
                                                                Please Enter a Message
                                                            </div>
                                                            <input type="text"
                                                                class="form-control chat-input bg-light border-light"
                                                                id="chat-input" placeholder="Type your message..."
                                                                autocomplete="off" value="">
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="chat-input-links ms-2">
                                                                <div class="links-list-item">
                                                                    <button type="submit"
                                                                        class="btn btn-primary chat-send waves-effect waves-light">
                                                                        <i class="ri-send-plane-2-fill align-bottom"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="row border-bottom  border-primary">
                            <div class="col-lg-12 py-2">
                                    <b>Commodities</b><p id="commodities"></p>
                                    </div>
                               </div>
                        <div class="col-lg-4 border-end border-primary">
                            <form action="{{ route('store.client.action.form') }}" method="POST"
                                onsubmit="return validateDate()">
                                @csrf
                                <input type="hidden" id="actionClientData_id" name="data_id">
                                <div class="row border-bottom border-primary">
                                    <div class="cursor-pointer py-3 text-center">
                                        <label class="form-check-label" for="formCheckboxRight1">
                                            Priority High
                                        </label>
                                        <input class="form-check-input" type="checkbox" name="priority" id="priority"
                                            value="1">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="row">
                                        <h4 class="mt-4">Estimate</h4>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="customer_name" class="form-label">Closing Date</label>
                                                <input type="date" class="form-control dateInput"
                                                    name="estimate_closing_date" id="estimate_closing_date">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="amount" class="form-label">Closing Amount ($)</label>
                                                <input type="number" class="form-control" placeholder="Enter amount..."
                                                    name="estimate_closing_amount" id="estimate_closing_amount">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="reason" class="form-label">Probability (%)</label>
                                                <input type="text" class="form-control" placeholder="%"
                                                    name="estimate_closing_probability" id="estimate_closing_probability">
                                            </div>
                                        </div><!--end col-->
                                    </div>
                                </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="Status" class="form-label">Status</label>
                                        <select name="status" class="form-control" id="client-status">
                                            <option value="">-- select --</option>
                                            <option value="Pipeline">Pipeline</option>
                                            <option value="Sold">Sold</option>
                                            <option value="Lost">Lost</option>
                                            <option value="Cancel">Cancel</option>
                                        </select>
                                    </div>
                                </div><!--end col-->
                                <div class="col-12" id="pipeline_reminder">
                                    <div class="mb-3">
                                        <label for="customer_name" class="form-label">Reminder <span
                                                class="text-danger">*</span></label>
                                        <input type="datetime-local" class="form-control dateInput"
                                            name="pipeline_reminder" id="pipeline_reminder1">
                                    </div>
                                </div><!--end col-->
                                <div class="col-12" id="sold_amount">
                                    <div class="mb-3">
                                        <label for="amount" class="form-label">Amount<span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" placeholder="Enter amount..."
                                            name="sold_amount" id="sold_amount1">
                                    </div>
                                </div><!--end col-->
                                <div class="col-12" id="lost_reason">
                                    <div class="mb-3">
                                        <label for="reason" class="form-label">Reason<span
                                                class="text-danger">*</span></label>
                                        <textarea type="text" class="form-control" placeholder="Enter lost reason..." name="lost_reason"
                                            id="lost_reason1"></textarea>
                                    </div>
                                </div><!--end col-->
                                <div class="col-12" id="cancel_reason">
                                    <div class="mb-3">
                                        <label for="reason" class="form-label">Reason<span
                                                class="text-danger">*</span></label>
                                        <textarea type="text" class="form-control" placeholder="Enter cancel reason..." name="cancel_reason"
                                            id="cancel_reason1"></textarea>
                                    </div>
                                </div><!--end col-->
                            </div>

                        </div>
                        <div class="col-lg-12">
                            <div class="text-end">
                                <div class="mt-4">
                                    <div class="hstack gap-2 justify-content-center">
                                        <a href="javascript:void(0);" class="btn btn-link link-danger fw-medium"
                                            data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                            Close</a>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div><!--end col-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- /Client Panel Action --}}
    {{-- /Action Modal  --}}
@endsection

@section('js')
    <script>
        function validateDate() {
            const dateInputs = document.querySelectorAll('.dateInput');
            const currentDate = new Date().toISOString().split('T')[0];

            for (const input of dateInputs) {
                const inputValue = input.value;

                if (inputValue && input.type === 'date' && inputValue < currentDate) {
                    alert('Do not select an old date for Closing Date.');
                    return false; // Prevent form submission
                } else if (inputValue && input.type === 'datetime-local' && inputValue < currentDate) {
                    alert('Do not select an old date and time for Reminder.');
                    return false; // Prevent form submission
                }
            }

            // Allow form submission if the dates are valid or if the fields are empty
            return true;
        }
    </script>
    <script>
        $(document).ready(function() {

            $('.data-select').on('click', function() {
                var dataId = $(this).data('id');
                var clientDataId = $(this).data('clientdataid');
                $('#clientData_id').val(clientDataId);
                $('#actionClientData_id').val(clientDataId);
                // Make an AJAX request to fetch data based on the data ID
                $.ajax({
                    url: '/get/customer/details/' + dataId, // Replace with your actual API endpoint
                    type: 'GET',
                    success: function(data) {
                        // Update modal content with fetched data
                        updateModal(data);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });

                // Function to load initial messages
                function loadInitialMessages() {
                     $('#users-conversation').empty();
                    var data_id = $('#clientData_id').val();
                    // Make an AJAX request to get initial messages from the server
                    $.ajax({
                        type: 'GET',
                        url: '/client/panel/data/comment/' + data_id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // Handle the success response and append messages to the conversation
                            for (var i = 0; i < response.messages.length; i++) {
                                appendMessage(response.messages[i]);
                            }
                        },
                        error: function(error) {
                            // Handle the error if needed
                            console.error(error);
                        }
                    });
                }

                // Call the function to load initial messages when the page loads
                loadInitialMessages();
            });

            // Function to append a new message to the conversation
            function appendMessage(message) {
                $('#users-conversation').append('<li class="mb-2">' + ` <div
                                                                        class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-3 ms-0">
                                                                        <img src="{{ asset('assets/images/users/user-dummy-img.jpg') }}"
                                                                            class="rounded-circle avatar-xs"
                                                                            alt="">
                                                                        <span class="user-status"></span>
                                                                    </div>` + message + '</li>');
                var conversationDiv = $('#chat-conversation');
                conversationDiv.scrollTop(conversationDiv[0].scrollHeight);
            }

            function updateModal(data) {
                // Check if data is defined
                if (!data) {
                    console.error('Data is undefined');
                    return;
                }

                // Update modal content with the fetched data
                $('#data_id').text(data.id);
                $('#company_name').text(data.company_name);
                $('#phone').text(data.phone);
                $('#email').text(data.email);
                $('#company_rep1').text(data.company_rep1);
                $('#business_address').text(data.business_address);
                $('#business_city').text(data.business_city);
                $('#business_state').text(data.business_state);
                $('#business_zip').text(data.business_zip);
                $('#dot').text(data.dot);
                $('#mc_docket').text(data.mc_docket);
                $('#vin').text(data.vin);
                $('#driver_name').text(data.driver_name);
                var dob = data.driver_dob;
                var formattedDOB = dob.split('-').reverse().join('-');
                $('#driver_dob').text(formattedDOB);
                $('#driver_license').text(data.driver_license);
                $('#unit_owned').text(data.unit_owned).prop('selected', true);
                $('#vehicle_year').text(data.vehicle_year);
                $('#vehicle_make').text(data.vehicle_make);
                $('#stated_value').text(data.stated_value);
                $('#comment').text(data.comment);
                
                var commodities = data.commodities;

    if (commodities) {
        // If commodities is a string, parse it into an array
        if (typeof commodities === 'string') {
            commodities = JSON.parse(commodities);
        }

        if (Array.isArray(commodities) && commodities.length > 0) {
            // Map the array elements to include numbers
            var commoditiesWithNumbers = commodities.map(function(value, index) {
                return (index + 1) + ' - ' + value;
            });

            // Join the array elements into a string
            var commoditiesString = commoditiesWithNumbers.join(', ');

            // Display the string in your desired element (replace '#commodities' with the actual selector)
            $('#commodities').text(commoditiesString);
        }
    }

                // Show the modal
                $('#clientPanelAction').modal('show');
            }
        });

        $(document).ready(function() {
            $('#pipeline_reminder').hide();
            $('#sold_amount').hide();
            $('#lost_reason').hide();
            $('#cancel_reason').hide();

            $('#client-status').on('change', function() {
                let status = $(this).val();
                if (status == 'Pipeline') {
                    $('#pipeline_reminder').show();
                    $('#sold_amount').hide();
                    $('#lost_reason').hide();
                    $('#cancel_reason').hide();
                } else if (status == 'Sold') {
                    $('#sold_amount').show();
                    $('#pipeline_reminder').hide();
                    $('#lost_reason').hide();
                    $('#cancel_reason').hide();
                } else if (status == 'Lost') {
                    $('#lost_reason').show();
                    $('#pipeline_reminder').hide();
                    $('#sold_amount').hide();
                    $('#cancel_reason').hide();
                } else if (status == 'Cancel') {
                    $('#cancel_reason').show();
                    $('#pipeline_reminder').hide();
                    $('#sold_amount').hide();
                    $('#lost_reason').hide();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Handler for form submission
            $('#chatinput-form').submit(function(e) {
                e.preventDefault();
                var data_id = $('#clientData_id').val();
                // Get the message from the input field
                var message = $('#chat-input').val();
                // Check if the message is not empty
                if (message.trim() !== '') {
                    // Get the CSRF token from the meta tag in your HTML
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    // AJAX call to send the message to the server
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('clientDataComment') }}',
                        headers: {
                            'X-CSRF-Token': csrfToken
                        },
                        data: {
                            message: message,
                            data_id: data_id,
                        },
                        success: function(response) {
                            // Handle the success response if needed
                            console.log(response);

                            // Clear the input field after successful submission
                            $('#chat-input').val('');

                            // Add the new message to the conversation
                            appendMessage(message);
                        },
                        error: function(error) {
                            // Handle the error if needed
                            console.error(error);
                        }
                    });
                }
            });

            function appendMessage(message) {
                $('#users-conversation').append('<li class="mb-2">' + ` <div
                                                                        class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-3 ms-0">
                                                                        <img src="{{ asset('assets/images/users/user-dummy-img.jpg') }}"
                                                                            class="rounded-circle avatar-xs"
                                                                            alt="">
                                                                        <span class="user-status"></span>
                                                                    </div>` + message + '</li>');
                var conversationDiv = $('#chat-conversation');
                conversationDiv.scrollTop(conversationDiv[0].scrollHeight);
            }

        });
    </script>
    {{-- Get Action Form Details --}}
    <script>
        $(document).ready(function() {
            $(document).on('click', '.data-select', function() {
                var data_id = $('#actionClientData_id').val(); // Use the correct ID
                // Make an AJAX request to get initial messages from the server
                $.ajax({
                    type: 'GET',
                    url: '/client/panel/form/data/' + data_id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response.data.status); // Add your handling logic here
                        if (response.data.priority == '1') {
                            $('#priority').prop('checked', true);
                        } else {
                            $('#priority').prop('checked', false);
                        }
                        $('#estimate_closing_date').val(response.data.estimate_closing_date);
                        $('#estimate_closing_amount').val(response.data
                            .estimate_closing_amount);
                        $('#estimate_closing_probability').val(response.data
                            .estimate_closing_probability);
                        $('#client-status').val(response.data.status);
                        if (response.data.status == 'Pipeline') {
                            $('#pipeline_reminder').show();
                        } else if (response.data.status == 'Sold') {
                            $('#sold_amount').show();
                        } else if (response.data.status == 'Lost') {
                            $('#lost_reason').show();
                        } else if (response.data.status == 'Cancel') {
                            $('#cancel_reason').show();
                        }
                        $('#pipeline_reminder1').val(response.data.pipeline_reminder);
                        $('#sold_amount1').val(response.data.sold_amount);
                        $('#lost_reason1').val(response.data.lost_reason);
                        $('#cancel_reason1').val(response.data.cancel_reason);
                    },
                    error: function(error) {
                        // Handle the error if needed
                        console.error(error);
                    }
                });
            });
        });
    </script>
    {{-- /Get Action Form Details --}}

    {{-- Search Filter --}}
    <script src="https://cdn.datatables.net/plug-ins/1.11.5/sorting/date-uk.js"></script>
    <script>
        $(document).ready(function() {
            // DataTable initialization
            var table = $('#example').DataTable();
            $('#allsearchFilter').on('keyup', function() {
                // Get the input value
                var globalSearchValue = $(this).val();

                // Apply the global search
                table.search(globalSearchValue).draw();
            });
            // Add event listeners to the filters
            $('#agentFilter, #statusFilter').on('change', function() {
                // Apply the filters
                var agentFilter = $('#agentFilter').val();
                var statusFilter = $('#statusFilter').val();

                table.search('').draw(); // Clear previous search

                if (agentFilter !== '') {
                    table.search(agentFilter, true, false);
                }
                if (statusFilter !== '') {
                    table.search(statusFilter, true, false);
                }

                table.draw();
            });
            // Get start and end dates
            $('#startDate, #endDate').on('change', function() {
                // Get the updated values
                var startDate = $('#startDate').val();
                // var endDate = $('#endDate').val();

                // Perform a custom search in DataTable
                table.search(startDate ).draw();
            });
        });
    </script>
    {{-- /Search Filter --}}

    {{-- Pipiline Reminder --}}
    <script>
        // Initialize a counter variable
        var notificationCount = 0;

        function checkReminder() {
            // Iterate over each element with the class "id"
            $(".id").each(function() {
                // Get the ID from the current hidden input in the loop
                var id = $(this).val();

                // Check if the id is defined before making the AJAX request
                if (id) {
                    // Make an AJAX request to fetch the pipeline reminder date and time
                    $.ajax({
                        url: '/getPipelineReminder/' + id,
                        method: 'GET',
                        success: function(response) {
                            // Check if pipeline_reminder is available in the response
                            if (response.pipeline_reminder) {
                                // Parse the response to get the reminder date and time
                                var reminderDateTime = new Date(response.pipeline_reminder);
                                var currentDateTime = new Date();

                                // Check if the reminderDateTime is in the future and within 5 minutes
                                if (reminderDateTime > currentDateTime && reminderDateTime -
                                    currentDateTime <= 300000) {
                                    // Calculate the time difference in milliseconds
                                    var timeDifference = reminderDateTime - currentDateTime;

                                    // Calculate remaining time in minutes
                                    var remainingMinutes = Math.ceil(timeDifference / (1000 * 60));

                                    // Get the message from the response, including the phone number
                                    var message = 'Phone: ' + response.phone;

                                    // Append a new notification item with the message and remaining time
                                    appendNotificationItem(message, remainingMinutes);

                                    // Update the counter and display it
                                    notificationCount++;
                                    updateNotificationCount(notificationCount);
                                }
                            }
                        },
                        error: function(error) {
                            console.error('Error fetching pipeline reminder:', error);
                        }
                    });
                } else {
                    console.error('ID is undefined');
                }
            });
        }

        function appendNotificationItem(message, remainingMinutes) {
            // Clone the template of a notification item
            var template = $('#notificationItemsTabContent #all-noti-tab .notification-item').first().clone();

            // Append the cloned template to the container
            $('#notificationItemsTabContent #all-noti-tab .pe-2').append(`<div class="text-reset notification-item d-block dropdown-item position-relative">
                                            <div class="d-flex">
                                                <div class="avatar-xs me-3 flex-shrink-0">
                                                    <span
                                                        class="avatar-title bg-info-subtle text-info rounded-circle fs-16">
                                                        <i class="bx bx-badge-check"></i>
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-2 lh-base">Pipeline reminder <br>
                                                            ` + message +
                `
                                                        </h6>
                                                    </a>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i> Remaining Time : ` +
                remainingMinutes + ` minute </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>`);
        }

        function updateNotificationCount(count) {
            // Update the count in the badge
            $(".notification-count").text(count);
        }

        // Check the reminder every 3 seconds (adjust the interval as needed)
        setInterval(checkReminder, 240000);
    </script>

    <script>
        $(document).ready(function() {
            $('#client-status').on('change', function() {
                var status = $(this).val();
                if (status == 'Pipeline') {
                    $('#pipeline_reminder1').prop('required', true);
                    $('#sold_amount1').prop('required', false);
                    $('#lost_reason1').prop('required', false);
                    $('#cancel_reason1').prop('required', false);
                } else if (status == 'Sold') {
                    $('#pipeline_reminder1').prop('required', false);
                    $('#sold_amount1').prop('required', true);
                    $('#lost_reason1').prop('required', false);
                    $('#cancel_reason1').prop('required', false);
                } else if (status == 'Lost') {
                    $('#pipeline_reminder1').prop('required', false);
                    $('#sold_amount1').prop('required', false);
                    $('#lost_reason1').prop('required', true);
                    $('#cancel_reason1').prop('required', false);
                } else if (status == 'Cancel') {
                    $('#pipeline_reminder1').prop('required', false);
                    $('#sold_amount1').prop('required', false);
                    $('#lost_reason1').prop('required', false);
                    $('#cancel_reason1').prop('required', true);
                }
            });
        });
    </script>
    
    <!-- Update Client PDF Form  -->
    <script>
        $(document).ready(function () {
          $('.addClientPdf').on('click',function(){
              var id = $(this).data('clientdataid');
              $('#clientPdf_id').val(id);
              $('#UpdateClientPDF').modal('show');
          });
        });
    </script>
@endsection
