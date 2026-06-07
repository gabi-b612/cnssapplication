<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Entreprise\Store\StoreEntrepriseRequest;
use App\Models\Entreprise;
use Illuminate\Support\Facades\Hash;

class EntrepriseController extends Controller
{
    public function index()
    {
        $entreprises = Entreprise::paginate(10);
        return view('admin.entreprises', compact('entreprises'));
    }

    public function show(Entreprise $entreprise)
    {
        $entreprise->load(['travailleurs', 'demandes']);
        return view('admin.entreprises.show', compact('entreprise'));
    }

    public function edit(Entreprise $entreprise)
    {
        return view('admin.entreprises.edit', compact('entreprise'));
    }

    public function update(StoreEntrepriseRequest $request, Entreprise $entreprise)
    {
        try {
            $data = $request->validated();
            
            // Ne hasher le password que s'il est fourni
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $entreprise->update($data);

            return redirect()->route('admin.entreprises.index')
                ->with('success', 'Entreprise mise à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour de l\'entreprise.')
                ->withInput();
        }
    }

    public function store(StoreEntrepriseRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);

            Entreprise::create($data);

            return redirect()->route('admin.entreprises.index')
                ->with('success', 'Entreprise créée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la création de l\'entreprise.')
                ->withInput();
        }
    }

    public function destroy(Entreprise $entreprise)
    {
        try {
            $entreprise->delete();
            
            return redirect()->route('admin.entreprises.index')
                ->with('success', 'Entreprise supprimée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression de l\'entreprise.');
        }
    }
}
