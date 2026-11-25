<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compteurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appartement_id')->constrained()->cascadeOnDelete();
            $table->string('type')->default('EAU');
            $table->string('reference')->nullable();
            $table->string('ref_client')->nullable();
            $table->string('ref_compteur')->nullable();
            $table->string('adresse_technique')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compteurs');
    }
};
