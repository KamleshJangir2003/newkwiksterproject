<!doctype html>
<html lang="en" data-layout="horizontal" data-layout-style="" data-layout-position="fixed" data-topbar="dark">

<head>

    <meta charset="utf-8" />
    <title>Kwikster | CRM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- CSS --}}
    @include('backend.common.css')
    @yield('css')
    {{-- /CSS --}}

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        {{-- Header --}}
        @include('backend.common.header')
        {{-- /Header --}}
        {{-- Menu --}}
        @include('backend.common.menu')
        {{-- /Menu --}}
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            {{-- Footer --}}
            @include('backend.common.footer')
            {{-- /Footer --}}

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    {{-- <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div> --}}

    {{-- Modals --}}
    @include('backend.common.modals')
    {{-- /Modals --}}
    <audio id="myAudio" src="{{ asset('sounds/notification-sound.mp3') }}"></audio>
    {{-- JS --}}
    @include('backend.common.js')
    {{-- /JS --}}
    @yield('js')
</body>

</html>
