<?php

namespace App\Services;

use App\Models\Demande;
use App\Models\Travailleur;

class DemandeEligibilityService
{
    public const TYPES_FEMININS = ['maternite', 'prenatale'];

    public function typesEligibles(Travailleur $travailleur): array
    {
        if ($travailleur->sexe === 'F') {
            return ['familiale', 'maternite', 'prenatale'];
        }

        return ['familiale'];
    }

    public function estEligible(Travailleur $travailleur, string $typeAllocation): bool
    {
        return in_array($typeAllocation, $this->typesEligibles($travailleur), true);
    }

    public function messageIneligibilite(Travailleur $travailleur, string $typeAllocation): ?string
    {
        if (!$this->estEligible($travailleur, $typeAllocation)) {
            return 'Les allocations maternité et prénatale sont réservées aux travailleuses de sexe féminin.';
        }

        return null;
    }

    public function aDemandeActive(int $travailleurId, string $typeAllocation): bool
    {
        return Demande::where('travailleur_id', $travailleurId)
            ->where('type_allocation', $typeAllocation)
            ->whereNotIn('statut', [Demande::STATUT_PAYEE, Demande::STATUT_REJETEE])
            ->exists();
    }

    public function messageDoublon(int $travailleurId, string $typeAllocation): ?string
    {
        if ($this->aDemandeActive($travailleurId, $typeAllocation)) {
            return 'Une demande de ce type est déjà en cours pour ce travailleur.';
        }

        return null;
    }
}
