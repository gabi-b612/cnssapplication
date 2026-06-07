<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Apf\Store\StoreApfRequest;
use App\Http\Requests\Admin\Update\UpdateApfRequest;
use App\Models\Apf;
use Illuminate\Support\Facades\Hash;

class ApfController extends Controller
{
    public function index()
    {
        $apfs = Apf::withCount('demandes')->latest()->paginate(10);

        return view('admin.apfs.index', compact('apfs'));
    }

    public function edit(Apf $apf)
    {
        return view('admin.apfs.edit', compact('apf'));
    }

    public function store(StoreApfRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);

            Apf::create($data);

            return redirect()->route('admin.apfs.index')
                ->with('success', 'Agent APF créé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la création de l\'agent APF.')
                ->withInput();
        }
    }

    public function update(UpdateApfRequest $request, Apf $apf)
    {
        try {
            $data = $request->validated();

            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $apf->update($data);

            return redirect()->route('admin.apfs.index')
                ->with('success', 'Agent APF mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour de l\'agent APF.')
                ->withInput();
        }
    }

    public function destroy(Apf $apf)
    {
        try {
            $apf->delete();

            return redirect()->route('admin.apfs.index')
                ->with('success', 'Agent APF supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression de l\'agent APF.');
        }
    }
}
