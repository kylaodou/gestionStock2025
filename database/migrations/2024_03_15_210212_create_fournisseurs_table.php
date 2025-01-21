<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration pour créer la table "fournisseurs"
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Création de la table "fournisseurs"
        Schema::create('fournisseurs', function (Blueprint $table) {
            $table->id(); // Champ pour l'ID du fournisseur
            $table->string('nom_fournisseur'); // Champ pour le nom du fournisseur
            $table->string('adresse_fournisseur'); // Champ pour l'adresse du fournisseur
            $table->string('email')->unique(); // Champ pour l'email du fournisseur (unique)
            $table->timestamps(); // Champs pour les horodatages de création et de mise à jour
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Suppression de la table "fournisseurs" si elle existe
        Schema::dropIfExists('fournisseurs');
    }
};
