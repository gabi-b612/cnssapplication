<?php

namespace App\Constants;

class AuthGuards
{
    const ADMINISTRATEUR = 'administrateur';
    const ENTREPRISE = 'entreprise';
    const TRAVAILLEUR = 'travailleur';
    const APF = 'apf';

    public static function all(): array
    {
        return [
            self::ADMINISTRATEUR,
            self::ENTREPRISE,
            self::TRAVAILLEUR,
            self::APF,
        ];
    }
}
