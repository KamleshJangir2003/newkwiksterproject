<!-- JAVASCRIPT -->
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>

<!-- apexcharts -->
<script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- Vector map-->
<script src="{{ asset('assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
<script src="{{ asset('assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

<!--Swiper slider js-->
<script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>

<!-- Dashboard init -->
<script src="{{ asset('assets/js/pages/dashboard-ecommerce.init.js') }}"></script>

<!-- list.js min js -->
<script src="{{ asset('assets/libs/list.js/list.min.js') }}"></script>
<script src="{{ asset('assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>

<!-- Sweet Alerts js -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- Sweet alert init js-->
<script src="{{ asset('assets/js/pages/sweetalerts.init.js') }}"></script>

<!-- crm leads init -->
<script src="{{ asset('assets/js/pages/crm-leads.init.js') }}"></script>

<!-- prismjs plugin -->
<script src="{{ asset('assets/libs/prismjs/prism.js') }}"></script>

<!-- notifications init -->
<script src="{{ asset('assets/js/pages/notifications.init.js') }}"></script>

<!-- App js -->
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="{{ asset('assets/js/toastr.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('assets/js/popup.js') }}"></script>
<script>
    function openTimer() {
        localStorage.setItem('click', '1');
        setTimeout(function() {
            localStorage.removeItem('click');
        }, 8 * 60 * 60 * 1000);
        openTimerPopup();
        var disableBtn = document.querySelector('.disablebtn');
        var clickValue = localStorage.getItem('click');
        if (clickValue === '1') {
            disableBtn.style.display = 'none';
        } else {
            disableBtn.style.display = 'block';
        }
    }
    $(document).ready(function() {

        var clickValue = localStorage.getItem('click');
        if (clickValue === '1') {
            $('.disablebtn').hide()
        } else {
            $('.disablebtn').show()
        }
    });
</script>
<script>
    Echo.channel('events')
        .listen('RealTimeMessage', (e) => console.log('RealTimeMessage: ' + e.message));
</script>
<script>
    $('.chosen-select').chosen();
    $('.chosen-container').css('min-width', '366px');
    $('.chosen-single').css({
        'min-height': '35px',
        'background': 'white',
        'line-height': '32px'
    });
</script>

{{-- Export Table --}}

{{-- /Export Table --}}

<script>
    $(document).ready(function() {
        // Check if there is a success message in the session
        var successMessage = "{{ session('success') }}";

        if (successMessage) {
            // Show the toastr notification
            toastr.success(successMessage, 'Success', {
                closeButton: true,
                progressBar: true,
                timeOut: 3000,
                positionClass: 'toast-top-center'
            });
        }
        var errorMessage = "{{ session('error') }}";

        if (errorMessage) {
            // Show the toastr notification
            toastr.error(errorMessage, 'Error', {
                closeButton: true,
                progressBar: true,
                timeOut: 3000,
                positionClass: 'toast-top-center'
            });
        }
    });
</script>
{{-- Ckeditor --}}
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor5/40.0.0/ckeditor.min.js"></script>
<script>
    ClassicEditor.create(document.querySelector("#editor")).catch((error) => {});
</script>
{{-- /Ckeditor --}}
{{-- Leads Data Get --}}
<script>
    $(document).ready(function() {
        $('.data-select').on('click', function() {
            var dataId = $(this).data('id');

            // Make an AJAX request to fetch data based on the data ID
            $.ajax({
                url: '/agent/get/data/' + dataId, // Replace with your actual API endpoint
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
            $('#data_id').val(data.id);
            $('#company_name').val(data.company_name);
            $('#phone').val(data.phone);
            $('#email').val(data.email);
            $('#company_rep1').val(data.company_rep1);
            $('#business_address').val(data.business_address);
            $('#business_city').val(data.business_city);
            $('#business_state').val(data.business_state);
            $('#business_zip').val(data.business_zip);
            $('#dot').val(data.dot);
            $('#mc_docket').val(data.mc_docket);

            // Set the selected option for form_status and unit_owned
            $('#form_status').val(data.form_status).prop('selected', true);
            $('#reminder').val(data.reminder);
            var commodities = data.commodities;

            if (commodities) {
            if (typeof commodities === 'string') {
            commodities = JSON.parse(commodities);
            }
            if (Array.isArray(commodities) && commodities.length > 0) {
            $.each(commodities, function(index, value) {
                $('input[name="commodities[]"][value="' + value + '"]').prop('checked', true);
            });
            }
            }
            $('#unit_owned').val(data.unit_owned).prop('selected', true);
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

            $('#vin').val(data.vin);
            $('#driver_name').val(data.driver_name);
            $('#driver_dob').val(data.driver_dob);
            $('#driver_license').val(data.driver_license);
            $('#driver_license_state').val(data.driver_license_state);
            $('#vehicle_year').val(data.vehicle_year);
            $('#vehicle_make').val(data.vehicle_make);
            $('#stated_value').val(data.stated_value);
            // 2
            $('#vin2').val(data.vin2);
            $('#driver_name2').val(data.driver_name2);
            $('#driver_dob2').val(data.driver_dob2);
            $('#driver_license2').val(data.driver_license2);
            $('#driver_license_state2').val(data.driver_license_state2);
            $('#vehicle_year2').val(data.vehicle_year2);
            $('#vehicle_make2').val(data.vehicle_make2);
            $('#stated_value2').val(data.stated_value2);
            // 3
            $('#vin3').val(data.vin3);
            $('#driver_name3').val(data.driver_name3);
            $('#driver_dob3').val(data.driver_dob3);
            $('#driver_license3').val(data.driver_license3);
            $('#driver_license_state3').val(data.driver_license_state3);
            $('#vehicle_year3').val(data.vehicle_year3);
            $('#vehicle_make3').val(data.vehicle_make3);
            $('#stated_value3').val(data.stated_value3);
            // 4
            $('#vin4').val(data.vin4);
            $('#driver_name4').val(data.driver_name4);
            $('#driver_dob4').val(data.driver_dob4);
            $('#driver_license4').val(data.driver_license4);
            $('#driver_license_state4').val(data.driver_license_state4);
            $('#vehicle_year4').val(data.vehicle_year4);
            $('#vehicle_make4').val(data.vehicle_make4);
            $('#stated_value4').val(data.stated_value4);
            // 5
            $('#vin5').val(data.vin5);
            $('#driver_name5').val(data.driver_name5);
            $('#driver_dob5').val(data.driver_dob5);
            $('#driver_license5').val(data.driver_license5);
            $('#driver_license_state5').val(data.driver_license_state5);
            $('#vehicle_year5').val(data.vehicle_year5);
            $('#vehicle_make5').val(data.vehicle_make5);
            $('#stated_value5').val(data.stated_value5);

            $('#comment').val(data.comment);

            $('#progress-bar').removeClass('bg-success bg-warning bg-info bg-danger').addClass(
                getProgressBarClass(data.form_status));
            $('#progress-bar').css('width', data.form_status_value + '%');
            $('#model-form-status').text(data.form_status);
            // ... update other fields ...

            // Show the modal
            $('#leaddata').modal('show');
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

        $('#form_status').on('change', function() {
            var status = $(this).val();
            if (status == 'Intrested') { // Corrected 'Intrested' to 'Interested'
                $('#company_name').prop('required', true);
                $('#phone').prop('required', true);
                $('#company_rep1').prop('required', true);
                $('#business_address').prop('required', true);
                $('#business_city').prop('required', true);
                $('#business_state').prop('required', true);
                $('#business_zip').prop('required', true);
                $('#dot').prop('required', true);
                $('#mc_docket').prop('required', true);
                $('#unit_owned').prop('required', true);
                $('#vin').prop('required', true);
                $('#driver_name').prop('required', true);
                $('#driver_dob').prop('required', true);
                $('#driver_license').prop('required', true);
                $('#driver_license_state').prop('required', true);
            } else if (status == 'Pipeline') {
                $('#company_name').prop('required', false);
                $('#phone').prop('required', false);
                $('#company_rep1').prop('required', false);
                $('#business_address').prop('required', false);
                $('#business_city').prop('required', false);
                $('#business_state').prop('required', false);
                $('#business_zip').prop('required', false);
                $('#dot').prop('required', false);
                $('#mc_docket').prop('required', false);
                $('#unit_owned').prop('required', false);
                $('#vin').prop('required', false);
                $('#driver_name').prop('required', false);
                $('#driver_dob').prop('required', false);
                $('#driver_license').prop('required', false);
                $('#driver_license_state').prop('required', false);
            }
        });

        // Single Lead Form
        $('#form_status_single').on('change', function() {
            var status = $(this).val();
            if (status == 'Intrested') { // Corrected 'Intrested' to 'Interested'
                $('#company_name_single').prop('required', true);
                $('#phone_single').prop('required', true);
                $('#company_rep_single1').prop('required', true);
                $('#business_address_single').prop('required', true);
                $('#business_city_single').prop('required', true);
                $('#business_state_single').prop('required', true);
                $('#business_zip_single').prop('required', true);
                $('#dot_single').prop('required', true);
                $('#mc_docket_single').prop('required', true);
                $('#unit_owned_single').prop('required', true);
                $('#vin_single').prop('required', true);
                $('#driver_name_single').prop('required', true);
                $('#driver_dob_single').prop('required', true);
                $('#driver_license_single').prop('required', true);
                $('#driver_license_state_single').prop('required', true);
            } else if (status == 'Pipeline') {
                $('#company_name_single').prop('required', false);
                $('#phone_single').prop('required', false);
                $('#company_rep_single1').prop('required', false);
                $('#business_address_single').prop('required', false);
                $('#business_city_single').prop('required', false);
                $('#business_state_single').prop('required', false);
                $('#business_zip_single').prop('required', false);
                $('#dot_single').prop('required', false);
                $('#mc_docket_single').prop('required', false);
                $('#unit_owned_single').prop('required', false);
                $('#vin_single').prop('required', false);
                $('#driver_name_single').prop('required', false);
                $('#driver_dob_single').prop('required', false);
                $('#driver_license_single').prop('required', false);
                $('#driver_license_state_single').prop('required', false);
            }
        });
    });
</script>
{{-- /Leads Data Get --}}

{{-- 10 min logout Agent --}}
{{-- @if (auth()->user()->designation == 'Agent')
    <script>
        $(document).ready(function() {
            let inactivityTimer;

            function resetInactivityTimer() {
                clearTimeout(inactivityTimer);
                inactivityTimer = setTimeout(logoutAndRedirect, 10 * 60 * 1000); // 10 minutes in milliseconds
            }

            function logoutAndRedirect() {
                // Perform logout actions (e.g., make an API call to log the user out)
                // Redirect to the login page
                window.location.href = '/';
            }

            // Reset the inactivity timer on user interaction
            $(document).on('mousemove keypress', resetInactivityTimer);

            // Initial setup of the timer
            resetInactivityTimer();
        });
    </script>
@endif --}}
{{-- /10 min logout Agent --}}

<script>
    $(document).ready(function() {
        $('.unit2').hide();
        $('.unit3').hide();
        $('.unit4').hide();
        $('.unit5').hide();
        $('#unit_owned').on('change', function() {
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
    // Single Lead Form
    $(document).ready(function() {
        $('.unitsingle2').hide();
        $('.unitsingle3').hide();
        $('.unitsingle4').hide();
        $('.unitsingle5').hide();
        $('#unit_owned_single').on('change', function() {
            var value = $(this).val();
            if (value == '2') {
                $('.unitsingle2').show();
                $('.unitsingle3').hide();
                $('.unitsingle4').hide();
                $('.unitsingle5').hide();
            } else if (value == '3') {
                $('.unitsingle2').show();
                $('.unitsingle3').show();
                $('.unitsingle4').hide();
                $('.unitsingle5').hide();
            } else if (value == '4') {
                $('.unitsingle2').show();
                $('.unitsingle3').show();
                $('.unitsingle4').show();
                $('.unitsingle5').hide();
            } else if (value == '5') {
                $('.unitsingle2').show();
                $('.unitsingle3').show();
                $('.unitsingle4').show();
                $('.unitsingle5').show();
            } else if (value == '1') {
                $('.unitsingle2').hide();
                $('.unitsingle3').hide();
                $('.unitsingle4').hide();
                $('.unitsingle5').hide();
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.insuredModal').on('click', function() {
            var insured_id = $(this).data('id');
            $('#insured_id').val(insured_id);
        });
    });
</script>

<script>
    function showTime() {
        var options = {
            timeZone: "America/New_York",
            hour12: true,
            hour: "numeric",
            minute: "numeric",
            second: "numeric",
            year: "numeric",
            month: "numeric",
            day: "numeric"
        };

        var dateTime = new Date().toLocaleString("en-US", options);

        var clockText = 'USA(Florida) '+dateTime;

        document.getElementById("MyClockDisplay").innerText = clockText;
        document.getElementById("MyClockDisplay").textContent = clockText;

        setTimeout(showTime, 1000);
    }

    showTime();
</script>

<script>
    // document.addEventListener('keydown', function(event) {
    //     // Prevent F12 key
    //     if (event.key === 'F12' || event.keyCode === 123) {
    //         event.preventDefault();
    //     }
    // });

    // // Disable right-click menu
    // document.addEventListener('contextmenu', function(event) {
    //     event.preventDefault();
    // });

    // document.addEventListener('keydown', function(event) {
    //     // Prevent Ctrl+U key
    //     if ((event.ctrlKey || event.metaKey) && event.key === 'U' || event.key === 'u') {
    //         event.preventDefault();
    //     }
    // });

    // // Disable Ctrl+Shift+I, Ctrl+Shift+J, and Ctrl+Shift+C
    // document.addEventListener('keydown', function(event) {
    //     if ((event.ctrlKey || event.metaKey) && (event.shiftKey) &&
    //         (event.key === 'I' || event.key === 'J' || event.key === 'C')) {
    //         event.preventDefault();
    //     }
    // });
</script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
{{-- <script>
    Pusher.logToConsole = true;

    var pusher = new Pusher('ce307888eab54d580fe5', {
        cluster: 'ap2'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
        // alert(JSON.stringify(data));
        alert(data.data.name + '-' + '-' + data.data.age);
    });
</script> --}}
<script>
    Pusher.logToConsole = true;

    var pusher = new Pusher('ce307888eab54d580fe5', {
        cluster: 'ap2'
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Load notifications from local storage and display them on page load
        loadNotifications();
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
        // Check if empId matches the authenticated user's ID
        var authenticatedUserId = {{ auth()->user()->id }};

        if (data.data.id == authenticatedUserId) {


            // Display notification
            toastr.options.timeOut = 100000;
            toastr.options.closeButton = true;
            toastr.error(data.data.message);

            // Create an array to store notifications
            var notifications = JSON.parse(localStorage.getItem('notifications')) || [];
            // Add the new notification to the array
            notifications.push(data.data.message);

            // Save the updated array in local storage
            localStorage.setItem('notifications', JSON.stringify(notifications));

            // Add the notification to the notification area
            var notificationItem = createNotificationItem(data.data.message);

            // Append the notification item to the notification area
            document.getElementById('notificationItemsTabContent').querySelector('#all-noti-tab .pe-2')
                .appendChild(notificationItem);
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Load notifications from local storage and display them on page load
        loadNotifications();
    });

    function loadNotifications() {
        // Load notifications from local storage
        var notifications = JSON.parse(localStorage.getItem('notifications')) || [];

        // Display notifications on the page
        for (var i = 0; i < notifications.length; i++) {
            var notificationItem = createNotificationItem(notifications[i]);
            // Append the notification item to the notification area
            document.getElementById('notificationItemsTabContent').querySelector('#all-noti-tab .pe-2')
                .appendChild(notificationItem);
        }
    }

    function createNotificationItem(message) {
        var notificationItem = document.createElement('div');
        notificationItem.className = 'text-reset notification-item d-block dropdown-item position-relative';

        notificationItem.innerHTML = `
            <div class="d-flex">
                <div class="avatar-xs me-3 flex-shrink-0">
                    <span class="avatar-title bg-info-subtle text-info rounded-circle fs-16">
                        <i class="bx bx-badge-check"></i>
                    </span>
                </div>
                <div class="flex-grow-1">
                    <a href="{{ route('agent.incoming.leads') }}" class="stretched-link"><b>{{ auth()->user()->name }}</b>-${message}</a>
                </div>
            </div>
        `;
        playAudio();
        updateMessageCount();
        // Add a click event listener to remove the message on user click
        notificationItem.addEventListener('click', function() {
            removeNotification(message);
            notificationItem.remove();
        });

        return notificationItem;
    }

    function removeNotification(message) {
        // Remove the specified message from local storage
        var notifications = JSON.parse(localStorage.getItem('notifications')) || [];
        var index = notifications.indexOf(message);
        if (index !== -1) {
            notifications.splice(index, 1);
            localStorage.setItem('notifications', JSON.stringify(notifications));
        }
        updateMessageCount();
    }

    function updateMessageCount() {
        // Get the current message count
        var notificationsCount = JSON.parse(localStorage.getItem('notifications'))?.length || 0;

        // Update the span element with the new count
        document.getElementById('notificationCount').innerText = notificationsCount.toString();
    }

    // function playAudio() {
    //     var audio = document.getElementById("myAudio");

    //     // Play the audio
    //     audio.play();
    // }
</script>

{{-- User update status --}}
@if (auth()->user()->designation == 'Manager'||auth()->user()->designation == 'Agent')
    <script>
        Pusher.logToConsole = true;

        var pusher = new Pusher('ce307888eab54d580fe5', {
            cluster: 'ap2'
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Load notifications from local storage and display them on page load
            loadNotifications();
        });

        var channel = pusher.subscribe('my-channel1');
        channel.bind('my-event1', function(data) {
            // Check if empId matches the authenticated user's ID
            var authenticatedUserId = {{ auth()->user()->id }};

            // Display notification
            toastr.options.timeOut = 10000;
            toastr.options.closeButton = true;
            toastr.error(data.data.message);

            // Create an array to store notifications
            var notifications = JSON.parse(localStorage.getItem('notifications')) || [];
            // Add the new notification to the array
            notifications.push(data.data.message);

            // Save the updated array in local storage
            localStorage.setItem('notifications', JSON.stringify(notifications));

            // Add the notification to the notification area
            var notificationItem = createNotificationItem(data.data.message, data.data.name);

            // Append the notification item to the notification area
            document.getElementById('notificationItemsTabContent').querySelector('#all-noti-tab .pe-2')
                .appendChild(notificationItem);

        });

        document.addEventListener('DOMContentLoaded', function() {
            // Load notifications from local storage and display them on page load
            loadNotifications();
        });

        function loadNotifications() {
            // Load notifications from local storage
            var notifications = JSON.parse(localStorage.getItem('notifications')) || [];

            // Display notifications on the page
            for (var i = 0; i < notifications.length; i++) {
                var notificationItem = createNotificationItem(notifications[i]);
                // Append the notification item to the notification area
                document.getElementById('notificationItemsTabContent').querySelector('#all-noti-tab .pe-2')
                    .appendChild(notificationItem);
            }
        }

        function createNotificationItem(message, name) {
            var notificationItem = document.createElement('div');
            notificationItem.className = 'text-reset notification-item d-block dropdown-item position-relative';

            notificationItem.innerHTML = `
            <div class="d-flex">
                <div class="avatar-xs me-3 flex-shrink-0">
                    <span class="avatar-title bg-info-subtle text-info rounded-circle fs-16">
                        <i class="bx bx-badge-check"></i>
                    </span>
                </div>
                <div class="flex-grow-1">
                    <a href="#" class="stretched-link"><b>${name}</b>-${message}</a>
                </div>
            </div>
        `;
            playAudio();
            updateMessageCount();
            // Add a click event listener to remove the message on user click
            notificationItem.addEventListener('click', function() {
                removeNotification(message);
                notificationItem.remove();
            });

            return notificationItem;
        }

        function removeNotification(message) {
            // Remove the specified message from local storage
            var notifications = JSON.parse(localStorage.getItem('notifications')) || [];
            var index = notifications.indexOf(message);
            if (index !== -1) {
                notifications.splice(index, 1);
                localStorage.setItem('notifications', JSON.stringify(notifications));
            }
            updateMessageCount();
        }

        function updateMessageCount() {
            // Get the current message count
            var notificationsCount = JSON.parse(localStorage.getItem('notifications'))?.length || 0;

            // Update the span element with the new count
            document.getElementById('notificationCount').innerText = notificationsCount.toString();
        }

        // function playAudio() {
        //     var audio = document.getElementById("myAudio");

        //     // Play the audio
        //     audio.play();
        // }
    </script>
@endif
{{-- User update status --}}

{{-- Break notification --}}
<script>
    $(document).ready(function() {
        // Function to display an alert
        function showAlert(message) {
            toastr.options.timeOut = 10000;
            toastr.options.closeButton = true;
            toastr.success(message);
        }

        // Get the current client-side time
        var currentTime = new Date();

        // Schedule alerts
        scheduleAlert('Dinner break', 22, 00);
        scheduleAlert('Tea break', 12, 30);
        scheduleAlert('Tea break', 01, 45);

        // Function to schedule alerts
        function scheduleAlert(message, hours, minutes) {
            var scheduledTime = new Date(currentTime);
            scheduledTime.setHours(hours, minutes, 0, 0);

            var timeDifference = scheduledTime - currentTime;

            if (timeDifference > 0) {
                setTimeout(function() {
                    showAlert(message + ' at ' + formatTime(hours, minutes));
                }, timeDifference);
            }
        }

        // Function to format time
        function formatTime(hours, minutes) {
            return ('0' + hours).slice(-2) + ':' + ('0' + minutes).slice(-2);
        }
    });
</script>
{{-- Break notification --}}

{{-- Master Serch start --}}
<script>
    $(document).ready(function() {
        $("#search-options").on("input", function() {
            let searchTerm = $(this).val();

            if (searchTerm.length >= 3) {
                $.ajax({
                    url: '/search',
                    type: 'POST',
                    data: {
                        searchTerm: searchTerm
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        displayResults(data);
                    }
                });
            } else {
                $("#search-dropdown").hide();
            }
        });

        function displayResults(results) {
            let dropdown = $("#search-dropdown").find("div[data-simplebar]");
            dropdown.empty();

            $.each(results, function(index, result) {
                let item = $("<a>", {
                    class: 'dropdown-item notify-item',
                    href: '{{ url('/search-leads/') }}' + '/' + result.id,
                    target: '_blank',
                    html: '<i class="ri-bubble-chart-line align-middle fs-18 text-muted me-2"></i><span>' +
                        result.company_name + '</span>'
                });

                dropdown.append(item);
            });

            $("#search-dropdown").show();
        }
    });
</script>
{{-- Master Serch End --}}


<script>
    $(document).ready(function() {
        $('#form_status').on('click', function() {
            var val = $(this).val();
            if (val == 'Pipeline') {
                $('.reminder').show();
            } else {
                $('.reminder').hide();
            }
        });
    });
</script>
@php
    $user_id = auth()->user()->id;
    $excelData = App\Models\ExcelData::where('click_id', $user_id)->whereNotNull('reminder')->get();

    foreach ($excelData as $reminder) {
        $reminderTimeFormatted = \Carbon\Carbon::parse($reminder->reminder)->format('Y-m-d\TH:i');
@endphp

<script>
    function checkReminder_{{ $reminder->id }}() {
        var reminderTime = new Date("{{ $reminderTimeFormatted }}");
        var currentTime = new Date();

        // Check if the current time is within a second of the reminder time
        if (Math.abs(currentTime - reminderTime) < 1000) {
            toastr.options.timeOut = 0;
            toastr.options.closeButton = true;
            toastr.options.onclick = function () {
                // Custom logic for handling clicks (you can leave this empty to disable the click-to-close)
            };
            toastr.options.onmouseover = function () {
                // Custom logic for handling mouseover (you can leave this empty to disable the disappear on hover)
            };
            toastr.success("Pipeline reminder Phone - {{ $reminder->phone }}");

            // Clear the interval after showing the message for this reminder
            clearInterval(reminderInterval_{{ $reminder->id }});
        }
    }

    // Check each reminder every second
    var reminderInterval_{{ $reminder->id }} = setInterval(checkReminder_{{ $reminder->id }}, 1000);

</script>

@php
    }
@endphp

{{-- Master File pipeline Start --}}
@php
    $user_id = auth()->user()->id;
    $excelData = App\Models\MasterExcelData::where('click_id', $user_id)->whereNotNull('reminder')->get();

    foreach ($excelData as $reminder) {
        $reminderTimeFormatted = \Carbon\Carbon::parse($reminder->reminder)->format('Y-m-d\TH:i');
@endphp

<script>
    function checkReminder_{{ $reminder->id }}() {
        var reminderTime = new Date("{{ $reminderTimeFormatted }}");
        var currentTime = new Date();

        // Check if the current time is within a second of the reminder time
        if (Math.abs(currentTime - reminderTime) < 1000) {
            toastr.options.timeOut = 0;
            toastr.options.closeButton = true;
            toastr.options.onclick = function () {
                // Custom logic for handling clicks (you can leave this empty to disable the click-to-close)
            };
            toastr.options.onmouseover = function () {
                // Custom logic for handling mouseover (you can leave this empty to disable the disappear on hover)
            };
            toastr.success("Pipeline reminder from Masterfile Phone - {{ $reminder->phone }}");

            // Clear the interval after showing the message for this reminder
            clearInterval(reminderInterval_{{ $reminder->id }});
        }
    }

    // Check each reminder every second
    var reminderInterval_{{ $reminder->id }} = setInterval(checkReminder_{{ $reminder->id }}, 1000);
</script>

@php
    }
@endphp
{{-- Master File pipeline End --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script>
    $(document).ready(function () {
        // Function to filter the table rows based on the selected date range
        function filterTableByDate(startDate, endDate) {
            // Loop through each table row
            $('#customerTable tbody tr').each(function () {
                var rowDate = moment($(this).data('date'), 'DD-MM-YY');
                var startMoment = moment(startDate, 'YYYY-MM-DD');
                var endMoment = moment(endDate, 'YYYY-MM-DD');

                // Check if the row date is within the selected range
                if (rowDate.isSameOrAfter(startMoment) && rowDate.isSameOrBefore(endMoment)) {
                    $(this).show();  // Display the row
                } else {
                    $(this).hide();  // Hide the row
                }
            });
        }

        // Event listener for the filter button click
        $('#filterButton').on('click', function (e) {
            e.preventDefault(); 
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();

            // Perform the filtering
            filterTableByDate(startDate, endDate);
        });
    });
</script>


{{-- Client Message Start --}}
<script>
    Pusher.logToConsole = true;

    var pusher = new Pusher('ce307888eab54d580fe5', {
        cluster: 'ap2'
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Load notifications from local storage and display them on page load
        loadNotifications();
    });

    var channel = pusher.subscribe('my-channel2');
    channel.bind('my-event2', function(data) {
        // Check if empId matches the authenticated user's ID
        var authenticatedUserId = {{ auth()->user()->id }};

        if (data.data.id == authenticatedUserId) {


            // Display notification
            toastr.options.timeOut = 10000;
            toastr.options.closeButton = true;
            toastr.error(data.data.message);

            // Create an array to store notifications
            var notifications = JSON.parse(localStorage.getItem('notifications')) || [];
            // Add the new notification to the array
            notifications.push(data.data.message);

            // Save the updated array in local storage
            localStorage.setItem('notifications', JSON.stringify(notifications));

            // Add the notification to the notification area
            var notificationItem = createNotificationItem(data.data.message);

            // Append the notification item to the notification area
            document.getElementById('notificationItemsTabContent').querySelector('#all-noti-tab .pe-2')
                .appendChild(notificationItem);
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Load notifications from local storage and display them on page load
        loadNotifications();
    });

    function loadNotifications() {
        // Load notifications from local storage
        var notifications = JSON.parse(localStorage.getItem('notifications')) || [];

        // Display notifications on the page
        for (var i = 0; i < notifications.length; i++) {
            var notificationItem = createNotificationItem(notifications[i]);
            // Append the notification item to the notification area
            document.getElementById('notificationItemsTabContent').querySelector('#all-noti-tab .pe-2')
                .appendChild(notificationItem);
        }
    }

    function createNotificationItem(message) {
        var notificationItem = document.createElement('div');
        notificationItem.className = 'text-reset notification-item d-block dropdown-item position-relative';

        notificationItem.innerHTML = `
            <div class="d-flex">
                <div class="avatar-xs me-3 flex-shrink-0">
                    <span class="avatar-title bg-info-subtle text-info rounded-circle fs-16">
                        <i class="bx bx-badge-check"></i>
                    </span>
                </div>
                <div class="flex-grow-1">
                    <a href="{{ url('/client/all/form') }}" class="stretched-link"><b>{{ auth()->user()->name }}</b>-${message}</a>
                </div>
            </div>
        `;
        playAudio();
        updateMessageCount();
        // Add a click event listener to remove the message on user click
        notificationItem.addEventListener('click', function() {
            removeNotification(message);
            notificationItem.remove();
        });

        return notificationItem;
    }

    function removeNotification(message) {
        // Remove the specified message from local storage
        var notifications = JSON.parse(localStorage.getItem('notifications')) || [];
        var index = notifications.indexOf(message);
        if (index !== -1) {
            notifications.splice(index, 1);
            localStorage.setItem('notifications', JSON.stringify(notifications));
        }
        updateMessageCount();
    }

    function updateMessageCount() {
        // Get the current message count
        var notificationsCount = JSON.parse(localStorage.getItem('notifications'))?.length || 0;

        // Update the span element with the new count
        document.getElementById('notificationCount').innerText = notificationsCount.toString();
    }

    // function playAudio() {
    //     var audio = document.getElementById("myAudio");

    //     // Play the audio
    //     audio.play();
    // }
</script>
{{-- Client Message End --}}









