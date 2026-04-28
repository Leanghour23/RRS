<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login')->with('status', 'Please sign in to access the admin area.');
        }

        if ($this->isAllowedAdmin($user)) {
            return $next($request);
        }

        abort(403, 'You do not have access to the admin area.');
    }

    protected function isAllowedAdmin($user): bool
    {
        if ((bool) data_get($user, 'is_admin')) {
            return true;
        }

        if (data_get($user, 'role') === 'admin') {
            return true;
        }

        $allowedEmails = array_filter(array_map(
            'trim',
            explode(',', (string) env('ADMIN_EMAILS', ''))
        ));

        return in_array($user->email, $allowedEmails, true);
    }
}
