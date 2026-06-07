<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->decimal('taux_cotisation', 5, 2)->default(6.50);
            $table->decimal('taux_allocation_familiale', 5, 2)->default(100.00);
            $table->decimal('taux_allocation_maternite', 5, 2)->default(100.00);
            $table->decimal('taux_allocation_prenatale', 5, 2)->default(100.00);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configurations');
    }
};
