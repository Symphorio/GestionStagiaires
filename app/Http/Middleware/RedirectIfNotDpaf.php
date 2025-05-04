<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotDpaf
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('dpaf')->check()) {
            return redirect()->route('dpaf.login');
        }

        return $next($request);
    }
}
