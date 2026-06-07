<?php

namespace App\Http\Controllers\Apf;

use App\Http\Controllers\Controller;
use App\Http\Requests\Apf\Validation\ValiderDemandeRequest;
use App\Models\Demande;

class DemandeController extends Controller
{
    public function index()
    {
        $demandes = Demande::with(['travailleur', 'entreprise'])
            ->where('statut', 'en_attente')
            ->latest()
            ->paginate(10);

        return view('apf.demandes_a_traiter', compact('demandes'));
    }

    public function valider(ValiderDemandeRequest $request, $id)
    {
        $demande = Demande::where('id', $id)
            ->where('statut', 'en_attente')
            ->firstOrFail();

        try {
            $demande->update([
                'statut' => $request->validated('statut'),
                'apf_id' => auth('apf')->id(),
            ]);

            $message = $request->validated('statut') === 'validee'
                ? 'Demande validée avec succès.'
                : 'Demande rejetée avec succès.';

            return redirect()->route('apf.demandes.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors du traitement de la demande.');
        }
    }
}
