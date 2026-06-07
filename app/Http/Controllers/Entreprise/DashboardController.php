<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $entreprise = auth('entreprise')->user();

        $stats = [
            'travailleurs' => $entreprise->travailleurs()->count(),
            'demandes' => $entreprise->demandes()->count(),
            'demandes_en_attente' => $entreprise->demandes()->where('statut', 'en_attente')->count(),
            'demandes_validees' => $entreprise->demandes()->where('statut', 'validee')->count(),
            'demandes_rejetees' => $entreprise->demandes()->where('statut', 'rejetee')->count(),
        ];

        return view('entreprise.dashboard', compact('stats', 'entreprise'));
    }
}
