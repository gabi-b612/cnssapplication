<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->decimal('montant_allocation_familiale', 12, 2)->default(24300)->after('taux_allocation_prenatale');
            $table->decimal('montant_allocation_maternite', 12, 2)->default(72000)->after('montant_allocation_familiale');
            $table->decimal('montant_allocation_prenatale', 12, 2)->default(16200)->after('montant_allocation_maternite');
        });

        DB::table('configurations')->update([
            'montant_allocation_familiale' => 24300,
            'montant_allocation_maternite' => 72000,
            'montant_allocation_prenatale' => 16200,
        ]);
    }

    public function down(): void
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn([
                'montant_allocation_familiale',
                'montant_allocation_maternite',
                'montant_allocation_prenatale',
            ]);
        });
    }
};
