<?php

namespace App\Http\Controllers\Apf;

use App\Http\Controllers\Controller;
use App\Models\Demande;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'en_attente' => Demande::where('statut', 'en_attente')->count(),
            'validees' => Demande::where('statut', 'validee')->count(),
            'rejetees' => Demande::where('statut', 'rejetee')->count(),
        ];

        return view('apf.dashboard', compact('stats'));
    }
}
