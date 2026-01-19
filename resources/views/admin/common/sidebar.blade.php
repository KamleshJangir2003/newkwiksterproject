 <div class="pcoded-main-container">
     <div class="pcoded-wrapper">
         <nav class="pcoded-navbar">
             <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
             <div class="pcoded-inner-navbar main-menu">
                 {{-- <div class="">
                     <div class="main-menu-header">
                     @if(!empty(session('admin_image')))
                                  <img src="{{ asset(session('admin_image')) }}" class="img-radius" alt="User-Profile-Image">
                                  @else
                                  <img src="https://bootdey.com/img/Content/avatar/avatar7.png" class="img-radius" alt="User-Profile-Image">
                                  @endif
                         <div class="user-details">
                             <span id="more-details">{{ session('admin_name') }}<i class="fa fa-caret-down"></i></span>
                         </div>
                     </div>

                     <div class="main-menu-content">
                         <ul>
                             <li class="more-details">
                                 <a href="user-profile.html"><i class="ti-user"></i>View Profile</a>
                                 <a href="#!"><i class="ti-settings"></i>Settings</a>
                                 <a href="auth-normal-sign-in.html"><i class="ti-layout-sidebar-left"></i>Logout</a>
                             </li>
                         </ul>
                     </div>
                 </div> --}}
                 <ul class="pcoded-item pcoded-left-item">
                    <br>
                     <?php
                        $admin_services = Session::get('services');
                        $ser = json_decode($admin_services);
                        // print_r($ser); die();
                        if ($ser[0] == "999") {
                            $admin_sidebar = App\adminmodel\AdminSidebar::OrderBy('seq', 'asc')->get();
                            // print_r($admin); die();
                            if (!empty($admin_sidebar)) {
                                foreach ($admin_sidebar as $sidebar) {
                        ?>
                     <?php if ($sidebar->url == "#") { ?>
                     <li class="pcoded-hasmenu">
                         <a href="javascript:void(0)" class="waves-effect waves-dark" style="margin-bottom:10px">
                             <span class="<?= $sidebar->icon ?>"style="margin-right:10px;margin-top:10px;"></span>
                             <span class="pcoded-mtext"
                                 data-i18n="nav.basic-components.main"><?= $sidebar->name; ?></span>
                             <span class="pcoded-mcaret"></span>
                         </a>
                         <ul class="pcoded-submenu">
                             <?php
                                                $admin_sidebar2 = App\adminmodel\AdminSidebar2::where('main_id', $sidebar->id)->get();
                                                // print_r($admin); die();
                                                if (!empty($admin_sidebar2)) {
                                                    foreach ($admin_sidebar2 as $sidebar2) {
                                                ?>
                             <li class=" ">
                                 <a href="{{route($sidebar2->url)}}" class="waves-effect waves-dark" >
                                     <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                     <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">
                                         <?= $sidebar2->name; ?></span>
                                     <span class="pcoded-mcaret"></span>
                                 </a>
                             </li>
                             <?php  }
                                                }   ?>
                         </ul>
                     </li>
                     <?php } else { ?>
                     <li class="">
                         <a href="{{route($sidebar->url)}}" class="waves-effect waves-dark" style="margin-bottom:10px">
                             <span class="<?= $sidebar->icon ?>" style="margin-right:10px"></span>
                             <span class="pcoded-mtext" data-i18n="nav.dash.main">{{$sidebar->name}}</span>
                             <span class="pcoded-mcaret"></span>
                         </a>
                     </li>
                     <?php } ?>
                     <?php
                                }
                            }
                            ?>
                     <?php } else {
                          foreach ($ser as $s) {
                            $sidebar = App\adminmodel\AdminSidebar::where('id', $s)->first();
                            // print_r($admin); die();
                            if (!empty($sidebar)) {
                        ?>
                     <?php if ($sidebar->url == "#") { ?>
                     <li class="pcoded-hasmenu" style="margin-bottom:10px">
                         <a href="javascript:void(0)" class="waves-effect waves-dark">
                             <span class="<?= $sidebar->icon ?>"style="margin-right:10px;margin-top:10px;"></span>
                             <span class="pcoded-mtext"
                                 data-i18n="nav.basic-components.main" ><?= $sidebar->name; ?></span>
                             <span class="pcoded-mcaret"></span>
                         </a><hr>
                         <ul class="pcoded-submenu">
                             <?php
                                                $admin_sidebar2 = App\adminmodel\AdminSidebar2::where('main_id', $sidebar->id)->get();
                                                // print_r($admin); die();
                                                if (!empty($admin_sidebar2)) {
                                                    foreach ($admin_sidebar2 as $sidebar2) {
                                                ?>
                             <li class=" ">
                                 <a href="{{route($sidebar2->url)}}" class="waves-effect waves-dark" style="margin-bottom:10px">
                                     <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                     <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">
                                         <?= $sidebar2->name; ?></span>
                                     <span class="pcoded-mcaret"></span>
                                 </a>
                             </li>
                             <?php  }
                                                }   ?>
                         </ul>
                     </li>
                     <?php } else { ?>
                     <li class="" style="margin-bottom:10px">
                         <a href="{{route($sidebar->url)}}" class="waves-effect waves-dark">
                             <span class="<?= $sidebar->icon ?>" style="margin-right:10px"></span>
                             <span class="pcoded-mtext" data-i18n="nav.dash.main">{{$sidebar->name}}</span>
                             <span class="pcoded-mcaret"></span>
                         </a>
                     </li><hr>
                     <?php } ?>
                     <?php   } ?>
                     <?php   } ?>
                     <?php   } ?>

                 </ul>
             </div>

             </ul>
     </div>
     </nav>
