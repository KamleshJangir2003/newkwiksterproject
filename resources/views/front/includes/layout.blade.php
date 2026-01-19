<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @include('front.includes.css')

    @yield('title')

    @yield('css')
    <style>
        .useful {
            padding-left: 65px;
        }

        @media(max-width:786px) {
            .useful {
                padding-left: 15px;
            }
        }

        .pd li {
            padding-right: 45px;

        }

        @media(max-width:786px) {
            .pd {
                padding: 10px;
            }
        }

        .logos {
            margin-left: 120px;

        }

        .quotes {
            display: none;
        }

        @media(max-width:786px) {
            .quotes {
                display: block;
            }
        }

        @media(max-width:786px) {
            .logos {
                height: 74px !important;
                width: 112px !important;
                margin-left: 15px !important;

            }
        }
        .dropdown-menu{
            border-radius: 0px;
        }
    </style>

</head>



<body>

    @include('front.includes.header')

    <!--  -->

    @yield('content')

    <!-- / END CONTACT SECTION -->

    @include('front.includes.footer')

    <!-- js -->

    @include('front.includes.js')

    @yield('js')

    <script>
        setTimeout(function() {

            document.getElementById('successMessage').style.display = 'none';

        }, 3000);
    </script>

</body>



</html>