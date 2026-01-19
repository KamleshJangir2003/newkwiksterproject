@extends('Agent.common.app')
@section('main')
	<link href="{{ asset('Agent/assets/plugins/fullcalendar/css/main.min.css')}}" rel="stylesheet" />
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
				<div class="row">
					<div class="col-sm-2">
						<div class="card radius-10 border-start border-0 border-4 border-success">
							<div class="card-body">
								<div style="text-align: center">
									<p class="mb-0 text-secondary">Present</p>
									<h4 class="my-1 text-success" id="present_count">0</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="card radius-10 border-start border-0 border-4 border-warning">
							<div class="card-body">
								<div style="text-align: center">
									<p class="mb-0 text-secondary">Half Day</p>
									<h4 class="my-1 text-warning" id="halfday_count">0</h4>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="card radius-10 border-start border-0 border-4" style="border-color: orangered !important;">
							<div class="card-body">
								<div style="text-align: center">
									<p class="mb-0 text-secondary">Absent</p>
									<h4 class="my-1" style="color:red" id="absent_count">0</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="card radius-10 border-start border-0 border-4 "  style="border-color: rgb(225, 0, 255) !important;">
							<div class="card-body">
								<div style="text-align: center">
									<p class="mb-0 text-secondary">Paid Leave</p>
									<h4 class="my-1" style="color:rgb(225, 0, 255)" id="paid_count">0</h4>
								</div>
							</div>
						</div>
					</div>
                    <div class="col-sm-2">
						<div class="card radius-10 border-start border-0 border-4 "  style="border-color: lightblue !important;">
							<div class="card-body">
								<div style="text-align: center">
									<p class="mb-0 text-secondary">Sundays</p>
									<h4 class="my-1" style="color:lightblue" id="sunday_count">0</h4>
								</div>
							</div>
						</div>
					</div>
                    <div class="col-sm-2">
						<div class="card radius-10 border-start border-0 border-4 "  style="border-color: #3788d8 !important;">
							<div class="card-body">
								<div style="text-align: center">
									<p class="mb-0 text-secondary">Holidays</p>
									<h4 class="my-1" style="color:#3788d8" id="holiday_count">0</h4>
								</div>
							</div>
						</div>
					</div>
					
				</div><!--end row-->
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

	
	
	<script src="{{ asset('Agent/assets/plugins/fullcalendar/js/main.min.js')}}"></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
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
						url: '{{ route('agent_get_attendance') }}',
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
					        $('#sunday_count').text(response.counts.sundaycount);
					        $('#holiday_count').text(response.counts.holidaycount);
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
				dayCellClassNames: function (arg) {
					var classes = [];
					if (arg.date.getDay() === 0) { // Check if Sunday
						classes.push('fc-sunday');
					}
					return classes;
				}
			});
	
			calendar.render();
		});
	</script>
		
@endsection