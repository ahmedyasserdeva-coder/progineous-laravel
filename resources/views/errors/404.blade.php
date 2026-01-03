@php
    // Get locale from session or use default
    $locale = session('locale', config('app.locale', 'en'));
    app()->setLocale($locale);
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $locale == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $locale == 'ar' ? '404 - الصفحة غير موجودة' : '404 - Page Not Found' }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo/pro Gineous Blue_defult icon.png') }}">
    
    <!-- Cairo Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Cairo', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }
        
        /* Animated Background Stars */
        .stars {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }
        
        .star {
            position: absolute;
            width: 2px;
            height: 2px;
            background: white;
            border-radius: 50%;
            animation: twinkle 3s infinite ease-in-out;
        }
        
        @keyframes twinkle {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.2); }
        }
        
        /* Floating Particles */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }
        
        .particle {
            position: absolute;
            width: 10px;
            height: 10px;
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            border-radius: 50%;
            opacity: 0.3;
            animation: float 15s infinite ease-in-out;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 0.3; }
            90% { opacity: 0.3; }
            100% { transform: translateY(-100vh) rotate(720deg); opacity: 0; }
        }
        
        .container {
            text-align: center;
            z-index: 10;
            padding: 2rem;
            max-width: 600px;
        }
        
        /* 404 Number with Glitch Effect */
        .error-code {
            font-size: clamp(120px, 25vw, 200px);
            font-weight: 800;
            background: linear-gradient(135deg, #3b82f6 0%, #06b6d4 50%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            animation: glitch 5s infinite;
            line-height: 1;
            margin-bottom: 1rem;
        }
        
        .error-code::before,
        .error-code::after {
            content: '404';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #3b82f6 0%, #06b6d4 50%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .error-code::before {
            animation: glitch-1 0.3s infinite linear alternate-reverse;
            clip-path: polygon(0 0, 100% 0, 100% 35%, 0 35%);
        }
        
        .error-code::after {
            animation: glitch-2 0.3s infinite linear alternate-reverse;
            clip-path: polygon(0 65%, 100% 65%, 100% 100%, 0 100%);
        }
        
        @keyframes glitch-1 {
            0% { transform: translateX(0); }
            100% { transform: translateX(-5px); }
        }
        
        @keyframes glitch-2 {
            0% { transform: translateX(0); }
            100% { transform: translateX(5px); }
        }
        
        /* Astronaut SVG */
        .astronaut {
            width: 150px;
            height: 150px;
            margin: 0 auto 2rem;
            animation: astronaut-float 6s ease-in-out infinite;
        }
        
        @keyframes astronaut-float {
            0%, 100% { transform: translateY(0) rotate(-5deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        .title {
            font-size: clamp(1.5rem, 4vw, 2rem);
            font-weight: 700;
            color: #f8fafc;
            margin-bottom: 1rem;
        }
        
        .description {
            font-size: clamp(1rem, 2.5vw, 1.125rem);
            color: #94a3b8;
            margin-bottom: 2.5rem;
            line-height: 1.7;
        }
        
        .buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            font-family: 'Cairo', sans-serif;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            color: white;
            border: none;
            box-shadow: 0 10px 40px rgba(59, 130, 246, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 50px rgba(59, 130, 246, 0.4);
        }
        
        .btn-secondary {
            background: transparent;
            color: #e2e8f0;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
        }
        
        /* Planet decoration */
        .planet {
            position: fixed;
            border-radius: 50%;
            opacity: 0.5;
        }
        
        .planet-1 {
            width: 300px;
            height: 300px;
            background: radial-gradient(circle at 30% 30%, #3b82f6, #1e40af);
            top: -100px;
            right: -100px;
            filter: blur(60px);
        }
        
        .planet-2 {
            width: 200px;
            height: 200px;
            background: radial-gradient(circle at 30% 30%, #06b6d4, #0891b2);
            bottom: -50px;
            left: -50px;
            filter: blur(40px);
        }
        
        /* Logo */
        .logo {
            position: fixed;
            top: 2rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 20;
        }
        
        .logo img {
            height: 40px;
            filter: brightness(0) invert(1);
        }
        
        /* Responsive */
        @media (max-width: 640px) {
            .buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Background Elements -->
    <div class="stars" id="stars"></div>
    <div class="particles" id="particles"></div>
    <div class="planet planet-1"></div>
    <div class="planet planet-2"></div>
    
    <!-- Logo -->
    <a href="{{ url('/') }}" class="logo">
        <img src="{{ asset('logo/pro Gineous_white logo.svg') }}" alt="Pro Gineous">
    </a>
    
    <!-- Main Content -->
    <div class="container">
        <!-- Astronaut SVG -->
        <div class="astronaut">
            <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Astronaut Body -->
                <ellipse cx="100" cy="130" rx="35" ry="45" fill="#e2e8f0"/>
                <ellipse cx="100" cy="130" rx="30" ry="40" fill="#f8fafc"/>
                
                <!-- Helmet -->
                <circle cx="100" cy="70" r="40" fill="#e2e8f0"/>
                <circle cx="100" cy="70" r="35" fill="#1e293b"/>
                <circle cx="100" cy="70" r="30" fill="#0f172a"/>
                
                <!-- Visor Reflection -->
                <ellipse cx="90" cy="60" rx="10" ry="15" fill="#3b82f6" opacity="0.3"/>
                
                <!-- Backpack -->
                <rect x="135" y="100" width="20" height="50" rx="5" fill="#94a3b8"/>
                
                <!-- Arms -->
                <ellipse cx="55" cy="120" rx="15" ry="10" fill="#e2e8f0" transform="rotate(-30 55 120)"/>
                <ellipse cx="145" cy="120" rx="15" ry="10" fill="#e2e8f0" transform="rotate(30 145 120)"/>
                
                <!-- Legs -->
                <ellipse cx="85" cy="175" rx="12" ry="20" fill="#e2e8f0"/>
                <ellipse cx="115" cy="175" rx="12" ry="20" fill="#e2e8f0"/>
                
                <!-- Antenna -->
                <line x1="100" y1="30" x2="100" y2="15" stroke="#94a3b8" stroke-width="3"/>
                <circle cx="100" cy="12" r="5" fill="#ef4444">
                    <animate attributeName="opacity" values="1;0.3;1" dur="1s" repeatCount="indefinite"/>
                </circle>
            </svg>
        </div>
        
        <!-- Error Code -->
        <div class="error-code">404</div>
        
        <!-- Title -->
        <h1 class="title">
            {{ $locale == 'ar' ? 'عفواً! الصفحة غير موجودة' : 'Oops! Page Not Found' }}
        </h1>
        
        <!-- Description -->
        <p class="description">
            {{ $locale == 'ar' 
                ? 'يبدو أنك ضللت الطريق في الفضاء الرقمي. الصفحة التي تبحث عنها قد تكون انتقلت أو لم تعد موجودة.' 
                : 'Looks like you\'ve drifted into digital space. The page you\'re looking for may have moved or no longer exists.' }}
        </p>
        
        <!-- Buttons -->
        <div class="buttons">
            <a href="{{ url('/') }}" class="btn btn-primary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9,22 9,12 15,12 15,22"/>
                </svg>
                {{ $locale == 'ar' ? 'العودة للرئيسية' : 'Back to Home' }}
            </a>
            <button onclick="goBack()" class="btn btn-secondary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="19" y1="12" x2="5" y2="12"/>
                    <polyline points="12,19 5,12 12,5"/>
                </svg>
                {{ $locale == 'ar' ? 'الرجوع للخلف' : 'Go Back' }}
            </button>
        </div>
    </div>
    
    <script>
        // Go Back function - fallback to home if no history
        function goBack() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = '{{ url('/') }}';
            }
        }
        
        // Generate Stars
        const starsContainer = document.getElementById('stars');
        for (let i = 0; i < 100; i++) {
            const star = document.createElement('div');
            star.className = 'star';
            star.style.left = Math.random() * 100 + '%';
            star.style.top = Math.random() * 100 + '%';
            star.style.animationDelay = Math.random() * 3 + 's';
            star.style.animationDuration = (Math.random() * 2 + 2) + 's';
            starsContainer.appendChild(star);
        }
        
        // Generate Particles
        const particlesContainer = document.getElementById('particles');
        for (let i = 0; i < 15; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 15 + 's';
            particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
            particle.style.width = (Math.random() * 10 + 5) + 'px';
            particle.style.height = particle.style.width;
            particlesContainer.appendChild(particle);
        }
    </script>
</body>
</html>
