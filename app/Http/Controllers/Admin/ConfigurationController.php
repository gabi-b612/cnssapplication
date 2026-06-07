<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Update\UpdateConfigurationRequest;
use App\Models\Configuration;

class ConfigurationController extends Controller
{
    public function index()
    {
        $configuration = Configuration::current();

        return view('admin.configuration.index', compact('configuration'));
    }

    public function update(UpdateConfigurationRequest $request)
    {
        try {
            $configuration = Configuration::current();
            $configuration->update($request->validated());

            return redirect()->route('admin.configuration.index')
                ->with('success', 'Paramètres de calcul mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour des paramètres.')
                ->withInput();
        }
    }
}
