<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use App\Models\Administrateur;
use App\Models\Demande;
use App\Models\Liquidation;
use App\Models\Apf;
use App\Models\Travailleur;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'entreprises' => Entreprise::count(),
            'administrateurs' => Administrateur::count(),
            'demandes' => Demande::count(),
            'demandes_validees' => Demande::where('statut', 'validee')->count(),
            'liquidations' => Liquidation::count(),
            'travailleurs' => Travailleur::count(),
            'apfs' => Apf::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
