<?php

namespace App\Http\Controllers\Travailleur;

use App\Http\Controllers\Controller;
use App\Models\Demande;

class DemandeController extends Controller
{
    public function show(Demande $demande)
    {
        $travailleurId = auth('travailleur')->id();

        if ($demande->travailleur_id !== $travailleurId) {
            abort(404);
        }

        $demande->load(['entreprise', 'apf', 'liquidation', 'statutHistoriques', 'reclamations']);

        return view('travailleur.demandes.show', compact('demande'));
    }
}
