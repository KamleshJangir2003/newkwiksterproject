<body>
    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
       
 
       
        <!--end sidebar wrapper -->
        <!--start header -->
        <header>
            
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand gap-3">
                    <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                    </div>
                    
<div>
                   <a href="{{ url('/agent/agent_dashboard') }}">
    <img src="{{ url('Admin/kwikster-logo.png') }}" class="logo-icon" alt="logo icon">
</a>
 
                </div>
                <ul class="metismenu" id="menu">
                <li>
                    <a href="{{ route('agent_dashboard') }}">
                        <div class="parent-icon"><i class='bx bx-home-alt'></i>
                        </div>
                        <div class="menu-title">Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('agent_incoming_leads') }}">
                        <div class="parent-icon"><i class="lni lni-target"></i>
                        </div>
                        <div class="menu-title">Incoming leads</div>
                    </a>
                </li>

                <li class="more-menu">
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="lni lni-database"></i>
                        </div>
                        <div class="menu-title">Leads</div>
                    </a>
                    <ul>
                       <li>
    <a href="{{ route('agent_intersted_data') }}">
        <i class='bx bx-radio-circle'></i>
        Verified Forms

        @if(($verifiedNotificationCount ?? 0) > 0)
            <span class="badge bg-danger ms-auto">
                {{ $verifiedNotificationCount }}
            </span>
        @endif
    </a>
</li>

<li>
    <a href="{{ route('agent_pipeline_data') }}">
        <i class='bx bx-radio-circle'></i>
        Pipeline

        @if(($pipelineNotificationCount ?? 0) > 0)
            <span class="badge bg-warning text-dark ms-auto">
                {{ $pipelineNotificationCount }}
            </span>
        @endif
    </a>
</li>

        <li>
    <a href="{{ route('agent.leads', ['loss_runs' => 'yes']) }}" class="position-relative">
        <i class='bx bx-radio-circle'></i>
        Loss Runs Required

        @if(isset($lossRunsCount) && $lossRunsCount > 0)
            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                {{ $lossRunsCount }}
            </span>
        @endif
    </a>
</li>

   <a href="{{ route('agent.live.transfer.index') }}">
      <i class='bx bx-radio-circle'></i> Live Transfer Failed Form
   </a>
</li>

<style>
    .sidebar a {
    display: flex;
    align-items: center;
}

.sidebar .badge {
    font-size: 11px;
    padding: 4px 7px;
    border-radius: 12px;
}

</style>
                        <!-- <li> <a href="{{ route('agent_search_leads') }}"><i class='bx bx-radio-circle'></i>Search Leads</a>
                        </li> -->
                        <!-- <li> <a href="{{ route('show_email_inrsted') }}"><i class='bx bx-radio-circle'></i>Email Verified
                            Forms</a>
                    </li> -->
                        {{-- <li> <a href="{{ route('agent_won_data') }}"><i class='bx bx-radio-circle'></i>Bind(Won)</a>
                        </li> --}}
                        <!-- <li> <a href="{{ route('agent_voicemail_data') }}"><i class='bx bx-radio-circle'></i>Unanswered (VM)</a>
                        </li> -->
                    </ul>
                </li>
                <li class="more-menu">
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-category'></i>
                        </div>
                        <div class="menu-title">More</div>
                    </a>
                    <ul class="more-submenu">



                        <li> <a href="{{ route('agent.email_script') }}"><i class='bx bx-radio-circle'></i>Email
                                Script</a>
                        </li>
                        <li> <a href="{{ route('agent.call_script') }}"><i class='bx bx-radio-circle'></i>Call
                                Script</a>
                        </li>
                        <li> <a href="{{ route('agent.text_script') }}"><i class='bx bx-radio-circle'></i>Text
                                Script</a>
                        </li>
                        <li> <a href="{{ route('todo') }}"><i class='bx bx-radio-circle'></i>To-Do</a>
                        </li>
                              <li>
  <a href="{{ route('agent.training_material') }}">
    <i class='bx bx-radio-circle'></i> Training Materials
  </a>
</li>
                    </ul>
                </li>
                <!-- <li>
                    <a href="{{ route('agent.credential') }}">
                        <div class="parent-icon"><i class="fadeIn animated bx bx-lock"></i>
                        </div>
                        <div class="menu-title">credentials</div>
                    </a>
                </li> -->
                <!-- <li>
                    <a href="{{ route('agent.training_material') }}">
                        <div class="parent-icon"><i class="lni lni-library"></i>
                        </div>
                        <div class="menu-title">Training Materials</div>
                    </a>
                </li> -->
                <!--<li>-->
                <!--    <a href="{{ route('passcode') }}">-->
                <!--        <div class="parent-icon">-->
                <!--            <i class="lni lni-drupal-original"></i>-->
                <!--        </div>-->
                <!--        <div class="menu-title">Salary & Bonus</div>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li>-->
                <!--    <a href="{{ route('agent_view_calender') }}">-->
                <!--        <div class="parent-icon"><i class="fadeIn animated bx bx-calendar"></i>-->
                <!--        </div>-->
                <!--        <div class="menu-title">Attendance</div>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li>-->
                <!--    <a href="{{ route('view_agent_task') }}">-->
                <!--        <div class="parent-icon"><i class="fadeIn animated bx bx-calendar"></i>-->
                <!--        </div>-->
                <!--        <div class="menu-title">Tasks</div>-->
                <!--    </a>-->
                <!--</li>-->
        
                @php
                    $agent_id = session('agent_id');

                    $groups = App\Models\Groups_chat::where(function ($query) use ($agent_id) {
                        // Convert the session agent_id array to a JSON string
                        $agent_id_json = json_encode($agent_id);

                        // Search for the JSON string within the user_ids column
                        $query->where('user_ids', 'like', '%' . $agent_id_json . '%');
                    })->get();
                    $group_count = 0;
                    foreach ($groups as $group) {
                        $check_seen = App\Models\ChMessage::where('group_id', $group->id)->get();
                        $unreadCount = 0;
                        foreach ($check_seen as $item) {
                            if ($item) {
                                // Decode 'seen' JSON array if it exists
                                if ($item->seen == 0) {
                                    $unreadCount++;
                                } else {
                                    $seen = json_decode($item->seen ?? '[]', true);

                                    // Check if session agent ID is not in 'seen'
                                    if (!in_array(session('agent_id'), $seen)) {
                                        $unreadCount++;
                                    }
                                }
                            }
                        }
                        $group_count += $unreadCount;
                    }

                    $user_message = App\Models\ChMessage::where('to_id', session('agent_id'))
                        ->where('seen', 0)
                        ->count();

                    $total_unread = $user_message + $group_count;

                @endphp
                <li>
                    <a href="{{ route('agent_chat') }}">
                        <div class="parent-icon"><i class="fadeIn animated bx bx-message-rounded-detail"></i>
                        </div>
                        <div class="menu-title">Chat @if ($total_unread !== 0)
                                <span class="badge rounded-pill bg-success"
                                    style="margin-left: 10px">{{ $total_unread }}</span>
                            @endif
                        </div>
                    </a>
                </li>
                <!-- <li>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#popscript">
                        <div class="parent-icon"><i class='lni lni-support'></i>
                        </div>
                        <div class="menu-title">Script</div>
                    </a>
                </li> -->
                <!--<li>-->
                <!--    <a href="{{ route('agent_break') }}">-->
                <!--        <div class="parent-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"-->
                <!--                viewBox="0 0 24 24" fill="none" stroke="#5f5f5f" stroke-width="2"-->
                <!--                stroke-linecap="round" stroke-linejoin="round"-->
                <!--                class="feather feather-coffee text-primary">-->
                <!--                <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>-->
                <!--                <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>-->
                <!--                <line x1="6" y1="1" x2="6" y2="4"></line>-->
                <!--                <line x1="10" y1="1" x2="10" y2="4"></line>-->
                <!--                <line x1="14" y1="1" x2="14" y2="4"></line>-->
                <!--            </svg>-->
                <!--        </div>-->
                <!--        <div class="menu-title">Breaks</div>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li>-->
                <!--    <a href="#" data-bs-toggle="modal" data-bs-target="#usholidays">-->
                <!--        <div class="parent-icon"><i class='bx bx-bookmark-heart'></i>-->
                <!--        </div>-->
                <!--        <div class="menu-title">Us Holidays</div>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li>-->
                <!--    <a href="{{ route('view_load') }}">-->
                <!--        <div class="parent-icon"><i class='bx bx-bookmark-heart'></i>-->
                <!--        </div>-->
                <!--        <div class="menu-title">Load Leads</div>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li>-->
                <!--    <a href="{{ route('agent.intrested.view_load') }}">-->
                <!--        <div class="parent-icon"><i class='bx bx-bookmark-heart'></i>-->
                <!--        </div>-->
                <!--        <div class="menu-title">Loads</div>-->
                <!--    </a>-->
                <!--</li>-->
            </ul>
                    <div class="search-bar d-lg-block d-none" data-bs-toggle="modal" data-bs-target="#SearchModal">
                        <a href="avascript:;" class="btn d-flex align-items-center"><i
                                class='bx bx-search'></i>Search</a>
                    </div>

                    <div class="top-menu ms-auto">
                        <ul class="navbar-nav align-items-center gap-1">
                            <li class="nav-item mobile-search-icon d-flex d-lg-none" data-bs-toggle="modal"
                                data-bs-target="#SearchModal">
                                <a class="nav-link" href="avascript:;"><i class='bx bx-search'></i>
                                </a>
                            </li>
                            <li class="nav-item dropdown dropdown-laungauge d-none d-sm-flex">
                                <a class="nav-link" title="Full Screen" onclick="toggleFullScreen()">
                                    <svg viewBox="0 0 1024 1024" class="icon" xmlns="http://www.w3.org/2000/svg"
                                        fill="#212529">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path fill="#212529"
                                                d="M160 96.064l192 .192a32 32 0 010 64l-192-.192V352a32 32 0 01-64 0V96h64v.064zm0 831.872V928H96V672a32 32 0 1164 0v191.936l192-.192a32 32 0 110 64l-192 .192zM864 96.064V96h64v256a32 32 0 11-64 0V160.064l-192 .192a32 32 0 110-64l192-.192zm0 831.872l-192-.192a32 32 0 010-64l192 .192V672a32 32 0 1164 0v256h-64v-.064z">
                                            </path>
                                        </g>
                                    </svg>
                                </a>
                            </li>
                            <!-- <li class="nav-item dropdown dropdown-laungauge d-none d-sm-flex">
                                <a class="nav-link" title="Task report" data-bs-toggle="modal"
                                    data-bs-target="#viewtaskmodel">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path d="M12.37 8.87988H17.62" stroke="#292D32" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M6.38 8.87988L7.13 9.62988L9.38 7.37988" stroke="#292D32"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                            <path d="M12.37 15.8799H17.62" stroke="#292D32" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M6.38 15.8799L7.13 16.6299L9.38 14.3799" stroke="#292D32"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                            <path
                                                d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z"
                                                stroke="#292D32" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                        </g>
                                    </svg>
                                </a>
                            </li> -->
                            <!-- <li class="nav-item dropdown dropdown-laungauge d-none d-sm-flex">
                                <a class="nav-link" title="Remaining Time" data-bs-toggle="modal"
                                    data-bs-target="#email_form_check">
                                    <svg height="200px" width="200px" version="1.1" id="_x32_"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        viewBox="0 0 512 512" xml:space="preserve" fill="#212529">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <style type="text/css">
                                                .st0 {
                                                    fill: #212529;
                                                }
                                            </style>
                                            <g>
                                                <path class="st0"
                                                    d="M429.988,249.657c-14.343-33.918-38.27-62.717-68.394-83.066c-15.07-10.183-31.688-18.25-49.448-23.774 c-17.752-5.524-36.629-8.496-56.151-8.496c-26.018,0-50.902,5.286-73.504,14.848c-33.91,14.35-62.709,38.269-83.065,68.401 c-10.183,15.062-18.25,31.688-23.774,49.448c-5.524,17.744-8.496,36.629-8.488,56.143c-0.008,26.018,5.278,50.911,14.848,73.512 c14.35,33.918,38.269,62.709,68.393,83.066c15.063,10.182,31.696,18.25,49.447,23.774c17.752,5.516,36.63,8.489,56.143,8.489 c26.026,0,50.91-5.286,73.52-14.848c33.91-14.35,62.701-38.269,83.066-68.393c10.174-15.07,18.242-31.696,23.766-49.455 c5.516-17.745,8.489-36.63,8.489-56.144C444.844,297.142,439.557,272.258,429.988,249.657z M255.996,474.444 c-20.939-0.008-40.79-4.236-58.87-11.882c-27.13-11.47-50.259-30.677-66.578-54.834c-8.16-12.075-14.618-25.375-19.031-39.571 c-4.413-14.197-6.796-29.29-6.796-44.996c0-20.938,4.236-40.79,11.882-58.878c11.47-27.121,30.677-50.259,54.826-66.578 c12.082-8.152,25.382-14.61,39.579-19.023c14.197-4.413,29.29-6.796,44.988-6.796c20.946,0,40.79,4.228,58.878,11.882 c27.129,11.462,50.267,30.669,66.578,54.826c8.16,12.075,14.61,25.383,19.031,39.579c4.413,14.197,6.796,29.283,6.796,44.988 c0,20.939-4.229,40.79-11.882,58.878c-11.469,27.129-30.677,50.267-54.826,66.578c-12.082,8.16-25.383,14.61-39.579,19.023 C286.795,472.053,271.71,474.444,255.996,474.444z">
                                                </path>
                                                <path class="st0"
                                                    d="M353.558,323.16h32.338c0.008-17.89-3.639-35.013-10.212-50.566c-9.876-23.329-26.325-43.134-47.049-57.131 c-20.709-14.006-45.792-22.203-72.638-22.195v32.346c13.515,0,26.31,2.728,37.97,7.654c17.484,7.394,32.416,19.782,42.935,35.358 c5.263,7.792,9.424,16.372,12.266,25.521C352.018,303.302,353.558,313.024,353.558,323.16z">
                                                </path>
                                                <polygon class="st0"
                                                    points="138.27,153.643 108.061,117.642 79.292,141.776 109.502,177.792 ">
                                                </polygon>
                                                <polygon class="st0"
                                                    points="432.715,141.776 403.939,117.642 373.722,153.643 402.498,177.792 ">
                                                </polygon>
                                                <path class="st0"
                                                    d="M228.354,100.557v17.077h55.293v-17.077c3.869-2.306,7.432-5.08,10.596-8.236 c9.776-9.768,15.844-23.33,15.836-38.238c0.008-14.917-6.06-28.478-15.836-38.239C284.474,6.068,270.913,0,255.996,0 c-14.909,0-28.47,6.068-38.23,15.844c-9.776,9.761-15.844,23.322-15.844,38.239c0,14.908,6.068,28.47,15.844,38.238 C220.922,95.477,224.477,98.25,228.354,100.557z M255.996,13.561c11.216,0.008,21.299,4.528,28.654,11.875 c7.34,7.347,11.86,17.437,11.86,28.647c0,11.208-4.52,21.29-11.86,28.646c-0.33,0.322-0.666,0.636-1.004,0.95V69.643h-55.293 v14.035c-0.337-0.314-0.674-0.628-1.004-0.95c-7.34-7.355-11.868-17.437-11.868-28.646c0-11.21,4.528-21.3,11.868-28.647 C234.705,18.089,244.795,13.568,255.996,13.561z">
                                                </path>
                                                <path class="st0"
                                                    d="M234.743,269.86h-17.69c-0.896,0-1.655,0.252-2.291,0.766l-15.53,10.94c-0.636,0.514-0.889,1.019-0.889,1.786 v18.586c0,1.011,0.758,1.272,1.525,0.759l14.641-9.669h0.253v62.104c0,0.767,0.514,1.28,1.272,1.28h18.709 c0.766,0,1.272-0.513,1.272-1.28v-83.993C236.015,270.373,235.509,269.86,234.743,269.86z">
                                                </path>
                                                <path class="st0"
                                                    d="M297.238,298.498c-6.742,0-10.94,2.16-13.362,4.451h-0.253v-14.503c0-0.513,0.253-0.766,0.766-0.766h32.837 c0.759,0,1.272-0.513,1.272-1.272v-15.269c0-0.766-0.513-1.279-1.272-1.279h-50.405c-0.766,0-1.272,0.513-1.272,1.279v48.742 c0,0.766,0.506,1.272,1.272,1.272h16.296c0.889,0,1.394-0.505,1.778-1.272c1.149-2.291,3.31-4.076,7.002-4.076 c3.563,0,6.236,1.402,7.386,4.965c0.628,1.655,0.881,3.823,0.881,7.386c0,3.31-0.253,5.601-0.881,7.255 c-1.15,3.302-3.823,4.958-7.263,4.958c-4.834,0-7.248-2.667-8.397-5.977c-0.253-0.766-0.766-1.272-1.655-1.148l-16.549,2.674 c-0.766,0.253-1.149,0.889-1.149,1.524c1.402,11.845,11.714,20.494,27.88,20.494c13.362,0,23.544-5.6,27.106-16.802 c1.149-3.432,1.908-7.76,1.908-12.978c0-7.508-0.758-11.584-1.908-15.146C316.077,303.08,308.064,298.498,297.238,298.498z">
                                                </path>
                                                <path class="st0"
                                                    d="M255.996,430.176c-3.693,0-6.688,2.996-6.688,6.696c0,3.693,2.996,6.689,6.688,6.689 c3.701,0,6.696-2.996,6.696-6.689C262.692,433.172,259.697,430.176,255.996,430.176z">
                                                </path>
                                                <path class="st0"
                                                    d="M202.488,230.487c3.202-1.854,4.306-5.945,2.459-9.148c-1.854-3.202-5.945-4.298-9.155-2.452 c-3.195,1.854-4.29,5.945-2.444,9.148C195.195,231.238,199.286,232.334,202.488,230.487z">
                                                </path>
                                                <path class="st0"
                                                    d="M309.504,415.841c-3.195,1.846-4.29,5.938-2.444,9.14c1.846,3.202,5.938,4.306,9.14,2.452 c3.202-1.846,4.298-5.945,2.452-9.148C316.805,415.083,312.706,413.994,309.504,415.841z">
                                                </path>
                                                <path class="st0"
                                                    d="M160.871,260.505c-3.202-1.847-7.294-0.751-9.148,2.46c-1.846,3.202-0.751,7.293,2.452,9.14 c3.202,1.846,7.302,0.751,9.148-2.452C165.177,266.45,164.074,262.359,160.871,260.505z">
                                                </path>
                                                <path class="st0"
                                                    d="M357.817,374.216c-3.195-1.846-7.294-0.751-9.14,2.452c-1.847,3.202-0.751,7.294,2.452,9.148 c3.202,1.847,7.294,0.751,9.14-2.452C362.123,380.162,361.019,376.07,357.817,374.216z">
                                                </path>
                                                <circle class="st0" cx="142.293" cy="323.16" r="6.696">
                                                </circle>
                                                <path class="st0"
                                                    d="M154.175,374.216c-3.202,1.854-4.298,5.945-2.452,9.148c1.854,3.202,5.945,4.298,9.148,2.452 c3.202-1.854,4.306-5.945,2.452-9.148C161.477,373.466,157.378,372.37,154.175,374.216z">
                                                </path>
                                                <path class="st0"
                                                    d="M202.488,415.841c-3.202-1.847-7.294-0.758-9.14,2.444c-1.846,3.202-0.758,7.302,2.444,9.148 c3.202,1.854,7.301,0.751,9.155-2.452C206.794,421.779,205.691,417.687,202.488,415.841z">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                </a>
                            </li> -->
                            <li class="nav-item dropdown dropdown-large">
                                <!--<a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative"-->
                                <!--    href="#" data-bs-toggle="dropdown">-->
                                <!--    <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" fill="#5f5f5f">-->
                                <!--        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>-->
                                <!--        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">-->
                                <!--        </g>-->
                                <!--        <g id="SVGRepo_iconCarrier">-->
                                <!--            <path fill="#212529"-->
                                <!--                d="M144 32S94.11 69.4 96 96c1.604 22.57 44.375 25.665 48 48 1.91 11.772-16 32-16 32s48-25.373 48-48-42.8-25.978-48-48c-3.875-16.414 16-48 16-48zm80 0s-49.89 37.4-48 64c1.604 22.57 44.375 25.665 48 48 1.91 11.772-16 32-16 32s48-25.373 48-48-42.8-25.978-48-48c-3.875-16.414 16-48 16-48zm80 0s-49.89 37.4-48 64c1.604 22.57 44.375 25.665 48 48 1.91 11.772-16 32-16 32s48-25.373 48-48-42.8-25.978-48-48c-3.875-16.414 16-48 16-48zM73.293 201c1.43 63.948 18.943 179.432 74.707 238h152c55.764-58.568 73.278-174.052 74.707-238H73.293zm319.598.445c-.186 9.152-.652 19.252-1.472 30.057C419.312 235.162 441 259.142 441 288c0 31.374-25.626 57-57 57-4.387 0-8.656-.517-12.764-1.465-2.912 9.62-6.176 19.165-9.84 28.51C368.602 373.97 376.176 375 384 375c48.155 0 87-38.845 87-87 0-45.153-34.153-82.12-78.11-86.555zM42.763 457c1.507 5.193 3.854 11.2 6.955 16.37 2.637 4.394 5.69 8.207 8.428 10.58C60.882 486.32 63 487 64 487h320c1 0 3.118-.678 5.855-3.05 2.738-2.373 5.79-6.186 8.428-10.58 3.1-5.17 5.448-11.177 6.955-16.37H42.762z">-->
                                <!--            </path>-->
                                <!--        </g>-->
                                <!--    </svg>-->
                                <!--</a>-->
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div class="msg-header">
                                        <p class="msg-header-title">Breaks</p>
                                    </div>
                                    <div class="header-message-list ps">
                                        @php
                                            $currentdate = Carbon\Carbon::now('America/New_York')->toDateString();
                                            $breaks = App\adminmodel\Breaks::where('status', 1)->get();
                                        @endphp
                                       @if (!$breaks->isEmpty())
                                            @foreach ($breaks as $break)
                                                @php
                                                    $break_detail = App\Models\Break_detail::where(
                                                        'break_id',
                                                        $break->id,
                                                    )
                                                        ->where('agent_id', session('agent_id'))
                                                        ->whereDate('created_at', $currentdate) // Fix typo: 'wheredate' -> 'whereDate' and '$curretndate' -> '$currentdate'
                                                        ->first();
                                                @endphp
                                                @if (empty($break_detail))
                                                    <div class="dropdown-item break-item"
                                                        data-id="{{ $break->id }}">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="flex-grow-1">
                                                                <h6 class="cart-product-title mb-0">
                                                                    {{ $break->name }}</h6>
                                                            </div>
                                                            <div class="">
                                                                <p class="cart-price mb-0">{{ $break->duration }}
                                                                    minutes</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="dropdown-item break-item">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="flex-grow-1">
                                                                <h6 class="cart-product-title mb-0">
                                                                    {{ $break->name }}</h6>
                                                            </div>
                                                            <div class="">
                                                                <p class="cart-price mb-0">{{ $break->duration }}
                                                                    minutes</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @else
                                        <div class="dropdown-item break-item">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="flex-grow-1">
                                                    <h6 class="cart-product-title mb-0">
                                                       No break found</h6>
                                                </div>
                                                {{-- <div class="">
                                                    <p class="cart-price mb-0">{{ $break->duration }}
                                                        minutes</p>
                                                </div> --}}
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <a href="javascript:;">
                                        <div class="text-center msg-footer"></div>
                                    </a>
                                </div>
                            </li>

                            <li class="nav-item dropdown dropdown-laungauge d-none d-sm-flex">
                                <a class="nav-link" href="{{ route('agent.req_data') }}" title="Req new data"
                                    id="ring_bell">
                                    <svg fill="#000000" height="200px" width="200px" id="Layer_1"
                                        data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path class="cls-1"
                                                d="M13.8358,4.75H9.57017a.71094.71094,0,0,0-.71093.71094V7.49219a.71094.71094,0,0,0,.71093.71093h.35547L9.57017,9.625l2.48828-1.42188H13.8358a.71093.71093,0,0,0,.71094-.71093V5.46094A.71094.71094,0,0,0,13.8358,4.75ZM8.19574,11H2.75s0-.74554.5-.74554h.06451C4.25,10.25446,4.75,5.33563,4.75,5.33563c0-.50372.25-.50372.25-.50372h.067c.07452-.03674.183-.14313.183-.4632v-.4834c.105-.8421.95294-1.33135,2.25-1.4295V2.19336c0-.0816.0896-.15009.21851-.19336h.5628c.1286.04327.21863.11176.21863.19336v.26245c1.22369.09259,2.03918.53748,2.21667,1.29419H9.57031A1.71294,1.71294,0,0,0,7.85938,5.46094V7.49219a1.71165,1.71165,0,0,0,.84472,1.4751ZM6,12h4a2.04908,2.04908,0,0,1-2,2A2.04917,2.04917,0,0,1,6,12Zm7.25-1H9.17944l2.869-1.63934c.19757.52673.43054.8938.7016.8938C13.25,10.25446,13.25,11,13.25,11Z">
                                            </path>
                                        </g>
                                    </svg> </a>
                            </li>
                            <!-- <li class="nav-item dropdown dropdown-laungauge d-none d-sm-flex">
                                <a class="nav-link" title="My Note" data-bs-toggle="modal"
                                    data-bs-target="#mynotemodal">
                                    <i class="lni lni-pencil-alt"></i>
                                </a>
                            </li> -->
                            @php
                                $encodedid = base64_encode( session('agent_id'));
                            @endphp
                            <!--<li class="nav-item dropdown dropdown-laungauge d-none d-sm-flex">-->
                            <!--    <button class="nav-link" title="Go to Attendance Panel" onclick="window.open('https://wallet.thekwikster.com/login/{{ $encodedid }}', '_blank')">-->
                            <!--        <i class="lni lni-coffee-cup" style="font-size: 18px;"></i>-->
                            <!--    </button>-->
                            <!--</li>-->
                            
                            
                            <li class="nav-item dropdown dropdown-laungauge d-none d-sm-flex">
                                <a class="nav-link" title="New Lead" data-bs-toggle="modal"
                                    data-bs-target="#exampleFullScreenModal2">
                                    <i class="lni lni-target-customer"></i>
                                </a>
                            </li>
                            <!-- <li class="nav-item dropdown dropdown-laungauge d-none d-sm-flex">
                                <a class="nav-link" title="My Note" data-bs-toggle="modal"
                                    data-bs-target="#email_form_check">
                                    <i class="lni lni-envelope"></i>
                                </a>
                            </li> -->
                            <li class="nav-item dark-mode d-none d-sm-flex">
                                <a class="nav-link dark-mode-icon" href="javascript:;"><i class='bx bx-moon'></i>
                                </a>
                            </li>
                            <li class="nav-item dropdown dropdown-app">

                                <div class="dropdown-menu dropdown-menu-end p-0">
                                    <div class="app-container p-2 my-2">


                                    </div>
                                </div>
                            </li>
                            @php
                                use Carbon\Carbon;
                                $notifications = App\Models\Notification::where('agent_id', session('agent_id'))
                                    ->where('click_id', 1)
                                    ->latest()
                                    ->get();

                                $noti_count = $notifications
                                    ->where('click_id', 1)
                                    ->filter(function ($notification) {
                                        $currentTime = Carbon::now('Asia/Kolkata');
                                        return is_null($notification->reminder) ||
                                            Carbon::parse($notification->reminder) < $currentTime;
                                    })
                                    ->count();

                            @endphp

                            <li class="nav-item dropdown dropdown-large">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative"
                                    href="#" data-bs-toggle="dropdown"><span class="alert-count"
                                        id="notif_count">{{ $noti_count }}</span>
                                    <i class='bx bx-bell'></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div class="msg-header">
                                        <p class="msg-header-title">Notifications</p>
                                        <a href="{{ route('clear_notifications') }}">
                                            <p class="msg-header-badge">Clear Notifications</p>
                                        </a>
                                    </div>
                                    @if ($notifications->isNotEmpty())
                                        <div class="header-notifications-list">
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
                                                            $link = route(
                                                                'agent_search_data',
                                                                $data->data_id . '/' . $data->id,
                                                            );
                                                        } else {
                                                            $link = route('agent_pipeline_data', $data->id);
                                                        }
                                                    } elseif ($data->type == 'leave') {
                                                        $link = route('passcode', $data->id);
                                                    } elseif ($data->type == 'lead_issue') {
                                                        $link = route(
                                                            'agent_search_data',
                                                            $data->data_id . '/' . $data->id,
                                                        );
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
                                                    <a class="dropdown-item" href= "{{ $link }}"
                                                        style="{{ $backgroundColor }}">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-grow-1">
                                                                <h6 class="msg-name">
                                                                    {{ $data->heading }}
                                                                    <span
                                                                        class="msg-time float-end">{{ $timeDisplay }}</span>
                                                                </h6>
                                                                <p class="msg-info">{{ $data->massage }}</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="header-notifications-list">
                                            <a class="dropdown-item" href="javascript:;">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1">
                                                        <h6 class="msg-name">No Notifications</h6>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                    <a href="javascript:;">
                                        <div class="text-center msg-footer">
                                            {{-- <button class="btn btn-primary w-100">View All Notifications</button> --}}
                                        </div>
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item dropdown dropdown-large">
                                {{-- <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="alert-count">8</span>
                                    <i class="bx bx-conversation"></i>
                                </a> --}}
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:;">
                                        <div class="msg-header">
                                            <p class="msg-header-title">My Cart</p>
                                            <p class="msg-header-badge">10 Items</p>
                                        </div>
                                    </a>
                                    <div class="header-message-list">
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="position-relative">
                                                    <div class="cart-product rounded-circle bg-light">
                                                        <img src="assets/images/products/11.png" class=""
                                                            alt="product image">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
                                                    <p class="cart-product-price mb-0">1 X $29.00</p>
                                                </div>
                                                <div class="">
                                                    <p class="cart-price mb-0">$250</p>
                                                </div>
                                                <div class="cart-product-cancel"><i class="bx bx-x"></i>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="position-relative">
                                                    <div class="cart-product rounded-circle bg-light">
                                                        <img src="assets/images/products/02.png" class=""
                                                            alt="product image">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
                                                    <p class="cart-product-price mb-0">1 X $29.00</p>
                                                </div>
                                                <div class="">
                                                    <p class="cart-price mb-0">$250</p>
                                                </div>
                                                <div class="cart-product-cancel"><i class="bx bx-x"></i>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="position-relative">
                                                    <div class="cart-product rounded-circle bg-light">
                                                        <img src="assets/images/products/03.png" class=""
                                                            alt="product image">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
                                                    <p class="cart-product-price mb-0">1 X $29.00</p>
                                                </div>
                                                <div class="">
                                                    <p class="cart-price mb-0">$250</p>
                                                </div>
                                                <div class="cart-product-cancel"><i class="bx bx-x"></i>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="position-relative">
                                                    <div class="cart-product rounded-circle bg-light">
                                                        <img src="assets/images/products/04.png" class=""
                                                            alt="product image">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
                                                    <p class="cart-product-price mb-0">1 X $29.00</p>
                                                </div>
                                                <div class="">
                                                    <p class="cart-price mb-0">$250</p>
                                                </div>
                                                <div class="cart-product-cancel"><i class="bx bx-x"></i>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="position-relative">
                                                    <div class="cart-product rounded-circle bg-light">
                                                        <img src="assets/images/products/05.png" class=""
                                                            alt="product image">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
                                                    <p class="cart-product-price mb-0">1 X $29.00</p>
                                                </div>
                                                <div class="">
                                                    <p class="cart-price mb-0">$250</p>
                                                </div>
                                                <div class="cart-product-cancel"><i class="bx bx-x"></i>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="position-relative">
                                                    <div class="cart-product rounded-circle bg-light">
                                                        <img src="assets/images/products/06.png" class=""
                                                            alt="product image">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
                                                    <p class="cart-product-price mb-0">1 X $29.00</p>
                                                </div>
                                                <div class="">
                                                    <p class="cart-price mb-0">$250</p>
                                                </div>
                                                <div class="cart-product-cancel"><i class="bx bx-x"></i>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="position-relative">
                                                    <div class="cart-product rounded-circle bg-light">
                                                        <img src="assets/images/products/07.png" class=""
                                                            alt="product image">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
                                                    <p class="cart-product-price mb-0">1 X $29.00</p>
                                                </div>
                                                <div class="">
                                                    <p class="cart-price mb-0">$250</p>
                                                </div>
                                                <div class="cart-product-cancel"><i class="bx bx-x"></i>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="position-relative">
                                                    <div class="cart-product rounded-circle bg-light">
                                                        <img src="assets/images/products/08.png" class=""
                                                            alt="product image">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
                                                    <p class="cart-product-price mb-0">1 X $29.00</p>
                                                </div>
                                                <div class="">
                                                    <p class="cart-price mb-0">$250</p>
                                                </div>
                                                <div class="cart-product-cancel"><i class="bx bx-x"></i>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="position-relative">
                                                    <div class="cart-product rounded-circle bg-light">
                                                        <img src="assets/images/products/09.png" class=""
                                                            alt="product image">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
                                                    <p class="cart-product-price mb-0">1 X $29.00</p>
                                                </div>
                                                <div class="">
                                                    <p class="cart-price mb-0">$250</p>
                                                </div>
                                                <div class="cart-product-cancel"><i class="bx bx-x"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <a href="javascript:;">
                                        <div class="text-center msg-footer">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <h5 class="mb-0">Total</h5>
                                                <h5 class="mb-0 ms-auto">$489.00</h5>
                                            </div>
                                            <button class="btn btn-primary w-100">Checkout</button>
                                        </div>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="user-box dropdown px-3">
                        <a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret"
                            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if (empty(Auth::guard('agent')->user()->image))
                                @if (!empty(session('agent_gender')) && session('agent_gender') == 1)
                                    <img src="{{ asset('Agent/assets/images/avatars/avatar-1.png') }}"
                                        class="user-img" alt="user avatar">
                                @else
                                    <img src="{{ asset('Agent/assets/images/avatars/avatar-2.png') }}"
                                        class="user-img" alt="user avatar">
                                @endif
                            @else
                                <img src="{{ Auth::guard('agent')->user()->image }}" class="user-img"
                                    alt="user avatar">
                            @endif

                            <div class="user-info">
                                <p class="user-name mb-0">{{ session('agent_alise_name') }}</p>
                                <p class="designattion mb-0">Agent</p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('agent_profile') }}"><i
                                        class="bx bx-user fs-5"></i><span>Profile</span></a>
                            </li>
                            <li><a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('agent_change_pass') }}"><i class="lni lni-lock"></i><span>Change
                                        Password</span></a>
                            </li>
                            <li>
                                <div class="dropdown-divider mb-0"></div>
                            </li>
                            <li><a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('agent_logout') }}"><i
                                        class="bx bx-log-out-circle"></i><span>Logout</span></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
       
   <style>




    #moreDropdown {
  position: fixed !important;
  z-index: 2147483647 !important;
  inset: auto auto auto auto !important; 
  overflow: hidden;/* bootstrap/metis overrides cancel */
}


.dropdown-menu {
  position: absolute !important;
  z-index: 9999 !important;
}
.time-card {
  z-index: 1;
}


/* Menu ko horizontal header bar me rakho */
.metismenu {
  display: flex !important;
  flex-direction: row !important;
  align-items: center;
  /* gap: 20px; */
  flex-wrap: nowrap;
  margin: 0;
  padding: 0;
  list-style: none;
  /* background: #202c33; */
  position: relative;
  z-index: 1000;
}

header, nav, .card, .chat-wrapper, .chat-sidebar {
  transform: none !important;
  filter: none !important;
  backdrop-filter: none !important;
  opacity: 1 !important;
}



/* More dropdown ko viewport ke andar overlay me open karo */
/* More dropdown ko smartly viewport ke andar open karo */
/* More dropdown container */
.metismenu > li.more-menu > ul {
  position: fixed !important;
  top: 70px !important;
  left: 50% !important;
  transform: translateX(-50%) !important;
  z-index: 999999 !important;

  background: #0dcaf0;
  border-radius: 10px;
  padding: 8px 0;
  width: 90vw;
  max-width: 260px;
  max-height: 60vh;
  overflow-y: auto;
  box-shadow: 0 5px 15px rgba(0,0,0,0.3);
  display: none;
}

/* show on hover or click */
.metismenu > li.more-menu:hover > ul,
.metismenu > li.more-menu.open > ul {
  display: block !important;
  animation: pop 0.2s ease-out;
}

/* Dropdown items */
.metismenu > li.more-menu > ul > li > a {
  display: flex !important;
  align-items: center;
  padding: 10px 16px;
  color: #111;
  font-size: 15px;
  font-weight: 500;
  text-decoration: none;
  transition: 0.2s;
  position: static !important; /* list ke liye important */
}

/* Hover effect */
.metismenu > li.more-menu > ul > li > a:hover {
  background: rgba(255,255,255,0.25);
  color: #000;
  font-weight: 600;
}

/* open animation */
@keyframes pop {
  0% {opacity: 0; transform: translate(-50%, 8px);}
  100% {opacity: 1; transform: translate(-50%, 0);}
}


.metismenu > li > ul > li > a:hover {
  background: #202c33;
  color: #0dcaf0;
}

/* Arrow icon hide */
.metismenu .has-arrow::after {
  display: none !important;
}
/* ❗ Most important fix: stacking reset */
.metismenu, .metismenu > li.more-menu {
  position: static !important;
  z-index: auto !important;
}

/* Force dropdown to global top layer */
body > .metismenu > li.more-menu > ul,
.metismenu > li.more-menu > ul {
  position: fixed !important;
  /* top: 10px !important;
  left: 50% !important; */
  transform: translateX(-50%) !important;
  z-index: 9999 !important; /* Maximum possible z-index */
  display: none !important;
  background: #0dcaf0;
  min-width: 230px;
  max-height: 70vh;
  overflow-y: auto;
  border-radius: 6px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.5);
}



.mm-collapse {
  display: block !important;
  visibility: visible !important;
  opacity: 1 !important;
  position: absolute !important;
  z-index: 999999 !important;
}

.metismenu .mm-collapse {
  transform: none !important;
}

* {
  transform-style: flat !important;
  perspective: none !important;
}


/* ===== ONLY DESIGN + HOVER FIX CSS ===== */

/* More menu ko hover zone banane ke liye relative rakho */
.metismenu > li.more-menu {
  position: relative !important;
}

/* Dropdown ko More button ke niche align karo */
.metismenu > li.more-menu > ul {
  position: absolute !important;
  top: 100% !important;       /* parent ke bilkul niche */
  left: 50% !important;       /* center align */
  transform: translateX(-50%) !important;
  z-index: 999999 !important;

  background: #0dcaf0;
  border-radius: 10px;
  padding: 8px 0;
  min-width: 230px;
  max-height: 70vh;
  overflow-y: auto;
  box-shadow: 0 4px 12px rgba(0,0,0,0.4);

  opacity: 0;
  visibility: hidden;
  transition: opacity 0.2s ease, visibility 0.2s ease;
  pointer-events: auto !important; /* hover stable */
}

/* More ya dropdown dono par hover ho to show rakho */
.metismenu > li.more-menu:hover > ul,
.metismenu > li.more-menu > ul:hover {
  opacity: 1 !important;
  visibility: visible !important;
  transition-delay: 200ms;
}

/* Jab hover dono se hat jaye tab hide */
.metismenu > li.more-menu:not(:hover) > ul:not(:hover) {
  opacity: 0 !important;
  visibility: hidden !important;
  transition-delay: 200ms;
}

/* Dropdown item design */
.metismenu > li.more-menu > ul > li > a {
  display: flex !important;
  align-items: center;
  padding: 10px 16px;
  color: #111;
  font-size: 15px;
  font-weight: 500;
  text-decoration: none;
  transition: 0.2s;
  white-space: nowrap;
}

.metismenu > li.more-menu > ul > li > a:hover {
  background: rgba(255,255,255,0.25);
  color: #000;
  font-weight: 600;
}

</style>

<style>
    /* Sidebar ko header ke niche full-width bar ki tarah banaye */
.sidebar-wrapper {
  all: unset;              /* purani side positioning hata dega without deleting code */
  display: flex;
  flex-direction: column;
  width: 100%;
  background: #0dcaf0;     /* header jaisa same theme */
  color: #fff;
}

.sidebar-header {
  display: none;           /* sidebar ka top logo section hide, kyunki aapko header me hi chahiye */
}

#menu {
  display: flex;
  flex-wrap: nowrap;
  /* gap: 35px;
  padding: 12px 20px; */
  margin: 0;
  list-style: none;
  /* background: #0dcaf0;      */
  /* border-top: 1px solid #2a3942; */
}

#menu li a {
  color: #160505ff;
  font-size: 15px;
  font-weight: 500;
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 8px 14px;
  border-radius: 6px;
  transition: 0.2s;
}

#menu li a:hover {
  background: #2a3942;
  color: #0dcaf0;
}

#menu .parent-icon {
  display: flex;
  align-items: center;
  font-size: 18px;
}


/* Sidebar ko header ke niche horizontal flex bar banaye */
.sidebar-wrapper {
  position: relative;
  width: 100%;
  background: #71c8fa;
  padding: 10px 20px;
}

/* Menu options ko flex row me dikhaye */
/* #menu {
  display: flex;
  flex-direction: row;
  align-items: center;
  gap: 20px;
  flex-wrap: wrap;
  margin: 0;
  padding: 0;
  list-style: none;
} */

/* #menu li a {
  display: flex;
  align-items: center;
  color: #fff;
  font-size: 15px;
  font-weight: 500;
  text-decoration: none;
  padding: 8px 12px;
  border-radius: 6px;
  transition: 0.2s;
} */

#menu li a:hover {
  background: #2a3942;
  color: #0dcaf0;
}

/* Icon + title bhi row me proper align rahe */
#menu li a .parent-icon,
#menu li a .menu-title,
#menu li a .menu-title span {
  display: flex;
  align-items: center;
}


/* .metismenu {
  display: flex;
  flex-direction: column;
  padding: 0;
  margin-top: 70px; 
} */

/* .metismenu .has-arrow::after {
  margin-left: auto;
}

.metismenu ul {
  background: #2a3942;
  padding-left: 20px;
  list-style: none;
}

.metismenu ul li a {
  padding: 8px 15px;
  display: block;
  color: #fff;
  border-radius: 6px;
}

.metismenu ul li a:hover {
  color: #0dcaf0;
} */






</style>
        {{-- final model start model --}}
        @if (!empty($breaks))
            @foreach ($breaks as $data)
                <div class="modal fade" id="breakConfirmationModal{{ $data->id }}" tabindex="-1"
                    aria-labelledby="breakConfirmationModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="breakConfirmationModalLabel">Confirm Break</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to take {{ $data->duration }} minutes break?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary"
                                    id="startbreak{{ $data->id }}">Start</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="startmodal{{ $data->id }}" tabindex="-1" aria-hidden="true"
                    data-bs-backdrop="static" data-bs-keyboard="false">
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

                                <canvas id="timerCanvas{{ $data->id }}" width="300" height="300"></canvas>
                                <div id="timeLabel{{ $data->id }}">00:00</div>

                                <form id="completeForm{{ $data->id }}" style="display: none;">
                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                    <input type="hidden" name="time" id="elapsedTime{{ $data->id }}"
                                        value="0">
                                </form>

                                <div class="buttons">
                                    <a href="#" class="button completeButton" data-id="{{ $data->id }}">
                                        Complete
                                    </a>
                                </div>
                                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                                <script type="text/javascript">
                                    (function() {
                                        const canvas = document.getElementById('timerCanvas{{ $data->id }}');
                                        const ctx = canvas.getContext('2d');
                                        const defaultDuration = {{ $data->duration }} * 60; // Total duration in seconds
                                        let timerInterval = null;
                                        const modalId = 'startmodal{{ $data->id }}';
                                        const elapsedTimeKey = `elapsedTime_{{ $data->id }}`;
                                        const startTimeKey = `startTime_{{ $data->id }}`;
                                        const modalStateKey = `modalState_{{ $data->id }}`;
                                        const SIX_HOURS_IN_SECONDS = 6 * 60 * 60; // 6 hours in seconds

                                    
                                        // Function to start the timer
                                        function startTimer() {
                                            clearInterval(timerInterval); // Clear existing intervals before starting a new one
                                            updateTimer(); // Immediately update the timer display
                                    
                                            timerInterval = setInterval(() => {
                                                updateTimer(); // Update the timer display every second
                                            }, 1000);
                                        }
                                    
                                        // Function to update the timer and display
                                        function updateTimer() {
                                            const elapsedTime = calculateElapsedTime(); // Calculate elapsed time since the start
                                            drawPieChart(elapsedTime);
                                            document.getElementById('timeLabel{{ $data->id }}').innerText = formatTime(elapsedTime);
                                            document.getElementById('elapsedTime{{ $data->id }}').value = elapsedTime;
                                            localStorage.setItem(elapsedTimeKey, elapsedTime);
                                            localStorage.setItem('breakcheck', 'active');
                                        }
                                    
                                        // Calculate total elapsed time based on the start time stored in localStorage
                                        function calculateElapsedTime() {
                                            const startTime = parseInt(localStorage.getItem(startTimeKey));
                                            if (!startTime) return 0;
                                            const now = Math.floor(Date.now() / 1000);
                                            const elapsedTime = now - startTime;
                                            return elapsedTime; // No cap on elapsed time, will keep running beyond defaultDuration
                                        }
                                    
                                        // Draw the pie chart based on the elapsed time
                                        function drawPieChart(elapsedTime) {
                                            const radius = 100;
                                            const centerX = canvas.width / 2;
                                            const centerY = canvas.height / 2;
                                            const endAngle = (Math.PI * 2) * (elapsedTime / defaultDuration);
                                    
                                            ctx.clearRect(0, 0, canvas.width, canvas.height);
                                    
                                            // Background circle
                                            ctx.beginPath();
                                            ctx.arc(centerX, centerY, radius, 0, Math.PI * 2);
                                            ctx.strokeStyle = '#ddd';
                                            ctx.lineWidth = 15;
                                            ctx.stroke();
                                    
                                            // Progress circle
                                            ctx.beginPath();
                                            ctx.arc(centerX, centerY, radius, -Math.PI / 2, (elapsedTime >= defaultDuration ? Math.PI * 2 :
                                                endAngle) - Math.PI / 2);
                                            ctx.strokeStyle = (elapsedTime >= defaultDuration) ? 'red' : 'green';
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
    console.log('Modal shown');
    
    const now = Math.floor(Date.now() / 1000); // Current time in seconds

    // Check if startTimeKey exists
    const startTime = parseInt(localStorage.getItem(startTimeKey));

    if (startTime) {
        // If startTimeKey exists, calculate the elapsed time
        const elapsedTime = now - startTime;

        // Check if the elapsed time is greater than the defined time (SIX_HOURS_IN_SECONDS)
        if (elapsedTime > SIX_HOURS_IN_SECONDS) {
            console.log(`Start time is older than ${SIX_HOURS_IN_SECONDS} seconds. Resetting start time.`);
            // Reset the start time to the current time
            localStorage.setItem(startTimeKey, now);
            console.log('Updated startTimeKey:', localStorage.getItem(startTimeKey));
        } else {
            console.log('startTimeKey exists and is within the allowed time:', startTime);
        }
    } else {
        console.log('First time opening modal. Setting new start time.');
        // Reset timer when opening for the first time or after completion
        localStorage.removeItem(elapsedTimeKey);
        localStorage.removeItem(startTimeKey);
        localStorage.removeItem(modalStateKey);
        localStorage.removeItem('breakcheck');

        // Set start time to the current time
        localStorage.setItem(startTimeKey, now);
        console.log('Set startTimeKey:', localStorage.getItem(startTimeKey));
    }

    startTimer(); // Start the timer when modal is shown
});

                                    
                                        modal.addEventListener('hidden.bs.modal', function() {
                                            console.log('Modal hidden');
                                            clearInterval(timerInterval); // Clear interval when modal is closed
                                            clearLocalStorage(); // Clear local storage on modal close
                                        });
                                    
                                        // Function to clear localStorage related to the timer
                                        function clearLocalStorage() {
                                            console.log('Clearing local storage...');
                                            localStorage.removeItem(elapsedTimeKey);
                                            localStorage.removeItem(startTimeKey);
                                            console.log('After clear, startTimeKey:', localStorage.getItem(startTimeKey)); // Check if it's removed
                                            localStorage.removeItem(modalStateKey);
                                            localStorage.removeItem('breakcheck');
                                            localStorage.clear();
                                        }
                                    
                                        // AJAX submit on complete button click
                                        document.addEventListener("DOMContentLoaded", function() {
                                            let isRequestInProgress = false; // Create a flag to track request state
                                    
                                            document.querySelector('.completeButton[data-id="{{ $data->id }}"]').addEventListener(
                                                'click',
                                                function(event) {
                                                    event.preventDefault();
                                                    event.stopPropagation();
                                    
                                                    // Check if a request is already in progress
                                                    if (isRequestInProgress) {
                                                        return; // Exit if another request is in progress
                                                    }
                                    
                                                    // Set the flag to true to prevent further requests
                                                    isRequestInProgress = true;
                                    
                                                    const completeButton = this; // Reference to the clicked button
                                                    completeButton.disabled = true; // Disable the button to prevent multiple clicks
                                    
                                                    const form = document.getElementById('completeForm{{ $data->id }}');
                                                    const formData = new FormData(form);
                                    
                                                    // Send data via AJAX
                                                    fetch('{{ route('complete_break_process') }}', {
                                                            method: 'POST',
                                                            headers: {
                                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                            },
                                                            body: formData,
                                                        })
                                                        .then(response => response.json())
                                                        .then(data => {
                                                            // Clear local storage
                                                            console.log('Clearing local storage after completion...');
                                                            localStorage.removeItem(elapsedTimeKey);
                                                            localStorage.removeItem(startTimeKey);
                                                            console.log('After completion, startTimeKey:', localStorage.getItem(startTimeKey)); // Check if it's removed
                                                            localStorage.removeItem(modalStateKey);
                                                            localStorage.removeItem('breakcheck');
                                    
                                                            // Hide the modal
                                                            const modal = document.getElementById(modalId);
                                                            const modalInstance = bootstrap.Modal.getInstance(modal);
                                                            modalInstance.hide();
                                    
                                                            // Refresh the page
                                                            location.reload();
                                                        })
                                                        .catch(error => {
                                                            console.error('Error:', error);
                                                            // Re-enable the button if an error occurs and reset the flag
                                                            completeButton.disabled = false;
                                                            isRequestInProgress = false;
                                                        });
                                                });
                                        });
                                    
                                        // Store modal state in localStorage
                                        window.addEventListener('beforeunload', function() {
                                            if ($('#' + modalId).hasClass('show')) {
                                                localStorage.setItem(modalStateKey, 'open');
                                            } else {
                                                localStorage.setItem(modalStateKey, 'closed');
                                            }
                                        });
                                    
                                        $(document).ready(function() {
                                            function checkModalState() {
                                                if (localStorage.getItem(modalStateKey) === 'open') {
                                                    $('#' + modalId).modal('show');
                                                    startTimer();
                                                }
                                            }
                                    
                                            // Check the modal state on page load
                                            checkModalState();

                                            $('#' + modalId).on('shown.bs.modal', function() {
                                                localStorage.setItem(modalStateKey, 'open');
                                            });
                                    
                                            $('#' + modalId).on('hidden.bs.modal', function() {
                                                localStorage.setItem(modalStateKey, 'closed');
                                                clearLocalStorage();
                                            });
                                        });
                                    })();
                                </script>
                                    
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $('#startbreak{{ $data->id }}').click(function(event) {
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
        {{-- modal start2 --}}
        {{-- modal end2 --}}
        <div class="modal fade" id="exampleFullScreenModal2" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header border-bottom">
                        <h4>Lead</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('storeSingleData') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            {{-- <input type="hidden" name="data_id" value="" id="data_id"> --}}
                            <input type="hidden" name="forword_id" value="" id="forword_id">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="row border-end border-primary">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Company Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter company name" id="company_name"
                                                    name="company_name">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="lastNameinput" class="form-label">Phone <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" class="form-control"
                                                    placeholder="Enter phone number" id="phone" name="phone">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email </label>
                                                <input type="email" class="form-control"
                                                    placeholder="example@gmail.com" id="email" name="email">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="compnayNameinput" class="form-label">Company Rep1 <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter company rep..." id="company_rep1"
                                                    name="company_rep1">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="emailidInput" class="form-label">Business Address <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter business address" id="business_address"
                                                    name="business_address">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="address1ControlTextarea" class="form-label">Business City
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter business city" id="business_city"
                                                    name="business_city">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Business State <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter business state" id="business_state"
                                                    name="business_state">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Business ZIP <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter business zip" id="business_zip"
                                                    name="business_zip">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">DOT <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter DOT"
                                                    id="dot" name="dot" required="">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">MC/Docket <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter MC"
                                                    id="mc_docket" name="mc_docket">
                                            </div>
                                        </div><!--end col-->
                                          <div class="col-12">
                                        <div class="mb-3">
                                            <label for="owner_dob" class="form-label">Owner DOB <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control"
                                                placeholder="Enter driver dob" id="owner_dob"
                                                name="owner_dob">
                                        </div>
                                    </div>
                                        <div class="col-12 mb-3">
                                            <h5>Commodities</h5>
                                            <div class="row">
                                                <div class="col-6">

                                                    <input type="checkbox" class="form-check-input"
                                                        name="commodities[]" value="Building Materials - Machinery">
                                                    <label for="citynameInput" class="form-label"> Building Materials
                                                        - Machinery</label>

                                                </div>
                                                <div class="col-6">

                                                    <input type="checkbox" class="form-check-input"
                                                        name="commodities[]" value="Building Materials">
                                                    <label for="citynameInput" class="form-label"> Building
                                                        Materials</label>

                                                </div>
                                                <div class="col-6">

                                                    <input type="checkbox" class="form-check-input"
                                                        name="commodities[]" value="Dry Freight - Amazon">
                                                    <label for="citynameInput" class="form-label"> Dry Freight -
                                                        Amazon</label>

                                                </div>
                                                <div class="col-6">

                                                    <input type="checkbox" class="form-check-input"
                                                        name="commodities[]" value="Dry Freight">
                                                    <label for="citynameInput" class="form-label"> Dry Freight</label>

                                                </div>
                                                <div class="col-6">

                                                    <input type="checkbox" class="form-check-input"
                                                        name="commodities[]" value="Reefer with seafood or flowers">
                                                    <label for="citynameInput" class="form-label"> Reefer with seafood
                                                        or flowers</label>

                                                </div>
                                                <div class="col-6">

                                                    <input type="checkbox" class="form-check-input"
                                                        name="commodities[]" value="Refrigerated Goods">
                                                    <label for="citynameInput" class="form-label"> Refrigerated
                                                        Goods</label>

                                                </div>
                                                <div class="col-6">

                                                    <input type="checkbox" class="form-check-input"
                                                        name="commodities[]" value="Reefer with flowers">
                                                    <label for="citynameInput" class="form-label"> Reefer with
                                                        flowers</label>

                                                </div>
                                                <div class="col-6">

                                                    <input type="checkbox" class="form-check-input"
                                                        name="commodities[]" value="Fracking Sand">
                                                    <label for="citynameInput" class="form-label"> Fracking
                                                        Sand</label>

                                                </div>
                                                <div class="col-6">

                                                    <input type="checkbox" class="form-check-input"
                                                        name="commodities[]" value="Hazard">
                                                    <label for="citynameInput" class="form-label"> Hazard</label>

                                                </div>
                                                <div class="col-6">

                                                    <input type="checkbox" class="form-check-input"
                                                        name="commodities[]" value="Containerized Freight">
                                                    <label for="citynameInput" class="form-label"> Containerized
                                                        Freight</label>

                                                </div>
                                                <div class="col-6">

                                                    <input type="checkbox" class="form-check-input"
                                                        name="commodities[]" value="Sand &amp; Gravel">
                                                    <label for="citynameInput" class="form-label"> Sand &amp;
                                                        Gravel</label>

                                                </div>
                                                <div class="col-6">

                                                    <input type="checkbox" class="form-check-input"
                                                        name="commodities[]" value="Auto 100%">
                                                    <label for="citynameInput" class="form-label"> Auto 100%</label>

                                                </div>
                                                <div class="col-6">

                                                    <input type="checkbox" class="form-check-input"
                                                        name="commodities[]" value="Hauls Oversized/Overweight">
                                                    <label for="citynameInput" class="form-label"> Hauls
                                                        Oversized/Overweight</label>

                                                </div>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="ForminputState" class="form-label">Unit Owned <span
                                                        class="text-danger">*</span></label>
                                                <select id="unit_owned1" class="form-select" name="unit_owned">
                                                    <option value="1" selected>1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                </select>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">VIN <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter VIN"
                                                    id="vin" name="vin" maxlength="17">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Vehicle Year </label>
                                                <input type="number" class="form-control" placeholder="YYYY"
                                                    id="vehicle_year" name="vehicle_year">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Vehicle Make </label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter Vehicle make..." id="vehicle_make"
                                                    name="vehicle_make">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Stated Value </label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter stated value" id="stated_value"
                                                    name="stated_value">
                                            </div>
                                        </div><!--end col-->

                                        <div class="row unit2" id="unit2" style="display: none;">
                                            <hr class=" border border-2 border-primary">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="citynameInput" class="form-label">VIN2 <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Enter VIN" id="vin2" name="vin2">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="citynameInput" class="form-label">Vehicle Year2 </label>
                                                    <input type="number" class="form-control" placeholder="YYYY" id="vehicle_year2" name="vehicle_year2">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="citynameInput" class="form-label">Vehicle Make2 </label>
                                                    <input type="text" class="form-control" placeholder="Enter Vehicle make..." id="vehicle_make2" name="vehicle_make2">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="citynameInput" class="form-label">Stated Value2 </label>
                                                    <input type="text" class="form-control" placeholder="Enter stated value" id="stated_value2" name="stated_value2">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row unit3" id="unit3" style="display: none;">
                                            <hr class="border border-2 border-primary">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="citynameInput" class="form-label">VIN3 <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Enter VIN" id="vin3" name="vin3">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="citynameInput" class="form-label">Vehicle Year3 </label>
                                                    <input type="number" class="form-control" placeholder="YYYY" id="vehicle_year3" name="vehicle_year3">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="citynameInput" class="form-label">Vehicle Make3 </label>
                                                    <input type="text" class="form-control" placeholder="Enter Vehicle make..." id="vehicle_make3" name="vehicle_make3">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="citynameInput" class="form-label">Stated Value3 </label>
                                                    <input type="text" class="form-control" placeholder="Enter stated value" id="stated_value3" name="stated_value3">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row unit4" id="unit4" style="display: none;">
                                            <hr class="border border-2 border-primary">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="citynameInput" class="form-label">VIN4 <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Enter VIN" id="vin4" name="vin4">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="citynameInput" class="form-label">Vehicle Year4 </label>
                                                    <input type="number" class="form-control" placeholder="YYYY" id="vehicle_year4" name="vehicle_year4">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="citynameInput" class="form-label">Vehicle Make4 </label>
                                                    <input type="text" class="form-control" placeholder="Enter Vehicle make..." id="vehicle_make4" name="vehicle_make4">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="citynameInput" class="form-label">Stated Value4 </label>
                                                    <input type="text" class="form-control" placeholder="Enter stated value" id="stated_value4" name="stated_value4">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row unit5" id="unit5" style="display: none;">
                                            <hr class=" border border-2 border-primary">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="citynameInput" class="form-label">VIN5 <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Enter VIN" id="vin5" name="vin5">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="citynameInput" class="form-label">Vehicle Year5 </label>
                                                    <input type="number" class="form-control" placeholder="YYYY" id="vehicle_year5" name="vehicle_year5">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="citynameInput" class="form-label">Vehicle Make5 </label>
                                                    <input type="text" class="form-control" placeholder="Enter Vehicle make..." id="vehicle_make5" name="vehicle_make5">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="citynameInput" class="form-label">Stated Value5 </label>
                                                    <input type="text" class="form-control" placeholder="Enter stated value" id="stated_value5" name="stated_value5">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row unit6" id="unit6" style="display: none;">
                                            <hr class="border border-2 border-primary">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="vin6" class="form-label">VIN6 <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Enter VIN" id="vin6" name="vin6">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="vehicle_year6" class="form-label">Vehicle Year6 </label>
                                                    <input type="number" class="form-control" placeholder="YYYY" id="vehicle_year6" name="vehicle_year6">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="vehicle_make6" class="form-label">Vehicle Make6 </label>
                                                    <input type="text" class="form-control" placeholder="Enter Vehicle make..." id="vehicle_make6" name="vehicle_make6">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="stated_value6" class="form-label">Stated Value6 </label>
                                                    <input type="text" class="form-control" placeholder="Enter stated value" id="stated_value6" name="stated_value6">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row unit7" id="unit7" style="display: none;">
                                            <hr class="border border-2 border-primary">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="vin7" class="form-label">VIN7 <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Enter VIN" id="vin7" name="vin7">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="vehicle_year7" class="form-label">Vehicle Year7 </label>
                                                    <input type="number" class="form-control" placeholder="YYYY" id="vehicle_year7" name="vehicle_year7">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="vehicle_make7" class="form-label">Vehicle Make7 </label>
                                                    <input type="text" class="form-control" placeholder="Enter Vehicle make..." id="vehicle_make7" name="vehicle_make7">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="stated_value7" class="form-label">Stated Value7 </label>
                                                    <input type="text" class="form-control" placeholder="Enter stated value" id="stated_value7" name="stated_value7">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row unit8" id="unit8" style="display: none;">
                                            <hr class="border border-2 border-primary">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="vin8" class="form-label">VIN8 <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Enter VIN" id="vin8" name="vin8">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="vehicle_year8" class="form-label">Vehicle Year8 </label>
                                                    <input type="number" class="form-control" placeholder="YYYY" id="vehicle_year8" name="vehicle_year8">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="vehicle_make8" class="form-label">Vehicle Make8 </label>
                                                    <input type="text" class="form-control" placeholder="Enter Vehicle make..." id="vehicle_make8" name="vehicle_make8">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="stated_value8" class="form-label">Stated Value8 </label>
                                                    <input type="text" class="form-control" placeholder="Enter stated value" id="stated_value8" name="stated_value8">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row unit9" id="unit9" style="display: none;">
                                            <hr class="border border-2 border-primary">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="vin9" class="form-label">VIN9 <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Enter VIN" id="vin9" name="vin9">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="vehicle_year9" class="form-label">Vehicle Year9 </label>
                                                    <input type="number" class="form-control" placeholder="YYYY" id="vehicle_year9" name="vehicle_year9">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="vehicle_make9" class="form-label">Vehicle Make9 </label>
                                                    <input type="text" class="form-control" placeholder="Enter Vehicle make..." id="vehicle_make9" name="vehicle_make9">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="stated_value9" class="form-label">Stated Value9 </label>
                                                    <input type="text" class="form-control" placeholder="Enter stated value" id="stated_value9" name="stated_value9">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row unit10" id="unit10" style="display: none;">
                                            <hr class="border border-2 border-primary">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="vin10" class="form-label">VIN10 <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Enter VIN" id="vin10" name="vin10">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="vehicle_year10" class="form-label">Vehicle Year10 </label>
                                                    <input type="number" class="form-control" placeholder="YYYY" id="vehicle_year10" name="vehicle_year10">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="vehicle_make10" class="form-label">Vehicle Make10 </label>
                                                    <input type="text" class="form-control" placeholder="Enter Vehicle make..." id="vehicle_make10" name="vehicle_make10">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="stated_value10" class="form-label">Stated Value10 </label>
                                                    <input type="text" class="form-control" placeholder="Enter stated value" id="stated_value10" name="stated_value10">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="ForminputState" class="form-label">Drivers<span
                                                    class="text-danger">*</span></label>
                                            <select id="drivers_state1" class="form-select" name="drivers_state">
                                                <option value="1" selected>1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter driver name"
                                                id="driver_name" name="driver_name">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver DOB <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control" placeholder="Enter driver dob"
                                                id="driver_dob" name="driver_dob">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver License <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter driver license"
                                                id="driver_license" name="driver_license">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="citynameInput" class="form-label">Driver License State<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter driver license"
                                                id="driver_license_state" name="driver_license_state">
                                        </div>
                                    </div><!--end col-->
                                    <div class="row unit2" id="driver2" style="display: none;">
                                        <hr class="border border-2 border-primary">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_name2" class="form-label">Driver Name2 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver name" id="driver_name2" name="driver_name2">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_dob2" class="form-label">Driver DOB2 <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" placeholder="Enter driver dob" id="driver_dob2" name="driver_dob2">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license2" class="form-label">Driver License2 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver license" id="driver_license2" name="driver_license2">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license_state2" class="form-label">Driver License State2 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver license state" id="driver_license_state2" name="driver_license_state2">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row unit3" id="driver3" style="display: none;">
                                        <hr class="border border-2 border-primary">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_name3" class="form-label">Driver Name3 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver name" id="driver_name3" name="driver_name3">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_dob3" class="form-label">Driver DOB3 <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" placeholder="Enter driver dob" id="driver_dob3" name="driver_dob3">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license3" class="form-label">Driver License3 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver license" id="driver_license3" name="driver_license3">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license_state3" class="form-label">Driver License State3 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver license state" id="driver_license_state3" name="driver_license_state3">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row unit4" id="driver4" style="display: none;">
                                        <hr class="border border-2 border-primary">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_name4" class="form-label">Driver Name4 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver name" id="driver_name4" name="driver_name4">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_dob4" class="form-label">Driver DOB4 <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" placeholder="Enter driver dob" id="driver_dob4" name="driver_dob4">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license4" class="form-label">Driver License4 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver license" id="driver_license4" name="driver_license4">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license_state4" class="form-label">Driver License State4 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver license state" id="driver_license_state4" name="driver_license_state4">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row unit5" id="driver5" style="display: none;">
                                        <hr class="border border-2 border-primary">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_name5" class="form-label">Driver Name5 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver name" id="driver_name5" name="driver_name5">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_dob5" class="form-label">Driver DOB5 <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" placeholder="Enter driver dob" id="driver_dob5" name="driver_dob5">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license5" class="form-label">Driver License5 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver license" id="driver_license5" name="driver_license5">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license_state5" class="form-label">Driver License State5 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver license state" id="driver_license_state5" name="driver_license_state5">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row unit6" id="driver6" style="display: none;">
                                        <hr class="border border-2 border-primary">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_name6" class="form-label">Driver Name6 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver name" id="driver_name6" name="driver_name6">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_dob6" class="form-label">Driver DOB6 <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" placeholder="Enter driver dob" id="driver_dob6" name="driver_dob6">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license6" class="form-label">Driver License6 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver license" id="driver_license6" name="driver_license6">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license_state6" class="form-label">Driver License State6 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver license state" id="driver_license_state6" name="driver_license_state6">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row unit7" id="driver7" style="display: none;">
                                        <hr class="border border-2 border-primary">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_name7" class="form-label">Driver Name7 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver name" id="driver_name7" name="driver_name7">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_dob7" class="form-label">Driver DOB7 <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" placeholder="Enter driver dob" id="driver_dob7" name="driver_dob7">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license7" class="form-label">Driver License7 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver license" id="driver_license7" name="driver_license7">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license_state7" class="form-label">Driver License State7 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver license state" id="driver_license_state7" name="driver_license_state7">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row unit8" id="driver8" style="display: none;">
                                        <hr class="border border-2 border-primary">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_name8" class="form-label">Driver Name8 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver name" id="driver_name8" name="driver_name8">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_dob8" class="form-label">Driver DOB8 <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" placeholder="Enter driver dob" id="driver_dob8" name="driver_dob8">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license8" class="form-label">Driver License8 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver license" id="driver_license8" name="driver_license8">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license_state8" class="form-label">Driver License State8 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver license state" id="driver_license_state8" name="driver_license_state8">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row unit9" id="driver9" style="display: none;">
                                        <hr class="border border-2 border-primary">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_name9" class="form-label">Driver Name9 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver name" id="driver_name9" name="driver_name9">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_dob9" class="form-label">Driver DOB9 <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" placeholder="Enter driver dob" id="driver_dob9" name="driver_dob9">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license9" class="form-label">Driver License9 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver license" id="driver_license9" name="driver_license9">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license_state9" class="form-label">Driver License State9 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver license state" id="driver_license_state9" name="driver_license_state9">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row unit10" id="driver10" style="display: none;">
                                        <hr class="border border-2 border-primary">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_name10" class="form-label">Driver Name10 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver name" id="driver_name10" name="driver_name10">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_dob10" class="form-label">Driver DOB10 <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" placeholder="Enter driver dob" id="driver_dob10" name="driver_dob10">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license10" class="form-label">Driver License10 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver license" id="driver_license10" name="driver_license10">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="driver_license_state10" class="form-label">Driver License State10 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter driver license state" id="driver_license_state10" name="driver_license_state10">
                                            </div>
                                        </div>
                                    </div>
                                    
                                        


                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <img src="{{ asset('assets/images/phonetics.png') }}" alt=""
                                                height="400" class="img-fluid">
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="ForminputState" class="form-label">Status<span
                                                        class="text-danger">*</span></label>
                                                <select id="form_status1" class="form-select" name="form_status"
                                                    required="">
                                                    <option value="Intrested">Intrested</option>
                                                    <option value="Pipeline">Pipeline</option>
                                                </select>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="pt-0">
                                               <div class="mt-2">
     <label for="ForminputState" class="form-label">Mode<span
                                                    class="text-danger">*</span></label>

    <select name="contact_mode" class="form-select" required>
       
        <option value="Call"
            {{ old('contact_mode', $data->mail_status ?? '') == 'Call' ? 'selected' : '' }}>
            Voice
        </option>
        <option value="Email"
            {{ old('contact_mode', $data->mail_status ?? '') == 'Email' ? 'selected' : '' }}>
            Email
        </option>
    </select>
</div>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6 reminder" style="display:none">
                                            <div class="pb-4">
                                                <label for="dateInput" class="form-label">Date</label>
                                                <input type="date" class="form-control" id="dateInput2"
                                                    name="dateInput">

                                                <label for="timeInput" class="form-label">Time</label>
                                                <input type="time" class="form-control" id="timeInput2"
                                                    name="timeInput">
                                                <input type="hidden" name="reminder" id="reminder2"></input>
                                                <button onclick="setReminder1()">Set Reminder</button>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="citynameInput" class="form-label">Comment </label>
                                                <textarea id="comment" name="comment" class="form-control" rows="4" placeholder="Write a Coment...."
                                                    required=""></textarea>
                                            </div>
                                        </div><!--end col-->

                                        <h4>Policy</h4>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="ForminputState" class="form-label">Liability
                                                    limit</label>
                                                <select id="form_status" class="form-select" name="Liability"
                                                    required="">
                                                    <option value="N/A">N/A</option>
                                                    <option value="$250,000">$250,000</option>
                                                    <option value="$300,000">$300,000</option>
                                                    <option value="$500,000">$500,000</option>
                                                    <option value="$750,000">$750,000</option>
                                                    <option value="$1,000,000">$1,000,000</option>
                                                    <option value="$1,500,000">$1,500,000</option>
                                                    <option value="$1,750,000">$1,750,000</option>
                                                    <option value="$2,000,000">$2,000,000</option>
                                                </select>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="ForminputState" class="form-label">Do you need MTC
                                                    ?</label>
                                                <select id="form_status" class="form-select" name="MTC"
                                                    required="">
                                                    <option value="N/A">N/A</option>
                                                    <option value="$25,000">$25,000</option>
                                                    <option value="$50,000">$50,000</option>
                                                    <option value="$100,000">$100,000</option>
                                                    <option value="$150,000">$150,000</option>
                                                    <option value="$200,000">$200,000</option>
                                                    <option value="$250,000">$250,000</option>
                                                    <option value="$300,000">$300,000</option>
                                                    <option value="$500,000">$500,000</option>
                                                </select>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-7">
                                            <div class="mb-3">
                                                <label for="ForminputState" class="form-label">Trailer
                                                    interchange</label>
                                                <select id="form_status" class="form-select" name="interchange"
                                                    required="">
                                                    <option value="N/A">N/A</option>
                                                    <option value="$1,000">$1,000</option>
                                                    <option value="$2,500">$2,500</option>
                                                    <option value="$5,000">$5,000</option>
                                                    <option value="$10,000">$10,000</option>
                                                    <option value="$15,000">$15,000</option>
                                                    <option value="$25,000">$25,000</option>
                                                    <option value="$30,000">$30,000</option>
                                                    <option value="$40,000">$40,000</option>
                                                    <option value="$50,000">$50,000</option>
                                                    <option value="$60,000">$60,000</option>
                                                    <option value="$75,000">$75,000</option>
                                                    <option value="$100,000">$100,000</option>
                                                </select>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="physical" id="physical"
                                                        value="1" class="form-check-input">
                                                    Physical Damage
                                                </label>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="general" id="general"
                                                        value="1" class="form-check-input">
                                                    General Liability
                                                </label>
                                            </div>
                                        </div><!--end col-->
                                        <hr />
                                        <h5>Documents/Files</h5>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <input class="form-control" style="margin-left: 10px"
                                                    type="file" value="" name="file1">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <input class="form-control" style="margin-left: 10px"
                                                    type="file" value="" name="file2">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <input class="form-control" style="margin-left: 10px"
                                                    type="file" value="" name="file3">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <input class="form-control" style="margin-left: 10px"
                                                    type="file" value="" name="file4">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <input class="form-control" style="margin-left: 10px"
                                                    type="file" value="" name="file5">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <input class="form-control" style="margin-left: 10px"
                                                    type="file" value="" name="file6">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-lg-12">
                                            <div class="text-end">
                                                <div class="mt-4">
                                                    <div class="hstack gap-2 justify-content-center">
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-link link-danger fw-medium"
                                                            data-bs-dismiss="modal"><i
                                                                class="ri-close-line me-1 align-middle"></i>
                                                            Close</a>
                                                        <button type="submit"
                                                            class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--end col-->
                                    </div>
                                </div>
                            </div><!--end row-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- notes model --}}
        <div class="modal fade" id="mynotemodal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">My Note</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @php
                            $script = App\adminmodel\ScriptModal::whereNull('deleted_at')
                                ->where('ajent_id', session('agent_id'))
                                ->first();
                        @endphp
                        <form method="post">
                            <textarea class="form-control" height="500px" type="text" name="mynote" id="mynotes">{{ old('name') ? old('name') : $script->my_note ?? '' }}</textarea>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- end modal --}}
        {{-- holidays model --}}
        <div class="modal fade" id="usholidays" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">US Holidays(2024)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="{{ url('Agent/assets/holidays.jpeg') }}" class="img-fluid"
                            style="width: 100%; height:100%" alt="US Holidays">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- holidays model --}}
        {{-- check time model --}}
        <div class="modal fade" id="checktimeremain" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Your Remaining Time</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="height: 400px;">
                        <style>
                            .wrap {
                                position: absolute;
                                bottom: 0;
                                top: 0;
                                left: 0;
                                right: 0;
                                margin: auto;
                                height: 310px;
                            }

                            a {
                                text-decoration: none;
                                color: #1a1a1a;
                            }

                            /* Title */
                            h1 {
                                margin-bottom: 60px;
                                text-align: center;
                                font: 300 2.25em 'Lato', sans-serif;
                                text-transform: uppercase;
                            }

                            h1 strong {
                                font-weight: 400;
                                color: #00800f;
                            }

                            h2 {
                                margin-bottom: 80px;
                                text-align: center;
                                font: 300 0.7em 'Lato', sans-serif;
                                text-transform: uppercase;
                            }

                            h2 strong {
                                font-weight: 400;
                            }

                            /* Countdown */
                            .countdown {
                                width: 720px;
                                margin: 0 auto;
                            }

                            .countdown .bloc-time {
                                float: left;
                                margin-right: 45px;
                                text-align: center;
                            }

                            .countdown .bloc-time:last-child {
                                margin-right: 0;
                            }

                            .countdown .count-title {
                                display: block;
                                margin-bottom: 15px;
                                font: normal 0.94em 'Lato', sans-serif;
                                color: #1a1a1a;
                                text-transform: uppercase;
                            }

                            .countdown .figure {
                                position: relative;
                                float: left;
                                height: 110px;
                                width: 100px;
                                margin-right: 10px;
                                background-color: #fff;
                                border-radius: 8px;
                                box-shadow: 0 3px 4px 0 rgba(0, 0, 0, 0.2), inset 2px 4px 0 0 rgba(255, 255, 255, 0.08);
                            }

                            .countdown .figure:last-child {
                                margin-right: 0;
                            }

                            .countdown .figure>span {
                                position: absolute;
                                left: 0;
                                right: 0;
                                margin: auto;
                                font: normal 5.94em/107px 'Lato', sans-serif;
                                font-weight: 700;
                                color: #00800f;
                            }

                            .countdown .figure .top,
                            .countdown .figure .bottom-back {
                                position: absolute;
                                left: 0;
                                right: 0;
                            }

                            .countdown .figure .top:after,
                            .countdown .figure .bottom-back:after {
                                content: "";
                                position: absolute;
                                z-index: -1;
                                left: 0;
                                bottom: 0;
                                width: 100%;
                                height: 100%;
                                border-bottom: 1px solid rgba(0, 0, 0, 0.1);
                            }

                            .countdown .figure .top {
                                z-index: 3;
                                background-color: #f7f7f7;
                                transform-origin: 50% 100%;
                                transform: perspective(200px);
                                border-top-left-radius: 10px;
                                border-top-right-radius: 10px;
                            }

                            .countdown .figure .bottom {
                                z-index: 1;
                                position: relative;
                            }

                            .countdown .figure .bottom:before {
                                content: "";
                                position: absolute;
                                display: block;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 50%;
                                background-color: rgba(0, 0, 0, 0.02);
                            }

                            .countdown .figure .bottom-back {
                                z-index: 2;
                                top: 0;
                                height: 50%;
                                overflow: hidden;
                                background-color: #f7f7f7;
                                border-top-left-radius: 10px;
                                border-top-right-radius: 10px;
                            }

                            .countdown .figure .bottom-back span {
                                position: absolute;
                                top: 0;
                                left: 0;
                                right: 0;
                                margin: auto;
                            }

                            .countdown .figure .top,
                            .countdown .figure .top-back {
                                height: 50%;
                                overflow: hidden;
                                backface-visibility: hidden;
                            }

                            .countdown .figure .top-back {
                                z-index: 4;
                                bottom: 0;
                                background-color: #fff;
                                transform-origin: 50% 0;
                                transform: perspective(200px) rotateX(180deg);
                                border-bottom-left-radius: 10px;
                                border-bottom-right-radius: 10px;
                            }

                            .countdown .figure .top-back span {
                                position: absolute;
                                top: -100%;
                                left: 0;
                                right: 0;
                                margin: auto;
                            }
                        </style>

                       <div class="wrap">
@php
    $current = Carbon::now('America/New_York');

    $attendance = App\Models\Attendance::where('emp_id', session('agent_id'))
        ->whereDate('created_at', $current->toDateString())
        ->first();

    // Crash se bachane ke liye check
    $logintowork = $attendance->login ?? null;
    $worktime = $attendance->total_work ?? 0;

    $diff = 0;
    if($logintowork){
        $login = Carbon::parse($logintowork, 'America/New_York');
        $diff = $login->diffInMinutes($current);
    }

    $total = (int)($worktime + $diff);
    $hours = floor($total / 60);
    $minutes = $total % 60;
@endphp

<h1>Total <strong>Work Time</strong></h1>
<div>{{ $hours }} Hours {{ $minutes }} Minutes</div>
</div>

                        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
                        <script>
                            // Create CountUp
                            var hour = {{ $hours }};
                            var minut = {{ $minutes }};
                            var CountUp = {

                                // Backbone-like structure
                                $el: $('.countdown'),

                                // Params
                                countup_interval: null,
                                total_seconds: 0, // Start from 0

                                // Initialize the countup  
                                init: function() {

                                    // DOM
                                    this.$ = {
                                        hours: this.$el.find('.bloc-time.hours .figure'),
                                        minutes: this.$el.find('.bloc-time.min .figure'),
                                        seconds: this.$el.find('.bloc-time.sec .figure')
                                    };

                                    // Init countup values
                                    this.values = {
                                        hours: hour, // Start from 0
                                        minutes: minut, // Start from 0
                                        seconds: 0 // Start from 0
                                    };

                                    // Start counting up 
                                    this.count();
                                },

                                count: function() {

                                    var that = this,
                                        $hour_1 = this.$.hours.eq(0),
                                        $hour_2 = this.$.hours.eq(1),
                                        $min_1 = this.$.minutes.eq(0),
                                        $min_2 = this.$.minutes.eq(1),
                                        $sec_1 = this.$.seconds.eq(0),
                                        $sec_2 = this.$.seconds.eq(1);

                                    this.countup_interval = setInterval(function() {

                                        // Increment seconds
                                        ++that.values.seconds;

                                        if (that.values.seconds >= 60) {
                                            that.values.seconds = 0;
                                            ++that.values.minutes; // Increment minutes
                                        }

                                        if (that.values.minutes >= 60) {
                                            that.values.minutes = 0;
                                            ++that.values.hours; // Increment hours
                                        }

                                        // Update DOM values
                                        // Hours
                                        that.checkHour(that.values.hours, $hour_1, $hour_2);

                                        // Minutes
                                        that.checkHour(that.values.minutes, $min_1, $min_2);

                                        // Seconds
                                        that.checkHour(that.values.seconds, $sec_1, $sec_2);

                                        ++that.total_seconds;

                                    }, 1000); // Increment every second
                                },

                                animateFigure: function($el, value) {

                                    var that = this,
                                        $top = $el.find('.top'),
                                        $bottom = $el.find('.bottom'),
                                        $back_top = $el.find('.top-back'),
                                        $back_bottom = $el.find('.bottom-back');

                                    // Before we begin, change the back value
                                    $back_top.find('span').html(value);

                                    // Also change the back bottom value
                                    $back_bottom.find('span').html(value);

                                    // Then animate
                                    TweenMax.to($top, 0.8, {
                                        rotationX: '-180deg',
                                        transformPerspective: 300,
                                        ease: Quart.easeOut,
                                        onComplete: function() {

                                            $top.html(value);
                                            $bottom.html(value);

                                            TweenMax.set($top, {
                                                rotationX: 0
                                            });
                                        }
                                    });

                                    TweenMax.to($back_top, 0.8, {
                                        rotationX: 0,
                                        transformPerspective: 300,
                                        ease: Quart.easeOut,
                                        clearProps: 'all'
                                    });
                                },

                                checkHour: function(value, $el_1, $el_2) {

                                    var val_1 = value.toString().charAt(0),
                                        val_2 = value.toString().charAt(1),
                                        fig_1_value = $el_1.find('.top').html(),
                                        fig_2_value = $el_2.find('.top').html();

                                    if (value >= 10) {
                                        // Animate only if the figure has changed
                                        if (fig_1_value !== val_1) this.animateFigure($el_1, val_1);
                                        if (fig_2_value !== val_2) this.animateFigure($el_2, val_2);
                                    } else {
                                        // If we are under 10, replace first figure with 0
                                        if (fig_1_value !== '0') this.animateFigure($el_1, 0);
                                        if (fig_2_value !== val_1) this.animateFigure($el_2, val_1);
                                    }
                                }
                            };

                            // Start the count-up timer
                            CountUp.init();
                        </script>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- check time model --}}
         {{-- email form check --}}
         <div class="modal fade" id="email_form_check" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Send Form On Email</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="height: 280px;">
                        <form action="{{route('agent_email_form')}}" method="post">
                            @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row border-end border-primary">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="firstNameinput" class="form-label">Company Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter company name"
                                                name="company_name" required>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="lastNameinput" class="form-label">Phone <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control"
                                                placeholder="Enter phone number"name="phone" required>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email<span
                                                class="text-danger">*</span></label> </label>
                                            <input type="email" class="form-control"
                                                placeholder="example@gmail.com"name="email" required>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="compnayNameinput" class="form-label">How many trucks<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="How many trucks" 
                                                name="trucks" required>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="emailidInput" class="form-label">How many drivers<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="How many drivers"
                                                name="drivers" required>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="emailidInput" class="form-label">Comment<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                placeholder="comment"
                                                name="comment" required>
                                        </div>
                                    </div><!--end col-->
                                </div>
                            </div>
                        </div><!--end row-->
                   
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Submit</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        {{-- email form check --}}
        {{-- viewtaskmodel model --}}
        <div class="modal fade" id="viewtaskmodel" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Your Task Progress (Weekly | Monthly)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Styles for the charts container and items -->
                        <style>
                            .charts-container {
                                display: flex;
                                justify-content: space-between;
                                align-items: center;
                                width: 100%;
                                padding: 10px 0;
                            }

                            .chart-item {
                                display: flex;
                                flex-direction: column;
                                align-items: center;
                                width: 45%;
                                /* Adjust the width to fit both charts side by side */
                            }

                            .chart-container {
                                width: 150px;
                                /* Adjust the size of the pie chart */
                                height: 150px;
                                /* Adjust the size of the pie chart */
                            }

                            .chart-label {
                                margin-top: 10px;
                                font-size: 20px;
                                font-weight: bold;
                            }

                            #weeklyTaskChart,
                            #monthlyTaskChart {
                                width: 100%;
                                height: 100%;
                            }
                        </style>
                        @php

                            // Current date in 'America/New_York' timezone
                            $parsedDate = Carbon::now('America/New_York');

                            // Get the start of the week and start of the month for the given date
                            $startOfWeek = $parsedDate->startOfWeek()->format('Y-m-d');
                            $startOfMonth = $parsedDate->startOfMonth()->format('Y-m-d');
                            $endOfWeek = $parsedDate->endOfWeek()->format('Y-m-d');
                            $endOfMonth = $parsedDate->endOfMonth()->format('Y-m-d');

                            // Fetch both weekly and monthly tasks for the given agent and date
                            $tasks = App\adminmodel\Task::where('agent_id', session('agent_id'))
                                ->where(function ($query) use ($startOfWeek, $startOfMonth) {
                                    $query
                                        ->where('week', $startOfWeek) // Weekly task for the week
                                        ->orWhere('month', $startOfMonth); // Monthly task for the month
                                })
                                ->get();

                            // Initialize default values for weekly and monthly tasks
                            $weeklyTask = 0;
                            $monthlyTask = 0;

                            // Loop through tasks and assign the values to weeklyTask and monthlyTask
                            foreach ($tasks as $task) {
                                if ($task->week == $startOfWeek) {
                                    $weeklyTask = $task->task;
                                }
                                if ($task->month == $startOfMonth) {
                                    $monthlyTask = $task->task;
                                }
                            }

                            $timeZone = 'America/New_York';

                           $currentDate = Carbon::now($timeZone);

                           $firstDayOfWeek = $currentDate->startOfWeek()->format('Y-m-d');
                           $lastDayOfWeek = $currentDate->endOfWeek()->format('Y-m-d');

                            // Calculate interested calls for the current week
                            $weekly_data = App\Models\ExcelData::where('click_id',session('agent_id'))->whereBetween('date', [$firstDayOfWeek, $lastDayOfWeek])->get();
                            $weeklyInterestedCalls = $weekly_data->where('form_status','Intrested')->where('red_mark', '!=', 1)->count();

                            $remainweektarget = $weeklyTask - $weeklyInterestedCalls;
                            // Calculate interested calls for the current month
                           

                            $firstDayOfMonth = $currentDate->startOfMonth()->format('Y-m-d');
                             $lastDayOfMonth = $currentDate->endOfMonth()->format('Y-m-d');

                            $monthly_data = App\Models\ExcelData::where('click_id',session('agent_id'))->whereBetween('date', [$firstDayOfMonth, $lastDayOfMonth])->get();
                            $monthlyInterestedCalls = $monthly_data->where('form_status','Intrested')->where('red_mark', '!=', 1)->count();

                            $reaminmonthtarget = $monthlyTask - $monthlyInterestedCalls;
                        @endphp
                        <div class="charts-container">
                            <!-- Weekly Task Chart -->
                            <div class="chart-item">
                                <div class="chart-container">
                                    <canvas id="weeklyTaskChart"></canvas>
                                </div>
                                <div class="chart-label">Weekly ({{ $weeklyTask }})</div>
                            </div>

                            <!-- Monthly Task Chart -->
                            <div class="chart-item">
                                <div class="chart-container">
                                    <canvas id="monthlyTaskChart"></canvas>
                                </div>
                                <div class="chart-label">Monthly ({{ $monthlyTask }})</div>
                            </div>
                        </div>

                        <script>
                            // Initialize chart variables to hold instances
                            let weeklyChartInstance;
                            let monthlyChartInstance;
                            var monthintrest = {{ $monthlyInterestedCalls }};
                            var reaminmonth = {{ $reaminmonthtarget }};
                            var weekintrest = {{ $weeklyInterestedCalls }};
                            var remainweek = {{ $remainweektarget }};
                            // Function to create a pie chart
                            function createPieChart(chartId, completed, remaining) {
                                const canvas = document.getElementById(chartId);
                                if (!canvas) {
                                    console.error('Canvas element not found for chart: ' + chartId);
                                    return;
                                }

                                const ctx = canvas.getContext('2d');
                                return new Chart(ctx, {
                                    type: 'pie',
                                    data: {
                                        labels: ['Completed', 'Remaining'],
                                        datasets: [{
                                            data: [completed, remaining],
                                            backgroundColor: ['#4caf50', '#ff5252']
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        plugins: {
                                            legend: {
                                                display: true,
                                                position: 'bottom' // Set legend position to the bottom
                                            }
                                        }
                                    }
                                });
                            }

                            // Create charts when modal is shown
                            document.getElementById('viewtaskmodel').addEventListener('shown.bs.modal', function() {
                                // Destroy existing chart instances if present
                                if (weeklyChartInstance) {
                                    weeklyChartInstance.destroy();
                                }
                                if (monthlyChartInstance) {
                                    monthlyChartInstance.destroy();
                                }

                                // Create new chart instances
                                weeklyChartInstance = createPieChart('weeklyTaskChart', weekintrest,
                                    remainweek); // Static data for Weekly tasks
                                monthlyChartInstance = createPieChart('monthlyTaskChart', monthintrest,
                                    reaminmonth); // Static data for Monthly tasks
                            });

                            // Optional: Clear charts when modal is hidden
                            document.getElementById('viewtaskmodel').addEventListener('hidden.bs.modal', function() {
                                if (weeklyChartInstance) {
                                    weeklyChartInstance.destroy();
                                }
                                if (monthlyChartInstance) {
                                    monthlyChartInstance.destroy();
                                }
                            });
                        </script>
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Task Type</th>
                                        <th>Task</th>
                                        <th>Completed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Weekly Task</td>
                                        <td id="weeklyTaskData">{{ $weeklyTask }}</td>
                                        <td id="weeklyInterestedCallsData">{{ $weeklyInterestedCalls }}</td>
                                    </tr>
                                    <tr>
                                        <td>Monthly Task</td>
                                        <td id="monthlyTaskData">{{ $monthlyTask }}</td>
                                        <td id="monthlyInterestedCallsData">{{ $monthlyInterestedCalls }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- end viewtaskmodel model --}}
        <div class="modal fade" id="popscript" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Call Script</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                       @php
    $script = App\adminmodel\ScriptModal::where('ajent_id', session('agent_id'))->first();
    $call_script = $script && $script->calling_script ? $script->calling_script : 'No script found.';
@endphp
                       <p>{!! $call_script !!}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--end header -->
        <script>
            // Get the link element
            var submitReportLink = document.getElementById('submitReportLink');

            // Add click event listener
            submitReportLink.addEventListener('click', function(event) {
                // Prevent the default behavior of the link
                event.preventDefault();

                // Show a confirmation dialog
                var confirmed = confirm('Are you sure you want to submit the daily report?');

                // If the user confirms, navigate to the link
                if (confirmed) {
                    window.location.href = submitReportLink.href;
                } else {
                    // If the user cancels, do nothing or perform any other action
                    // For example, you can display a message or keep the user on the same page
                }
            });
        </script>
        <script>
            // Get the link element
            var submitBellLink = document.getElementById('ring_bell');

            // Add click event listener
            submitBellLink.addEventListener('click', function(event) {
                // Prevent the default behavior of the link
                event.preventDefault();

                // Show a confirmation dialog
                var confirmed = confirm('Are you sure you want to send the data request to the manager?');

                // If the user confirms, navigate to the link
                if (confirmed) {
                    window.location.href = submitBellLink.href;
                } else {
                    // If the user cancels, do nothing or perform any other action
                    // For example, you can display a message or keep the user on the same page
                }
            });
        </script>
        {{-- <script>
            document.addEventListener("DOMContentLoaded", function() {
                const unitSelect = document.getElementById("unit_owned1");
                const unit2Div = document.getElementById("unit2");
                const unit3Div = document.getElementById("unit3");
                const unit4Div = document.getElementById("unit4");
                const unit5Div = document.getElementById("unit5");

                unitSelect.addEventListener("change", function() {
                    if (unitSelect.value == 2) {
                        unit2Div.style.display = "";
                    } else if (unitSelect.value == 3) {
                        unit2Div.style.display = "";
                        unit3Div.style.display = "";
                    } else if (unitSelect.value == 4) {
                        unit2Div.style.display = "";
                        unit3Div.style.display = "";
                        unit4Div.style.display = "";
                    } else if (unitSelect.value == 5) {
                        unit2Div.style.display = "";
                        unit3Div.style.display = "";
                        unit4Div.style.display = "";
                        unit5Div.style.display = "";
                    }
                });
            });
        </script> --}}
        {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const unitSelect2 = document.getElementById("unit_owned1");
        
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
                    document.getElementById("unit2").style.display = selectedValue >= 2 ? "" : "none";
                    document.getElementById("unit3").style.display = selectedValue >= 3 ? "" : "none";
                    document.getElementById("unit4").style.display = selectedValue >= 4 ? "" : "none";
                    document.getElementById("unit5").style.display = selectedValue >= 5 ? "" : "none";
                    document.getElementById("unit6").style.display = selectedValue >= 6 ? "" : "none";
                    document.getElementById("unit7").style.display = selectedValue >= 7 ? "" : "none";
                    document.getElementById("unit8").style.display = selectedValue >= 8 ? "" : "none";
                    document.getElementById("unit9").style.display = selectedValue >= 9 ? "" : "none";
                    document.getElementById("unit10").style.display = selectedValue >= 10 ? "" : "none";
        
                    // Toggle required attribute based on display status
                    toggleRequiredBasedOnDisplay("unit2", document.getElementById("unit2").style.display !==
                        "none");
                    toggleRequiredBasedOnDisplay("unit3", document.getElementById("unit3").style.display !==
                        "none");
                    toggleRequiredBasedOnDisplay("unit4", document.getElementById("unit4").style.display !==
                        "none");
                    toggleRequiredBasedOnDisplay("unit5", document.getElementById("unit5").style.display !==
                        "none");
                        toggleRequiredBasedOnDisplay("unit6", document.getElementById("unit6").style.display !==
                        "none");
                        toggleRequiredBasedOnDisplay("unit7", document.getElementById("unit7").style.display !==
                        "none");
                        toggleRequiredBasedOnDisplay("unit8", document.getElementById("unit8").style.display !==
                        "none");
                        toggleRequiredBasedOnDisplay("unit9", document.getElementById("unit9").style.display !==
                        "none");
                        toggleRequiredBasedOnDisplay("unit10", document.getElementById("unit10").style.display !==
                        "none");
                });
        
                // Trigger change event on page load if needed
                unitSelect2.dispatchEvent(new Event('change'));
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const unitSelect2 = document.getElementById("drivers_state1");
        
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
                    document.getElementById("driver2").style.display = selectedValue >= 2 ? "" : "none";
                    document.getElementById("driver3").style.display = selectedValue >= 3 ? "" : "none";
                    document.getElementById("driver4").style.display = selectedValue >= 4 ? "" : "none";
                    document.getElementById("driver5").style.display = selectedValue >= 5 ? "" : "none";
                    document.getElementById("driver6").style.display = selectedValue >= 6 ? "" : "none";
                    document.getElementById("driver7").style.display = selectedValue >= 7 ? "" : "none";
                    document.getElementById("driver8").style.display = selectedValue >= 8 ? "" : "none";
                    document.getElementById("driver9").style.display = selectedValue >= 9 ? "" : "none";
                    document.getElementById("driver10").style.display = selectedValue >= 10 ? "" : "none";
        
                    // Toggle required attribute based on display status
                    toggleRequiredBasedOnDisplay("driver2", document.getElementById("driver2").style
                        .display !== "none");
                    toggleRequiredBasedOnDisplay("driver3", document.getElementById("driver3").style
                        .display !== "none");
                    toggleRequiredBasedOnDisplay("driver4", document.getElementById("driver4").style
                        .display !== "none");
                    toggleRequiredBasedOnDisplay("driver5", document.getElementById("driver5").style
                        .display !== "none");
                    toggleRequiredBasedOnDisplay("driver6", document.getElementById("driver6").style
                        .display !== "none");
                    toggleRequiredBasedOnDisplay("driver7", document.getElementById("driver7").style
                        .display !== "none");
                    toggleRequiredBasedOnDisplay("driver8", document.getElementById("driver8").style
                        .display !== "none");
                    toggleRequiredBasedOnDisplay("driver9", document.getElementById("driver9").style
                        .display !== "none");
                    toggleRequiredBasedOnDisplay("driver10", document.getElementById("driver10").style
                        .display !== "none");
                });
        
                // Trigger change event on page load if needed
                unitSelect2.dispatchEvent(new Event('change'));
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Attach click event to each break item
                document.querySelectorAll('.break-item').forEach(function(item) {
                    item.addEventListener('click', function() {
                        var breakId = this.getAttribute('data-id');
                        // Show the confirmation modal
                        var confirmationModal = new bootstrap.Modal(document.getElementById(
                            'breakConfirmationModal' + breakId));
                        confirmationModal.show();

                        // Handle confirm button click
                        document.getElementById('startbreak' + breakId).onclick = function() {
                            // Perform action with breakId (e.g., AJAX request or form submission)
                            console.log("Break confirmed with ID:", breakId);

                            // Now show the actual break modal
                            var breakModal = new bootstrap.Modal(document.getElementById(
                                'startmodal' + breakId));
                            breakModal.show();

                            // Hide the confirmation modal
                            confirmationModal.hide();
                        };
                    });
                });
            });
        </script>
       <!-- <script>
document.addEventListener("DOMContentLoaded", function(){
  document.querySelectorAll('#menu > li.more-menu > a').forEach(el => {
    el.addEventListener('click', function(e) {
      e.preventDefault();
      this.parentElement.classList.toggle('open');
    });
  });
});
</script> -->
<script>
 document.addEventListener("click", function (e) {
  const trigger = e.target.closest("#menu > li.more-menu > a");
  const dropdown = document.getElementById("moreMenuDropdown") || document.getElementById("moreMenuDropdown") || document.querySelector("#moreMenuDropdown") || document.querySelector("#menu > li.more-menu > ul") || document.getElementById("moreMenuDropdown") || document.getElementById("moreMenuDropdown") || document.querySelector("#moreMenuDropdown") || document.querySelector("#menu > li.more-menu > ul") || document.getElementById("moreMenuDropdown") || document.getElementById("moreMenuDropdown") || document.querySelector("#moreMenuDropdown") || document.querySelector("#menu > li.more-menu > ul");
  const moreDropdown = document.querySelector("#menu > li.more-menu > ul");

  if (trigger && moreDropdown) {
    e.preventDefault();
    const rect = trigger.getBoundingClientRect();

    Object.assign(moreDropdown.style, {
      position: "fixed",
      top: rect.bottom + "px",
      left: rect.left + "px",
      zIndex: "2147483647",
      display: moreDropdown.style.display === "block" ? "none" : "block",
    });
  }

  if (!trigger && !e.target.closest(".more-menu") && moreDropdown) {
    moreDropdown.style.display = "none";
  }
});


</script>



        <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
