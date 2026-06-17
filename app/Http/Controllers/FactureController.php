<?php

namespace App\Http\Controllers;

use App\Models\Liquidation;
use App\Services\FacturePdfService;
use Symfony\Component\HttpFoundation\Response;

class FactureController extends Controller
{
    public function __construct(
        private FacturePdfService $facturePdfService
    ) {
    }

    public function download(Liquidation $liquidation): Response
    {
        $liquidation->load('demande');

        $this->authorizeAccess($liquidation);

        if ($liquidation->demande->statut !== \App\Models\Demande::STATUT_PAYEE) {
            abort(404);
        }

        $pdf = $this->facturePdfService->genererPdf($liquidation);

        return $pdf->download($this->facturePdfService->nomFichier($liquidation));
    }

    private function authorizeAccess(Liquidation $liquidation): void
    {
        $demande = $liquidation->demande;

        if (auth('administrateur')->check()) {
            return;
        }

        if (auth('entreprise')->check() && auth('entreprise')->id() === $demande->entreprise_id) {
            return;
        }

        if (auth('travailleur')->check() && auth('travailleur')->id() === $demande->travailleur_id) {
            return;
        }

        abort(403);
    }
}
