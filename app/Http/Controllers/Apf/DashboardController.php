<?php

namespace App\Http\Controllers\Apf;

use App\Http\Controllers\Controller;
use App\Models\Demande;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'en_attente' => Demande::whereIn('statut', [Demande::STATUT_SOUMISE, Demande::STATUT_EN_VERIFICATION])->count(),
            'approuvees' => Demande::where('statut', Demande::STATUT_APPROUVEE)->count(),
            'rejetees' => Demande::where('statut', Demande::STATUT_REJETEE)->count(),
        ];

        return view('apf.dashboard', compact('stats'));
    }
}
