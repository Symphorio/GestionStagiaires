<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotSg
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('sg')->check()) {
            return redirect()->route('sg.login');
        }

        return $next($request);
    }
}
