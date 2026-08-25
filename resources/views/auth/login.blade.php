<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>تسجيل الدخول — InvoicePro</title>
    <meta name="description" content="سجّل دخولك إلى لوحة تحكم InvoicePro لإدارة فواتيرك ومدفوعاتك">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --ink:        #0f1117;
            --ink-2:      #3d4150;
            --ink-3:      #7a7f94;
            --surface:    #ffffff;
            --surface-2:  #f6f7fb;
            --border:     #e4e6ed;
            --border-2:   #d0d3de;
            --accent:     #4361ee;
            --accent-d:   #3451d1;
            --accent-l:   #eef0fd;
            --success:    #0cad6c;
            --danger:     #e03e3e;
            --danger-l:   #fdf1f1;
            --panel-bg:   #111827;
        }

        html, body {
            height: 100%;
            font-family: 'IBM Plex Sans Arabic', 'Inter', sans-serif;
            background: var(--surface);
            color: var(--ink);
            -webkit-font-smoothing: antialiased;
        }

        /* ── LAYOUT ── */
        .page {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }

        /* ── LEFT — BRAND PANEL ── */
        .brand-panel {
            background: var(--panel-bg);
            position: relative;
            display: flex;
            flex-direction: column;
            padding: 48px 56px;
            overflow: hidden;
        }

        /* Subtle texture */
        .brand-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle at 20% 20%, rgba(67,97,238,.18) 0%, transparent 55%),
                radial-gradient(circle at 80% 80%, rgba(67,97,238,.10) 0%, transparent 50%);
            pointer-events: none;
        }

        /* Fine dot grid */
        .brand-panel::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255,255,255,.07) 1px, transparent 1px);
            background-size: 28px 28px;
            pointer-events: none;
        }

        .bp-top {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .logo-mark {
            width: 38px; height: 38px;
            background: var(--accent);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .logo-mark svg { width: 20px; height: 20px; color: #fff; }

        .logo-name {
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.3px;
        }

        .bp-body {
            position: relative;
            z-index: 2;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0 0 60px;
        }

        .bp-eyebrow {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .bp-eyebrow::before {
            content: '';
            display: block;
            width: 24px; height: 1.5px;
            background: var(--accent);
            border-radius: 2px;
        }

        .bp-headline {
            font-size: clamp(32px, 3vw, 46px);
            font-weight: 700;
            color: #fff;
            line-height: 1.18;
            letter-spacing: -1.5px;
            margin-bottom: 22px;
        }

        .bp-headline em {
            font-style: normal;
            color: var(--accent);
        }

        .bp-desc {
            font-size: 15px;
            line-height: 1.75;
            color: rgba(255,255,255,.52);
            max-width: 360px;
            margin-bottom: 44px;
        }



        /* ── RIGHT — FORM PANEL ── */
        .form-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 64px;
            background: var(--surface);
            position: relative;
            overflow-y: auto;
        }

        /* Subtle top-right decoration */
        .form-panel::before {
            content: '';
            position: absolute;
            top: -80px; left: -80px;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(67,97,238,.06), transparent 70%);
            pointer-events: none;
        }

        .form-box {
            width: 100%;
            max-width: 420px;
            animation: rise .5s cubic-bezier(.22,1,.36,1) both;
        }

        @keyframes rise {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Form header */
        .form-head { margin-bottom: 36px; }

        .form-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 100px;
            background: var(--accent-l);
            color: var(--accent);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .5px;
            margin-bottom: 18px;
        }

        .form-tag-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--accent);
            animation: blink 2.5s ease-in-out infinite;
        }

        @keyframes blink {
            0%,100% { opacity: 1; }
            50%      { opacity: .3; }
        }

        .form-title {
            font-size: 30px;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -1px;
            line-height: 1.1;
            margin-bottom: 8px;
        }

        .form-sub {
            font-size: 14px;
            color: var(--ink-3);
            line-height: 1.6;
        }

        /* Alerts */
        .alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 13px 15px;
            border-radius: 10px;
            font-size: 13.5px;
            line-height: 1.5;
            margin-bottom: 22px;
            animation: alertIn .35s ease;
        }

        @keyframes alertIn {
            from { opacity: 0; transform: translateY(-6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .alert-ok {
            background: #edfbf4;
            border: 1px solid #a7e8c8;
            color: #0a7d4e;
        }

        .alert-err {
            background: var(--danger-l);
            border: 1px solid #f5bebe;
            color: var(--danger);
        }

        .alert-icon { margin-top: 1px; flex-shrink: 0; }

        /* Field */
        .field { margin-bottom: 20px; }

        .field-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--ink-2);
            margin-bottom: 8px;
            display: block;
        }

        .field-wrap { position: relative; }

        .field-input {
            width: 100%;
            padding: 12px 44px 12px 16px;
            background: var(--surface-2);
            border: 1.5px solid var(--border);
            border-radius: 11px;
            font-size: 14.5px;
            font-family: inherit;
            color: var(--ink);
            outline: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
            -webkit-appearance: none;
        }

        .field-input::placeholder { color: var(--ink-3); opacity: .6; }

        .field-input:focus {
            background: var(--surface);
            border-color: var(--accent);
            box-shadow: 0 0 0 3.5px rgba(67,97,238,.12);
        }

        .field-input.err {
            border-color: var(--danger);
            box-shadow: 0 0 0 3px rgba(224,62,62,.10);
        }

        .field-icon {
            position: absolute;
            right: 14px;
            top: 50%; transform: translateY(-50%);
            color: var(--ink-3);
            pointer-events: none;
            transition: color .2s;
            display: flex;
        }

        .field-input:focus ~ .field-icon { color: var(--accent); }

        .pw-toggle {
            position: absolute;
            left: 13px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            cursor: pointer;
            color: var(--ink-3);
            padding: 4px;
            display: flex;
            transition: color .2s;
        }
        .pw-toggle:hover { color: var(--accent); }
        .has-toggle { padding-left: 44px !important; }

        .field-err {
            font-size: 12px;
            color: var(--danger);
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Options row */
        .options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 26px;
        }

        .check-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            user-select: none;
            font-size: 13.5px;
            color: var(--ink-2);
        }

        .check-label input[type="checkbox"] {
            appearance: none; -webkit-appearance: none;
            width: 17px; height: 17px;
            border: 1.5px solid var(--border-2);
            border-radius: 5px;
            background: var(--surface);
            cursor: pointer;
            position: relative;
            transition: all .2s;
            flex-shrink: 0;
        }

        .check-label input[type="checkbox"]:checked {
            background: var(--accent);
            border-color: var(--accent);
        }

        .check-label input[type="checkbox"]:checked::after {
            content: '';
            position: absolute;
            left: 4px; top: 1.5px;
            width: 5px; height: 9px;
            border: 2px solid #fff;
            border-top: none; border-left: none;
            transform: rotate(45deg);
        }

        .forgot {
            font-size: 13.5px;
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
            transition: color .2s;
        }
        .forgot:hover { color: var(--accent-d); text-decoration: underline; text-underline-offset: 3px; }

        /* Submit button */
        .btn-login {
            width: 100%;
            padding: 14px 20px;
            background: var(--accent);
            border: none;
            border-radius: 11px;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            letter-spacing: .2px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            position: relative;
            overflow: hidden;
            transition: background .2s, transform .15s, box-shadow .2s;
            box-shadow: 0 4px 14px rgba(67,97,238,.32);
        }

        .btn-login:hover {
            background: var(--accent-d);
            transform: translateY(-1px);
            box-shadow: 0 7px 20px rgba(67,97,238,.4);
        }

        .btn-login:active { transform: translateY(0); }
        .btn-login:disabled { opacity: .65; cursor: not-allowed; transform: none; }

        /* Shimmer */
        .btn-login::after {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,.18) 55%, transparent 70%);
            transform: translateX(-100%);
            transition: transform .55s ease;
        }
        .btn-login:hover::after { transform: translateX(100%); }

        .btn-spinner {
            display: none;
            width: 17px; height: 17px;
            border: 2px solid rgba(255,255,255,.35);
            border-top-color: #fff;
            border-radius: 50%;
            animation: sp .65s linear infinite;
        }
        @keyframes sp { to { transform: rotate(360deg); } }

        /* Divider */
        .divider {
            display: flex; align-items: center; gap: 12px;
            margin: 24px 0;
        }
        .divider-line { flex: 1; height: 1px; background: var(--border); }
        .divider-txt { font-size: 12px; color: var(--ink-3); font-weight: 500; letter-spacing: .8px; white-space: nowrap; }

        /* Footer note */
        .form-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 13px;
            color: var(--ink-3);
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 860px) {
            .page { grid-template-columns: 1fr; }
            .brand-panel { display: none; }
            .form-panel { padding: 36px 24px; min-height: 100vh; }
        }
    </style>
</head>
<body>
<div class="page">

    {{-- ═══════════ LEFT: BRAND PANEL ═══════════ --}}
    <div class="brand-panel">

        <div class="bp-top">
            <div class="logo-mark">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="3"/>
                    <path d="M8 12h8M8 8h5M8 16h3"/>
                </svg>
            </div>
            <span class="logo-name">InvoicePro</span>
        </div>

        <div class="bp-body">
            <div class="bp-eyebrow">منصة الفواتير الاحترافية</div>
            <h1 class="bp-headline">
                ادر فواتيرك<br>
                <em>بثقة واحترافية</em>
            </h1>
            <p class="bp-desc">
                كل ما تحتاجه من إنشاء فواتير ومتابعة مدفوعات وتقارير مالية — في مكان واحد، بواجهة سلسة وبسيطة.
            </p>

        </div>
    </div>

    {{-- ═══════════ RIGHT: FORM PANEL ═══════════ --}}
    <div class="form-panel">
        <div class="form-box">

            <div class="form-head">
                <div class="form-tag">
                    <span class="form-tag-dot"></span>
                    مرحباً بعودتك
                </div>
                <h2 class="form-title">تسجيل الدخول</h2>
                <p class="form-sub">أدخل بياناتك للوصول إلى لوحة التحكم</p>
            </div>

            {{-- Status message --}}
            @if (session('status'))
                <div class="alert alert-ok" role="alert">
                    <svg class="alert-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            {{-- Errors --}}
            @if ($errors->any())
                <div class="alert alert-err" role="alert">
                    <svg class="alert-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
                @csrf

                {{-- Email --}}
                <div class="field">
                    <label class="field-label" for="email">البريد الإلكتروني</label>
                    <div class="field-wrap">
                        <input
                            id="email"
                            type="email"
                            name="email"
                            class="field-input {{ $errors->has('email') ? 'err' : '' }}"
                            placeholder="you@company.com"
                            value="{{ old('email') }}"
                            required autofocus autocomplete="username" dir="ltr"
                        >
                        <span class="field-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </span>
                    </div>
                    @if ($errors->has('email'))
                        <div class="field-err">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                {{-- Password --}}
                <div class="field">
                    <label class="field-label" for="password">كلمة المرور</label>
                    <div class="field-wrap">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="field-input has-toggle {{ $errors->has('password') ? 'err' : '' }}"
                            placeholder="••••••••••"
                            required autocomplete="current-password" dir="ltr"
                        >
                        <span class="field-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </span>
                        <button type="button" class="pw-toggle" id="pwToggle" aria-label="إظهار/إخفاء كلمة المرور">
                            <svg id="eyeIcon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    @if ($errors->has('password'))
                        <div class="field-err">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>

                {{-- Options --}}
                <div class="options">
                    <label class="check-label" for="remember_me">
                        <input type="checkbox" id="remember_me" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        تذكرني
                    </label>
                    @if (Route::has('password.request'))
                        <a class="forgot" href="{{ route('password.request') }}">نسيت كلمة المرور؟</a>
                    @endif
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-login" id="submitBtn">
                    <span class="btn-spinner" id="btnSpinner"></span>
                    <svg id="btnIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                        <polyline points="10 17 15 12 10 7"/>
                        <line x1="15" y1="12" x2="3" y2="12"/>
                    </svg>
                    <span id="btnText">دخول الآن</span>
                </button>

            </form>

            <div class="form-footer">
                &copy; {{ date('Y') }} InvoicePro · جميع الحقوق محفوظة
            </div>

        </div>
    </div>

</div>

<script>
/* Password toggle */
(function () {
    var btn  = document.getElementById('pwToggle');
    var inp  = document.getElementById('password');
    var icon = document.getElementById('eyeIcon');

    var eyeOpen = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    var eyeSlash = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';

    btn.addEventListener('click', function () {
        var isPass = inp.type === 'password';
        inp.type = isPass ? 'text' : 'password';
        icon.innerHTML = isPass ? eyeSlash : eyeOpen;
    });
})();

/* Form submit */
document.getElementById('loginForm').addEventListener('submit', function (e) {
    var email = document.getElementById('email').value.trim();
    var pass  = document.getElementById('password').value;
    var ok    = true;

    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        document.getElementById('email').classList.add('err');
        ok = false;
    } else {
        document.getElementById('email').classList.remove('err');
    }

    if (!pass) {
        document.getElementById('password').classList.add('err');
        ok = false;
    } else {
        document.getElementById('password').classList.remove('err');
    }

    if (!ok) { e.preventDefault(); return; }

    var btn     = document.getElementById('submitBtn');
    var spinner = document.getElementById('btnSpinner');
    var icon    = document.getElementById('btnIcon');
    var txt     = document.getElementById('btnText');

    btn.disabled         = true;
    spinner.style.display = 'block';
    icon.style.display    = 'none';
    txt.textContent       = 'جارٍ الدخول...';
});
</script>

</body>
</html>
