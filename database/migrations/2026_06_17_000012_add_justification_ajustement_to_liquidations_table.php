<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('liquidations', function (Blueprint $table) {
            $table->text('justification_ajustement')->nullable()->after('date_liquidation');
        });
    }

    public function down(): void
    {
        Schema::table('liquidations', function (Blueprint $table) {
            $table->dropColumn('justification_ajustement');
        });
    }
};
