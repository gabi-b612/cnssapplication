<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Http\Requests\Entreprise\Store\StoreDemandeRequest;
use App\Models\Demande;
use App\Models\Travailleur;

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

    public function create()
    {
        $travailleurs = auth('entreprise')->user()
            ->travailleurs()
            ->orderBy('nom')
            ->get();

        return view('entreprise.demandes.create', compact('travailleurs'));
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

            Demande::create([
                'entreprise_id' => $entrepriseId,
                'travailleur_id' => $travailleur->id,
                'type_allocation' => $request->validated('type_allocation'),
                'statut' => 'en_attente',
                'documents' => $documentPaths,
            ]);

            return redirect()->route('entreprise.demandes.index')
                ->with('success', 'Demande soumise avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la soumission de la demande.')
                ->withInput();
        }
    }
}
