@extends('layouts.master')

@section('title', 'StaySphere | Login')
@section('page_class', 'page-auth')

@section('content')
    <style>
        .auth-copy {
            padding: 0;
            overflow: hidden;
            min-height: 100%;
        }

        .auth-copy img {
            width: 100%;
            height: 100%;
            min-height: 520px;
            object-fit: cover;
            display: block;
        }

        .password-field {
            position: relative;
        }

        .password-field input {
            padding-right: 84px;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: 1px solid rgba(35, 83, 71, 0.12);
            background: rgba(255, 255, 255, 0.88);
            color: var(--surface-dark);
            border-radius: 999px;
            padding: 9px;
            cursor: pointer;
            display: grid;
            place-items: center;
            width: 38px;
            height: 38px;
        }

        .password-toggle svg {
            width: 18px;
            height: 18px;
            display: block;
        }
    </style>

    <section class="auth-grid auth-card">
        <div class="auth-copy">
            <img src="{{ asset('pic/login_demo.jpg') }}" alt="Login illustration">
        </div>

        <div class="auth-form-wrap">
            <span class="eyebrow">Account Access</span>
            <h2>Login</h2>
            <p>Sign in to manage room requests, customer records, and inventory.</p>

            <form action="{{ route('login.submit') }}" method="POST" class="form-grid">
                @csrf
                <div class="field">
                    <label for="email">Email address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="renter@example.com" required>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <div class="password-field">
                        <input id="password" type="password" name="password" placeholder="Enter your password" required>
                        <button type="button" class="password-toggle" data-password-toggle="password" aria-label="Show password">
                            <svg data-icon="eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                </div>

                <label class="inline-note" style="display:flex; gap:8px; align-items:center;">
                    <input type="checkbox" name="remember" value="1" style="width:auto; padding:0;">
                    Remember this device
                </label>

                <button type="submit" class="button-submit">Sign In</button>
                <p class="inline-note">Need an account? <a href="{{ route('register') }}"><strong>Register here</strong></a>.</p>
            </form>
        </div>
    </section>

    <script>
        document.querySelectorAll('[data-password-toggle]').forEach((button) => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-password-toggle');
                const input = document.getElementById(targetId);

                if (!input) {
                    return;
                }

                const isHidden = input.type === 'password';
                input.type = isHidden ? 'text' : 'password';
                button.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
                button.innerHTML = isHidden
                    ? '<svg data-icon="eye-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-6.5 0-10-8-10-8a21.79 21.79 0 0 1 5.04-6.14"></path><path d="M1 1l22 22"></path><path d="M9.9 4.24A9.74 9.74 0 0 1 12 4c6.5 0 10 8 10 8a21.87 21.87 0 0 1-2.13 3.19"></path><path d="M14.12 14.12A3 3 0 0 1 9.88 9.88"></path></svg>'
                    : '<svg data-icon="eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"></path><circle cx="12" cy="12" r="3"></circle></svg>';
            });
        });
    </script>
@endsection
