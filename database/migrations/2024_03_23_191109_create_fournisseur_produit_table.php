<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration pour créer la table pivot "fournisseur_produit"
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Création de la table pivot avec les clés étrangères et la contrainte de clé primaire composite
        Schema::create('fournisseur_produit', function (Blueprint $table) {
            // Clés étrangères pour lier les IDs des produits et des fournisseurs
            $table->unsignedBigInteger('produit_id');
            $table->unsignedBigInteger('fournisseur_id');

            // Définition des contraintes de clés étrangères avec l'option "onDelete('cascade')" pour supprimer les enregistrements associés lorsqu'un produit ou un fournisseur est supprimé
            $table->foreign('produit_id')->references('id')->on('produits')->onDelete('cascade');
            $table->foreign('fournisseur_id')->references('id')->on('fournisseurs')->onDelete('cascade');

            // Définition de la clé primaire composite pour éviter les doublons
            $table->primary(['produit_id', 'fournisseur_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Suppression de la table pivot si elle existe
        Schema::dropIfExists('fournisseur_produit');
    }
};
