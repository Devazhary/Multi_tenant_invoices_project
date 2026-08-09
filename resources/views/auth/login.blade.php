<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>تسجيل الدخول Invoice Pro</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --clr-bg:        #060612;
            --clr-surface:   #0d0d24;
            --clr-card:      rgba(14, 14, 35, 0.82);
            --clr-border:    rgba(120, 100, 255, 0.18);
            --clr-primary:   #7c5cfc;
            --clr-primary-2: #9b7fff;
            --clr-accent:    #f5a623;
            --clr-accent-2:  #ff6b6b;
            --clr-text:      #e8e6ff;
            --clr-muted:     #8887ab;
            --clr-success:   #00d9a3;
        }

        html, body {
            height: 100%;
            font-family: 'Cairo', 'Inter', sans-serif;
            background: var(--clr-bg);
            color: var(--clr-text);
            overflow: hidden;
        }

        /* ═══════════════ ANIMATED BACKGROUND ═══════════════ */
        .bg-scene {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
        }

        .bg-scene::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 30%, rgba(124, 92, 252, 0.22) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 80% 70%, rgba(245, 166, 35, 0.12) 0%, transparent 60%),
                radial-gradient(ellipse 50% 40% at 50% 100%, rgba(0, 217, 163, 0.08) 0%, transparent 60%),
                linear-gradient(180deg, #060612 0%, #0a0820 50%, #060612 100%);
        }

        .bg-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(124, 92, 252, 0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(124, 92, 252, 0.06) 1px, transparent 1px);
            background-size: 60px 60px;
            animation: gridDrift 25s linear infinite;
        }

        @keyframes gridDrift {
            from { transform: translateY(0); }
            to   { transform: translateY(60px); }
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            animation: orbFloat 12s ease-in-out infinite;
        }

        .orb-1 {
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(124, 92, 252, 0.35), transparent 70%);
            top: -15%; left: -10%;
            animation-duration: 15s;
        }
        .orb-2 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(245, 166, 35, 0.2), transparent 70%);
            bottom: -10%; right: -5%;
            animation-duration: 20s;
            animation-delay: -5s;
        }
        .orb-3 {
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(0, 217, 163, 0.15), transparent 70%);
            top: 50%; right: 20%;
            animation-duration: 18s;
            animation-delay: -8s;
        }

        @keyframes orbFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33%       { transform: translate(40px, -30px) scale(1.08); }
            66%       { transform: translate(-20px, 25px) scale(0.95); }
        }

        .particles {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 3px; height: 3px;
            border-radius: 50%;
            background: var(--clr-primary);
            opacity: 0;
            animation: particleFly 8s ease-in-out infinite;
        }

        @keyframes particleFly {
            0%   { opacity: 0; transform: translateY(100vh) rotate(0deg); }
            10%  { opacity: 1; }
            90%  { opacity: 0.8; }
            100% { opacity: 0; transform: translateY(-20px) rotate(720deg); }
        }

        /* ═══════════════ MAIN LAYOUT ═══════════════ */
        .login-wrapper {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }

        /* ═══════════════ LEFT — HERO ═══════════════ */
        .hero-panel {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 50px;
            overflow: hidden;
        }

        .hero-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(124, 92, 252, 0.12), rgba(245, 166, 35, 0.06));
            border-right: 1px solid rgba(124, 92, 252, 0.15);
        }

        .hero-brand {
            position: absolute;
            top: 40px;
            left: 50px;
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 2;
        }

        .brand-icon {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, var(--clr-primary), #4e35c1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 20px rgba(124, 92, 252, 0.5);
            animation: brandPulse 3s ease-in-out infinite;
        }

        .brand-icon i { font-size: 22px; color: #fff; }

        @keyframes brandPulse {
            0%, 100% { box-shadow: 0 0 20px rgba(124, 92, 252, 0.5); }
            50%       { box-shadow: 0 0 40px rgba(124, 92, 252, 0.9), 0 0 80px rgba(124, 92, 252, 0.3); }
        }

        .brand-name {
            font-size: 22px;
            font-weight: 800;
            background: linear-gradient(135deg, #fff, var(--clr-primary-2));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 480px;
        }

        .hero-image-wrapper {
            display: inline-block;
            position: relative;
            width: 320px;
            height: 320px;
            margin-bottom: 40px;
        }

        .hero-image-wrapper::before {
            content: '';
            position: absolute;
            inset: -15px;
            border-radius: 50%;
            background: conic-gradient(
                from 0deg,
                transparent 0%,
                rgba(124, 92, 252, 0.5) 20%,
                transparent 40%,
                rgba(245, 166, 35, 0.4) 60%,
                transparent 80%,
                rgba(124, 92, 252, 0.5) 100%
            );
            animation: ringRotate 6s linear infinite;
            filter: blur(8px);
        }

        @keyframes ringRotate {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        .hero-image {
            width: 320px;
            height: 320px;
            object-fit: cover;
            border-radius: 50%;
            position: relative;
            z-index: 1;
            border: 2px solid rgba(124, 92, 252, 0.3);
            animation: heroFloat 6s ease-in-out infinite;
            box-shadow: 0 0 60px rgba(124, 92, 252, 0.3), inset 0 0 40px rgba(124, 92, 252, 0.1);
        }

        @keyframes heroFloat {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-18px); }
        }

        .floating-badge {
            position: absolute;
            background: rgba(14, 14, 35, 0.9);
            border: 1px solid rgba(120, 100, 255, 0.18);
            border-radius: 16px;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            backdrop-filter: blur(20px);
            box-shadow: 0 8px 32px rgba(0,0,0,0.4);
            white-space: nowrap;
            z-index: 2;
        }

        .badge-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .badge-text-label { font-size: 11px; color: var(--clr-muted); line-height: 1; margin-bottom: 2px; }
        .badge-text-value { font-size: 14px; font-weight: 700; color: var(--clr-text); line-height: 1; }

        .fb-1 { top: 8%; left: -25px; animation: badgeFloat1 5s ease-in-out infinite; }
        .fb-2 { bottom: 12%; right: -35px; animation: badgeFloat2 6s ease-in-out infinite; }
        .fb-3 { top: 50%; left: -45px; transform: translateY(-50%); animation: badgeFloat3 7s ease-in-out infinite; }

        @keyframes badgeFloat1 {
            0%, 100% { transform: translateY(0px) rotate(-2deg); }
            50%       { transform: translateY(-12px) rotate(1deg); }
        }
        @keyframes badgeFloat2 {
            0%, 100% { transform: translateY(0px) rotate(1deg); }
            50%       { transform: translateY(-15px) rotate(-1deg); }
        }
        @keyframes badgeFloat3 {
            0%, 100% { transform: translateY(-50%) rotate(0deg); }
            50%       { transform: translateY(calc(-50% - 10px)) rotate(-2deg); }
        }

        .hero-headline {
            font-size: 36px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 16px;
            background: linear-gradient(135deg, #fff 30%, var(--clr-primary-2) 70%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtext {
            font-size: 16px;
            color: var(--clr-muted);
            line-height: 1.7;
            max-width: 360px;
            margin: 0 auto;
        }

        .feature-pills {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 32px;
        }

        .pill {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 8px 16px;
            border-radius: 50px;
            background: rgba(124, 92, 252, 0.08);
            border: 1px solid rgba(124, 92, 252, 0.2);
            font-size: 13px;
            color: var(--clr-primary-2);
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .pill:hover {
            background: rgba(124, 92, 252, 0.15);
            border-color: rgba(124, 92, 252, 0.4);
            transform: translateY(-2px);
        }

        .pill i { font-size: 15px; }

        /* ═══════════════ RIGHT — FORM ═══════════════ */
        .form-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 60px;
            position: relative;
            overflow-y: auto;
        }

        .form-container {
            width: 100%;
            max-width: 440px;
            animation: formEnter 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes formEnter {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .form-card {
            background: rgba(14, 14, 35, 0.82);
            border: 1px solid rgba(120, 100, 255, 0.18);
            border-radius: 28px;
            padding: 48px 44px;
            backdrop-filter: blur(40px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.3), 0 20px 80px rgba(0,0,0,0.5), inset 0 1px 0 rgba(255,255,255,0.06);
            position: relative;
            overflow: hidden;
        }

        .form-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(124, 92, 252, 0.6), rgba(245, 166, 35, 0.4), transparent);
            animation: shimmerLine 4s ease-in-out infinite;
        }

        @keyframes shimmerLine {
            0%   { opacity: 0.4; }
            50%  { opacity: 1; }
            100% { opacity: 0.4; }
        }

        .form-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .form-greeting {
            font-size: 13px;
            font-weight: 600;
            color: var(--clr-primary-2);
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .greeting-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--clr-primary);
            animation: dotPulse 2s ease-in-out infinite;
        }

        @keyframes dotPulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.5; transform: scale(0.7); }
        }

        .form-title {
            font-size: 34px;
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
            margin-bottom: 8px;
            letter-spacing: -1px;
        }

        .form-subtitle {
            font-size: 14px;
            color: var(--clr-muted);
            line-height: 1.6;
        }

        .alert-box {
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: alertSlide 0.4s ease;
        }

        @keyframes alertSlide {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .alert-success {
            background: rgba(0, 217, 163, 0.1);
            border: 1px solid rgba(0, 217, 163, 0.3);
            color: var(--clr-success);
        }

        .alert-error {
            background: rgba(255, 107, 107, 0.1);
            border: 1px solid rgba(255, 107, 107, 0.3);
            color: var(--clr-accent-2);
        }

        .form-group { margin-bottom: 22px; }

        .form-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            color: var(--clr-muted);
            margin-bottom: 9px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .label-icon { font-size: 14px; color: var(--clr-primary); }

        .input-wrapper { position: relative; }

        .form-input {
            width: 100%;
            padding: 15px 50px 15px 18px;
            background: rgba(255, 255, 255, 0.04);
            border: 1.5px solid rgba(120, 100, 255, 0.2);
            border-radius: 14px;
            color: #fff;
            font-size: 15px;
            font-family: inherit;
            transition: all 0.3s ease;
            outline: none;
            -webkit-appearance: none;
        }

        .form-input:focus {
            background: rgba(124, 92, 252, 0.07);
            border-color: var(--clr-primary);
            box-shadow: 0 0 0 4px rgba(124, 92, 252, 0.12), 0 0 20px rgba(124, 92, 252, 0.15);
        }

        .form-input::placeholder { color: rgba(136, 135, 171, 0.5); }

        .form-input.is-error {
            border-color: var(--clr-accent-2);
            box-shadow: 0 0 0 4px rgba(255, 107, 107, 0.1);
        }

        .input-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: var(--clr-muted);
            transition: color 0.3s ease;
            pointer-events: none;
        }

        .form-input:focus + .input-icon { color: var(--clr-primary); }

        .password-toggle {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--clr-muted);
            font-size: 18px;
            transition: color 0.3s;
            padding: 4px;
            display: flex;
            align-items: center;
        }

        .password-toggle:hover { color: var(--clr-primary); }

        .input-with-toggle { padding-left: 48px !important; }

        .field-error {
            font-size: 12px;
            color: var(--clr-accent-2);
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .options-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 9px;
            cursor: pointer;
            font-size: 13px;
            color: var(--clr-muted);
            user-select: none;
        }

        .remember-label input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 18px; height: 18px;
            border: 1.5px solid rgba(120, 100, 255, 0.3);
            border-radius: 5px;
            background: transparent;
            cursor: pointer;
            position: relative;
            transition: all 0.2s;
            flex-shrink: 0;
        }

        .remember-label input[type="checkbox"]:checked {
            background: var(--clr-primary);
            border-color: var(--clr-primary);
        }

        .remember-label input[type="checkbox"]:checked::after {
            content: '';
            position: absolute;
            left: 4px; top: 1px;
            width: 6px; height: 10px;
            border: 2px solid #fff;
            border-top: none;
            border-left: none;
            transform: rotate(45deg);
        }

        .forgot-link {
            font-size: 13px;
            color: var(--clr-primary-2);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
            padding: 4px 0;
            border-bottom: 1px solid transparent;
        }

        .forgot-link:hover { color: #fff; border-bottom-color: var(--clr-primary); }

        .btn-submit {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--clr-primary) 0%, #4e35c1 100%);
            border: none;
            border-radius: 14px;
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            letter-spacing: 0.3px;
            box-shadow: 0 8px 25px rgba(124, 92, 252, 0.4);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 40px rgba(124, 92, 252, 0.55);
        }

        .btn-submit:active { transform: translateY(0); }

        .btn-submit::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, transparent 60%);
            transform: translateX(-100%);
            transition: transform 0.5s ease;
        }

        .btn-submit:hover::after { transform: translateX(100%); }
        .btn-submit:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }

        .btn-spinner {
            display: none;
            width: 18px; height: 18px;
            border: 2.5px solid rgba(255,255,255,0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .divider {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 28px 0;
        }

        .divider-line {
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(120, 100, 255, 0.25), transparent);
        }

        .divider-text {
            font-size: 12px;
            color: var(--clr-muted);
            white-space: nowrap;
            font-weight: 500;
            letter-spacing: 1px;
        }

        .social-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 28px;
        }

        .btn-social {
            padding: 12px 14px;
            background: rgba(255, 255, 255, 0.04);
            border: 1.5px solid rgba(120, 100, 255, 0.18);
            border-radius: 12px;
            color: var(--clr-text);
            font-size: 13.5px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-social:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(120, 100, 255, 0.35);
            transform: translateY(-2px);
        }

        .btn-social svg { width: 18px; height: 18px; flex-shrink: 0; }

        .signup-text {
            text-align: center;
            font-size: 14px;
            color: var(--clr-muted);
            margin-top: 8px;
        }

        .signup-link {
            color: var(--clr-primary-2);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .signup-link:hover { color: #fff; text-decoration: underline; text-underline-offset: 3px; }

        .fade-in { animation: fadeIn 0.6s ease both; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
        .delay-5 { animation-delay: 0.5s; }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--clr-bg); }
        ::-webkit-scrollbar-thumb { background: rgba(124, 92, 252, 0.3); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(124, 92, 252, 0.6); }

        @media (max-width: 900px) {
            html, body { overflow: auto; }
            .login-wrapper { grid-template-columns: 1fr; }
            .hero-panel { display: none; }
            .form-panel { padding: 30px 24px; min-height: 100vh; }
            .form-card { padding: 36px 28px; }
        }
    </style>
</head>
<body>

<!-- BACKGROUND -->
<div class="bg-scene">
    <div class="bg-grid"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="particles" id="particles"></div>
</div>

<!-- MAIN WRAPPER -->
<div class="login-wrapper">

    <!-- LEFT — HERO PANEL -->
    <div class="hero-panel">

        <div class="hero-brand">
            <div class="brand-icon">
                <i class="ph-bold ph-invoice"></i>
            </div>
            <span class="brand-name">InvoicePro</span>
        </div>

        <div class="hero-content">

            <div class="hero-image-wrapper">

                <img src="{{ asset('assets/img/media/login-hero.png') }}"
                     alt="Finance Dashboard Illustration"
                     class="hero-image"
                     id="heroImg"
                     onerror="this.style.display='none'; document.getElementById('hero-fallback').style.display='flex'">

                <div id="hero-fallback" style="display:none; width:320px; height:320px; border-radius:50%; background:linear-gradient(135deg,rgba(124,92,252,0.2),rgba(245,166,35,0.1)); border:2px solid rgba(124,92,252,0.3); align-items:center; justify-content:center; position:relative; z-index:1; animation: heroFloat 6s ease-in-out infinite;">
                    <i class="ph-bold ph-chart-line-up" style="font-size:120px; background:linear-gradient(135deg,#7c5cfc,#f5a623); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent;"></i>
                </div>


            </div>

            <h1 class="hero-headline">
                إدارة مالية<br>ذكية وفعّالة
            </h1>
            <p class="hero-subtext">
                منصة متكاملة لإدارة الفواتير والعملاء وتتبع المدفوعات بكل سهولة ويسر
            </p>

            <div class="feature-pills">
                <div class="pill"><i class="ph-bold ph-shield-check"></i> آمن 100%</div>
                <div class="pill"><i class="ph-bold ph-lightning"></i> سريع وفوري</div>
                <div class="pill"><i class="ph-bold ph-cloud-check"></i> سحابي</div>
            </div>
        </div>
    </div>

    <!-- RIGHT — FORM PANEL -->
    <div class="form-panel">
        <div class="form-container">
            <div class="form-card">

                <div class="form-header fade-in">
                    <div class="form-greeting">
                        <span class="greeting-dot"></span>
                        مرحباً بعودتك
                        <span class="greeting-dot"></span>
                    </div>
                    <h2 class="form-title">تسجيل الدخول</h2>
                    <p class="form-subtitle">أدخل بياناتك للوصول إلى لوحة التحكم</p>
                </div>

                @if (session('status'))
                    <div class="alert-box alert-success">
                        <i class="ph-bold ph-check-circle" style="font-size:18px; flex-shrink:0;"></i>
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-box alert-error">
                        <i class="ph-bold ph-warning-circle" style="font-size:18px; flex-shrink:0;"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
                    @csrf

                    <!-- Email -->
                    <div class="form-group fade-in delay-1">
                        <label class="form-label" for="email">
                            <i class="ph-bold ph-envelope label-icon"></i>
                            البريد الإلكتروني
                        </label>
                        <div class="input-wrapper">
                            <input
                                id="email"
                                type="email"
                                name="email"
                                class="form-input {{ $errors->has('email') ? 'is-error' : '' }}"
                                placeholder="example@company.com"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                dir="ltr"
                            >
                            <i class="ph-bold ph-envelope input-icon"></i>
                        </div>
                        @if ($errors->has('email'))
                            <div class="field-error">
                                <i class="ph-bold ph-x-circle"></i>
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>

                    <!-- Password -->
                    <div class="form-group fade-in delay-2">
                        <label class="form-label" for="password">
                            <i class="ph-bold ph-lock label-icon"></i>
                            كلمة المرور
                        </label>
                        <div class="input-wrapper">
                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="form-input input-with-toggle {{ $errors->has('password') ? 'is-error' : '' }}"
                                placeholder="••••••••••"
                                required
                                autocomplete="current-password"
                                dir="ltr"
                            >
                            <i class="ph-bold ph-lock input-icon"></i>
                            <button type="button" class="password-toggle" id="togglePassword" aria-label="إظهار/إخفاء كلمة المرور">
                                <i class="ph-bold ph-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @if ($errors->has('password'))
                            <div class="field-error">
                                <i class="ph-bold ph-x-circle"></i>
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>

                    <!-- Options row -->
                    <div class="options-row fade-in delay-3">
                        <label class="remember-label">
                            <input type="checkbox" name="remember" id="remember_me" {{ old('remember') ? 'checked' : '' }}>
                            تذكرني
                        </label>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn-submit fade-in delay-4" id="submitBtn">
                        <span class="btn-spinner" id="btnSpinner"></span>
                        <i class="ph-bold ph-sign-in" id="btnIcon"></i>
                        <span id="btnText">دخول الآن</span>
                    </button>
                </form>




            </div>
        </div>
    </div>

</div>

<script>
    /* Particles */
    (function() {
        const container = document.getElementById('particles');
        const colors = ['#7c5cfc', '#f5a623', '#00d9a3', '#9b7fff', '#ff6b6b'];
        for (let i = 0; i < 50; i++) {
            const p = document.createElement('div');
            p.className = 'particle';
            const size = Math.random() * 3 + 1;
            p.style.cssText = [
                'left:' + (Math.random() * 100) + '%',
                'width:' + size + 'px',
                'height:' + size + 'px',
                'background:' + colors[Math.floor(Math.random() * colors.length)],
                'animation-delay:' + (Math.random() * 12) + 's',
                'animation-duration:' + (6 + Math.random() * 8) + 's',
                'opacity:0',
                'border-radius:50%'
            ].join(';');
            container.appendChild(p);
        }
    })();

    /* Password toggle */
    document.getElementById('togglePassword').addEventListener('click', function() {
        var inp = document.getElementById('password');
        var icon = document.getElementById('toggleIcon');
        if (inp.type === 'password') {
            inp.type = 'text';
            icon.className = 'ph-bold ph-eye-slash';
        } else {
            inp.type = 'password';
            icon.className = 'ph-bold ph-eye';
        }
    });

    /* Form submit */
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        var email = document.getElementById('email').value.trim();
        var pass  = document.getElementById('password').value;
        var ok = true;

        if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            document.getElementById('email').classList.add('is-error');
            ok = false;
        } else {
            document.getElementById('email').classList.remove('is-error');
        }

        if (!pass) {
            document.getElementById('password').classList.add('is-error');
            ok = false;
        } else {
            document.getElementById('password').classList.remove('is-error');
        }

        if (!ok) { e.preventDefault(); return; }

        var btn     = document.getElementById('submitBtn');
        var spinner = document.getElementById('btnSpinner');
        var icon    = document.getElementById('btnIcon');
        var txt     = document.getElementById('btnText');

        btn.disabled         = true;
        spinner.style.display = 'block';
        icon.style.display    = 'none';
        txt.textContent       = 'جاري الدخول...';
    });

    /* Mouse parallax */
    document.addEventListener('mousemove', function(e) {
        var img = document.getElementById('heroImg') || document.getElementById('hero-fallback');
        if (!img) return;
        var cx = window.innerWidth / 2;
        var cy = window.innerHeight / 2;
        var dx = (e.clientX - cx) / cx;
        var dy = (e.clientY - cy) / cy;
        img.style.transform = 'translateY(0) rotateX(' + (dy * -4) + 'deg) rotateY(' + (dx * 4) + 'deg)';
    });
</script>

</body>
</html>
