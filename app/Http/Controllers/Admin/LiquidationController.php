<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Liquidation;

class LiquidationController extends Controller
{
    public function index()
    {
        $liquidations = Liquidation::paginate(10);
        return view('admin.liquidations.index', compact('liquidations'));
    }

    public function store()
    {
        // À implémenter
    }

    public function destroy(Liquidation $liquidation)
    {
        // À implémenter
    }
}
