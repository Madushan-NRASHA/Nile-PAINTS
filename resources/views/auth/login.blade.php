<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#132b27">
    <title>{{ $isRegister ? 'Create account' : 'Sign in' }} | Nile Paints</title>
    <style>
        :root {
            color-scheme: light;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #172b27;
            background: #f6f7f3;
            font-synthesis: none;
            text-rendering: optimizeLegibility;
        }

        * { box-sizing: border-box; }

        body {
            min-width: 320px;
            min-height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            padding: 32px;
            background:
                radial-gradient(ellipse at 8% 5%, rgba(224, 237, 211, .64), transparent 32%),
                #f6f7f3;
        }

        .login-shell {
            width: min(1080px, 100%);
            min-height: 650px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            overflow: hidden;
            border: 1px solid #e9ece5;
            border-radius: 24px;
            background: #fff;
            box-shadow: 0 28px 80px rgba(25, 46, 39, .12);
        }

        .brand-panel {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            padding: 44px 48px;
            color: #fff;
            background: #173832;
        }

        .brand-panel::before,
        .brand-panel::after {
            position: absolute;
            content: "";
            pointer-events: none;
            border-radius: 50%;
        }

        .brand-panel::before {
            width: 390px;
            height: 390px;
            right: -128px;
            top: 148px;
            border: 1px solid rgba(236, 245, 222, .14);
            box-shadow: 0 0 0 38px rgba(236, 245, 222, .035), 0 0 0 78px rgba(236, 245, 222, .025);
        }

        .brand-panel::after {
            width: 170px;
            height: 170px;
            right: 74px;
            top: 262px;
            background: linear-gradient(145deg, #d9e7a6, #b6c978);
            opacity: .94;
        }

        .brand,
        .brand-copy,
        .brand-footer { position: relative; z-index: 1; }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: inherit;
            text-decoration: none;
        }

        .brand-mark {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, .3);
            border-radius: 13px;
            color: #d9e7a6;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .brand-name { font-size: 15px; font-weight: 750; letter-spacing: .11em; }
        .brand-caption { margin-top: 3px; color: rgba(255, 255, 255, .61); font-size: 10px; letter-spacing: .2em; }

        .brand-copy { max-width: 390px; margin: auto 0; padding: 92px 0 98px; }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: #d9e7a6;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .eyebrow::before { width: 20px; height: 1px; content: ""; background: currentColor; }

        .brand-copy h1 {
            max-width: 370px;
            margin: 20px 0 16px;
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(38px, 4.3vw, 54px);
            font-weight: 400;
            letter-spacing: -.045em;
            line-height: 1.08;
        }

        .brand-copy p { max-width: 340px; margin: 0; color: rgba(255, 255, 255, .7); font-size: 14px; line-height: 1.8; }
        .brand-footer { color: rgba(255, 255, 255, .52); font-size: 11px; letter-spacing: .04em; }

        .form-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 56px;
        }

        .form-content { width: min(100%, 360px); }

        .mobile-brand { display: none; }

        .form-heading { margin: 0; font-family: Georgia, "Times New Roman", serif; font-size: 36px; font-weight: 400; letter-spacing: -.04em; }
        .form-intro { margin: 10px 0 34px; color: #77817c; font-size: 14px; line-height: 1.6; }
        .field { margin-bottom: 21px; }
        .account-prompt { margin: 23px 0 0; color: #77817c; font-size: 12px; text-align: center; }
        .account-prompt a { color: #315b40; font-weight: 700; text-decoration: none; }
        .account-prompt a:hover { text-decoration: underline; }

        label { display: block; margin-bottom: 9px; color: #34443e; font-size: 12px; font-weight: 700; }

        .input-wrap { position: relative; }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            height: 50px;
            padding: 0 15px;
            border: 1px solid #dfe4dc;
            border-radius: 9px;
            outline: none;
            color: #172b27;
            background: #fff;
            font: inherit;
            font-size: 14px;
            transition: border-color .15s, box-shadow .15s;
        }

        input::placeholder { color: #a4ada7; }
        input:focus { border-color: #537c59; box-shadow: 0 0 0 3px rgba(83, 124, 89, .12); }
        input[aria-invalid="true"] { border-color: #c74747; }
        .password-input { padding-right: 58px !important; }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 12px;
            padding: 6px;
            transform: translateY(-50%);
            border: 0;
            color: #78847d;
            background: transparent;
            cursor: pointer;
            font: inherit;
            font-size: 11px;
            font-weight: 700;
        }

        .toggle-password:hover { color: #173832; }
        .field-error { margin: 7px 0 0; color: #b53636; font-size: 12px; }

        .form-options { display: flex; align-items: center; margin: 2px 0 25px; }
        .remember { display: inline-flex; align-items: center; gap: 9px; margin: 0; color: #68746d; font-size: 12px; font-weight: 500; cursor: pointer; }
        .remember input { width: 15px; height: 15px; margin: 0; accent-color: #315b40; }

        .submit-button {
            width: 100%;
            min-height: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border: 0;
            border-radius: 9px;
            color: #fff;
            background: #234b39;
            cursor: pointer;
            font: inherit;
            font-size: 13px;
            font-weight: 700;
            transition: background .15s, transform .15s;
        }

        .submit-button:hover { transform: translateY(-1px); background: #193e2d; }
        .submit-button:focus-visible, .toggle-password:focus-visible { outline: 3px solid #a8bf73; outline-offset: 3px; }
        .security-note { display: flex; justify-content: center; align-items: center; gap: 7px; margin-top: 23px; color: #89928d; font-size: 11px; }
        .security-note svg { flex: 0 0 auto; }

        @media (max-width: 760px) {
            body { padding: 18px; }
            .login-shell { max-width: 480px; min-height: auto; grid-template-columns: 1fr; border-radius: 19px; }
            .brand-panel { display: none; }
            .form-panel { padding: 40px 30px 36px; }
            .mobile-brand { display: inline-flex; align-items: center; gap: 10px; margin-bottom: 38px; }
            .mobile-brand .brand-mark { border-color: #dfe8dc; color: #315b40; }
            .mobile-brand .brand-name { color: #173832; }
            .mobile-brand .brand-caption { color: #89928d; }
        }

        @media (max-width: 380px) {
            body { padding: 12px; }
            .form-panel { padding: 32px 22px; }
        }
    </style>
</head>
<body>
    <main class="login-shell">
        <section class="brand-panel" aria-label="About Nile Paints">
            <a class="brand" href="{{ route('login') }}" aria-label="Nile Paints home">
                <span class="brand-mark" aria-hidden="true">N</span>
                <span>
                    <span class="brand-name">NILE PAINTS</span>
                    <span class="brand-caption">COLOUR YOUR WORLD</span>
                </span>
            </a>

            <div class="brand-copy">
                <span class="eyebrow">A fresh perspective</span>
                <h1>Make every space feel like yours.</h1>
                <p>Welcome to your Nile Paints workspace. Sign in to manage your business with confidence.</p>
            </div>

            <div class="brand-footer">Thoughtfully made for the places that matter.</div>
        </section>

        <section class="form-panel" aria-labelledby="login-heading">
            <div class="form-content">
                <a class="mobile-brand" href="{{ route('login') }}" aria-label="Nile Paints home">
                    <span class="brand-mark" aria-hidden="true">N</span>
                    <span>
                        <span class="brand-name">NILE PAINTS</span>
                        <span class="brand-caption">COLOUR YOUR WORLD</span>
                    </span>
                </a>

                <h2 class="form-heading" id="login-heading">{{ $isRegister ? 'Create your account' : 'Welcome back' }}</h2>
                <p class="form-intro">{{ $isRegister ? 'Join Nile Paints to manage your business workspace.' : 'Sign in with your account details to continue.' }}</p>

                <form method="POST" action="{{ $isRegister ? route('register.store') : route('login.store') }}">
                    @csrf

                    @if ($isRegister)
                        <div class="field">
                            <label for="name">Full name</label>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name') }}"
                                placeholder="Your name"
                                autocomplete="name"
                                required
                                autofocus
                                @error('name') aria-invalid="true" aria-describedby="name-error" @enderror
                            >
                            @error('name')
                                <p class="field-error" id="name-error" role="alert">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <div class="field">
                        <label for="email">Email address</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            placeholder="you@example.com"
                            autocomplete="username"
                            required
                            @if (! $isRegister) autofocus @endif
                            @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                        >
                        @error('email')
                            <p class="field-error" id="email-error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <div class="input-wrap">
                            <input
                                class="password-input"
                                id="password"
                                name="password"
                                type="password"
                                placeholder="{{ $isRegister ? 'Create a password (8+ characters)' : 'Enter your password' }}"
                                autocomplete="{{ $isRegister ? 'new-password' : 'current-password' }}"
                                required
                                @error('password') aria-invalid="true" aria-describedby="password-error" @enderror
                            >
                            <button class="toggle-password" type="button" aria-controls="password" aria-label="Show password" aria-pressed="false">Show</button>
                        </div>
                        @error('password')
                            <p class="field-error" id="password-error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    @if ($isRegister)
                        <div class="field">
                            <label for="password_confirmation">Confirm password</label>
                            <div class="input-wrap">
                                <input
                                    class="password-input"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    type="password"
                                    placeholder="Enter your password again"
                                    autocomplete="new-password"
                                    required
                                    @error('password_confirmation') aria-invalid="true" aria-describedby="password-confirmation-error" @enderror
                                >
                                <button class="toggle-password" type="button" aria-controls="password_confirmation" aria-label="Show password" aria-pressed="false">Show</button>
                            </div>
                            @error('password_confirmation')
                                <p class="field-error" id="password-confirmation-error" role="alert">{{ $message }}</p>
                            @enderror
                        </div>
                    @else
                        <div class="form-options">
                            <label class="remember" for="remember">
                                <input id="remember" name="remember" type="checkbox" value="1" @checked(old('remember'))>
                                <span>Keep me signed in</span>
                            </label>
                        </div>
                    @endif

                    <button class="submit-button" type="submit">
                        <span>{{ $isRegister ? 'Create account' : 'Sign in to your account' }}</span>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                            <path d="M3.25 8h9.5m-4-4 4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </form>

                <p class="account-prompt">
                    {{ $isRegister ? 'Already have an account?' : 'New to Nile Paints?' }}
                    <a href="{{ $isRegister ? route('login') : route('register') }}">{{ $isRegister ? 'Sign in' : 'Create an account' }}</a>
                </p>

                <div class="security-note">
                    <svg width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M8 1.75 13 3.5v3.75c0 3.1-2.1 5.8-5 7-2.9-1.2-5-3.9-5-7V3.5l5-1.75Z" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round"/>
                        <path d="m6 7.75 1.35 1.35L10.25 6.2" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>{{ $isRegister ? 'Your account details are protected and secure' : 'Your sign-in is protected and secure' }}</span>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.querySelectorAll('.toggle-password').forEach((passwordToggle) => {
            const passwordInput = document.getElementById(passwordToggle.getAttribute('aria-controls'));

            passwordToggle.addEventListener('click', () => {
                const isVisible = passwordInput.type === 'text';
                passwordInput.type = isVisible ? 'password' : 'text';
                passwordToggle.textContent = isVisible ? 'Show' : 'Hide';
                passwordToggle.setAttribute('aria-label', isVisible ? 'Show password' : 'Hide password');
                passwordToggle.setAttribute('aria-pressed', String(!isVisible));
            });
        });
    </script>
</body>
</html>
