@extends('layouts.master')

@section('title', 'Register')
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
            border: 1px solid rgba(229, 231, 235, 1);
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
            <img src="{{ asset('pic/register_demo.jpg') }}" alt="Room interior">
        </div>

        <div class="auth-form-wrap">
            <span class="eyebrow">New Account</span>
            <h2>Register</h2>
            <p>Create a renter account and start sending booking requests.</p>

            <form action="{{ route('register.submit') }}" method="POST" class="form-grid">
                @csrf
                <div class="form-row-two">
                    <div class="field">
                        <label for="first_name">First name</label>
                        <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" placeholder="Ariana" required>
                    </div>

                    <div class="field">
                        <label for="last_name">Last name</label>
                        <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Miller" required>
                    </div>
                </div>

                <div class="field">
                    <label for="register_email">Email address</label>
                    <input id="register_email" type="email" name="email" value="{{ old('email') }}" placeholder="your@email.com" required>
                </div>

                <div class="field">
                    <label for="phone">Phone number</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" placeholder="+855 1234 5678">
                </div>

                <div class="form-row-two">
                    <div class="field">
                        <label for="register_password">Password</label>
                        <div class="password-field">
                            <input id="register_password" type="password" name="password" placeholder="Create a password" required>
                            <button type="button" class="password-toggle" data-password-toggle="register_password" aria-label="Show password">
                                <svg data-icon="eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="field">
                        <label for="confirm_password">Confirm password</label>
                        <div class="password-field">
                            <input id="confirm_password" type="password" name="password_confirmation" placeholder="Repeat the password" required>
                            <button type="button" class="password-toggle" data-password-toggle="confirm_password" aria-label="Show password">
                                <svg data-icon="eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" class="button-submit">Create Account</button>
                <p class="inline-note">Already registered? <a href="{{ route('login') }}"><strong>Go to login</strong></a>.</p>
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
