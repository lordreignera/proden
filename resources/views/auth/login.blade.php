<x-guest-layout>
    <style>
        :root {
            --proden-red: #c41e3a;
            --proden-dark: #7c0f24;
            --proden-gold: #e8a020;
            --proden-ink: #1f2937;
            --proden-mist: #f6f8fc;
        }

        .auth-shell {
            min-height: 100vh;
            background: radial-gradient(circle at 20% 15%, #fde9ee 0%, #f7f9ff 35%, #ffffff 70%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .auth-frame {
            width: min(1020px, 100%);
            background: #fff;
            border: 1px solid #ecedf3;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 30px 70px rgba(25, 35, 58, 0.14);
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
        }

        .auth-brand {
            background: linear-gradient(160deg, #8b0000 0%, #c41e3a 60%, #dd3553 100%);
            color: #fff;
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .auth-brand::before,
        .auth-brand::after {
            content: '';
            position: absolute;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            pointer-events: none;
        }

        .auth-brand::before {
            width: 240px;
            height: 240px;
            top: -80px;
            right: -60px;
        }

        .auth-brand::after {
            width: 180px;
            height: 180px;
            bottom: -70px;
            left: -55px;
        }

        .brand-chip {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            background: rgba(255,255,255,.16);
            border: 1px solid rgba(255,255,255,.35);
            border-radius: 999px;
            padding: .45rem .85rem;
            font-size: .76rem;
            font-weight: 700;
            letter-spacing: .3px;
            text-transform: uppercase;
        }

        .brand-title {
            font-size: clamp(1.8rem, 4vw, 2.6rem);
            line-height: 1.1;
            font-weight: 800;
            margin: 1.2rem 0 .65rem;
        }

        .brand-text {
            max-width: 32ch;
            color: rgba(255,255,255,.9);
            line-height: 1.7;
            margin-bottom: 1.5rem;
            font-size: .98rem;
        }

        .brand-tags {
            display: flex;
            flex-wrap: wrap;
            gap: .6rem;
        }

        .brand-tags span {
            border: 1px solid rgba(255,255,255,.35);
            background: rgba(255,255,255,.12);
            border-radius: 999px;
            padding: .32rem .7rem;
            font-size: .78rem;
            font-weight: 600;
        }

        .auth-panel {
            padding: 2.5rem 2rem;
            background: #fff;
        }

        .auth-heading {
            font-size: 1.65rem;
            font-weight: 800;
            color: var(--proden-ink);
            margin-bottom: .35rem;
        }

        .auth-subtext {
            color: #6b7280;
            font-size: .95rem;
            margin-bottom: 1.6rem;
        }

        .alert-error {
            background: #fff3f5;
            border: 1px solid #ffd4dd;
            color: #8b1f35;
            border-radius: 12px;
            padding: .85rem 1rem;
            font-size: .9rem;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: #ecfdf3;
            border: 1px solid #bbf7d0;
            color: #166534;
            border-radius: 12px;
            padding: .85rem 1rem;
            font-size: .9rem;
            margin-bottom: 1rem;
        }

        .auth-label {
            display: block;
            color: #374151;
            font-size: .9rem;
            font-weight: 600;
            margin-bottom: .45rem;
        }

        .auth-input {
            width: 100%;
            border: 1px solid #d6dbe6;
            border-radius: 12px;
            padding: .78rem .92rem;
            font-size: .96rem;
            background: #fff;
            transition: border-color .2s, box-shadow .2s;
        }

        .auth-input:focus {
            border-color: var(--proden-red);
            box-shadow: 0 0 0 4px rgba(196, 30, 58, .13);
            outline: none;
        }

        .auth-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .75rem;
            margin-top: 1rem;
        }

        .remember-wrap {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            color: #4b5563;
            font-size: .88rem;
        }

        .remember-wrap input {
            width: 16px;
            height: 16px;
            accent-color: var(--proden-red);
        }

        .forgot-link {
            color: var(--proden-dark);
            font-size: .88rem;
            font-weight: 600;
            text-decoration: none;
        }

        .forgot-link:hover { text-decoration: underline; }

        .btn-login {
            margin-top: 1rem;
            width: 100%;
            border: 0;
            border-radius: 12px;
            background: linear-gradient(135deg, #8b0000 0%, #c41e3a 100%);
            color: #fff;
            padding: .86rem 1rem;
            font-size: .95rem;
            font-weight: 700;
            letter-spacing: .2px;
            transition: transform .2s, box-shadow .2s;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 24px rgba(139, 0, 0, .22);
        }

        .auth-footnote {
            margin-top: 1.1rem;
            text-align: center;
            color: #6b7280;
            font-size: .8rem;
        }

        @media (max-width: 900px) {
            .auth-frame {
                grid-template-columns: 1fr;
                max-width: 560px;
            }

            .auth-brand {
                padding: 1.7rem;
            }

            .auth-panel {
                padding: 1.7rem;
            }
        }
    </style>

    <div class="auth-shell">
        <div class="auth-frame">
            <aside class="auth-brand">
                <span class="brand-chip">Proden Distribution</span>
                <h1 class="brand-title">Welcome Back</h1>
                <p class="brand-text">
                    Access your Proden account to manage orders, inventory, and customers with ease.
                </p>
                <div class="brand-tags">
                    <span>Natural Drinks</span>
                    <span>UGX Pricing</span>
                    <span>Fast Fulfillment</span>
                </div>
            </aside>

            <section class="auth-panel">
                <h2 class="auth-heading">Sign In</h2>
                <p class="auth-subtext">Use your admin or staff credentials to continue.</p>

                @if($errors->any())
                    <div class="alert-error">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                @session('status')
                    <div class="alert-success">
                        {{ $value }}
                    </div>
                @endsession

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <label for="email" class="auth-label">Email Address</label>
                        <input id="email" class="auth-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="you@example.com">
                    </div>

                    <div class="mt-4">
                        <label for="password" class="auth-label">Password</label>
                        <input id="password" class="auth-input" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password">
                    </div>

                    <div class="auth-row">
                        <label for="remember_me" class="remember-wrap">
                            <input id="remember_me" type="checkbox" name="remember">
                            <span>Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="forgot-link" href="{{ route('password.request') }}">Forgot password?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn-login">Log In to Proden</button>
                </form>

                <p class="auth-footnote">Proden Distribution Co. Ltd</p>
            </section>
        </div>
    </div>
</x-guest-layout>
