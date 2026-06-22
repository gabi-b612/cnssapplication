<?php

namespace App\Services;

use App\Models\Configuration;
use InvalidArgumentException;

class AllocationCalculator
{
    public const MONTANT_FAMILIALE = 24300;
    public const MONTANT_MATERNITE = 72000;
    public const MONTANT_PRENATALE = 16200;

    public function montantPourType(string $typeAllocation): float
    {
        $configuration = Configuration::current();

        return match ($typeAllocation) {
            'familiale' => (float) $configuration->montant_allocation_familiale,
            'maternite' => (float) $configuration->montant_allocation_maternite,
            'prenatale' => (float) $configuration->montant_allocation_prenatale,
            default => throw new InvalidArgumentException("Type d'allocation inconnu : {$typeAllocation}"),
        };
    }

    public function montantsParType(): array
    {
        $configuration = Configuration::current();

        return [
            'familiale' => (float) $configuration->montant_allocation_familiale,
            'maternite' => (float) $configuration->montant_allocation_maternite,
            'prenatale' => (float) $configuration->montant_allocation_prenatale,
        ];
    }

    public static function formaterMontant(float|int|string $montant): string
    {
        return number_format((float) $montant, 0, ',', ' ') . ' FC';
    }

    public static function labelType(string $typeAllocation): string
    {
        return match ($typeAllocation) {
            'familiale' => 'Allocation familiale',
            'maternite' => 'Allocation maternité',
            'prenatale' => 'Allocation prénatale',
            default => ucfirst(str_replace('_', ' ', $typeAllocation)),
        };
    }
}
