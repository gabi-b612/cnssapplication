<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use App\Models\Administrateur;
use App\Models\Demande;
use App\Models\Liquidation;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'entreprises' => Entreprise::count(),
            'administrateurs' => Administrateur::count(),
            'demandes' => Demande::count(),
            'liquidations' => Liquidation::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
