<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IdleSessionTimeout
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $timeout = config('session.timeout_minutes', 30);
        $lastActivity = session('last_activity');

        if ($lastActivity && now()->diffInMinutes($lastActivity) > $timeout) {
            Auth::logout();
            session()->forget('last_activity');

            return redirect()->route('login')
                ->with('message', 'Session expired due to inactivity. Please log in again.');
        }

        session(['last_activity' => now()]);
        return $next($request);
    }
}
