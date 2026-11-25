<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contrats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('appartement_id')->constrained()->cascadeOnDelete();
            $table->string('date')->nullable();
            $table->string('debut')->nullable();
            $table->string('fin')->nullable();
            // decimal plutôt que string (incohérent avec la cast 'integer' du
            // modèle Contrat d'origine, alors que factures.montant était déjà
            // un decimal(8,2) casté en string côté modèle) : on uniformise ici.
            $table->decimal('montant', 10, 2)->nullable();
            $table->string('type')->nullable();
            $table->boolean('sign1')->default(false);
            $table->boolean('sign2')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contrats');
    }
};
