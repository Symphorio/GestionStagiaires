<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request)
{
    if (!$request->expectsJson()) {
        if ($request->is('stagiaire/*')) {
            return route('stagiaire.login');
        }

        if ($request->is('dpaf/*')) {
            return route('dpaf.login');
        }

        if ($request->is('sg/*')) {
            return route('sg.login');
        }

        if ($request->is('srhds/*')) {
            return route('srhds.login');
        }

        return route('login');
    }
}
}
