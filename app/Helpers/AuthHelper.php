<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class AuthHelper
{
    public static function getActiveGuard(): ?string
    {
        $guards = ['administrateur', 'entreprise', 'travailleur', 'apf'];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return $guard;
            }
        }

        return null;
    }

    public static function getActiveUser()
    {
        $guard = self::getActiveGuard();
        return $guard ? Auth::guard($guard)->user() : null;
    }

    public static function logout(): void
    {
        $guard = self::getActiveGuard();
        if ($guard) {
            Auth::guard($guard)->logout();
        }
    }

    public static function isAdministrateur(): bool
    {
        return Auth::guard('administrateur')->check();
    }

    public static function isEntreprise(): bool
    {
        return Auth::guard('entreprise')->check();
    }

    public static function isTravailleur(): bool
    {
        return Auth::guard('travailleur')->check();
    }

    public static function isApf(): bool
    {
        return Auth::guard('apf')->check();
    }
}
