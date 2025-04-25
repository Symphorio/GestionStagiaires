<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role)
    {
        $guard = null;
        
        // Détermine le guard en fonction du rôle
        switch($role) {
            case 'stagiaire': $guard = 'stagiaire'; break;
            case 'encadreur': $guard = 'encadreur'; break;
            // ... autres rôles
        }
    
        if (!auth($guard)->check() || auth($guard)->user()->role->nom != $role) {
            abort(403);
        }
        
        return $next($request);
    }
}
