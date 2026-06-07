<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTravailleurIsAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth('travailleur')->check()) {
            return redirect()->route('travailleur.login');
        }

        return $next($request);
    }
}
