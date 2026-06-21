<?php

use App\Models\Liquidation;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $annee = now()->year;
        $sequence = Liquidation::whereNotNull('numero_facture')
            ->whereYear('created_at', $annee)
            ->count();

        Liquidation::whereNull('numero_facture')
            ->orderBy('id')
            ->each(function (Liquidation $liquidation) use (&$sequence, $annee) {
                $sequence++;
                $liquidation->update([
                    'numero_facture' => sprintf('FAC-%s-%05d', $annee, $sequence),
                ]);
            });
    }

    public function down(): void
    {
        // Les numéros générés rétroactivement ne sont pas annulés.
    }
};
