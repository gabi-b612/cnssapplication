<?php

namespace App\Http\Controllers\Apf;

use App\Http\Controllers\Controller;
use App\Http\Requests\Apf\Validation\ValiderDemandeRequest;
use App\Models\Demande;
use App\Services\DemandeNotifier;
use Illuminate\Support\Facades\DB;

class DemandeController extends Controller
{
    public function __construct(
        private DemandeNotifier $demandeNotifier
    ) {
    }

    public function index()
    {
        $demandes = Demande::with(['travailleur', 'entreprise'])
            ->whereIn('statut', [Demande::STATUT_SOUMISE, Demande::STATUT_EN_VERIFICATION])
            ->latest()
            ->paginate(10);

        return view('apf.demandes_a_traiter', compact('demandes'));
    }

    public function valider(ValiderDemandeRequest $request, $id)
    {
        $demande = Demande::where('id', $id)
            ->whereIn('statut', [Demande::STATUT_SOUMISE, Demande::STATUT_EN_VERIFICATION])
            ->firstOrFail();

        $nouveauStatut = $request->validated('statut');

        try {
            DB::transaction(function () use ($request, $demande, $nouveauStatut) {
                $apfId = auth('apf')->id();

                if ($demande->statut === Demande::STATUT_SOUMISE) {
                    $demande->changeStatut(Demande::STATUT_EN_VERIFICATION, 'apf', $apfId);
                    $demande->update(['apf_id' => $apfId]);
                }

                $demande->changeStatut(
                    $nouveauStatut,
                    'apf',
                    $apfId,
                    $request->validated('motif_rejet')
                );

                if (!$demande->apf_id) {
                    $demande->update(['apf_id' => $apfId]);
                }
            });

            if ($nouveauStatut === Demande::STATUT_APPROUVEE) {
                $this->demandeNotifier->notifyApprouvee($demande->fresh());
            }

            $message = $nouveauStatut === Demande::STATUT_APPROUVEE
                ? 'Demande approuvée avec succès.'
                : 'Demande rejetée avec succès.';

            return redirect()->route('apf.demandes.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors du traitement de la demande.');
        }
    }
}
