<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demande_statut_historiques', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('demande_id');
            $table->string('ancien_statut')->nullable();
            $table->string('nouveau_statut');
            $table->string('acteur_type')->nullable();
            $table->unsignedBigInteger('acteur_id')->nullable();
            $table->timestamps();

            $table->foreign('demande_id')->references('id')->on('demandes')->onDelete('cascade');
            $table->index('demande_id');
        });

        $now = now();

        foreach (DB::table('demandes')->orderBy('id')->get() as $demande) {
            DB::table('demande_statut_historiques')->insert([
                'demande_id' => $demande->id,
                'ancien_statut' => null,
                'nouveau_statut' => $demande->statut,
                'acteur_type' => 'system',
                'acteur_id' => null,
                'created_at' => $demande->created_at ?? $now,
                'updated_at' => $demande->created_at ?? $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('demande_statut_historiques');
    }
};
