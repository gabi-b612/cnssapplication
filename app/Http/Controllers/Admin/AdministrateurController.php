<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Store\StoreAdministrateurRequest;
use App\Models\Administrateur;
use Illuminate\Support\Facades\Hash;

class AdministrateurController extends Controller
{
    public function index()
    {
        $administrateurs = Administrateur::paginate(10);
        return view('admin.administrateurs.index', compact('administrateurs'));
    }

    public function show(Administrateur $administrateur)
    {
        $administrateur->load('liquidations');
        return view('admin.administrateurs.show', compact('administrateur'));
    }

    public function edit(Administrateur $administrateur)
    {
        return view('admin.administrateurs.edit', compact('administrateur'));
    }

    public function update(StoreAdministrateurRequest $request, Administrateur $administrateur)
    {
        try {
            $data = $request->validated();
            
            // Ne hasher le password que s'il est fourni
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $administrateur->update($data);

            return redirect()->route('admin.administrateurs.index')
                ->with('success', 'Administrateur mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour de l\'administrateur.')
                ->withInput();
        }
    }

    public function store(StoreAdministrateurRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);

            Administrateur::create($data);

            return redirect()->route('admin.administrateurs.index')
                ->with('success', 'Administrateur créé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la création de l\'administrateur.')
                ->withInput();
        }
    }

    public function destroy(Administrateur $administrateur)
    {
        try {
            $administrateur->delete();
            
            return redirect()->route('admin.administrateurs.index')
                ->with('success', 'Administrateur supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression de l\'administrateur.');
        }
    }
}
