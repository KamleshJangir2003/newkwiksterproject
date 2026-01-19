<!-- app.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time | Tracker</title>
    <link rel="stylesheet" href="{{ asset('assets/css/timer.css') }}">
</head>

<body>

    <div class="container">
        <button onclick="openTimerPopup()">Timer</button>

        <script src="{{ asset('assets/js/popup.js') }}"></script>
    </div>
    
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>
