<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwikster Insurance CRM | Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>

        
        :root {
            --primary-blue: #0066cc;
            --secondary-yellow: #ffd700;
            --road-gray: #333333;
            --white: #ffffff;
            --light-gray: #f5f5f5;
            --dark-gray: #222222;
            --cargo-red: #e74c3c;
            --liability-green: #2ecc71;
            --freight-purple: #9b59b6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            height: 100vh;
            overflow: hidden;
            background: linear-gradient(to bottom, #1a2a6c, #b21f1f, #fdbb2d);
            animation: skyAnimation 30s infinite alternate;
            position: relative;
        }

        @keyframes skyAnimation {
            0% {
                background: linear-gradient(to bottom, #1a2a6c, #b21f1f, #fdbb2d);
            }

            50% {
                background: linear-gradient(to bottom, #0f2027, #203a43, #2c5364);
            }

            100% {
                background: linear-gradient(to bottom, #000428, #004e92);
            }
        }

        .highway {
            position: absolute;
            bottom: 0;
            width: 500%;
            height: 200px;
            background: var(--road-gray);
            animation: highwayAnimation 15s linear infinite;
            z-index: 1;
        }

        @keyframes highwayAnimation {
            100% {
                transform: translateX(-3400px);
            }
        }

        .road-line {
            position: absolute;
            top: 50%;
            width: 100%;
            height: 6px;
            background: repeating-linear-gradient(to right, var(--white) 0%, var(--white) 50%, transparent 50%, transparent 100%);
            background-size: 50px 6px;
            animation: roadLineAnimation 1s linear infinite;
            z-index: 2;
        }

        @keyframes roadLineAnimation {
            0% {
                background-position-x: 0;
            }

            100% {
                background-position-x: -50px;
            }
        }

        .moving-trucks {
            position: absolute;
            bottom: 150px;
            width: 100%;
            height: 100px;
            z-index: 3;
        }

        .truck {
            position: absolute;
            width: 220px;
            height: 90px;
            background-size: contain;
            background-repeat: no-repeat;
            animation: truckAnimation 20s linear infinite;
            filter: drop-shadow(2px 4px 6px rgba(0, 0, 0, 0.5));
        }

        /* More realistic truck designs */
        .truck:nth-child(1) {
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 220 90"><rect x="10" y="30" width="160" height="45" fill="%23e74c3c" rx="3"/><rect x="170" y="40" width="40" height="35" fill="%23e74c3c" rx="3"/><rect x="15" y="20" width="150" height="10" fill="%23e74c3c" rx="2"/><circle cx="45" cy="75" r="12" fill="%23333" stroke="%23ccc" stroke-width="2"/><circle cx="135" cy="75" r="12" fill="%23333" stroke="%23ccc" stroke-width="2"/><rect x="40" cy="75" width="5" height="12" fill="%23333" transform="rotate(45 40 75)"/><rect x="130" cy="75" width="5" height="12" fill="%23333" transform="rotate(45 130 75)"/><text x="110" y="45" font-family="Arial" font-size="10" fill="%23ffffff" text-anchor="middle" font-weight="bold">CARGO</text><text x="110" y="58" font-family="Arial" font-size="8" fill="%23ffffff" text-anchor="middle">INSURANCE</text><rect x="180" y="45" width="5" height="5" fill="%23ffd700"/><rect x="187" y="45" width="5" height="5" fill="%23ffd700"/></svg>');
            bottom: 50px;
            animation-delay: 0s;
        }

        .truck:nth-child(2) {
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 220 90"><rect x="10" y="30" width="160" height="45" fill="%232ecc71" rx="3"/><rect x="170" y="40" width="40" height="35" fill="%232ecc71" rx="3"/><rect x="15" y="20" width="150" height="10" fill="%232ecc71" rx="2"/><circle cx="45" cy="75" r="12" fill="%23333" stroke="%23ccc" stroke-width="2"/><circle cx="135" cy="75" r="12" fill="%23333" stroke="%23ccc" stroke-width="2"/><rect x="40" cy="75" width="5" height="12" fill="%23333" transform="rotate(45 40 75)"/><rect x="130" cy="75" width="5" height="12" fill="%23333" transform="rotate(45 130 75)"/><text x="110" y="45" font-family="Arial" font-size="10" fill="%23ffffff" text-anchor="middle" font-weight="bold">LIABILITY</text><text x="110" y="58" font-family="Arial" font-size="8" fill="%23ffffff" text-anchor="middle">COVERAGE</text><rect x="180" y="45" width="5" height="5" fill="%23ffd700"/><rect x="187" y="45" width="5" height="5" fill="%23ffd700"/></svg>');
            bottom: 100px;
            animation-delay: -5s;
        }

        .truck:nth-child(3) {
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 220 90"><rect x="10" y="30" width="160" height="45" fill="%239b59b6" rx="3"/><rect x="170" y="40" width="40" height="35" fill="%239b59b6" rx="3"/><rect x="15" y="20" width="150" height="10" fill="%239b59b6" rx="2"/><circle cx="45" cy="75" r="12" fill="%23333" stroke="%23ccc" stroke-width="2"/><circle cx="135" cy="75" r="12" fill="%23333" stroke="%23ccc" stroke-width="2"/><rect x="40" cy="75" width="5" height="12" fill="%23333" transform="rotate(45 40 75)"/><rect x="130" cy="75" width="5" height="12" fill="%23333" transform="rotate(45 130 75)"/><text x="110" y="45" font-family="Arial" font-size="10" fill="%23ffffff" text-anchor="middle" font-weight="bold">FREIGHT</text><text x="110" y="58" font-family="Arial" font-size="8" fill="%23ffffff" text-anchor="middle">PROTECTION</text><rect x="180" y="45" width="5" height="5" fill="%23ffd700"/><rect x="187" y="45" width="5" height="5" fill="%23ffd700"/></svg>');
            bottom: 150px;
            animation-delay: -10s;
        }

        @keyframes truckAnimation {
            0% {
                transform: translateX(-220px);
            }

            100% {
                transform: translateX(2000px);
            }
        }

        .login-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 420px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 10;
            overflow: hidden;
            transition: all 0.5s ease;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translate(-50%, -52%);
            }

            50% {
                transform: translate(-50%, -48%);
            }

            100% {
                transform: translate(-50%, -52%);
            }
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }

        .login-container:hover::before {
            left: 100%;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .logo-icon {
            font-size: 60px;
            color: var(--secondary-yellow);
            margin-bottom: 10px;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .logo h1 {
            color: var(--white);
            margin-top: 5px;
            font-weight: 700;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            font-size: 28px;
        }

        .logo span {
            color: var(--secondary-yellow);
        }

        .logo p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            margin-top: 5px;
            font-weight: 300;
        }

        .input-group {
            position: relative;
            margin-bottom: 30px;
        }

        .input-group input {
            width: 100%;
            padding: 15px 45px 15px 20px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 35px;
            font-size: 16px;
            color: var(--white);
            outline: none;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .input-group input:focus {
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 15px rgba(0, 102, 204, 0.7);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .input-group input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .input-group label {
            position: absolute;
            top: 15px;
            left: 20px;
            color: var(--white);
            font-size: 16px;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .input-group input:focus+label,
        .input-group input:valid+label {
            top: -20px;
            left: 15px;
            font-size: 12px;
            color: var(--secondary-yellow);
            background: var(--primary-blue);
            padding: 2px 10px;
            border-radius: 20px;
        }

        .input-icon {
            position: absolute;
            right: 20px;
            top: 15px;
            color: var(--white);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .input-icon:not(.password-toggle) {
            pointer-events: none;
        }

        .password-toggle:hover {
            color: var(--secondary-yellow);
        }

        .password-strength {
            width: 100%;
            height: 5px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            margin-top: 5px;
            overflow: hidden;
            position: relative;
        }

        .strength-meter {
            height: 100%;
            width: 0;
            border-radius: 5px;
            transition: width 0.3s ease;
            position: relative;
        }

        .strength-meter::after {
            content: '';
            position: absolute;
            top: -5px;
            right: -10px;
            width: 20px;
            height: 15px;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 15"><rect x="5" width="10" height="10" fill="%23ffffff"/><rect width="20" y="10" height="5" fill="%23ffffff"/></svg>');
            background-size: contain;
            transition: transform 0.3s ease;
        }

        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 14px;
            color: var(--white);
        }

        .options a {
            color: var(--white);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .options a:hover {
            color: var(--secondary-yellow);
            text-decoration: underline;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
        }

        .checkbox-container input {
            margin-right: 5px;
            accent-color: var(--primary-blue);
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            background: var(--primary-blue);
            color: var(--white);
            border: none;
            border-radius: 35px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-btn:hover {
            background: #0055aa;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: 0.5s;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .login-btn i {
            margin-left: 8px;
            transition: transform 0.3s ease;
        }

        .login-btn:hover i {
            transform: translateX(5px);
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: var(--white);
            font-size: 12px;
        }

        .footer a {
            color: var(--secondary-yellow);
            text-decoration: none;
        }

        /* Security shield animation */
        .shield {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: radial-gradient(circle, rgba(0, 102, 204, 0.2) 0%, transparent 70%);
            border-radius: 20px;
            opacity: 0;
            transition: opacity 0.5s ease;
            pointer-events: none;
            z-index: -1;
        }

        .login-container:hover .shield {
            opacity: 1;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-container {
                width: 90%;
                padding: 30px 20px;
            }

            .highway {
                height: 150px;
            }

            .truck {
                width: 180px;
            }
        }

        /* Loading animation */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loading {
            display: inline-block;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
            margin-right: 8px;
        }
        .logo {
    text-align: center;
}

.logo-icon img {
    width: 220px;      /* size adjust kar sakte ho */
    height: auto;
    
}

    </style>
</head>

<body>
    <div class="highway"></div>
    <div class="road-line"></div>

    <div class="moving-trucks">
        <div class="truck"></div>
        <div class="truck"></div>
        <div class="truck"></div>
    </div>

    <div class="login-container">
        <div class="shield"></div>

        <div class="logo">
    <div class="logo-icon">
        <img src="{{ asset('Admin/kwikster-logo.png') }}" alt="Edtim Global CRM">
    </div>

    <h1><span>Kwikster</span> CRM</h1>
    <p>Insurance Management System</p>
</div>


        <form id="loginForm" action="{{ route('ajent_login_process') }}" method="POST">
            @csrf
            <div class="input-group">
                <input type="text" id="username" name="email" required placeholder=" "
                    value="{{ old('email') }}">
                <label for="username">Agent ID</label>
                <i class="fas fa-user input-icon"></i>
            </div>
            @error('email')
                <p class="error-message" style="background-color:white;margin-bottom:5px;color:red;">{{ $message }}</p>
            @enderror

            <div class="input-group">
                <input type="password" id="password" name="password" required placeholder=" ">
                <label for="password">Password</label>
                <i class="fas fa-lock input-icon"></i>
                <i class="fas fa-eye input-icon password-toggle" id="togglePassword"></i>
                <div class="password-strength">
                    <div class="strength-meter" id="strengthMeter"></div>
                </div>
            </div>
            @error('password')
                <p class="error-message" style="background-color:white;margin-bottom:5px;color:red;">{{ $message }}</p>
            @enderror

            @if (session('error'))
                <p class="error-message" style="background-color:white;margin-bottom:5px;color:red;">{{ session('error') }}</p>
            @endif

            <div class="options">
                <div class="checkbox-container">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>
                <a href="#">Forgot password?</a>
            </div>

            <button type="submit" class="login-btn" id="loginButton">
                <span>LOGIN</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>


        <div class="footer">
            <p>Need help? Contact <a href="#">IT Support</a></p>
            <p>© 2025 Kwikster CRM. All rights reserved.</p>
        </div>
    </div>

    <script>
        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const strengthMeter = document.getElementById('strengthMeter');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;

            // Check for length
            if (password.length >= 8) strength += 25;
            if (password.length >= 12) strength += 25;

            // Check for uppercase letters
            if (/[A-Z]/.test(password)) strength += 15;

            // Check for numbers
            if (/[0-9]/.test(password)) strength += 15;

            // Check for special characters
            if (/[^A-Za-z0-9]/.test(password)) strength += 20;

            // Update strength meter
            strengthMeter.style.width = strength + '%';

            // Change color based on strength
            if (strength < 40) {
                strengthMeter.style.background = '#e74c3c';
            } else if (strength < 70) {
                strengthMeter.style.background = '#f39c12';
            } else {
                strengthMeter.style.background = '#2ecc71';
            }
        });

        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this;

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Form submission
        // document.getElementById('loginForm').addEventListener('submit', function(e) {
        //     e.preventDefault();

        //     const loginButton = document.getElementById('loginButton');
        //     const originalContent = loginButton.innerHTML;

        //     // Show loading state
        //     loginButton.innerHTML = '<span class="loading"></span> AUTHENTICATING';
        //     loginButton.disabled = true;

        //     // Simulate API call
        //     setTimeout(() => {
        //         loginButton.innerHTML = '<i class="fas fa-check"></i> ACCESS GRANTED';
        //         loginButton.style.background = '#2ecc71';

        //         // Redirect after delay
        //         setTimeout(() => {
        //             window.location.href = 'dashboard.html';
        //         }, 1000);
        //     }, 2000);
        // });
    </script>
</body>

</html>
