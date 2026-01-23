<!DOCTYPE html>
<html lang="en">

<head>
    <title>Kwikinsure|Admin</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="description" content="Mega Able Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
      <meta name="keywords" content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
      <meta name="author" content="codedthemes" />
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <!-- Favicon icon -->
      <link rel="icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
    <!-- waves.css -->
    <link rel="stylesheet" href="{{asset('Admin/assets/pages/waves/css/waves.min.css')}}" type="text/css" media="all">
      <!-- Required Fremwork -->
      <link rel="stylesheet" type="text/css" href="{{asset('Admin/assets/css/bootstrap/css/bootstrap.min.css')}}">
      <!-- waves.css -->
      <link rel="stylesheet" href="{{asset('Admin/assets/pages/waves/css/waves.min.css')}}" type="text/css" media="all">
      <!-- themify icon -->
      <link rel="stylesheet" type="text/css" href="{{asset('Admin/assets/icon/themify-icons/themify-icons.css')}}">
      <!-- Font Awesome -->
      <link rel="stylesheet" type="text/css" href="{{asset('Admin/assets/icon/font-awesome/css/font-awesome.min.css')}}">
      <!-- scrollbar.css -->
      <link rel="stylesheet" type="text/css" href="{{asset('Admin/assets/css/jquery.mCustomScrollbar.css')}}">
        <!-- am chart export.css -->
        <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
      <!-- Style.css -->
      <link rel="stylesheet" type="text/css" href="{{asset('Admin/assets/css/style.css')}}">
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
      <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
      <script>
          // Enable pusher logging - don't include this in production
          Pusher.logToConsole = true;
  
          var pusher = new Pusher('3ef0092734ff41650c00', {
              cluster: 'ap2'
          });
  
          var channel = pusher.subscribe('my-channel');
          channel.bind('my-event', function(data) {
             if (data.message.valid == 1) {
            showNotification(data.message.massage);
            }
          });
      </script>
      <style>
        .theme4 {
    background-color:#0098b6 !important;
    color: black !important;
}
/* Force sidebar visibility */
.pcoded-navbar {
    display: block !important;
    visibility: visible !important;
    position: relative !important;
    width: 100% !important;
    height: auto !important;
    background: #fff !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    margin: 10px 0 !important;
}
.pcoded-inner-navbar {
    display: block !important;
    width: 100% !important;
    padding: 10px 20px !important;
}
.pcoded-item {
    display: flex !important;
    flex-direction: row !important;
    flex-wrap: wrap !important;
    list-style: none !important;
    margin: 0 !important;
    padding: 0 !important;
}
.pcoded-item > li {
    display: inline-block !important;
    margin: 0 10px !important;
    position: relative !important;
}
.pcoded-item > li > a {
    display: inline-flex !important;
    align-items: center !important;
    padding: 8px 15px !important;
    background: #007bff !important;
    color: white !important;
    text-decoration: none !important;
    border-radius: 4px !important;
    margin: 2px !important;
}
.pcoded-item > li > a:hover {
    background: #0056b3 !important;
}
.pcoded-mtext {
    margin-left: 5px !important;
}
      </style>
      <style>
        .header-notifications-list {
          max-height: 300px; /* Adjust the height as needed */
          overflow-y: auto;
          border: 1px solid #ccc; /* Optional: Add a border to make the scrollable area visible */
        }
        .show-notification {
          list-style-type: none;
          padding: 0;
          margin: 0;
        }
        .show-notification li {
          padding: 10px;
          border-bottom: 1px solid #ddd;
        }
        .show-notification li a {
          text-decoration: none;
          color: inherit;
          display: block;
        }
        .show-notification .media {
          display: flex;
          align-items: center;
        }
        .show-notification .media-body {
          margin-left: 10px;
        }
      </style>
  </head>

  <body>
  <!-- Pre-loader start -->
  <div class="theme-loader">
      <div class="loader-track">
          <div class="preloader-wrapper">
              <div class="spinner-layer spinner-blue">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
              <div class="spinner-layer spinner-red">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>

              <div class="spinner-layer spinner-yellow">
                              <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>

              <div class="spinner-layer spinner-green">
                  <div             class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- Pre-loader end -->
  <div id="pcoded" class="pcoded">
      <div class="pcoded-overlay-box"></div>
      <div class="pcoded-container navbar-wrapper">
        <nav class="navbar header-navbar pcoded-header theme4">
              <div class="navbar-wrapper">
                  <div class="navbar-logo">
                      <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="#!">
                          <i class="ti-menu"></i>
                      </a>
                      <div class="mobile-search waves-effect waves-light">
                          <div class="header-search">
                              <div class="main-search morphsearch-search">
                                  <div class="input-group">
                                      <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                                      <input type="text" class="form-control" placeholder="Enter Keyword">
                                      <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <a href="#">
                          <img class="img-fluid" src="{{url('Admin/logo.jpeg')}}" alt="Theme-Logo" style="height:50px"/>
                      </a>
                      <a class="mobile-options waves-effect waves-light">
                          <i class="ti-more"></i>
                      </a>
                  </div>

                  <div class="navbar-container container-fluid">
                      <ul class="nav-left">
                                          <li>
                              <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                          </li>
                           <li>
                            <a href="javascript:void(0);" class="waves-effect waves-light" onclick="toggleSearch()">
                                <i id="search-icon" class="ti-search"></i>
                            </a>
                        </li>
                        <li id="search-input" style="display: none;">
                            <input type="text" id="search-field" class="form-control" placeholder="Search..." onkeydown="searchRedirect(event)" style="margin-top: 10px">
                        </li>
                          <li>
                              <a href="#!" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                                  <i class="ti-fullscreen"></i>
                              </a>
                          </li>
                      </ul>
                      <ul class="nav-right">
                        <li>
                            <a href="#!"  data-toggle="modal" data-target="#import_leads_header" class="waves-effect waves-light">
                                <i class="fa fa-upload" aria-hidden="true"></i>
                            </a>
                        </li>
                        @php
                        use Carbon\Carbon;
                        $notifications = App\Models\Notification::where('agent_id', null)
                            ->where('click_id', 1)
                            ->latest()
                            ->get();

                        $noti_count = $notifications->count();

                    @endphp
                          <li class="header-notification">
                              <a href="#!" class="waves-effect waves-light">
                                <span class="badge bg-c-red" style="
                                left: 23%;
                                top: 9%;
                            ">{{$noti_count}}</span>
                                  <i class="ti-bell"></i>
                                 
                              </a>
                              <ul class="show-notification">
                                  <li>
                                      <h6>Notifications</h6>
                                      <label class="label label-danger">New</label>
                                  </li>
                                  @if ($notifications->isNotEmpty())
                                  <div class="header-notifications-list" style=" max-height: 300px; overflow-y: auto;">
                                      @foreach ($notifications as $data)
                                          @php
                                              $indiaTimeZone = 'Asia/Kolkata'; // India Standard Time

                                              $reminderTime = \Carbon\Carbon::parse($data->reminder)->setTimezone(
                                                  $indiaTimeZone,
                                              );
                                              $currentTime = \Carbon\Carbon::now($indiaTimeZone);

                                              $link = null;

if ($data->type == 'reminder') {
if (!empty($data->data_id)) {
  $link = route('agent_search_data', $data->data_id . '/' . $data->id);
} else {
  $link = route('agent_pipeline_data', $data->id);
}
} elseif ($data->type == 'leave') {
$link = route('admin.view_leave_request', $data->id);
} elseif ($data->type == 'lead_issue') {
$link = route('interstedleads', $data->data_id . '/' . $data->id);
} else {
$link = route('agent_incoming_leads', $data->id);
}

                                              $isFutureReminder =
                                                  $data->type == 'reminder' && $reminderTime->isFuture();
                                              $backgroundColor =
                                                  $data->click_id == 1 ? 'background-color:#fbe0e0' : '';
                                              $timeDisplay = $isFutureReminder
                                                  ? $reminderTime->diffForHumans()
                                                  : $data->created_at->diffForHumans();
                                          @endphp
                                          @if ($reminderTime->isPast())
                                              <a class="dropdown-item" href= "{{ $link }}">
                                              <li class="waves-effect waves-light">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <h5 class="notification-user"> {{ $data->heading }}</h5>
                                                        <p class="notification-msg">{{ $data->massage }}</p>
                                                        <span class="notification-time">{{$timeDisplay}}</span>
                                                    </div>
                                                </div>
                                            </li>
                                              </a>
                                          @endif
                                      @endforeach
                                  </div>
                              @else
                              <li class="waves-effect waves-light">
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="notification-user"></h5>
                                        <p class="notification-msg">No Notifications</p>
                                        <span class="notification-time"></span>
                                    </div>
                                </div>
                            </li>
                              @endif
                                  
                              </ul>
                          </li>
                          <li class="user-profile header-notification">
                              <a href="#!" class="waves-effect waves-light">
                                @if(!empty(session('admin_image')))
                                  <img src="{{ asset(session('admin_image')) }}" class="img-radius" alt="User-Profile-Image">
                                  @else
                                  <img src="https://bootdey.com/img/Content/avatar/avatar7.png" class="img-radius" alt="User-Profile-Image">
                                  @endif
                                  <span>{{ session('admin_name') }}</span>
                                  <i class="ti-angle-down"></i>
                              </a>
                              <ul class="show-notification profile-notification">
                                  <li class="waves-effect waves-light">
                                      <a href="{{route('admin_profile')}}">
                                          <i class="ti-user"></i> Profile
                                      </a>
                                  </li>
                                  <li class="waves-effect waves-light">
                                      <a href="{{route('view_change_password')}}">
                                          <i class="ti-lock"></i>Change Password
                                      </a>
                                  </li>
                                  <li class="waves-effect waves-light">
                                      <a href="{{route('admin_logout')}}">
                                          <i class="ti-layout-sidebar-left"></i> Logout
                                      </a>
                                  </li>
                              </ul>
                          </li>
                      </ul>
                  </div>
              </div>
          </nav>
<!-- import leads model -->
<div class="modal fade" id="import_leads_header" tabindex="-1" role="dialog"
aria-labelledby="exampleModalLongTitle" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Import Leads</h5>
            <button type="button" class="close" data-dismiss="modal"
                aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="card-body">
                <form action="{{ route('import') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">File Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" class="form-control"
                                name="batch_name" value="" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Excel file</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="file" class="form-control"
                                name="excel_file" required>
                        </div>
                    </div>
                    <p style="padding:5px;border:1px black solid">DOT | MC_DOCKET | COMPANY_NAME | CUSTOMER_REP | PHONE_NUMBER | ADDRESS | CITY | STATE | ZIP_CODE | EMAIL </p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary"
                data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>
    </div>
</div>
</div>
<!--End import leads model -->
<script>
    function toggleSearch() {
        var icon = document.getElementById('search-icon');
        var searchInput = document.getElementById('search-input');
    
        if (searchInput.style.display === 'none') {
            searchInput.style.display = 'inline';
            icon.style.display = 'none'; // Hide the search icon
            document.getElementById('search-field').focus(); // Focus on the search input
        } else {
            searchInput.style.display = 'none';
            icon.style.display = 'inline'; // Show the search icon
        }
    }
    
    function searchRedirect(event) {
        // Check if the Enter key was pressed
        if (event.key === 'Enter') {
            var searchQuery = document.getElementById('search-field').value;
            if (searchQuery) {
                // Encode the search query in base64
                var encodedQuery = btoa(searchQuery); // JavaScript's built-in base64 encoding method
                
                // Redirect using Laravel's named route (passed from Blade)
                var url = "{{ route('admin_global_search', ':query') }}"; // Place ':query' as a placeholder
                url = url.replace(':query', encodedQuery); // Replace placeholder with the base64 query
                
                // Redirect to the new URL
                window.location.href = url;
            }
        }
    }
    </script>