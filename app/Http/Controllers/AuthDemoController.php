<?php

namespace App\Http\Controllers;

use App\Models\CustomerProfile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class AuthDemoController extends Controller
{
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Invalid email or password.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        if ($this->isAdmin(Auth::user())) {
            return redirect()->route('dashboard');
        }

        return redirect()->route('home')->with('status', 'You are now signed in.');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = DB::transaction(function () use ($validated) {
            $isAdmin = $this->isAdminEmail($validated['email']);

            $user = User::create([
                'name' => trim($validated['first_name'] . ' ' . $validated['last_name']),
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => $isAdmin ? 'admin' : 'customer',
                'is_admin' => $isAdmin,
            ]);

            CustomerProfile::create([
                'user_id' => $user->id,
                'phone' => $validated['phone'] ?? null,
                'status' => 'active',
            ]);

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('status', 'Account created successfully.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'You have been signed out.');
    }

    protected function isAdmin(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return (bool) $user->is_admin || $user->role === 'admin' || $this->isAdminEmail($user->email);
    }

    protected function isAdminEmail(string $email): bool
    {
        $allowedEmails = array_filter(array_map(
            'trim',
            explode(',', (string) env('ADMIN_EMAILS', ''))
        ));

        return in_array($email, $allowedEmails, true);
    }
}
