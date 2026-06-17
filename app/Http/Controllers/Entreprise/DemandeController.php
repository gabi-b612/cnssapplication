<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Http\Requests\Entreprise\Store\StoreDemandeRequest;
use App\Models\Demande;
use App\Models\Travailleur;
use App\Services\AllocationCalculator;
use Illuminate\Support\Facades\DB;

class DemandeController extends Controller
{
    public function index()
    {
        $demandes = auth('entreprise')->user()
            ->demandes()
            ->with('travailleur')
            ->latest()
            ->paginate(10);

        return view('entreprise.demandes', compact('demandes'));
    }

    public function show(Demande $demande)
    {
        $entrepriseId = auth('entreprise')->id();

        if ($demande->entreprise_id !== $entrepriseId) {
            abort(404);
        }

        $demande->load(['travailleur', 'apf', 'liquidation', 'statutHistoriques']);

        return view('entreprise.demandes.show', compact('demande'));
    }

    public function create()
    {
        $travailleurs = auth('entreprise')->user()
            ->travailleurs()
            ->orderBy('nom')
            ->get();

        $montants = app(AllocationCalculator::class)->montantsParType();

        return view('entreprise.demandes.create', compact('travailleurs', 'montants'));
    }

    public function store(StoreDemandeRequest $request)
    {
        try {
            $entrepriseId = auth('entreprise')->id();
            $travailleur = Travailleur::where('id', $request->validated('travailleur_id'))
                ->where('entreprise_id', $entrepriseId)
                ->firstOrFail();

            $documentPaths = [];

            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $file) {
                    $documentPaths[] = $file->store('documents', 'public');
                }
            }

            DB::transaction(function () use ($entrepriseId, $travailleur, $request, $documentPaths) {
                $demande = Demande::create([
                    'entreprise_id' => $entrepriseId,
                    'travailleur_id' => $travailleur->id,
                    'type_allocation' => $request->validated('type_allocation'),
                    'statut' => Demande::STATUT_SOUMISE,
                    'documents' => $documentPaths,
                ]);

                $demande->statutHistoriques()->create([
                    'ancien_statut' => null,
                    'nouveau_statut' => Demande::STATUT_SOUMISE,
                    'acteur_type' => 'entreprise',
                    'acteur_id' => $entrepriseId,
                ]);
            });

            return redirect()->route('entreprise.demandes.index')
                ->with('success', 'Demande soumise avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la soumission de la demande.')
                ->withInput();
        }
    }
}
