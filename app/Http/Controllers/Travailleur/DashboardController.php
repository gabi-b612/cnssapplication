<?php

namespace App\Http\Controllers\Travailleur;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $travailleur = auth()->guard('travailleur')->user()->load('entreprise');
        $demandes = $travailleur->demandes()->with('entreprise')->latest()->get();

        return view('travailleur.dashboard', compact('travailleur', 'demandes'));
    }
}
