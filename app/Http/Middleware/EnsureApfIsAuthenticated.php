<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureApfIsAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth('apf')->check()) {
            return redirect()->route('apf.login');
        }

        return $next($request);
    }
}
