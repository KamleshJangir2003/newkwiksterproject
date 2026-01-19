@extends('admin.common.app')
@section('main')
	<link href="{{ asset('Agent/assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
	<link href="{{ asset('Agent/assets/plugins/fullcalendar/css/main.min.css')}}" rel="stylesheet" />
	<link href="{{ asset('Agent/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" />
	<link href="{{ asset('Agent/assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
	
	<!-- Bootstrap CSS -->
	<link href="{{ asset('Agent/assets/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{ asset('Agent/assets/css/bootstrap-extended.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="{{ asset('Agent/assets/css/app.css')}}" rel="stylesheet">
	<link href="{{ asset('Agent/assets/css/icons.css')}}" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="{{ asset('Agent/assets/css/dark-theme.css')}}" />
	<link rel="stylesheet" href="{{ asset('Agent/assets/css/semi-dark.css')}}" />
	<link rel="stylesheet" href="{{ asset('Agent/assets/css/header-colors.css')}}" />
	<style>
		.fc-event-green {
    background-color: #4caf50; /* Green color */
    color: white; /* Text color */
}

.fc-event-yellow {
    background-color: rgb(227, 189, 73); /* Yellow color */
    color: black !important; /* Text color */
}

.fc-event-red {
    background-color: #f44336; /* Red color */
    color: white; /* Text color */
}
.fc-event-begani {
    background-color: rgb(225, 0, 255); /* Red color */
    color: white; /* Text color */
}

    .fc-today {
        background-color: rgb(255, 0, 0) !important;
    }
    .fc-sunday {
        background-color: lightblue !important;
    }

	</style>
	{{-- <style>
		@keyframes blink {
			0% {
				opacity: 1;
			}
			50% {
				opacity: 0;
			}
			100% {
				opacity: 1;
			}
		}
	
		.blink {
			animation: blink 1s infinite;
		}
	</style> --}}

		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
					<div class="col">
						<div class="card radius-10 border-start border-0 border-4 border-success">
							<div class="card-body">
								<div style="text-align: center">
									<p class="mb-0 text-secondary">Salary</p>
									<h4 class="my-1 text-success blink" id="salary">0</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 border-start border-0 border-4 border-warning">
							<div class="card-body">
								<div style="text-align: center">
									<p class="mb-0 text-secondary">Available Paid Leaves</p>
									<h4 class="my-1 text-warning" id="availableH4">0</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 border-start border-0 border-4" style="border-color: orangered !important;">
							<div class="card-body">
								<div style="text-align: center">
									<p class="mb-0 text-secondary">Bonus/Incestive Amount</p>
									<h4 class="my-1" style="color:red" id="bonusH4">0</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 border-start border-0 border-4 "  style="border-color: rgb(225, 0, 255) !important;">
							<div class="card-body">
								<div style="text-align: center">
									<p class="mb-0 text-secondary">Advance</p>
									<h4 class="my-1" style="color:rgb(225, 0, 255)" id="advanceH4">0</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 border-start border-0 border-4 border-success">
							<div class="card-body">
								<div style="text-align: center">
									<p class="mb-0 text-secondary">Present</p>
									<h4 class="my-1 text-success" id="present_count">0</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 border-start border-0 border-4 border-warning">
							<div class="card-body">
								<div style="text-align: center">
									<p class="mb-0 text-secondary">Half Day</p>
									<h4 class="my-1 text-warning" id="halfday_count">0</h4>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 border-start border-0 border-4" style="border-color: orangered !important;">
							<div class="card-body">
								<div style="text-align: center">
									<p class="mb-0 text-secondary">Absent</p>
									<h4 class="my-1" style="color:red" id="absent_count">0</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 border-start border-0 border-4 "  style="border-color: rgb(225, 0, 255) !important;">
							<div class="card-body">
								<div style="text-align: center">
									<p class="mb-0 text-secondary">Paid Leave</p>
									<h4 class="my-1" style="color:rgb(225, 0, 255)" id="paid_count">0</h4>
								</div>
							</div>
						</div>
					</div>
					
				</div><!--end row-->
				<form action="{{ route('store_salary_cycle') }}" method="post">
					@csrf
				<div class="row g-4 align-items-center" style="margin-bottom: 10px">
					<div class="col-sm-5">
						<div class="search-box">
							<select class="form-select" id="agent">
								<option>Select Agent</option>
								@if(!empty($agents))
								@foreach($agents as $agent)
								<option value="{{$agent->id}}">{{$agent->name}}</option>
								@endforeach
								@endif
							  </select>
						</div>
					</div>
					   <div class="col-sm-3">
					   	<div class="search-box">
							@php
                              // Get the current month name
                             $currentMonth = \Carbon\Carbon::now()->format('F');
							 $previousMonth = \Carbon\Carbon::now()->subMonth()->format('F');
                            @endphp
					   		<input type="text" name="Start_day" id="start_day" class="form-control search" placeholder="Enter day" value="{{$salary_cycle->start_date}} {{$previousMonth}}">
					   	</div>
					   </div>
					   <div class="col-sm-3">
					   	<div class="search-box">
					   		<input type="text" name="end_day" id="end_day" class="form-control search" value="" readonly>
					   	</div>
					   </div>
					   <div class="col-sm-1">
					   	<button type="submit" class=" btn-success" style="margin-right:5px"><i class="ti-search"></i></button> 
					   </div>
				</div>
			</form>
				<!--end breadcrumb-->
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<div id='calendar'></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--end page wrapper -->
		<!-- import leads model -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog"
aria-labelledby="exampleModalLongTitle" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Update Attendence </h5>
            <button type="button" class="close" data-dismiss="modal"
                aria-label="Close" onclick="close_modal()">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="card-body">
                    <div class="row mb-3">
						<div class="col-sm-9">
							<div class="form-check">
								<input class="form-check-input" type="radio" name="attendance" id="present" value="present">
								<label class="form-check-label" for="present">
									Present
								</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="attendance" id="halfday" value="halfday">
								<label class="form-check-label" for="halfday">
								   Half Day
								</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="attendance" id="absent" value="absent">
								<label class="form-check-label" for="absent">
									Absent
								</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="attendance" id="paid" value="paid">
								<label class="form-check-label" for="paid">
									Paid Leave
								</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="attendance" id="none" value="none">
								<label class="form-check-label" for="none">
									None
								</label>
							</div>
						</div>
						<input type="hidden" id="event_date" name="date" value="">
						<input type="hidden" id="agent_user_id" name="agent_user_id" value="">
                        </div>
                    </div>
            </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary"
                data-dismiss="modal" onclick="close_modal()">Close</button>
            <button type="button" class="btn btn-primary"  onclick="submitForm()">Submit</button>
		</div>
    </div>
</div>
</div>
<!--End import leads model -->

<!-- salary model -->
<div class="modal fade" id="salarymodal" tabindex="-1" role="dialog"
aria-labelledby="exampleModalLongTitle" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Salary Details</h5>
            <button type="button" class="close" data-dismiss="modal"
                aria-label="Close" id="closeicon">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="card-body">
				<div class="col-12">
					<div class="card radius-10">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<p class="mb-2 " style="margin-right: 5px"> Per Day Salary : <span id="per_sal">0</span></p>
									<p class="mb-2 "  style="margin-right: 5px"> present  : <span id="pre_sal">0</span> (<span id="pre_count">0</span>)</p>
									<p class="mb-2 "  style="margin-right: 5px"> Halfday  : <span id="half_sal">0</span> (<span id="half_count">0</span>)</p>
									<p class="mb-2 "  style="margin-right: 5px"> Paid leave  : <span id="paid_sal">0</span> (<span id="paidleave_count">0</span>)</p>
									<p class="mb-2 "  style="margin-right: 5px"> holidays  : <span id="holi_sal">0</span> (<span id="holi_count">0</span>)</p>
									<p class="mb-2 "  style="margin-right: 5px"> Sunday : <span id="sund_sal">0</span> (<span id="sund_count">0</span>)</p>
									<p class="mb-2 "  style="margin-right: 5px"> Bonus  : <span id="bonus_sal">0</span></p>
									<p class="mb-2 "  style="margin-right: 5px"> Advance : <span id="adv_sal">0</span></p>
									<h5 class="mb-2"  style="margin-top: 10px;border:solid 1px black;padding:10px">Basic Salary : <span id="basic_sal">0</span></h5>
									<p class="mb-2 "  style="margin-right: 5px"> Adherence Bonus : <span id="adherence">0</span></p>
									<h5 class="mb-2"  style="margin-top: 10px;border:solid 1px black;padding:10px">Total Salary : <span id="total_sal">0</span></h5>


								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary"
                data-dismiss="modal" id="closebutton">Close</button>
		</div>
    </div>
</div>
</div>
<!--End salary model -->

		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<footer class="page-footer">
			<p class="mb-0">Copyright © 2023. All right reserved.</p>
		</footer>
	</div>
	<!--end wrapper-->

	
	<!-- Bootstrap JS -->
	<script src="{{ asset('Agent/assets/js/bootstrap.bundle.min.js')}}"></script>
	<!--plugins-->
	<script src="{{ asset('Agent/assets/js/jquery.min.js')}}"></script>
	<script src="{{ asset('Agent/assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
	<script src="{{ asset('Agent/assets/plugins/fullcalendar/js/main.min.js')}}"></script>
	<script src="{{ asset('Agent/assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
	<script src="{{ asset('Agent/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
	<script>
		function submitForm() {
        var attendanceData = {
            attendance: document.querySelector('input[name="attendance"]:checked').value,
            date: document.getElementById('event_date').value,
            agent_user_id: document.getElementById('agent_user_id').value
        };

        $.ajax({
            url: '{{ route('update_attendence_calender') }}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: attendanceData,
			success: function(response) {
    console.log('Success:', response);
    close_modal(); // Close modal after successful submission

    if (typeof calendar !== 'undefined') {
        calendar.refetchEvents();
    } else {
        console.error('FullCalendar is not initialized or accessible.');
    }
},

            error: function(xhr, status, error) {
                // Handle error
                console.error('Error:', xhr.responseText);
                // Optionally handle error display or logging
            }
        });
    }
	function close_modal(){
			$('#eventModal').modal('hide');
		}
   </script>
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			var calendarEl = document.getElementById('calendar');
			var userId = 2; // Example user ID

			 // Handle change event of agent select dropdown
			 $('#agent').on('change', function() {
            var selectedAgentId = $(this).val();
            userId = selectedAgentId;
            // Update FullCalendar events with the new userId
            calendar.refetchEvents();
        });
	
			var calendar = new FullCalendar.Calendar(calendarEl, {
				headerToolbar: {
					left: 'prev,next today',
					center: 'title',
					right: 'dayGridMonth'
				},
				initialView: 'dayGridMonth',
				initialDate: new Date().toISOString().slice(0, 10), // Use today's date
				events: function (fetchInfo, successCallback, failureCallback) {
					var startDate = new Date(fetchInfo.start);
                  var endDate = new Date(fetchInfo.end);
                 var midpointDate = new Date((startDate.getTime() + endDate.getTime()) / 2);
                 var formattedMidpointDate = midpointDate.toISOString().slice(0, 10); // Fo
					$.ajax({
						url: '{{ route('get_attendance') }}',
						type: 'POST',
						contentType: 'application/json',
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						data: JSON.stringify({
							user_id: userId,
							date: formattedMidpointDate
						}),
						success: function (response) {
							$('#present_count').text(response.counts.present);
					        $('#absent_count').text(response.counts.absent);
					        $('#paid_count').text(response.counts.paidleave);
					        $('#halfday_count').text(response.counts.halfday);
					        $('#availableH4').text(response.counts.available_paid);
					        $('#bonusH4').text(response.counts.bonus);
					        $('#advanceH4').text(response.counts.advance);
					     
					        $('#pre_count').text(response.salary.present);
					        $('#half_count').text(response.salary.halfday);
					        $('#paidleave_count').text(response.salary.paidleave);
					        $('#holi_count').text(response.salary.holidays);
					        $('#sund_count').text(response.salary.sunday);
							var perdaysalary = response.salary.perdaysalary;
							var formattedPerDaySalary = perdaysalary.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
							var persent_salary = formattedPerDaySalary*response.salary.present;
							var halfdaysalary = formattedPerDaySalary*response.salary.halfday/2;
							var paidleavesalary = formattedPerDaySalary*response.salary.paidleave;
							var holidaysalary = formattedPerDaySalary*response.salary.holidays;
							var sundaysalary = formattedPerDaySalary*response.salary.sunday;
							var formattedbasic =  response.salary.totalsalary.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
							var finalsalary =  response.salary.finalsalary.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
							$('#salary').text(finalsalary);
							$('#pre_sal').text(persent_salary);
							$('#half_sal').text(halfdaysalary);
							$('#paid_sal').text(paidleavesalary);
							$('#holi_sal').text(holidaysalary);
							$('#sund_sal').text(sundaysalary);
							$('#per_sal').text(formattedPerDaySalary);
							$('#bonus_sal').text(response.salary.bonus);
							$('#adv_sal').text(response.salary.advance);
							$('#basic_sal').text(formattedbasic);
							$('#adherence').text(response.counts.adherence);
							$('#total_sal').text(finalsalary);
							
					
							
							var events = [];
							response.events.forEach(function (event) {
								var classNames = [];
								if (event.title === 'Present') {
									classNames.push('fc-event-green');
								} else if (event.title === 'Half Day') {
									classNames.push('fc-event-yellow');
								} else if (event.title === 'Absent') {
									classNames.push('fc-event-red');
								}
								else if (event.title === 'Paid Leave') {
									classNames.push('fc-event-begani');
								}
	
								events.push({
									title: event.title,
									start: event.start,
									end: event.end,
									classNames: classNames,
									description: event.description // If you have additional data to pass to modal
								});
							});
							successCallback(events);
						},
						error: function () {
							failureCallback();
						}
					});
				},
				eventClick: function (info) {
					// Open modal with event details
					var event = info.event;
					var title = event.title;
					var start = event.start;
					var User_id = userId;
	
					// Example modal open function
					openModal(title, start ,User_id);
				},
				dayCellClassNames: function (arg) {
					var classes = [];
					if (arg.date.getDay() === 0) { // Check if Sunday
						classes.push('fc-sunday');
					}
					return classes;
				}
			});
	
			calendar.render();
	
			function openModal(title, start, User_id) {
				$('#event_date').val(start);
				$('#agent_user_id').val(User_id);
				
	
				if (title === 'Present') {
					$('#present').prop('checked', true); // Select the radio button with id 'present'
				} else {
					// Clear selection if title is not 'Present' (optional)
					$('#present').prop('checked', false);
				}
				if (title === 'Half Day') {
					$('#halfday').prop('checked', true); // Select the radio button with id 'halfday'
				} else {
					// Clear selection if title is not 'Half Day' (optional)
					$('#halfday').prop('checked', false);
				}
				if (title === 'Absent') {
					$('#absent').prop('checked', true); // Select the radio button with id 'absent'
				} else {
					// Clear selection if title is not 'Absent' (optional)
					$('#absent').prop('checked', false);
				}
				if (title === 'Paid Leave') {
					$('#paid').prop('checked', true); // Select the radio button with id 'absent'
				} else {
					// Clear selection if title is not 'Absent' (optional)
					$('#paid').prop('checked', false);
				}
				if (title === 'Absent' || title === 'Half Day' || title === 'Present' || title === 'Paid Leave') {
					$('#eventModal').modal('show');
				}
			}
		});
	</script>
	<script>
		// Run the script when the page loads or if there's initial data in the input
		document.addEventListener('DOMContentLoaded', function() {
			var startDayInput = document.getElementById('start_day');
			var startDayValue = startDayInput.value.trim();
	
			if (startDayValue) {
				updateEndDate(startDayValue);
			}
	
			startDayInput.addEventListener('input', function() {
				var startDay = this.value.trim();
				if (startDay) {
					updateEndDate(startDay);
				} else {
					document.getElementById('end_day').value = '';
				}
			});
	
			function updateEndDate(startDay) {
				// Split the input into day and month
				var parts = startDay.split(' ');
				var day = parseInt(parts[0]);
				var monthName = parts[1];
	
				// Get month names and days in each month
				var monthData = {
					'January': 31, 'February': 28, 'March': 31, 'April': 30, 'May': 31, 'June': 30,
					'July': 31, 'August': 31, 'September': 30, 'October': 31, 'November': 30, 'December': 31
				};
	
				// Find the index of the current month
				var startMonthIndex = Object.keys(monthData).indexOf(monthName);
				if (startMonthIndex !== -1) {
					var endMonthIndex = startMonthIndex + 1;
					if (endMonthIndex >= 12) {
						endMonthIndex = 0; // Wrap around to January if December
					}
					var endMonthName = Object.keys(monthData)[endMonthIndex];
	
					// Calculate the end date as one day before the start date in the next month
					var daysInEndMonth = monthData[endMonthName];
					var endDate = (day - 1 <= daysInEndMonth) ? (day - 1) + ' ' + endMonthName : daysInEndMonth + ' ' + endMonthName;
					document.getElementById('end_day').value = endDate;
				}
			}
		});
	</script>
	<script>
		// Select the <h4> element
		const h4Element = document.getElementById('availableH4');
		
		// Add click event listener
		h4Element.addEventListener('click', function() {
			// Prompt user for input
			const userInput = prompt('Enter something:');
		
			if (userInput) {
				var selectedAgentId = $('#agent').val();
				agentId = selectedAgentId;
		        var type = "available";
            $.ajax({
				url: '{{ route('edit_salary_datas') }}', // Replace with your Laravel route
				type: 'POST',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				contentType: 'application/json',
				data: JSON.stringify({
							agent_id: agentId,
							type: type,
							Userinput: userInput,
						}),
				success: function(response) {
					$('#availableH4').text(response.final_value);
				},
				error: function(xhr, status, error) {
					console.error('Error:', error);
					// Handle error response here
				}
			});
        }
		});
		</script>
		<script>
			// Select the <h4> element
			const h4bonus = document.getElementById('bonusH4');
			
			// Add click event listener
			h4bonus.addEventListener('click', function() {
				// Prompt user for input
				const userInput = prompt('Enter something:');
			
				if (userInput) {
					var selectedAgentId = $('#agent').val();
					agentId = selectedAgentId;
					var type = "bonus";
				$.ajax({
					url: '{{ route('edit_salary_datas') }}', // Replace with your Laravel route
					type: 'POST',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					contentType: 'application/json',
					data: JSON.stringify({
								agent_id: agentId,
								type: type,
								Userinput: userInput,
							}),
					success: function(response) {
						$('#bonusH4').text(response.final_value);
					},
					error: function(xhr, status, error) {
						console.error('Error:', error);
						// Handle error response here
					}
				});
			}
			});
			</script>
			<script>
				// Select the <h4> element
				const h4advance = document.getElementById('advanceH4');
				
				// Add click event listener
				h4advance.addEventListener('click', function() {
					// Prompt user for input
					const userInput = prompt('Enter something:');
				
					if (userInput) {
						var selectedAgentId = $('#agent').val();
						agentId = selectedAgentId;
						var type = "advance";
					$.ajax({
						url: '{{ route('edit_salary_datas') }}',
						type: 'POST',
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						contentType: 'application/json',
						data: JSON.stringify({
									agent_id: agentId,
									type: type,
									Userinput: userInput,
								}),
						success: function(response) {
							$('#advanceH4').text(response.final_value);
						},
						error: function(xhr, status, error) {
							console.error('Error:', error);
							// Handle error response here
						}
					});
				}
				});
				</script>
				<script>
					$(document).ready(function(){
						$('#salary').on('click', function() {
							$('#salarymodal').modal('show');
						});
				
						 $('#closebutton').on('click', function() {
							$('#salarymodal').modal('hide');
						});
						$('#closeicon').on('click', function() {
							$('#salarymodal').modal('hide');
						});
					});
				</script>
		
	

@endsection