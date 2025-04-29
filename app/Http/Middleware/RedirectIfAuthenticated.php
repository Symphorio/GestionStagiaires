<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
{
    $guards = empty($guards) ? array_keys(config('auth.guards')) : $guards;

    foreach ($guards as $guard) {
        if (Auth::guard($guard)->check()) {
            return redirect($this->getHomeRouteForGuard($guard));
        }
    }

    return $next($request);
}

protected function getHomeRouteForGuard($guard)
{
    return match($guard) {
        'stagiaire' => route('stagiaire.dashboard'),
        'dpaf' => route('dpaf.dashboard'),
        'tuteur' => route('tuteur.dashboard'),
        'sg' => route('sg.dashboard'),
        default => RouteServiceProvider::HOME
    };
}
}
