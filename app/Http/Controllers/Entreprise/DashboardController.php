<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Models\Demande;

class DashboardController extends Controller
{
    public function index()
    {
        $entreprise = auth('entreprise')->user();

        $stats = [
            'travailleurs' => $entreprise->travailleurs()->count(),
            'demandes' => $entreprise->demandes()->count(),
            'demandes_en_cours' => $entreprise->demandes()->whereIn('statut', Demande::STATUTS_EN_COURS)->count(),
            'demandes_approuvees' => $entreprise->demandes()->whereIn('statut', [Demande::STATUT_APPROUVEE, Demande::STATUT_PAYEE])->count(),
            'demandes_rejetees' => $entreprise->demandes()->where('statut', Demande::STATUT_REJETEE)->count(),
        ];

        $demandesEnCours = $entreprise->demandes()
            ->with('travailleur')
            ->whereNotIn('statut', [Demande::STATUT_PAYEE, Demande::STATUT_REJETEE])
            ->latest()
            ->limit(10)
            ->get();

        return view('entreprise.dashboard', compact('stats', 'entreprise', 'demandesEnCours'));
    }
}
