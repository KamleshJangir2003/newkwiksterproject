<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="userauth-id" content="{{ Auth::guard('agent')->id() }}">
    <!--favicon-->
    <link rel="icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon">
    <!--plugins-->
    <link rel="stylesheet" href="{{ asset('Agent/assets/plugins/notifications/css/lobibox.min.css') }}" />
    <link href="{{ asset('Agent/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <link href="{{ asset('Agent/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />

    <link href="{{ asset('Agent/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('Agent/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('Agent/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <!-- loader-->
    {{-- <link href="{{asset('Agent/assets/css/pace.min.css')}}" rel="stylesheet"/>
	<script src="{{asset('Agent/assets/js/pace.min.js')}}"></script> --}}
    <!-- Bootstrap CSS -->
    <link href="{{ asset('Agent/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Agent/assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="{{ asset('Agent/assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('Agent/assets/css/icons.css') }}" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{ asset('Agent/assets/css/dark-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('Agent/assets/css/semi-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('Agent/assets/css/header-colors.css') }}" />
    <title>Kwikinsure|Agent</title>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('3ef0092734ff41650c00', {
            cluster: 'ap2'
        });

        var channel = pusher.subscribe('my-channel');
        var userId = document.querySelector('meta[name="userauth-id"]').getAttribute('content');
        channel.bind('my-event', function(data) {
            if (data.message.user_id == userId) {
                round_success_noti(data.message.massage, 1);

                var notifCountElement = document.getElementById('notif_count');
                if (notifCountElement) {
                    var currentCount = parseInt(notifCountElement.innerHTML);
                    notifCountElement.innerHTML = currentCount + 1;
                }
            }
        });
    </script>


</head>
