<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Http\Requests\Entreprise\Store\StoreTravailleurRequest;
use App\Http\Requests\Entreprise\Update\UpdateTravailleurRequest;
use App\Models\Travailleur;
use Illuminate\Support\Facades\Hash;

class TravailleurController extends Controller
{
    public function index()
    {
        $travailleurs = auth('entreprise')->user()
            ->travailleurs()
            ->latest()
            ->paginate(10);

        return view('entreprise.travailleurs', compact('travailleurs'));
    }

    public function edit(Travailleur $travailleur)
    {
        $this->ensureBelongsToEntreprise($travailleur);

        return view('entreprise.travailleurs.edit', compact('travailleur'));
    }

    public function store(StoreTravailleurRequest $request)
    {
        try {
            $data = $request->validated();
            $data['entreprise_id'] = auth('entreprise')->id();
            $data['password'] = Hash::make($data['password']);

            Travailleur::create($data);

            return redirect()->route('entreprise.travailleurs.index')
                ->with('success', 'Travailleur ajouté avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de l\'ajout du travailleur.')
                ->withInput();
        }
    }

    public function update(UpdateTravailleurRequest $request, Travailleur $travailleur)
    {
        $this->ensureBelongsToEntreprise($travailleur);

        try {
            $data = $request->validated();

            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $travailleur->update($data);

            return redirect()->route('entreprise.travailleurs.index')
                ->with('success', 'Travailleur mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour du travailleur.')
                ->withInput();
        }
    }

    public function destroy(Travailleur $travailleur)
    {
        $this->ensureBelongsToEntreprise($travailleur);

        try {
            $travailleur->delete();

            return redirect()->route('entreprise.travailleurs.index')
                ->with('success', 'Travailleur supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression du travailleur.');
        }
    }

    private function ensureBelongsToEntreprise(Travailleur $travailleur): void
    {
        if ($travailleur->entreprise_id !== auth('entreprise')->id()) {
            abort(403, 'Accès non autorisé à ce travailleur.');
        }
    }
}
