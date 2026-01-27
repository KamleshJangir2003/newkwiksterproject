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
            --accident-orange: #ff4400;
            --fire-red: #ff3300;
            --smoke-gray: #666666;
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
            background: linear-gradient(to bottom, #6dc1c9, #b21f1f, #fdbb2d);
            animation: skyAnimation 30s infinite alternate;
            position: relative;
        }

        @keyframes skyAnimation {
            0% {
                background: linear-gradient(to bottom, #303237, #b21f1f, #fdbb2d);
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
            filter: drop-shadow(2px 4px 6px rgba(0, 0, 0, 0.5));
            transform-origin: center center;
        }

        /* Truck designs */
        .truck:nth-child(1) {
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 220 90"><rect x="10" y="30" width="160" height="45" fill="%23e74c3c" rx="3"/><rect x="170" y="40" width="40" height="35" fill="%23e74c3c" rx="3"/><rect x="15" y="20" width="150" height="10" fill="%23e74c3c" rx="2"/><circle cx="45" cy="75" r="12" fill="%23333" stroke="%23ccc" stroke-width="2"/><circle cx="135" cy="75" r="12" fill="%23333" stroke="%23ccc" stroke-width="2"/><rect x="40" cy="75" width="5" height="12" fill="%23333" transform="rotate(45 40 75)"/><rect x="130" cy="75" width="5" height="12" fill="%23333" transform="rotate(45 130 75)"/><text x="110" y="45" font-family="Arial" font-size="10" fill="%23ffffff" text-anchor="middle" font-weight="bold">CARGO</text><text x="110" y="58" font-family="Arial" font-size="8" fill="%23ffffff" text-anchor="middle">INSURANCE</text><rect x="180" y="45" width="5" height="5" fill="%23ffd700"/><rect x="187" y="45" width="5" height="5" fill="%23ffd700"/></svg>');
            bottom: 50px;
            left: -250px;
        }

        .truck:nth-child(2) {
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 220 90"><rect x="10" y="30" width="160" height="45" fill="%232ecc71" rx="3"/><rect x="170" y="40" width="40" height="35" fill="%232ecc71" rx="3"/><rect x="15" y="20" width="150" height="10" fill="%232ecc71" rx="2"/><circle cx="45" cy="75" r="12" fill="%23333" stroke="%23ccc" stroke-width="2"/><circle cx="135" cy="75" r="12" fill="%23333" stroke="%23ccc" stroke-width="2"/><rect x="40" cy="75" width="5" height="12" fill="%23333" transform="rotate(45 40 75)"/><rect x="130" cy="75" width="5" height="12" fill="%23333" transform="rotate(45 130 75)"/><text x="110" y="45" font-family="Arial" font-size="10" fill="%23ffffff" text-anchor="middle" font-weight="bold">LIABILITY</text><text x="110" y="58" font-family="Arial" font-size="8" fill="%23ffffff" text-anchor="middle">COVERAGE</text><rect x="180" y="45" width="5" height="5" fill="%23ffd700"/><rect x="187" y="45" width="5" height="5" fill="%23ffd700"/></svg>');
            bottom: 100px;
            right: -250px;
            transform: rotateY(180deg);
        }

        .truck:nth-child(3) {
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 220 90"><rect x="10" y="30" width="160" height="45" fill="%239b59b6" rx="3"/><rect x="170" y="40" width="40" height="35" fill="%239b59b6" rx="3"/><rect x="15" y="20" width="150" height="10" fill="%239b59b6" rx="2"/><circle cx="45" cy="75" r="12" fill="%23333" stroke="%23ccc" stroke-width="2"/><circle cx="135" cy="75" r="12" fill="%23333" stroke="%23ccc" stroke-width="2"/><rect x="40" cy="75" width="5" height="12" fill="%23333" transform="rotate(45 40 75)"/><rect x="130" cy="75" width="5" height="12" fill="%23333" transform="rotate(45 130 75)"/><text x="110" y="45" font-family="Arial" font-size="10" fill="%23ffffff" text-anchor="middle" font-weight="bold">FREIGHT</text><text x="110" y="58" font-family="Arial" font-size="8" fill="%23ffffff" text-anchor="middle">PROTECTION</text><rect x="180" y="45" width="5" height="5" fill="%23ffd700"/><rect x="187" y="45" width="5" height="5" fill="%23ffd700"/></svg>');
            bottom: 150px;
            left: 30%;
            opacity: 0.7;
        }

        /* Truck movement animations */
        .truck.moving-right {
            animation: moveRight 4s linear forwards;
        }

        @keyframes moveRight {
            0% {
                left: -250px;
                transform: rotate(0deg);
            }
            100% {
                left: calc(50% - 110px);
                transform: rotate(0deg);
            }
        }

        .truck.moving-left {
            animation: moveLeft 4s linear forwards;
        }

        @keyframes moveLeft {
            0% {
                right: -250px;
                transform: rotateY(180deg);
            }
            100% {
                right: calc(50% - 110px);
                transform: rotateY(180deg);
            }
        }

        /* Collision animations */
        .truck.collide-right {
            animation: collideRight 1s cubic-bezier(0.2, 0.8, 0.3, 1) forwards;
        }

        @keyframes collideRight {
            0% {
                left: calc(50% - 110px);
                transform: rotate(0deg);
            }
            30% {
                left: calc(50% - 80px);
                transform: rotate(-10deg);
            }
            60% {
                left: calc(50% - 140px);
                transform: rotate(25deg) scale(0.95);
            }
            100% {
                left: calc(50% - 160px);
                transform: rotate(40deg) scale(0.9);
                filter: brightness(0.8) drop-shadow(2px 4px 6px rgba(0, 0, 0, 0.7));
            }
        }

        .truck.collide-left {
            animation: collideLeft 1s cubic-bezier(0.2, 0.8, 0.3, 1) forwards;
        }

        @keyframes collideLeft {
            0% {
                right: calc(50% - 110px);
                transform: rotateY(180deg);
            }
            30% {
                right: calc(50% - 80px);
                transform: rotateY(180deg) rotate(10deg);
            }
            60% {
                right: calc(50% - 140px);
                transform: rotateY(180deg) rotate(-25deg) scale(0.95);
            }
            100% {
                right: calc(50% - 160px);
                transform: rotateY(180deg) rotate(-40deg) scale(0.9);
                filter: brightness(0.8) drop-shadow(2px 4px 6px rgba(0, 0, 0, 0.7));
            }
        }

        /* Broken truck parts */
        .broken-part {
            position: absolute;
            background-size: contain;
            background-repeat: no-repeat;
            z-index: 4;
            opacity: 0;
        }

        .wheel {
            width: 25px;
            height: 25px;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25"><circle cx="12.5" cy="12.5" r="12" fill="%23333" stroke="%23ccc" stroke-width="1"/><circle cx="12.5" cy="12.5" r="4" fill="%23666"/></svg>');
        }

        .debris {
            width: 40px;
            height: 20px;
            background-color: var(--cargo-red);
            border-radius: 3px;
        }

        .debris.green {
            background-color: var(--liability-green);
        }

        /* Explosion effects */
        .explosion {
            position: absolute;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: radial-gradient(circle, var(--fire-red) 0%, var(--accident-orange) 30%, rgba(255, 100, 0, 0.3) 60%, transparent 70%);
            z-index: 5;
            opacity: 0;
            pointer-events: none;
        }

        .explosion.medium {
            animation: explodeMedium 0.8s forwards;
        }

        @keyframes explodeMedium {
            0% {
                width: 0;
                height: 0;
                opacity: 0;
                transform: scale(0.1);
            }
            50% {
                width: 200px;
                height: 200px;
                opacity: 0.9;
                transform: scale(1);
            }
            100% {
                width: 300px;
                height: 300px;
                opacity: 0;
                transform: scale(1.5);
            }
        }

        .explosion.large {
            animation: explodeLarge 1s forwards;
        }

        @keyframes explodeLarge {
            0% {
                width: 0;
                height: 0;
                opacity: 0;
                transform: scale(0.1);
            }
            40% {
                width: 300px;
                height: 300px;
                opacity: 0.8;
                transform: scale(1);
            }
            100% {
                width: 500px;
                height: 500px;
                opacity: 0;
                transform: scale(1.8);
            }
        }

        /* Fire effect */
      

        @keyframes fireFlicker {
            0% {
                transform: scale(1) translateY(0);
                opacity: 0.8;
            }
            100% {
                transform: scale(1.1) translateY(-5px);
                opacity: 1;
            }
        }

        /* Smoke effect */
        .smoke {
            position: absolute;
            width: 80px;
            height: 80px;
            background: radial-gradient(circle, rgba(100, 100, 100, 0.8) 0%, rgba(50, 50, 50, 0.4) 40%, transparent 70%);
            border-radius: 50%;
            z-index: 3;
            opacity: 0;
            pointer-events: none;
        }

        .smoke.float-up {
            animation: floatUp 3s ease-out forwards;
        }

        @keyframes floatUp {
            0% {
                transform: translateY(0) scale(1);
                opacity: 0.7;
            }
            100% {
                transform: translateY(-200px) scale(2);
                opacity: 0;
            }
        }

        /* Accident popup */
        .accident-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            width: 500px;
            background: rgba(0, 0, 0, 0.9);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 0 50px rgba(255, 50, 0, 0.8);
            border: 3px solid var(--accident-orange);
            z-index: 100;
            text-align: center;
            transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .accident-popup.show {
            transform: translate(-50%, -50%) scale(1);
        }

        .accident-popup h2 {
            color: var(--accident-orange);
            font-size: 32px;
            margin-bottom: 15px;
            font-weight: 700;
            text-shadow: 0 0 10px rgba(255, 100, 0, 0.5);
        }

        .accident-popup p {
            color: var(--white);
            font-size: 18px;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .accident-popup .highlight {
            color: var(--secondary-yellow);
            font-weight: 600;
        }

        .popup-btn {
            background: linear-gradient(to right, var(--primary-blue), #0044aa);
            color: var(--white);
            border: none;
            padding: 15px 40px;
            font-size: 18px;
            border-radius: 35px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            margin-top: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .popup-btn:hover {
            background: linear-gradient(to right, #0055aa, #003388);
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 102, 204, 0.5);
        }

        .warning-icon {
            font-size: 60px;
            color: var(--accident-orange);
            margin-bottom: 20px;
            animation: pulse 1s infinite;
            text-shadow: 0 0 20px rgba(255, 100, 0, 0.7);
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                text-shadow: 0 0 10px rgba(255, 100, 0, 0.7);
            }
            50% {
                transform: scale(1.1);
                text-shadow: 0 0 20px rgba(255, 100, 0, 1);
            }
            100% {
                transform: scale(1);
                text-shadow: 0 0 10px rgba(255, 100, 0, 0.7);
            }
        }

        /* Login container */
        .login-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            width: 420px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 10;
            overflow: hidden;
            transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .login-container.show {
            transform: translate(-50%, -50%) scale(1);
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

            .accident-popup {
                width: 90%;
                padding: 20px;
            }

            .highway {
                height: 150px;
            }

            .truck {
                width: 180px;
            }
        }

        /* Screen shake effect */
        @keyframes screenShake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-10px); }
            20%, 40%, 60%, 80% { transform: translateX(10px); }
        }

        .shake {
            animation: screenShake 0.5s linear;
        }

        /* Broken glass effect */
        .glass-crack {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(45deg, transparent 49%, rgba(255,255,255,0.1) 50%, transparent 51%),
                linear-gradient(-45deg, transparent 49%, rgba(255,255,255,0.1) 50%, transparent 51%);
            background-size: 50px 50px;
            z-index: 6;
            opacity: 0;
            pointer-events: none;
        }

        .glass-crack.show {
            animation: crackAppear 0.5s forwards;
        }

        @keyframes crackAppear {
            0% { opacity: 0; }
            100% { opacity: 0.3; }
        }

        /* Skid marks */
        .skid-mark {
            position: absolute;
            height: 8px;
            background: linear-gradient(to right, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 50%, transparent 100%);
            border-radius: 4px;
            bottom: 50px;
            z-index: 2;
            transform-origin: left center;
            opacity: 0.7;
        }
    </style>
</head>

<body>
    <div class="highway"></div>
    <div class="road-line"></div>

    <!-- Skid marks -->
    <div class="skid-mark" id="skidMark1" style="width: 0; left: 30%;"></div>
    <div class="skid-mark" id="skidMark2" style="width: 0; right: 30%;"></div>

    <!-- Glass crack effect -->
    <div class="glass-crack" id="glassCrack"></div>

    <div class="moving-trucks">
        <div class="truck" id="truck1"></div>
        <div class="truck" id="truck2"></div>
        <div class="truck" id="truck3"></div>
    </div>

    <!-- Explosion effects -->
    <div class="explosion" id="explosion1"></div>
    <div class="explosion" id="explosion2"></div>
    
    <!-- Fire effect -->
    <div class="fire" id="fire1"></div>
    <div class="fire" id="fire2"></div>
    
    <!-- Smoke effects -->
    <div class="smoke" id="smoke1"></div>
    <div class="smoke" id="smoke2"></div>
    <div class="smoke" id="smoke3"></div>

    <!-- Broken parts -->
    <div class="broken-part wheel" id="wheel1"></div>
    <div class="broken-part wheel" id="wheel2"></div>
    <div class="broken-part debris" id="debris1"></div>
    <div class="broken-part debris green" id="debris2"></div>

    <!-- Accident Popup -->
    <div class="accident-popup" id="accidentPopup">
        <i class="fas fa-exclamation-triangle warning-icon"></i>
        <h2>MAJOR COLLISION!</h2>
        <p>A serious accident has occurred between commercial vehicles.</p>
        <p>Estimated damage: <span class="highlight">$250,000+</span></p>
        <p>This highlights the critical need for proper <span class="highlight">insurance coverage</span> and our CRM system helps manage such incidents efficiently.</p>
        <button class="popup-btn" id="proceedBtn">
            <i class="fas fa-shield-alt"></i> Access Claims System
        </button>
    </div>

    <!-- Login Container -->
    <div class="login-container" id="loginContainer">
        <div class="shield"></div>

        <div class="logo">
            <div class="logo-icon">
                <i class="fas fa-truck-moving"></i>
            </div>
            <h1><span>Kwikster</span> CRM</h1>
            <p>Insurance Claims & Policy Management</p>
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
                <span>LOGIN TO CLAIMS SYSTEM</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>

        <div class="footer">
            <p>Emergency Claims Hotline: <a href="tel:+18005551234">1-800-555-1234</a></p>
            <p>© 2025 Kwikster CRM. All rights reserved.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const truck1 = document.getElementById('truck1');
            const truck2 = document.getElementById('truck2');
            const truck3 = document.getElementById('truck3');
            const explosion1 = document.getElementById('explosion1');
            const explosion2 = document.getElementById('explosion2');
            const fire1 = document.getElementById('fire1');
            const fire2 = document.getElementById('fire2');
            const smoke1 = document.getElementById('smoke1');
            const smoke2 = document.getElementById('smoke2');
            const smoke3 = document.getElementById('smoke3');
            const wheel1 = document.getElementById('wheel1');
            const wheel2 = document.getElementById('wheel2');
            const debris1 = document.getElementById('debris1');
            const debris2 = document.getElementById('debris2');
            const skidMark1 = document.getElementById('skidMark1');
            const skidMark2 = document.getElementById('skidMark2');
            const glassCrack = document.getElementById('glassCrack');
            const accidentPopup = document.getElementById('accidentPopup');
            const proceedBtn = document.getElementById('proceedBtn');
            const loginContainer = document.getElementById('loginContainer');
            const passwordInput = document.getElementById('password');
            const strengthMeter = document.getElementById('strengthMeter');
            const togglePassword = document.getElementById('togglePassword');
            const highway = document.querySelector('.highway');
            const roadLine = document.querySelector('.road-line');

            // Start the animation sequence
            setTimeout(() => {
                // Start trucks moving towards each other
                truck1.classList.add('moving-right');
                truck2.classList.add('moving-left');
                
                // Show skid marks
                setTimeout(() => {
                    skidMark1.style.width = '200px';
                    skidMark1.style.transition = 'width 0.5s ease-out';
                    skidMark2.style.width = '200px';
                    skidMark2.style.transition = 'width 0.5s ease-out';
                }, 3500);
                
                // Create collision effect
                setTimeout(() => {
                    // Stop highway animation
                    highway.style.animationPlayState = 'paused';
                    roadLine.style.animationPlayState = 'paused';
                    
                    // Screen shake
                    document.body.classList.add('shake');
                    
                    // Glass crack effect
                    glassCrack.classList.add('show');
                    
                    // Stop trucks and apply collision animation
                    truck1.classList.remove('moving-right');
                    truck2.classList.remove('moving-left');
                    truck1.classList.add('collide-right');
                    truck2.classList.add('collide-left');
                    
                    // Position explosions at collision point
                    explosion1.style.left = 'calc(50% - 100px)';
                    explosion1.style.top = 'calc(50% + 30px)';
                    explosion1.classList.add('medium');
                    
                    explosion2.style.left = 'calc(50% - 150px)';
                    explosion2.style.top = 'calc(50% + 50px)';
                    explosion2.classList.add('large');
                    
                    // Position fires
                    setTimeout(() => {
                        fire1.style.left = 'calc(50% - 120px)';
                        fire1.style.top = 'calc(50% + 40px)';
                        fire1.style.opacity = '0.8';
                        
                        fire2.style.left = 'calc(50% - 180px)';
                        fire2.style.top = 'calc(50% + 60px)';
                        fire2.style.opacity = '0.6';
                    }, 300);
                    
                    // Create smoke
                    setTimeout(() => {
                        smoke1.style.left = 'calc(50% - 100px)';
                        smoke1.style.top = 'calc(50% + 50px)';
                        smoke1.classList.add('float-up');
                        smoke1.style.animationDelay = '0s';
                        
                        smoke2.style.left = 'calc(50% - 140px)';
                        smoke2.style.top = 'calc(50% + 60px)';
                        smoke2.classList.add('float-up');
                        smoke2.style.animationDelay = '0.5s';
                        
                        smoke3.style.left = 'calc(50% - 80px)';
                        smoke3.style.top = 'calc(50% + 70px)';
                        smoke3.classList.add('float-up');
                        smoke3.style.animationDelay = '1s';
                    }, 500);
                    
                    // Flying debris
                    setTimeout(() => {
                        // Wheel 1
                        wheel1.style.left = 'calc(50% - 50px)';
                        wheel1.style.top = 'calc(50% + 30px)';
                        wheel1.style.opacity = '1';
                        wheel1.style.animation = 'wheelFly1 1.5s cubic-bezier(0.2, 0.8, 0.3, 1) forwards';
                        
                        // Wheel 2
                        wheel2.style.left = 'calc(50% + 20px)';
                        wheel2.style.top = 'calc(50% + 40px)';
                        wheel2.style.opacity = '1';
                        wheel2.style.animation = 'wheelFly2 1.5s cubic-bezier(0.2, 0.8, 0.3, 1) forwards';
                        
                        // Debris 1
                        debris1.style.left = 'calc(50% - 80px)';
                        debris1.style.top = 'calc(50% + 20px)';
                        debris1.style.opacity = '1';
                        debris1.style.animation = 'debrisFly1 1.2s cubic-bezier(0.2, 0.8, 0.3, 1) forwards';
                        
                        // Debris 2
                        debris2.style.left = 'calc(50% + 40px)';
                        debris2.style.top = 'calc(50% + 50px)';
                        debris2.style.opacity = '1';
                        debris2.style.animation = 'debrisFly2 1.3s cubic-bezier(0.2, 0.8, 0.3, 1) forwards';
                        
                        // Define flying animations
                        const style = document.createElement('style');
                        style.textContent = `
                            @keyframes wheelFly1 {
                                0% { transform: translate(0, 0) rotate(0deg); }
                                100% { transform: translate(-100px, -80px) rotate(720deg); }
                            }
                            @keyframes wheelFly2 {
                                0% { transform: translate(0, 0) rotate(0deg); }
                                100% { transform: translate(120px, -60px) rotate(-720deg); }
                            }
                            @keyframes debrisFly1 {
                                0% { transform: translate(0, 0) rotate(0deg); }
                                100% { transform: translate(-60px, -40px) rotate(180deg); }
                            }
                            @keyframes debrisFly2 {
                                0% { transform: translate(0, 0) rotate(0deg); }
                                100% { transform: translate(80px, -30px) rotate(-180deg); }
                            }
                        `;
                        document.head.appendChild(style);
                        
                    }, 200);
                    
                    // Third truck reacts to accident
                    setTimeout(() => {
                        truck3.style.animation = 'swerve 1s forwards';
                        const style = document.createElement('style');
                        style.textContent = `
                            @keyframes swerve {
                                0% { left: 30%; transform: translateX(0); }
                                100% { left: 40%; transform: translateX(50px) rotate(15deg); }
                            }
                        `;
                        document.head.appendChild(style);
                    }, 400);
                    
                    // Show accident popup
                    setTimeout(() => {
                        accidentPopup.classList.add('show');
                    }, 1500);
                    
                }, 4000); // Time until collision
                
            }, 1000); // Initial delay

            // Proceed to login
            proceedBtn.addEventListener('click', function() {
                accidentPopup.classList.remove('show');
                
                // Fade out accident scene
                setTimeout(() => {
                    truck1.style.opacity = '0.3';
                    truck2.style.opacity = '0.3';
                    fire1.style.opacity = '0';
                    fire2.style.opacity = '0';
                    glassCrack.classList.remove('show');
                    
                    // Show login form
                    setTimeout(() => {
                        loginContainer.classList.add('show');
                    }, 500);
                }, 300);
            });

            // Password strength indicator
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;

                if (password.length >= 8) strength += 25;
                if (password.length >= 12) strength += 25;
                if (/[A-Z]/.test(password)) strength += 15;
                if (/[0-9]/.test(password)) strength += 15;
                if (/[^A-Za-z0-9]/.test(password)) strength += 20;

                strengthMeter.style.width = strength + '%';

                if (strength < 40) {
                    strengthMeter.style.background = '#e74c3c';
                } else if (strength < 70) {
                    strengthMeter.style.background = '#f39c12';
                } else {
                    strengthMeter.style.background = '#2ecc71';
                }
            });

            // Toggle password visibility
            togglePassword.addEventListener('click', function() {
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

            // Add sound effects (uncomment if you have audio files)
            /*
            function playCollisionSound() {
                const audio = new Audio('collision.mp3');
                audio.volume = 0.6;
                audio.play();
            }
            
            function playExplosionSound() {
                const audio = new Audio('explosion.mp3');
                audio.volume = 0.7;
                audio.play();
            }
            
            setTimeout(playCollisionSound, 4000);
            setTimeout(playExplosionSound, 4050);
            */
        });
    </script>
</body>
</html>