<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entreprise_id');
            $table->unsignedBigInteger('travailleur_id');
            $table->unsignedBigInteger('apf_id')->nullable();
            $table->enum('type_allocation', ['familiale', 'maternite', 'prenatale']);
            $table->enum('statut', ['en_attente', 'validee', 'rejetee'])->default('en_attente');
            $table->json('documents')->nullable();
            $table->timestamps();

            $table->foreign('entreprise_id')->references('id')->on('entreprises')->onDelete('cascade');
            $table->foreign('travailleur_id')->references('id')->on('travailleurs')->onDelete('cascade');
            $table->foreign('apf_id')->references('id')->on('apfs')->onDelete('set null');
            $table->index('entreprise_id');
            $table->index('travailleur_id');
            $table->index('apf_id');
            $table->index('statut');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};
