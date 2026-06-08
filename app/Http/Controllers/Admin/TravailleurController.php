<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Travailleur;

class TravailleurController extends Controller
{
    public function index()
    {
        $travailleurs = Travailleur::with('entreprise')
            ->latest()
            ->paginate(10);

        return view('admin.travailleurs.index', compact('travailleurs'));
    }
}
