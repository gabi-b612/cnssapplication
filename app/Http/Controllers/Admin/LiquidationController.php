<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Store\StoreLiquidationRequest;
use App\Models\Liquidation;
use App\Models\Demande;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LiquidationController extends Controller
{
    public function index()
    {
        $demandes = Demande::where('statut', 'validee')
            ->whereDoesntHave('liquidation')
            ->with(['travailleur', 'entreprise'])
            ->latest()
            ->get();

        return view('admin.liquidations.index', compact('demandes'));
    }

    public function historique()
    {
        $liquidations = Liquidation::with(['demande.travailleur', 'administrateur'])
            ->latest()
            ->paginate(10);

        return view('admin.liquidations.historique', compact('liquidations'));
    }

    public function store(StoreLiquidationRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $data = $request->validated();
                $data['administrateur_id'] = Auth::guard('administrateur')->id();

                $demande = Demande::where('id', $data['demande_id'])
                    ->where('statut', 'validee')
                    ->whereDoesntHave('liquidation')
                    ->firstOrFail();

                Liquidation::create($data);

                $demande->update(['statut' => 'liquidee']);
            });

            return redirect()->route('admin.liquidations.index')
                ->with('success', 'Liquidation enregistrée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la création de la liquidation.')
                ->withInput();
        }
    }

    public function show(Liquidation $liquidation)
    {
        $liquidation->load(['demande.travailleur', 'demande.entreprise', 'administrateur']);

        return view('admin.liquidations.show', compact('liquidation'));
    }

    public function destroy(Liquidation $liquidation)
    {
        try {
            DB::transaction(function () use ($liquidation) {
                $demande = $liquidation->demande;
                $liquidation->delete();

                if ($demande && $demande->statut === 'liquidee') {
                    $demande->update(['statut' => 'validee']);
                }
            });

            return redirect()->route('admin.liquidations.historique')
                ->with('success', 'Liquidation supprimée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression de la liquidation.');
        }
    }
}
