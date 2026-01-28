 {{-- show massage --}}
 <?php
 if (session('success')) {
     // Assign the session variable to the custom message
     $success_message = session('success');
 
     // Unset or remove the session variable to ensure it's executed only once
     session()->forget('done');
 }
 if (session('error')) {
     // Assign the session variable to the custom message
     $error_message = session('error');
 
     // Unset or remove the session variable to ensure it's executed only once
     session()->forget('done');
 }
 ?>
 <?php
 // JavaScript section to display notification
 if (isset($success_message)) {
     echo '<script>
          document.addEventListener("DOMContentLoaded", function() {
              round_success_noti("' .
         $success_message .
         '");
          });
      </script>';
 }
 if (isset($error_message)) {
     echo '<script>
          document.addEventListener("DOMContentLoaded", function() {
              round_error_noti("' .
         $error_message .
         '");
          });
      </script>';
 }
 ?>
 {{-- show massage --}}
 <!-- search modal -->
 <div class="modal" id="SearchModal" tabindex="-1">
     <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-md-down">
         <div class="modal-content">
             <div class="modal-header gap-2">
                 <div class="position-relative popup-search w-100">
                     <input id="searchInput" class="form-control form-control-lg ps-5 border border-3 border-primary"
                         type="search" placeholder="Search">
                     <span class="position-absolute top-50 search-show ms-3 translate-middle-y start-0 top-50 fs-4"><i
                             class='bx bx-search'></i></span>
                 </div>
                 <button type="button" class="btn-close d-md-none" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <div class="search-list">
                     <div class="list-group" id="search_data">
                         <a href="javascript:;"
                             class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i
                                 class='bx bxl-vuejs fs-4'></i>Search anything from leads</a>

                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- end search modal -->
 <!--end page wrapper -->
 <!--start overlay-->
 <div class="overlay toggle-icon"></div>
 <!--end overlay-->
 <!--Start Back To Top Button-->
 <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
 <!--End Back To Top Button-->
 <footer class="page-footer">
     <p class="mb-0">Copyright © 2024 Kwikster. All right reserved.</p>
 </footer>
 </div>
 <!--end wrapper-->
 <!--start switcher-->
 <!-- <div class="switcher-wrapper">
     <div class="switcher-btn"> <i class='bx bx-cog bx-spin'></i>
     </div> -->
     @php
         $users = App\Models\User::whereNull('deleted_at')
             ->where('is_active', 1)
             ->where('id', session('agent_id'))
             ->first();
         $mode = $users->mode;
         $header = $users->header;
         $sidebar = $users->sidebar;
     @endphp
     <!-- <div class="switcher-body">
         <div class="d-flex align-items-center">
             <h5 class="mb-0 text-uppercase">Theme Customizer</h5>
             <button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
         </div>
         <hr />
         <h6 class="mb-0">Theme Styles</h6>
         <hr />
         <div class="d-flex align-items-center justify-content-between">
             <div class="form-check">
                 <input class="form-check-input" type="radio" name="flexRadioDefault" id="lightmode"
                     {{ $mode == 0 ? 'checked' : '' }}>

                 <label class="form-check-label" for="lightmode">Light</label>
             </div>
             <div class="form-check">
                 <input class="form-check-input" type="radio" name="flexRadioDefault" id="darkmode"
                     {{ $mode == 1 ? 'checked' : '' }}>
                 <label class="form-check-label" for="darkmode">Dark</label>
             </div>
             <div class="form-check">
                 <input class="form-check-input" type="radio" name="flexRadioDefault" id="semidark"
                     {{ $mode == 2 ? 'checked' : '' }}>
                 <label class="form-check-label" for="semidark">Semi Dark</label>
             </div>
         </div>
         <hr />
         <div class="form-check">
             <input class="form-check-input" type="radio" id="minimaltheme" name="flexRadioDefault"
                 {{ $mode == 3 ? 'checked' : '' }}>
             <label class="form-check-label" for="minimaltheme">Minimal Theme</label>
         </div>
         <hr />
         <h6 class="mb-0">Header Colors</h6>
         <hr />
         <div class="header-colors-indigators">
             <div class="row row-cols-auto g-3">
                 <div class="col">
                     <div class="indigator headercolor1" id="headercolor1"></div>
                 </div>
                 <div class="col">
                     <div class="indigator headercolor2" id="headercolor2"></div>
                 </div>
                 <div class="col">
                     <div class="indigator headercolor3" id="headercolor3"></div>
                 </div>
                 <div class="col">
                     <div class="indigator headercolor4" id="headercolor4"></div>
                 </div>
                 <div class="col">
                     <div class="indigator headercolor5" id="headercolor5"></div>
                 </div>
                 <div class="col">
                     <div class="indigator headercolor6" id="headercolor6"></div>
                 </div>
                 <div class="col">
                     <div class="indigator headercolor7" id="headercolor7"></div>
                 </div>
                 <div class="col">
                     <div class="indigator headercolor8" id="headercolor8"></div>
                 </div>
             </div>
         </div>
         <hr />
         <h6 class="mb-0">Sidebar Colors</h6>
         <hr />
         <div class="header-colors-indigators">
             <div class="row row-cols-auto g-3">
                 <div class="col selected">
                     <div class="indigator sidebarcolor1" id="sidebarcolor1"></div>
                 </div>
                 <div class="col">
                     <div class="indigator sidebarcolor2" id="sidebarcolor2"></div>
                 </div>
                 <div class="col">
                     <div class="indigator sidebarcolor3" id="sidebarcolor3"></div>
                 </div>
                 <div class="col">
                     <div class="indigator sidebarcolor4" id="sidebarcolor4"></div>
                 </div>
                 <div class="col">
                     <div class="indigator sidebarcolor5" id="sidebarcolor5"></div>
                 </div>
                 <div class="col">
                     <div class="indigator sidebarcolor6" id="sidebarcolor6"></div>
                 </div>
                 <div class="col">
                     <div class="indigator sidebarcolor7" id="sidebarcolor7"></div>
                 </div>
                 <div class="col">
                     <div class="indigator sidebarcolor8" id="sidebarcolor8"></div>
                 </div>
             </div>
         </div>
     </div> -->
 </div>
 <div id="routeUrls" data-logout="{{ route('agent_time_logout') }}" data-login="{{ route('ajent_login') }}">
 </div>

 <!--end switcher-->
 <!-- Bootstrap JS -->
 <script src="{{ asset('Agent/assets/js/bootstrap.bundle.min.js') }}"></script>
 <!--plugins-->
 <script src="{{ asset('Agent/assets/js/jquery.min.js') }}"></script>
 <script src="{{ asset('Agent/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
 <script src="{{ asset('Agent/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
 <script src="{{ asset('Agent/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
 <script src="{{ asset('Agent/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
 <script src="{{ asset('Agent/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
 <script src="{{ asset('Agent/assets/plugins/chartjs/js/chart.js') }}"></script>
 <script src="{{ asset('Agent/assets/js/index.js') }}"></script>
 <!--app JS-->
 <script src="{{ asset('Agent/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('Agent/assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
 {{-- notification --}}
 <script src="{{ asset('Agent/assets/plugins/notifications/js/lobibox.min.js') }}"></script>
 <script src="{{ asset('Agent/assets/plugins/notifications/js/notifications.min.js') }}"></script>
 <script src="{{ asset('Agent/assets/plugins/notifications/js/notification-custom-script.js') }}"></script>

 {{-- databales --}}
 <script>
     $(document).ready(function() {
         $('#example').DataTable();
     });
 </script>
 <script>
    var audioPath = "{{ asset('Agent/livechat-129007.mp3') }}";
    var erroraudioPath = "{{ asset('Agent/error-126627.mp3') }}";
</script>
 <script>
     $(document).ready(function() {
         var table = $('#example2').DataTable({
             lengthChange: false,
             buttons: ['copy', 'excel', 'pdf', 'print']
         });

         table.buttons().container()
             .appendTo('#example2_wrapper .col-md-6:eq(0)');
     });
 </script>
 {{-- end databales --}}
 <script>
    new PerfectScrollbar('.chat-list');
    new PerfectScrollbar('.chat-content');
</script>
<script>
    $(document).ready(function() {
        $('#form_status1').change(function() {
            if ($(this).val() === 'Pipeline') {
                $('.reminder').show();
            } else {
                $('.reminder').hide();
            }
        });
    });
</script>
<script src="{{ asset('Agent/assets/js/app.js') }}?v={{ time() }}"></script>

 <script>
     new PerfectScrollbar(".app-container")
 </script>

 {{-- modes --}}
 <script>
     $(document).ready(function() {
         // Get CSRF token from a meta tag with name="csrf-token"
         var csrfToken = $('meta[name="csrf-token"]').attr('content');

         $('input[type=radio][name=flexRadioDefault]').change(function() {
             var mode = $(this).attr('id');
             $.ajax({
                 url: '{{ route('updateUser_modes') }}',
                 type: 'POST',
                 headers: {
                     'X-CSRF-Token': csrfToken // Include CSRF token in the request headers
                 },
                 data: {
                     mode: mode,
                     _token: csrfToken // Also include CSRF token in the request data
                 },
                 success: function(response) {
                     console.log(response);
                 },
                 error: function(xhr, status, error) {
                     console.error(xhr.responseText);
                 }
             });
         });
     });
 </script>
 {{-- reminder notification --}}
<script>
    function setReminder1() {
        const dateInput = document.getElementById('dateInput2').value;
        const timeInput = document.getElementById('timeInput2').value;
        const currentDateTime = new Date();
        if (!dateInput && !timeInput) {
            alert('Please select a date or time for the reminder.');
            return;
        }

        let reminderDateTime;

        if (dateInput && timeInput) {
            reminderDateTime = new Date(`${dateInput}T${timeInput}`);
        } else if (dateInput) {
            reminderDateTime = new Date(dateInput);
        } else if (timeInput) {
            const [hours, minutes] = timeInput.split(':');
            reminderDateTime = new Date();
            reminderDateTime.setHours(hours, minutes, 0, 0);
            if (reminderDateTime <= currentDateTime) {
                reminderDateTime.setDate(reminderDateTime.getDate() + 1);
            }
        }

        if (reminderDateTime > currentDateTime) {
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            
            $.ajax({
                 url: '{{ route('agent_reminder_notif') }}',
                 type: 'POST',
                 headers: {
                     'X-CSRF-Token': csrfToken // Include CSRF token in the request headers
                 },
                 data: {
                     reminderDateTime: reminderDateTime.toISOString(),
                     _token: csrfToken // Also include CSRF token in the request data
                 },
                 success: function(response) {
                    document.cookie = `reminder=${reminderDateTime.toISOString()}; path=/`;
                     alert('Reminder set successfully!');
                 },
                 error: function(xhr, status, error) {
                     console.error(xhr.responseText);
                 }
             });
               
           
        } else {
            alert('Please select a future date and time for the reminder.');
        }
    }

    function checkReminders() {
        const cookies = document.cookie.split('; ');
        const reminderCookie = cookies.find(row => row.startsWith('reminder='));
        if (reminderCookie) {
            const reminderDateTime = new Date(reminderCookie.split('=')[1]);
            const currentDateTime = new Date();

            if (reminderDateTime <= currentDateTime) {
                round_success_noti('Reminder: Check Your Pipeline', 1);
                document.cookie = 'reminder=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';

                var notifCountElement = document.getElementById('notif_count');
    if (notifCountElement) {
        var currentCount = parseInt(notifCountElement.innerHTML);
        notifCountElement.innerHTML = currentCount + 1;
    }
            }
        }
    }

    setInterval(checkReminders, 60000); // Check reminders every minute

    document.addEventListener('DOMContentLoaded', () => {
        if (Notification.permission !== 'granted' && Notification.permission !== 'denied') {
            Notification.requestPermission();
        }
    });
</script>


 <script>
    function setReminder() {
        const dateInput = document.getElementById('dateInput1').value;
        const timeInput = document.getElementById('timeInput1').value;
        const lead_id = document.getElementById('data_id').value;
        const currentDateTime = new Date();
       
        if (!dateInput && !timeInput) {
            alert('Please select a date or time for the reminder.');
            return;
        }

        let reminderDateTime;

        if (dateInput && timeInput) {
            reminderDateTime = new Date(`${dateInput}T${timeInput}`);
        } else if (dateInput) {
            reminderDateTime = new Date(dateInput);
        } else if (timeInput) {
            const [hours, minutes] = timeInput.split(':');
            reminderDateTime = new Date();
            reminderDateTime.setHours(hours, minutes, 0, 0);
            if (reminderDateTime <= currentDateTime) {
                reminderDateTime.setDate(reminderDateTime.getDate() + 1);
            }
        }

        if (reminderDateTime > currentDateTime) {
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            
            $.ajax({
                 url: '{{ route('agent_reminder_notif') }}',
                 type: 'POST',
                 headers: {
                     'X-CSRF-Token': csrfToken // Include CSRF token in the request headers
                 },
                 data: {
                     reminderDateTime: reminderDateTime.toISOString(),
                     lead_id: lead_id,
                     _token: csrfToken // Also include CSRF token in the request data
                 },
                 success: function(response) {
                    document.cookie = `reminder=${reminderDateTime.toISOString()}; path=/`;
                     alert('Reminder set successfully!');
                 },
                 error: function(xhr, status, error) {
                     console.error(xhr.responseText);
                 }
             });
               
           
        } else {
            alert('Please select a future date and time for the reminder.');
        }
    }

    function checkReminders() {
        const cookies = document.cookie.split('; ');
        const reminderCookie = cookies.find(row => row.startsWith('reminder='));
        if (reminderCookie) {
            const reminderDateTime = new Date(reminderCookie.split('=')[1]);
            const currentDateTime = new Date();

            if (reminderDateTime <= currentDateTime) {
                round_success_noti('Reminder: Check Your Pipeline', 1);
                document.cookie = 'reminder=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
            }
        }
    }

    setInterval(checkReminders, 60000); // Check reminders every minute

    document.addEventListener('DOMContentLoaded', () => {
        if (Notification.permission !== 'granted' && Notification.permission !== 'denied') {
            Notification.requestPermission();
        }
    });
</script>
<script>
    function setReminder3() {
        const dateInput = document.getElementById('dateInput3').value;
        const timeInput = document.getElementById('timeInput3').value;
        const lead_id = document.getElementById('data_id').value;
        const currentDateTime = new Date();
        if (!dateInput && !timeInput) {
            alert('Please select a date or time for the reminder.');
            return;
        }

        let reminderDateTime;

        if (dateInput && timeInput) {
            reminderDateTime = new Date(`${dateInput}T${timeInput}`);
        } else if (dateInput) {
            reminderDateTime = new Date(dateInput);
        } else if (timeInput) {
            const [hours, minutes] = timeInput.split(':');
            reminderDateTime = new Date();
            reminderDateTime.setHours(hours, minutes, 0, 0);
            if (reminderDateTime <= currentDateTime) {
                reminderDateTime.setDate(reminderDateTime.getDate() + 1);
            }
        }

        if (reminderDateTime > currentDateTime) {
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            
            $.ajax({
                 url: '{{ route('agent_reminder_notif') }}',
                 type: 'POST',
                 headers: {
                     'X-CSRF-Token': csrfToken // Include CSRF token in the request headers
                 },
                 data: {
                     reminderDateTime: reminderDateTime.toISOString(),
                     lead_id: lead_id,
                     _token: csrfToken // Also include CSRF token in the request data
                 },
                 success: function(response) {
                    document.cookie = `reminder=${reminderDateTime.toISOString()}; path=/`;
                     alert('Reminder set successfully!');
                 },
                 error: function(xhr, status, error) {
                     console.error(xhr.responseText);
                 }
             });
               
           
        } else {
            alert('Please select a future date and time for the reminder.');
        }
    }

    function checkReminders() {
        const cookies = document.cookie.split('; ');
        const reminderCookie = cookies.find(row => row.startsWith('reminder='));
        if (reminderCookie) {
            const reminderDateTime = new Date(reminderCookie.split('=')[1]);
            const currentDateTime = new Date();

            if (reminderDateTime <= currentDateTime) {
                round_success_noti('Reminder: Check Your Pipeline', 1);
                document.cookie = 'reminder=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
            }
        }
    }

    setInterval(checkReminders, 60000); // Check reminders every minute

    document.addEventListener('DOMContentLoaded', () => {
        if (Notification.permission !== 'granted' && Notification.permission !== 'denied') {
            Notification.requestPermission();
        }
    });
</script>
{{-- endv reminder notification --}}
 {{-- header --}}
 <script>
     $(document).ready(function() {
        
         // Add click event listener to each div by their IDs
         var csrfToken = $('meta[name="csrf-token"]').attr('content');
         $('#sidebarcolor1, #sidebarcolor2, #sidebarcolor3, #sidebarcolor4, #sidebarcolor5, #sidebarcolor6, #sidebarcolor7, #sidebarcolor8')
             .click(function() {
                 // Get the ID of the clicked element
                 var id = $(this).attr('id');

                 // Perform AJAX call
                 $.ajax({
                     url: '{{ route('updateUser_modes') }}', // Change this to the URL of your AJAX handler
                     type: 'POST', // Change this to 'GET' if needed
                     headers: {
                         'X-CSRF-Token': csrfToken // Include CSRF token in the request headers
                     },
                     data: {
                         sidebar: id,
                         _token: csrfToken
                     }, // Pass any data you need to send to the server
                     success: function(response) {
                         // Handle the response from the server here
                         console.log(response);
                     },
                     error: function(xhr, status, error) {
                         // Handle errors here
                         console.error(xhr.responseText);
                     }
                 });
             });
     });
 </script>
 {{-- sidebar --}}
 <script>
     $(document).ready(function() {
         // Add click event listener to each div by their IDs
         var csrfToken = $('meta[name="csrf-token"]').attr('content');
         $('#headercolor1, #headercolor2, #headercolor3, #headercolor4, #headercolor5, #headercolor6, #headercolor7, #headercolor8')
             .click(function() {
                 // Get the ID of the clicked element
                 var id = $(this).attr('id');

                 // Perform AJAX call
                 $.ajax({
                     url: '{{ route('updateUser_modes') }}', // Change this to the URL of your AJAX handler
                     type: 'POST', // Change this to 'GET' if needed
                     headers: {
                         'X-CSRF-Token': csrfToken // Include CSRF token in the request headers
                     },
                     data: {
                         header: id,
                         _token: csrfToken
                     }, // Pass any data you need to send to the server
                     success: function(response) {
                         // Handle the response from the server here
                         console.log(response);
                     },
                     error: function(xhr, status, error) {
                         // Handle errors here
                         console.error(xhr.responseText);
                     }
                 });
             });
     });
 </script>
 {{-- notes ajax --}}
 <script>
    $(document).ready(function() {
        ClassicEditor
            .create(document.querySelector('#mynotes'))
            .then(editor => {
                console.log(editor);
    
                editor.model.document.on('change:data', () => {
                    var content = editor.getData();
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    
                    $.ajax({
                        url: '{{ route('store_notes_script') }}',  // Adjust the route to your needs
                        method: 'POST',
                        headers: {
                            'X-CSRF-Token': csrfToken  // Include CSRF token in the request headers
                        },
                        data: {
                            _token: csrfToken,  // Include the CSRF token for security
                            content: content
                        },
                        success: function(response) {
                            console.log('Content saved successfully:', response);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error saving content:', error);
                        }
                    });
                });
            })
            .catch(error => {
                console.error(error);
            });
    });
    </script>
 {{-- Search ajax --}}
 <script>
     $(document).ready(function() {
        

         $('#searchInput').keyup(function() {
            
             var csrfToken = $('meta[name="csrf-token"]').attr('content');
             // Get the value of the search input
             var searchTerm = $(this).val();
           

             // Make sure the search term is not empty
             if (searchTerm.trim() !== '') {
                

                 // Perform your AJAX request here
                 $.ajax({
                     url: '{{ route('agent_global_search') }}', // Replace with your actual search endpoint
                     method: 'post', // or 'POST' depending on your server route
                     headers: {
                         'X-CSRF-Token': csrfToken // Include CSRF token in the request headers
                     },
                     data: {
                         search: searchTerm,
                         _token: csrfToken
                     },
                     success: function(response) {
                         // Clear previous search results
						
                         $('#search_data').empty();
						
                         $.each(response, function(index, result) {
							
                             var listItem = $('<a>', {
								href: '{{ route('agent_search_data', ['id' => '']) }}' + result.id,
                                 class: 'list-group-item list-group-item-action align-items-center d-flex gap-2 py-1',
                                 html: '<i class="bx bxl-mailchimp fs-4"></i>' + result.company_name // Adjust according to your response structure
                             });

                             $('#search_data').append(listItem);
                         });
                     },
                     error: function(xhr, status, error) {
                         console.error('Error performing search:',
                         error); // Debugging: Check for AJAX errors
                     }
                 });
             } else {
                 console.log("Search term is empty."); // Debugging: Check if search term is empty
             }
         });
     });
 </script>
 {{-- End search ajax --}}
 <script>
     document.addEventListener('DOMContentLoaded', function() {
         window.addEventListener('popstate', function(event) {

             // Make AJAX request to clear passcode session
             var forgetpasscodesession = "{{ route('clearpasscode') }}";
             $.ajax({
                 url: forgetpasscodesession, // Adjust the URL if needed
                 method: 'GET',
                 success: function(response) {
                     console.log(response.message); // Log success message
                 },
                 error: function(xhr, status, error) {
                     console.error('Error clearing passcode:', error);
                 }
             });
         });
     });
 </script>
 <script>
    function toggleFullScreen() {
        if (!document.fullscreenElement) {
            // If currently not in fullscreen mode, enter fullscreen
            if (document.documentElement.requestFullscreen) {
                document.documentElement.requestFullscreen();
            } else if (document.documentElement.webkitRequestFullscreen) { /* Safari */
                document.documentElement.webkitRequestFullscreen();
            } else if (document.documentElement.msRequestFullscreen) { /* IE11 */
                document.documentElement.msRequestFullscreen();
            }
        } else {
            // If currently in fullscreen mode, exit fullscreen
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) { /* Safari */
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) { /* IE11 */
                document.msExitFullscreen();
            }
        }
    }
</script>
 <script>
     //---------------------- mode ---------------------------
     $(document).ready(function() {
         <?php if ($mode == 0): ?>
         // Add light-theme class to the HTML element if $mode equals 1
         $("html").addClass("light-theme");
         <?php elseif ($mode == 1): ?>
         // Add dark-theme class to the HTML element if $mode equals 2
         $("html").addClass("dark-theme");
         <?php elseif ($mode == 2): ?>
         // Add dark-theme class to the HTML element if $mode equals 2
         $("html").addClass("semi-dark");
         <?php elseif ($mode == 3): ?>
         // Add dark-theme class to the HTML element if $mode equals 2
         $("html").addClass("minimal-theme");
         <?php endif; ?>
         //-------------------------------------- sidebar --------------------------------
         <?php if ($sidebar == 1): ?>
         $('html').attr('class', 'color-sidebar sidebarcolor1');

         <?php elseif ($sidebar == 2): ?>
         $('html').attr('class', 'color-sidebar sidebarcolor2');

         <?php elseif ($sidebar == 3): ?>
         $('html').attr('class', 'color-sidebar sidebarcolor3');

         <?php elseif ($sidebar == 4): ?>
         $('html').attr('class', 'color-sidebar sidebarcolor4');

         <?php elseif ($sidebar == 5): ?>
         $('html').attr('class', 'color-sidebar sidebarcolor5');

         <?php elseif ($sidebar == 6): ?>
         $('html').attr('class', 'color-sidebar sidebarcolor6');

         <?php elseif ($sidebar == 7): ?>
         $('html').attr('class', 'color-sidebar sidebarcolor7');

         <?php elseif ($sidebar == 8): ?>
         $('html').attr('class', 'color-sidebar sidebarcolor8');

         <?php endif; ?>

         //-------------------header ----------------------
         <?php if ($header == 1): ?>
         $("html").addClass("color-header headercolor1"), $("html").removeClass(
             "headercolor2 headercolor3 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8")

         <?php elseif ($header == 2): ?>
         $("html").addClass("color-header headercolor2"), $("html").removeClass(
             "headercolor1 headercolor3 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8")

         <?php elseif ($header == 3): ?>
         $("html").addClass("color-header headercolor3"), $("html").removeClass(
             "headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8")

         <?php elseif ($header == 4): ?>
         $("html").addClass("color-header headercolor4"), $("html").removeClass(
             "headercolor1 headercolor2 headercolor3 headercolor5 headercolor6 headercolor7 headercolor8")

         <?php elseif ($header == 5): ?>
         $("html").addClass("color-header headercolor5"), $("html").removeClass(
             "headercolor1 headercolor2 headercolor4 headercolor3 headercolor6 headercolor7 headercolor8")

         <?php elseif ($header == 6): ?>
         $("html").addClass("color-header headercolor6"), $("html").removeClass(
             "headercolor1 headercolor2 headercolor4 headercolor5 headercolor3 headercolor7 headercolor8")

         <?php elseif ($header == 7): ?>
         $("html").addClass("color-header headercolor7"), $("html").removeClass(
             "headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor3 headercolor8")

         <?php elseif ($header == 8): ?>
         $("html").addClass("color-header headercolor8"), $("html").removeClass(
             "headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor7 headercolor3")

         <?php endif; ?>



     });
 </script>
 </body>

 </html>
