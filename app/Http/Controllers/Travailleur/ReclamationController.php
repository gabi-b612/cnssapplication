<?php

namespace App\Http\Controllers\Travailleur;

use App\Http\Controllers\Controller;
use App\Http\Requests\Travailleur\Store\StoreReclamationRequest;
use App\Models\Demande;
use App\Models\Reclamation;

class ReclamationController extends Controller
{
    public function store(StoreReclamationRequest $request, Demande $demande)
    {
        if ($demande->travailleur_id !== auth('travailleur')->id()) {
            abort(404);
        }

        if (!in_array($demande->statut, [Demande::STATUT_REJETEE, Demande::STATUT_EN_VERIFICATION], true)) {
            return redirect()->back()
                ->with('error', 'Une réclamation n\'est possible que pour une demande rejetée ou en vérification.');
        }

        Reclamation::create([
            'demande_id' => $demande->id,
            'travailleur_id' => auth('travailleur')->id(),
            'message' => $request->validated('message'),
            'statut' => Reclamation::STATUT_EN_ATTENTE,
        ]);

        return redirect()->route('travailleur.demandes.show', $demande)
            ->with('success', 'Votre réclamation a été enregistrée.');
    }
}
