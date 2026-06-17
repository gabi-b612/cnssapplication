<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reclamations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('demande_id');
            $table->unsignedBigInteger('travailleur_id');
            $table->text('message');
            $table->string('statut')->default('en_attente');
            $table->timestamps();

            $table->foreign('demande_id')->references('id')->on('demandes')->onDelete('cascade');
            $table->foreign('travailleur_id')->references('id')->on('travailleurs')->onDelete('cascade');
            $table->index('demande_id');
            $table->index('statut');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reclamations');
    }
};
