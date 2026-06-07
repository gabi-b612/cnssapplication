<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdministrateurIsAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth('administrateur')->check()) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
