<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration pour créer la table "produits"
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Création de la table "produits"
        Schema::create('produits', function (Blueprint $table) {
            $table->id(); // Champ pour l'ID du produit
            $table->string('nom_produit'); // Champ pour le nom du produit
            $table->text('description'); // Champ pour la description du produit
            $table->string('image'); // Champ pour le nom du fichier d'image
            $table->timestamps(); // Champs pour les horodatages de création et de mise à jour
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Suppression de la table "produits" si elle existe
        Schema::dropIfExists('produits');
    }
};
