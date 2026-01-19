</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Required Jquery -->
    <script type="text/javascript" src="{{asset('Admin/assets/js/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('Admin/assets/js/jquery-ui/jquery-ui.min.js')}} "></script>
    <script type="text/javascript" src="{{asset('Admin/assets/js/popper.js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('Admin/assets/js/bootstrap/js/bootstrap.min.js')}} "></script>
    <script type="text/javascript" src="{{asset('Admin/assets/pages/widget/excanvas.js')}} "></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js "></script>
    <!-- waves js -->
    <script src="{{asset('Admin/assets/pages/waves/js/waves.min.js')}}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{asset('Admin/assets/js/jquery-slimscroll/jquery.slimscroll.js')}} "></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="{{asset('Admin/assets/js/modernizr/modernizr.js')}} "></script>
    <!-- slimscroll js -->
    <script type="text/javascript" src="{{asset('Admin/assets/js/SmoothScroll.js')}}"></script>
    <script src="{{asset('Admin/assets/js/jquery.mCustomScrollbar.concat.min.js ')}}"></script>
    <!-- Chart js -->
    <script type="text/javascript" src="{{asset('Admin/assets/js/chart.js/Chart.js')}}"></script>
    <!-- amchart js -->
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="{{asset('Admin/assets/pages/widget/amchart/gauge.js')}}"></script>
    <script src="{{asset('Admin/assets/pages/widget/amchart/serial.js')}}"></script>
    <script src="{{asset('Admin/assets/pages/widget/amchart/light.js')}}"></script>
    <script src="{{asset('Admin/assets/pages/widget/amchart/pie.min.js')}}"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.j"></script>
    <!-- menu js -->
    <script src="{{asset('Admin/assets/js/pcoded.min.js')}}"></script>
    <script src="{{asset('Admin/assets/js/vertical-layout.min.js')}} "></script>
    <!-- custom js -->
    <script type="text/javascript" src="{{asset('Admin/assets/pages/dashboard/custom-dashboard.js')}}"></script>
    <script type="text/javascript" src="{{asset('Admin/assets/js/script.js')}} "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <script>
        // Example function to show a notification
        var audio = new Audio("{{ asset('Admin/beep-warning-6387.mp3') }}");
        function showNotification(message) {
    if (message) {
        // Play the audio notification
        audio.play().then(() => {
            // Show the toastr notification
            toastr.success(message, 'Notification', {
                timeOut: 0, // Disable auto-hide
                closeButton: true, // Allow closing the notification manually
            });
        }).catch((error) => {
            console.error('Error playing audio:', error);
        });
    }
}

    </script>
</body>

</html>
