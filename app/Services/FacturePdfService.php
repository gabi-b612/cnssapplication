<?php

namespace App\Services;

use App\Models\Liquidation;
use Barryvdh\DomPDF\Facade\Pdf;

class FacturePdfService
{
    public function genererNumeroFacture(): string
    {
        $annee = now()->year;
        $dernierNumero = Liquidation::whereYear('created_at', $annee)
            ->whereNotNull('numero_facture')
            ->count();

        return sprintf('FAC-%s-%05d', $annee, $dernierNumero + 1);
    }

    public function genererPdf(Liquidation $liquidation)
    {
        $liquidation->load([
            'demande.travailleur',
            'demande.entreprise',
            'administrateur',
        ]);

        return Pdf::loadView('pdf.facture', [
            'liquidation' => $liquidation,
            'demande' => $liquidation->demande,
        ])->setPaper('a4');
    }

    public function nomFichier(Liquidation $liquidation): string
    {
        $numero = $liquidation->numero_facture ?? 'facture-' . $liquidation->id;

        return $numero . '.pdf';
    }
}
