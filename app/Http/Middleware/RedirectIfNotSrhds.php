<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotSrhds
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('srhds')->check()) {
            return redirect()->route('srhds.login');
        }

        return $next($request);
    }
}
