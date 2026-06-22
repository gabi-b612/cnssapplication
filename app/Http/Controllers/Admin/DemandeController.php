<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Demande;
use App\Services\AllocationCalculator;

class DemandeController extends Controller
{
    public function index()
    {
        $demandes = Demande::whereIn('statut', [Demande::STATUT_APPROUVEE, Demande::STATUT_PAYEE])
            ->with(['travailleur', 'entreprise', 'liquidation'])
            ->latest()
            ->paginate(10);

        $montants = app(AllocationCalculator::class)->montantsParType();

        return view('admin.demandes.index', compact('demandes', 'montants'));
    }
}
