<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotStagiaire
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('stagiaire')->check()) {
            return redirect()->route('stagiaire.login');
        }

        return $next($request);
    }
}
