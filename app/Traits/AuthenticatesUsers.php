<?php

namespace App\Traits;

use App\Constants\AuthGuards;
use Illuminate\Support\Facades\Auth;

trait AuthenticatesUsers
{
    protected function getAuthenticatedUser($guard = null)
    {
        $guard = $guard ?? $this->getGuard();
        return Auth::guard($guard)->user();
    }

    protected function isAuthenticated($guard = null): bool
    {
        $guard = $guard ?? $this->getGuard();
        return Auth::guard($guard)->check();
    }

    protected function authenticate($credentials, $guard = null)
    {
        $guard = $guard ?? $this->getGuard();
        return Auth::guard($guard)->attempt($credentials);
    }

    protected function logout($guard = null): void
    {
        $guard = $guard ?? $this->getGuard();
        Auth::guard($guard)->logout();
    }

    protected function getGuard(): string
    {
        return $this->guard ?? AuthGuards::ADMINISTRATEUR;
    }
}
