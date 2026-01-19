@extends('Agent.common.app')
@section('main')
    <link href="{{ asset('Agent/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <style>
        .red-row {
            background-color: #ff6666 !important;
        }
    </style>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Breaks</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"></li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->


            <!-- show success and error messages -->
            @if (session('success'))
                <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
                    <div class="text-white">{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
                    <div class="text-white">{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <!-- End show success and error messages -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Break </th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Break Time Taken</th>
                                    <th scope="col">Extra</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($datas))
                                    @php $a = 0; @endphp
                                    @foreach ($datas as $data)
                                        @php $a++; @endphp
                                        <tr>
                                            <th scope="row">{{ $a }}</th>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->duration }} minutes</td>
                                           @php
                                            $currentdate = Carbon\Carbon::now('America/New_York')->toDateString();
                                            $break = App\Models\Break_detail::where('break_id', $data->id)
                                                ->where('agent_id', session('agent_id'))
                                                ->whereDate('created_at', $currentdate)
                                                ->first();
                                        
                                            // Get duration and time used in minutes
                                            $durationInMinutes = $data->duration; // Assuming duration is in minutes
                                            $timeUsedInMinutes = $break->time_use ?? 0; // Assuming time_used is in minutes
                                        
                                            // Convert both to seconds for accurate calculation
                                            $durationInSeconds = $durationInMinutes * 60;
                                            $timeUsedInSeconds = $timeUsedInMinutes * 60;
                                        
                                            // Calculate extra time in seconds
                                            $extraInSeconds = $timeUsedInSeconds - $durationInSeconds;
                                        
                                            // If extra time is negative, set it to zero (to show only excess time)
                                            $extraInSeconds = max(0, $extraInSeconds);
                                            
                                            // Function to format seconds into MM:SS
                                            $formatTime = function($totalSeconds) {
                                                $minutes = floor($totalSeconds / 60);
                                                $seconds = $totalSeconds % 60;
                                        
                                                return sprintf('%02d:%02d', $minutes, $seconds);
                                            };
                                        @endphp
                                        <td>
                                            {{ $formatTime($timeUsedInMinutes * 60) }} min
                                        </td>
                                        <td>
                                            {{ $formatTime($extraInSeconds) }} min
                                        </td>
                                            <td>
                                                @if (empty($break))
                                                    <div class="btn-group">
                                                        <a href="javascript:();">
                                                            <button type="button" class="btn btn-success">Available</button>
                                                        </a>
                                                    </div>
                                                @elseif($break->status == 0)
                                                    <div class="btn-group">
                                                        <a href="javascript:();">
                                                            <button type="button" class="btn btn-primary">Running</button>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="btn-group">
                                                        <a href="javascript:();">
                                                            <button type="button" class="btn btn-dark">Completed</button>
                                                        </a>
                                                    </div>
                                                @endif
                                                <div style="display:none" id="cnfbox{{ $a }}">
                                                    <p> Are you sure ..?</p>
                                                    <a href="#" data-bs-toggle="modal"
                                                        id="startbreak2{{ $data->id }}"
                                                        data-bs-target="#startmodal{{ $data->id }}"
                                                        class="btn btn-danger">Yes</a>
                                                    <a href="javascript:();" class="cans btn btn-default"
                                                        mydatas="{{ $a }}">No</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="startmodal{{ $data->id }}" tabindex="-1"
                                            aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="text-align: center">
                                                        <h5 class="modal-title">Break ({{ $data->duration }} minutes)</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <style>
                                                            /* Styles for timer and buttons */
                                                            #timerCanvas{{ $data->id }} {
                                                                width: 300px;
                                                                height: 300px;
                                                                display: block;
                                                                margin: 0 auto;
                                                            }

                                                            #timeLabel{{ $data->id }} {
                                                                text-align: center;
                                                                font-size: 2em;
                                                                position: absolute;
                                                                top: 40%;
                                                                left: 50%;
                                                                transform: translate(-50%, -50%);
                                                            }

                                                            .buttons {
                                                                width: 100%;
                                                                height: 50px;
                                                                margin: 50px auto 0px auto;
                                                                display: flex;
                                                                align-items: center;
                                                                justify-content: space-around;
                                                            }

                                                            .buttons p {
                                                                height: 50px;
                                                                line-height: 50px;
                                                                font-weight: 400;
                                                                padding: 0px 25px 0px 0px;
                                                                color: #333;
                                                                margin: 0px;
                                                            }

                                                            .button {
                                                                display: inline-block;
                                                                height: 50px;
                                                                box-sizing: border-box;
                                                                line-height: 46px;
                                                                text-decoration: none;
                                                                color: #333;
                                                                padding: 0px 20px;
                                                                border: solid 2px #333;
                                                                border-radius: 4px;
                                                                text-transform: uppercase;
                                                                font-weight: 700;
                                                                transition: all .2s ease-in-out;
                                                            }

                                                            .button:hover {
                                                                background-color: #333;
                                                                color: #FFF;
                                                            }

                                                            .button i {
                                                                margin-right: 5px;
                                                            }
                                                        </style>

                                                        <canvas id="timerCanvas{{ $data->id }}" width="300"
                                                            height="300"></canvas>
                                                        <div id="timeLabel{{ $data->id }}">00:00</div>

                                                        <form id="completeForm{{ $data->id }}" style="display: none;">
                                                            <input type="hidden" name="id"
                                                                value="{{ $data->id }}">
                                                            <input type="hidden" name="time"
                                                                id="elapsedTime{{ $data->id }}" value="0">
                                                        </form>

                                                        <div class="buttons">
                                                            <a href="#" class="button completeButton"
                                                                data-id="{{ $data->id }}">
                                                                Complete
                                                            </a>
                                                        </div>
                                                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                                                         <script type="text/javascript">
                                    (function() {
                                        const canvas = document.getElementById('timerCanvas{{ $data->id }}');
                                        const ctx = canvas.getContext('2d');
                                        const defaultDuration = {{ $data->duration }} * 60; // Total duration in seconds
                                        let timerInterval = null; // Ensure timerInterval is initialized as null
                                        const modalId = 'startmodal{{ $data->id }}'; // Unique modal ID for each modal
                                        const elapsedTimeKey = `elapsedTime_{{ $data->id }}`; // Key to store elapsed time in localStorage
                                        const startTimeKey = `startTime_{{ $data->id }}`; // Key to store start time in localStorage
                                        const modalStateKey = `modalState_{{ $data->id }}`; // Store modal state in localStorage
                                    
                                        // Function to start the timer
                                        function startTimer() {
                                            clearInterval(timerInterval); // Clear any existing intervals before starting a new one
                                    
                                            timerInterval = setInterval(() => {
                                                const elapsedTime = calculateElapsedTime(); // Calculate elapsed time since the start
                                                updateTimer(elapsedTime); // Update the timer display based on the elapsed time
                                            }, 1000);
                                        }
                                    
                                        // Function to update the timer and display
                                        function updateTimer(elapsedTime) {
                                            drawPieChart(elapsedTime);
                                            document.getElementById('timeLabel{{ $data->id }}').innerText = formatTime(elapsedTime);
                                            document.getElementById('elapsedTime{{ $data->id }}').value = elapsedTime; // Update hidden input
                                            localStorage.setItem(elapsedTimeKey, elapsedTime); // Save elapsed time to localStorage
                                        }
                                    
                                        // Calculate total elapsed time based on the start time stored in localStorage
                                        function calculateElapsedTime() {
                                            const startTime = parseInt(localStorage.getItem(startTimeKey));
                                            if (!startTime) return 0; // If no start time is stored, return 0
                                            const now = Math.floor(Date.now() / 1000); // Get current time in seconds
                                            return now - startTime; // Return total time elapsed since the timer started
                                        }
                                    
                                        // Draw the pie chart based on the elapsed time
                                        function drawPieChart(elapsedTime) {
                                            const radius = 100; // Radius of the pie chart
                                            const centerX = canvas.width / 2;
                                            const centerY = canvas.height / 2;
                                            const endAngle = (Math.PI * 2) * (elapsedTime / defaultDuration);
                                    
                                            // Clear the canvas
                                            ctx.clearRect(0, 0, canvas.width, canvas.height);
                                    
                                            // Draw the background circle
                                            ctx.beginPath();
                                            ctx.arc(centerX, centerY, radius, 0, Math.PI * 2);
                                            ctx.strokeStyle = '#ddd'; // Light gray for background
                                            ctx.lineWidth = 15;
                                            ctx.stroke();
                                    
                                            // Draw the progress circle
                                            ctx.beginPath();
                                            ctx.arc(centerX, centerY, radius, -Math.PI / 2, endAngle - Math.PI / 2);
                                            ctx.strokeStyle = (elapsedTime >= defaultDuration) ? 'red' : 'green'; // Change to red if over time
                                            ctx.lineWidth = 15;
                                            ctx.stroke();
                                        }
                                    
                                        // Format time as MM:SS
                                        function formatTime(seconds) {
                                            const minutes = Math.floor(seconds / 60);
                                            const secs = seconds % 60;
                                            return `${pad(minutes)}:${pad(secs)}`;
                                        }
                                    
                                        // Pad single digits with a leading zero
                                        function pad(val) {
                                            return val < 10 ? "0" + val : val;
                                        }
                                    
                                        // Modal event listeners
                                        var modal = document.getElementById(modalId);
                                        modal.addEventListener('shown.bs.modal', function() {
                                            const startTime = localStorage.getItem(startTimeKey);
                                            if (!startTime) {
                                                localStorage.setItem(startTimeKey, Math.floor(Date.now() / 1000)); // Set start time if it doesn't exist
                                            }
                                            startTimer(); // Start the timer when the modal is shown
                                        });
                                    
                                        modal.addEventListener('hidden.bs.modal', function() {
                                            clearInterval(timerInterval); // Clear the interval when modal is closed
                                            const currentTime = Math.floor(Date.now() / 1000); // Get current time in seconds
                                            localStorage.setItem(startTimeKey, currentTime); // Store the start time when modal is closed
                                        });
                                    
                                        // AJAX submit on complete button click
                                        document.querySelector('.completeButton[data-id="{{ $data->id }}"]').addEventListener('click', function(event) {
                                            event.preventDefault(); // Prevent default anchor behavior
                                            event.stopPropagation();
                                    
                                            const form = document.getElementById('completeForm{{ $data->id }}');
                                            const formData = new FormData(form);
                                    
                                            // Send data via AJAX
                                            fetch('{{ route('complete_break_process') }}', { // Replace with your actual endpoint
                                                method: 'POST',
                                                headers: {
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include CSRF token for Laravel
                                                },
                                                body: formData,
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                localStorage.removeItem(elapsedTimeKey); // Clear the elapsed time when the modal is closed
                                                localStorage.removeItem(startTimeKey);
                                                localStorage.removeItem(modalStateKey); // Clear the modal state
                                                const modal = document.getElementById(modalId);
                                                const modalInstance = bootstrap.Modal.getInstance(modal); // Use Bootstrap's modal instance
                                                modalInstance.hide(); // Hide the modal
                                    
                                                // Refresh the page
                                                location.reload();
                                            })
                                            .catch((error) => {
                                                console.error('Error:', error);
                                            });
                                        });
                                    
                                        // Store modal state in localStorage
                                        window.addEventListener('beforeunload', function() {
                                            if ($('#' + modalId).hasClass('show')) {
                                                localStorage.setItem(modalStateKey, 'open'); // Save modal state as 'open'
                                            } else {
                                                localStorage.setItem(modalStateKey, 'closed'); // Save modal state as 'closed'
                                            }
                                        });
                                    
                                        $(document).ready(function() {
                                            // Function to check local storage and open the modal if it was open
                                            function checkModalState() {
                                                if (localStorage.getItem(modalStateKey) === 'open') {
                                                    $('#' + modalId).modal('show'); // Show the modal if it was previously open
                                                    startTimer(); // Resume the timer when the modal is reopened
                                                }
                                            }
                                    
                                            // Check the modal state on page load
                                            checkModalState();
                                    
                                            // When the modal is opened, store the state as 'open'
                                            $('#' + modalId).on('shown.bs.modal', function() {
                                                localStorage.setItem(modalStateKey, 'open');
                                            });
                                    
                                            // When the modal is closed, store the state as 'closed'
                                            $('#' + modalId).on('hidden.bs.modal', function() {
                                                localStorage.setItem(modalStateKey, 'closed');
                                                localStorage.removeItem(elapsedTimeKey); // Clear the elapsed time when the modal is closed
                                                localStorage.removeItem(startTimeKey); // Clear the start time when the modal is closed
                                            });
                                        });
                                    })();
                                    </script>

                                                        <script type="text/javascript">
                                                            $(document).ready(function() {
                                                                $('#startbreak2{{ $data->id }}').click(function(event) {
                                                                    event.preventDefault(); // Prevent default action

                                                                    // Data to be sent with the POST request
                                                                    const formData = new FormData();
                                                                    formData.append('id', {{ $data->id }}); // Break ID
                                                                    formData.append('time', 0); // Initialize time to 0

                                                                    $.ajax({
                                                                        url: '{{ route('start_break') }}', // Your route for handling the request
                                                                        type: 'POST',
                                                                        data: formData,
                                                                        processData: false, // Important for FormData
                                                                        contentType: false, // Important for FormData
                                                                        headers: {
                                                                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for Laravel
                                                                        },
                                                                        success: function(response) {
                                                                            if (response.success) {


                                                                            } else {
                                                                                // Handle error response
                                                                                alert('An error occurred: ' + response.message);
                                                                            }
                                                                        },
                                                                        error: function(xhr, status, error) {
                                                                            // Handle AJAX errors
                                                                            console.error('AJAX error:', error);
                                                                            alert('AJAX request failed. Please try again.');
                                                                        }
                                                                    });
                                                                });
                                                            });
                                                        </script>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </tbody>


                            <tfoot>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Break </th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Break Time Taken</th>
                                    <th scope="col">Extra</th>
                                    <th scope="col">Action</th>
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
            $('.dCnf').click(function(e) {
                e.preventDefault();
                var mydata = $(this).attr('mydata');
                $('#cnfbox' + mydata).show();
            });

            $('.cans').click(function(e) {
                e.preventDefault();
                var mydata = $(this).attr('mydatas');
                $('#cnfbox' + mydata).hide();
            });
        });
    </script>
@endsection
