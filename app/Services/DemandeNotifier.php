<?php

namespace App\Services;

use App\Models\Demande;
use App\Models\Liquidation;
use App\Notifications\DemandeApprouveeNotification;
use App\Notifications\DemandeLiquideeNotification;
use Illuminate\Support\Facades\Log;

class DemandeNotifier
{
    public function notifyApprouvee(Demande $demande): void
    {
        $demande->loadMissing(['entreprise', 'travailleur']);

        $this->sendSafely(function () use ($demande) {
            if ($demande->entreprise?->email) {
                $demande->entreprise->notify(new DemandeApprouveeNotification($demande));
            }

            if ($demande->travailleur?->email) {
                $demande->travailleur->notify(new DemandeApprouveeNotification($demande));
            }
        }, 'approuvee', $demande->id);
    }

    public function notifyLiquidee(Demande $demande, Liquidation $liquidation): void
    {
        $demande->loadMissing(['entreprise', 'travailleur']);

        $this->sendSafely(function () use ($demande, $liquidation) {
            if ($demande->entreprise?->email) {
                $demande->entreprise->notify(new DemandeLiquideeNotification($demande, $liquidation));
            }

            if ($demande->travailleur?->email) {
                $demande->travailleur->notify(new DemandeLiquideeNotification($demande, $liquidation));
            }
        }, 'liquidee', $demande->id);
    }

    private function sendSafely(callable $callback, string $type, int $demandeId): void
    {
        try {
            $callback();
        } catch (\Throwable $e) {
            Log::warning("Échec envoi notification email ({$type})", [
                'demande_id' => $demandeId,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
