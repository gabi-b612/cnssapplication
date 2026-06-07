<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Store\StoreLiquidationRequest;
use App\Models\Liquidation;
use App\Models\Demande;
use Illuminate\Support\Facades\Auth;

class LiquidationController extends Controller
{
    public function index()
    {
        $liquidations = Liquidation::with(['demande', 'administrateur'])->paginate(10);
        return view('admin.liquidations.index', compact('liquidations'));
    }

    public function create()
    {
        // Récupérer les demandes validées qui n'ont pas encore de liquidation
        $demandes = Demande::where('statut', 'validee')
            ->whereDoesntHave('liquidation')
            ->with('travailleur')
            ->get();

        return view('admin.liquidations.create', compact('demandes'));
    }

    public function store(StoreLiquidationRequest $request)
    {
        try {
            $data = $request->validated();
            $data['administrateur_id'] = Auth::guard('administrateur')->id();

            Liquidation::create($data);

            return redirect()->route('admin.liquidations.index')
                ->with('success', 'Liquidation créée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la création de la liquidation.')
                ->withInput();
        }
    }

    public function show(Liquidation $liquidation)
    {
        $liquidation->load(['demande', 'administrateur']);
        return view('admin.liquidations.show', compact('liquidation'));
    }

    public function destroy(Liquidation $liquidation)
    {
        try {
            $liquidation->delete();
            
            return redirect()->route('admin.liquidations.index')
                ->with('success', 'Liquidation supprimée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression de la liquidation.');
        }
    }
}
