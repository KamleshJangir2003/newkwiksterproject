 <!-- ========== App Menu ========== -->
 <div class="app-menu navbar-menu">
     <!-- LOGO -->
     <div class="navbar-brand-box">
         <!-- Dark Logo-->
         <a href="index.html" class="logo logo-dark">
             <span class="logo-sm">
                 <img src="assets/images/logo-sm.png" alt="" height="22">
             </span>
             <span class="logo-lg">
                 <img src="assets/images/logo-dark.png" alt="" height="17">
             </span>
         </a>
         <!-- Light Logo-->
         <a href="index.html" class="logo logo-light">
             <span class="logo-sm">
                 <img src="assets/images/logo-sm.png" alt="" height="22">
             </span>
             <span class="logo-lg">
                 <img src="assets/images/logo-light.png" alt="" height="17">
             </span>
         </a>
         <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
             id="vertical-hover">
             <i class="ri-record-circle-line"></i>
         </button>
     </div>

     <div id="scrollbar">
         <div class="container-fluid">

             <div id="two-column-menu">
             </div>
             <ul class="navbar-nav" id="navbar-nav">
                 <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                 <li class="nav-item">
                     @if (auth()->user()->designation == 'Admin')
                         <a class="nav-link menu-link" href="{{ route('admin.dashboard') }}">
                             <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                         </a>
                     @elseif(auth()->user()->designation == 'Manager')
                         <a class="nav-link menu-link" href="{{ route('manager.dashboard') }}">
                             <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                         </a>
                     @elseif(auth()->user()->designation == 'Agent')
                         <a class="nav-link menu-link" href="{{ route('agent.dashboard') }}">
                             <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                         </a>
                     @endif
                 </li> <!-- end Dashboard Menu -->
                 @if (auth()->user()->designation == 'Admin' || auth()->user()->designation == 'Manager')
                     <li class="nav-item">
                         <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button"
                             aria-expanded="false" aria-controls="sidebarApps">
                             <i class="mdi mdi-account-group"></i> <span data-key="t-apps">Team</span>
                         </a>
                         <div class="collapse menu-dropdown" id="sidebarApps">
                             <ul class="nav nav-sm flex-column">
                                 @if (auth()->user()->designation == 'Admin')
                                     <li class="nav-item">
                                         <a href="{{ route('admin.view.team') }}" class="nav-link"
                                             data-key="t-api-key">View
                                             Team</a>
                                     </li>
                                     
                                     <!--<li class="nav-item">-->
                                     <!--    <a href="{{ route('admin.moniter.team') }}" class="nav-link"-->
                                     <!--        data-key="t-api-key">Moniter-->
                                     <!--        Team</a>-->
                                     <!--</li>-->

                                     <li class="nav-item">
                                        <a href="{{ route('admin.view.team.leads') }}" class="nav-link"
                                            data-key="t-api-key">View
                                            Team Leads</a>
                                    </li>
                                 @elseif(auth()->user()->designation == 'Manager')
                                     <li class="nav-item">
                                         <a href="{{ route('manager.view.team') }}" class="nav-link"
                                             data-key="t-api-key">View
                                             Team</a>
                                     </li>
                                 @endif
                                 @if (auth()->user()->designation == 'Admin')
                                  <li class="nav-item">
                                         <a href="{{ route('admin.view.credentials') }}" class="nav-link"
                                             data-key="t-api-key">
                                             Credentials PIN</a>
                                     </li>
                                 @endif
                             </ul>
                         </div>
                     </li>
                 @endif
                 <li class="nav-item">
                     <a class="nav-link menu-link" href="#sidebarLayouts" data-bs-toggle="collapse" role="button"
                         aria-expanded="false" aria-controls="sidebarLayouts">
                         <i class="bx bx-target-lock"></i> <span data-key="t-layouts">Leads</span> <span
                             class="badge badge-pill bg-danger" data-key="t-hot">Hot</span>
                     </a>
                     <div class="collapse menu-dropdown pb-0" id="sidebarLayouts">
                         <ul class="nav nav-sm flex-column">
                             <li class="nav-item">
                                 @if (auth()->user()->designation == 'Admin')
                                     <a href="{{ route('admin.tab.leads') }}" class="nav-link" data-key="t-horizontal">
                                         Tab View </a>
                                     <a href="{{ route('admin.all.leads') }}" class="nav-link" data-key="t-horizontal">
                                         All Leads </a>
                                     <a href="{{ route('admin.assigned.leads') }}" class="nav-link"
                                         data-key="t-horizontal">
                                         Assigned Leads </a>
                                 @elseif (auth()->user()->designation == 'Manager')
                                 <a href="{{ route('manager.tab.leads') }}" class="nav-link" data-key="t-horizontal">
                                         Tab View </a>
                                          
                                     <a href="{{ route('manager.all.leads') }}" class="nav-link"
                                         data-key="t-horizontal">
                                         All Leads </a>
                                         
                                    <a href="#sidebarSignIn" class="nav-link" data-bs-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="sidebarSignIn"
                                            data-key="t-signin">DISPO
                                        </a>
                                        <div class="collapse menu-dropdown" id="sidebarSignIn">
                                            <ul class="nav nav-sm flex-column">
                                                <li class="nav-item">
                                                  <a href="{{ route('manager.intrested.leads') }}" class="nav-link"
                                         data-key="t-horizontal">
                                         Interested</a>
                                                </li>
                                                <li class="nav-item">
                                                   <a href="{{ route('manager.pipeline.leads') }}" class="nav-link"
                                         data-key="t-horizontal">
                                         Pipeline</a>
                                                </li>
                                                <li class="nav-item">
                                                   <a href="{{ route('manager.voicemail.leads') }}" class="nav-link"
                                         data-key="t-horizontal">
                                         Voice Mail</a>
                                                </li>
                                                <li class="nav-item">
                                                   <a href="{{ route('manager.wrongnumber.leads') }}" class="nav-link"
                                         data-key="t-horizontal">
                                         Wrong Number</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="{{ route('manager.notintrested.leads') }}" class="nav-link"
                                         data-key="t-horizontal">
                                         Not Interested</a>
                                                </li>
                                                <li class="nav-item">
                                                   <a href="{{ route('manager.notconnected.leads') }}" class="nav-link"
                                         data-key="t-horizontal">
                                         Not Connected</a>
                                                </li>
                                                <li class="nav-item">
                                                  <a href="{{ route('manager.insured.leads') }}" class="nav-link"
                                         data-key="t-horizontal">
                                         Insured Leads </a>
                                                </li>
                                                <li class="nav-item">
                                                  <a href="{{ route('manager.won.leads') }}" class="nav-link"
                                         data-key="t-horizontal">
                                         WON </a>
                                                </li>
                                                <li class="nav-item">
                                                  <a href="{{ route('manager.dnd.leads') }}" class="nav-link"
                                         data-key="t-horizontal">
                                         DND </a>
                                                </li>
                                            </ul>
                                        </div>
                                     <!--     <a href="{{ route('manager.mmintrested.leads') }}" class="nav-link"-->
                                     <!--    data-key="t-horizontal">-->
                                     <!--    Master Interested</a>-->
                                     <!--<a href="{{ route('manager.mmpipeline.leads') }}" class="nav-link"-->
                                     <!--    data-key="t-horizontal">-->
                                     <!--    Master Pipeline</a>-->
                                     <a href="{{ route('manager.assigned.leads') }}"
                                         class="nav-link bg-secondary text-white border-bottom"
                                         data-key="t-horizontal">
                                         Assigned Leads </a>
                                     <a href="{{ route('manager.incoming.leads') }}"
                                         class="nav-link bg-secondary text-white" data-key="t-horizontal">
                                         Incoming Leads </a>
                                 @elseif (auth()->user()->designation == 'Agent')
                                     <a href="{{ route('agent.intrested.leads') }}" class="nav-link"
                                         data-key="t-horizontal">
                                         Interested</a>
                                     <a href="{{ route('agent.pipeline.leads') }}" class="nav-link"
                                         data-key="t-horizontal">
                                         Pipeline</a>
                                     <a href="{{ route('agent.won.leads') }}" class="nav-link"
                                         data-key="t-horizontal">
                                         WON</a>
                                     <!--<a href="{{ route('agent.mintrested.leads') }}" class="nav-link"-->
                                     <!--    data-key="t-horizontal">-->
                                     <!--    Master Interested</a>-->
                                     <!--<a href="{{ route('agent.mpipeline.leads') }}" class="nav-link"-->
                                     <!--    data-key="t-horizontal">-->
                                     <!--    Master Pipeline</a>-->
                                     {{-- <a href="{{ route('agent.voicemail.leads') }}" class="nav-link"
                                         data-key="t-horizontal">
                                         Voice Mail</a>
                                     <a href="{{ route('agent.notintrested.leads') }}" class="nav-link"
                                         data-key="t-horizontal">
                                         Not Interested</a>
                                     <a href="{{ route('agent.notconnected.leads') }}" class="nav-link"
                                         data-key="t-horizontal">
                                         Not Connected</a>
                                     <a href="{{ route('agent.wrongnumber.leads') }}" class="nav-link"
                                         data-key="t-horizontal">
                                         Wrong Number</a> --}}
                                 @endif
                             </li>
                             @if (auth()->user()->designation == 'Agent')
                                 <li class="nav-item bg-primary">
                                     <a href="{{ route('agent.incoming.leads') }}"
                                         class="nav-link text-white btn btn-light border border-white w-75 mx-auto my-3"
                                         data-key="t-horizontal">
                                         Incoming Leads</a>
                                 </li>
                                 <li class="nav-item bg-primary">
                                     <a href="layouts-horizontal.html" target="_blank"
                                         class="nav-link text-white btn btn-light border border-white w-75 mx-auto "
                                         data-key="t-horizontal" data-bs-toggle="modal" data-bs-target="#newlead">
                                         New
                                         Lead </a>
                                 </li>
                             @endif
                             @if (auth()->user()->designation == 'Admin' || auth()->user()->designation == 'Manager')
                                 <li class="nav-item bg-primary">
                                     <a href="layouts-horizontal.html" target="_blank"
                                         class="nav-link text-white btn btn-light border border-white w-75 mx-auto mt-3"
                                         data-key="t-horizontal" data-bs-toggle="modal" data-bs-target="#newlead">
                                         New
                                         Lead </a>
                                 </li>
                                 <li class="nav-item bg-primary">
                                     <a href="layouts-detached.html" target="_blank"
                                         class="nav-link text-white btn btn-light border border-white w-75 mx-auto"
                                         data-key="t-detached" data-bs-toggle="modal" data-bs-target="#importleads">
                                         Import Leads </a>
                                 </li>
                             @endif
                         </ul>
                     </div>
                 </li> <!-- end Dashboard Menu -->

                 <li class="nav-item">
                     <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button"
                         aria-expanded="false" aria-controls="sidebarAuth">
                         <i class="ri-account-circle-line"></i> <span data-key="t-authentication">Clients</span>
                     </a>
                     <div class="collapse menu-dropdown" id="sidebarAuth">
                         <ul class="nav nav-sm flex-column">

                             @if (auth()->user()->designation == 'Admin')
                                 <li class="nav-item">
                                     <a href="{{ route('admin.client.all.form') }}" class="nav-link">
                                         My Form
                                     </a>
                                 </li>
                             @else
                                 <li class="nav-item">
                                     <a href="{{ route('client.all.form') }}" class="nav-link">
                                         My Form
                                     </a>
                                 </li>
                             @endif
                             @if (auth()->user()->designation == 'Manager' || auth()->user()->designation == 'Admin')
                                 <li class="nav-item">
                                     <a href="{{ route('client.panel.login') }}" class="nav-link" target="_blank">
                                         Login
                                     </a>
                                 </li>
                             @endif
                         </ul>
                     </div>
                 </li>

                 <li class="nav-item">
                     <a class="nav-link menu-link" href="#sidebarLanding" data-bs-toggle="collapse" role="button"
                         aria-expanded="false" aria-controls="sidebarLanding">
                         <i class='bx bx-customize'></i> <span data-key="t-landing">More</span>
                     </a>
                     <div class="collapse menu-dropdown" id="sidebarLanding">
                         <ul class="nav nav-sm flex-column">
                             <li class="nav-item">
                                 <a class="nav-link menu-link" href="{{ route('emails') }}" aria-expanded="false"
                                     aria-controls="sidebarIcons">
                                     <i class='bx bx-envelope'></i> <span data-key="t-icons">Email Script</span>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a class="nav-link menu-link" href="{{ route('calling') }}" aria-expanded="false"
                                     aria-controls="sidebarIcons">
                                     <i class='bx bx-phone-call'></i> <span data-key="t-icons">Calling Script</span>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a class="nav-link menu-link" href="{{ route('text') }}" aria-expanded="false"
                                     aria-controls="sidebarIcons">
                                     <i class='bx bx-text'></i> <span data-key="t-icons">Text Script</span>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a class="nav-link menu-link" href="{{ route('holidays.calendar') }}"
                                     aria-expanded="false" aria-controls="sidebarIcons">
                                     <i class='bx bx-calendar'></i> <span data-key="t-icons">Holidays</span>
                                 </a>
                             </li>
                             @if (auth()->user()->designation == 'Admin')
                                 <li class="nav-item">
                                     <a class="nav-link menu-link" href="{{ route('admin.offers') }}">
                                         <i class='bx bxs-offer'></i> <span data-key="t-pages">Offers</span>
                                     </a>
                                 </li>
                             @endif
                         </ul>
                     </div>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link menu-link" href="#sidebarLanding" data-bs-toggle="collapse" role="button"
                         aria-expanded="false" aria-controls="sidebarLanding">
                         <i class='bx bxs-flag-alt'></i> <span data-key="t-landing">Report</span>
                     </a>
                     <div class="collapse menu-dropdown" id="sidebarLanding">
                         <ul class="nav nav-sm flex-column">
                             @if (auth()->user()->designation == 'Admin')
                                 <li class="nav-item">
                                     <a class="nav-link menu-link" href="{{ route('admin.view.dayend.report') }}">
                                         <span data-key="t-pages">View Report</span>
                                     </a>
                                 </li>
                             @elseif (auth()->user()->designation == 'Manager')
                                 <li class="nav-item">
                                     <a class="nav-link menu-link" href="{{ route('view.dayend.report') }}">
                                         <span data-key="t-pages">View Report</span>
                                     </a>
                                 </li>
                             @endif
                             @if (auth()->user()->designation == 'Agent' || auth()->user()->designation == 'Manager')
                                 <li class="nav-item">
                                     <a class="nav-link menu-link" href="{{ route('submit.dayend.report') }}"
                                         onclick="return confirm('Click Ok to Send Day End Report !')">
                                         <span data-key="t-pages">Submit Report</span>
                                     </a>
                                 </li>
                             @endif
                         </ul>
                     </div>
                 </li>
                 <!--@if (auth()->user()->designation == 'Admin')-->
                 <!--    <li class="nav-item">-->
                 <!--        <a class="nav-link menu-link" href="{{url('kwikster/masterfile')}}" target="_blank">-->
                 <!--            <i class="ri-pages-line"></i> <span data-key="t-pages">Master File</span>-->
                 <!--        </a>-->
                 <!--    </li>-->
                 <!--@elseif(auth()->user()->designation == 'Manager')-->
                 <!--    <li class="nav-item">-->
                 <!--        <a class="nav-link menu-link" href="{{url('kwikster/masterfile')}}" target="_blank">-->
                 <!--            <i class="ri-pages-line"></i> <span data-key="t-pages">Master File</span>-->
                 <!--        </a>-->
                 <!--    </li>-->
                 <!--@endif-->
                 <li class="nav-item">
                         <a class="nav-link menu-link" href="{{url('/credentials')}}" target="_blank">
                             <i class="ri-pages-line"></i> <span data-key="t-pages">Credentials</span>
                         </a>
                     </li>

                 {{-- <li class="nav-item">
                     <a class="nav-link menu-link" href="{{ url('/team/chat') }}" aria-expanded="false"
                         aria-controls="sidebarIcons" target="_blank">
                         <i class='bx bxl-whatsapp'></i> <span data-key="t-icons">Team Chat</span>
                     </a>
                 </li> --}}
                 @if(auth()->user()->designation == 'Manager'||auth()->user()->designation == 'Admin')
                 <li class="nav-item">
                     <a class="nav-link menu-link" href="{{ route('attendance') }}" aria-expanded="false"
                         aria-controls="sidebarIcons" target="_blank">
                         <i class='bx bxs-calendar-check'></i> <span data-key="t-icons">Attendance</span>
                     </a>
                 </li>
                 @endif
                 <li class="nav-item">
                     <a class="nav-link menu-link" href="{{ route('mynotes') }}" aria-expanded="false"
                                     aria-controls="sidebarIcons">
                                     <i class='bx bx-edit'></i> <span data-key="t-icons">To-Do</span>
                                 </a>
                 </li>
                
                 <li class="nav-item">
                    <a id="MyClockDisplay" class="clock nav-link menu-link" onload="showTime()" style="position: fixed;
    right: 0px;"></a>
                 </li>
             </ul>
         </div>
         <!-- Sidebar -->
     </div>

     <div class="sidebar-background"></div>
 </div>
 <!-- Left Sidebar End -->
