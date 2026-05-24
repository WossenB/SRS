<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Symfony\Component\HttpFoundation\Response;

class RateLimitAuth extends ThrottleRequests
{
    public function handle($request, Closure $next, ...$limits): Response
    {
        // 5 attempts per minute for login
        if ($request->is('login') && $request->isMethod('post')) {
            return parent::handle($request, $next, '5,1');
        }

        // 3 attempts per hour for password reset
        if ($request->is('password/email') && $request->isMethod('post')) {
            return parent::handle($request, $next, '3,60');
        }

        return $next($request);
    }
}
