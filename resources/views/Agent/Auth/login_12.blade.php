<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <!--=============== CSS ===============-->
<link rel="stylesheet" href="{{ asset('login_12/assets/css/styles.css') }}?v={{ time() }}">


    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">

    <title>Kwikster|Agent</title>

    <style>
        /* Additional custom styles */
        .error-message {
            color: #ff4d4d;
            font-size: 0.8rem;
            margin-top: -10px;
            margin-bottom: 10px;
            text-align: left;
            padding-left: 40px;
            background-color: white;
            width: fit-content;
            padding: 10px;
        }

        input:-webkit-autofill {
    -webkit-text-fill-color: white !important; /* this changes the text color */
    background-color: transparent !important;
    transition: background-color 5000s ease-in-out 0s;
    caret-color: white; /* optional: changes cursor color */
}

/* Trigger label animation when autofilled */
input:-webkit-autofill + label,
input:focus + label,
input:not(:placeholder-shown) + label {
    transform: translateY(-1.5rem);
    font-size: 0.75rem;
    color: #ffffff; /* your active label color */
}
    </style>
</head>

<body>
    <div class="login">
        <img src="{{ asset('login_12/assets/img/login-bg.png') }}" alt="login image" class="login__img">

        <form action="{{ route('ajent_login_process') }}" method="post" class="login__form">
            @csrf
            <h1 class="login__title">KWIK-INSURANCE AGENT LOGIN</h1>

            <div class="login__content">
                <div class="login__box">
                    <i class="ri-user-3-line login__icon"></i>

                    <div class="login__box-input">
                        <input type="email" name="email" required class="login__input" id="login-email"
                            placeholder=" " value="{{ old('email') }}">
                        <label for="login-email" class="login__label">Email</label>
                    </div>
                </div>
                @error('email')
                    <p class="error-message">{{ $errors->first('email') }}</p>
                @enderror

                <div class="login__box">
                    <i class="ri-lock-2-line login__icon"></i>

                    <div class="login__box-input">
                        <input type="password" name="password" required class="login__input" id="login-pass"
                            placeholder=" ">
                        <label for="login-pass" class="login__label">Password</label>
                        <i class="ri-eye-off-line login__eye" id="login-eye"></i>
                    </div>
                </div>
                @if (session('error'))
                    <p class="error-message">{{ session('error') }}</p>
                @endif

                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
            </div>

            {{-- <div class="login__check">
                <div class="login__check-group">
                    <input type="checkbox" class="login__check-input" id="login-check" name="remember">
                    <label for="login-check" class="login__check-label">Remember me</label>
                </div>

                <a href="#" class="login__forgot">Forgot Password?</a>
            </div> --}}

            <button type="submit" class="login__button">Login</button>

            <p class="login__register">
                Don't have an account? <a href="#">Contact Administrator</a>
            </p>
        </form>
    </div>

    <!--=============== MAIN JS ===============-->
    <script src="{{ asset('login_12/assets/js/main.js') }}"></script>

    <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script>
        $(document).ready(function() {
            // Get the current position on page load
            navigator.geolocation.getCurrentPosition(function(position) {
                // Set latitude and longitude values in the hidden input fields
                $('#latitude').val(position.coords.latitude);
                $('#longitude').val(position.coords.longitude);
            }, function(error) {
                // Handle location error
                console.error('Error fetching location:', error.message);
                alert('Unable to retrieve your location. Please enable location access in your browser.');
            });
        });
    </script>
</body>

</html>
