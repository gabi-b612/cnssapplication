<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Administrateur;

class AdministrateurController extends Controller
{
    public function index()
    {
        $administrateurs = Administrateur::paginate(10);
        return view('admin.administrateurs.index', compact('administrateurs'));
    }

    public function store()
    {
        // À implémenter
    }

    public function destroy(Administrateur $administrateur)
    {
        // À implémenter
    }
}
