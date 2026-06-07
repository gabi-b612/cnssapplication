<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEntrepriseIsAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth('entreprise')->check()) {
            return redirect()->route('entreprise.login');
        }

        return $next($request);
    }
}
