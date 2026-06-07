<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('liquidations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('demande_id');
            $table->unsignedBigInteger('administrateur_id');
            $table->decimal('montant', 12, 2);
            $table->date('date_liquidation');
            $table->timestamps();

            $table->foreign('demande_id')->references('id')->on('demandes')->onDelete('cascade');
            $table->foreign('administrateur_id')->references('id')->on('administrateurs')->onDelete('restrict');
            $table->index('demande_id');
            $table->index('administrateur_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('liquidations');
    }
};
