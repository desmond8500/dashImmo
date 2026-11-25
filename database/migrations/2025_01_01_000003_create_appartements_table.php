<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appartements', function (Blueprint $table) {
            $table->id();
            // Contrairement à l'ancienne migration (2024_11_26_230935), qui posait
            // ->constrained() sur une colonne integer() classique — un no-op car
            // constrained() n'existe réellement que sur ForeignIdColumnDefinition —
            // ceci crée une vraie contrainte de clé étrangère.
            $table->foreignId('batiment_id')->constrained()->restrictOnDelete();
            $table->string('nom');
            $table->string('numero')->nullable();
            $table->string('niveau')->nullable();
            $table->string('adresse')->nullable();
            $table->boolean('statut')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appartements');
    }
};
