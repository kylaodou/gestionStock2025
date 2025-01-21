<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration pour ajouter les colonnes "created_by" et "fournisseur_id" avec leurs clés étrangères dans la table "produits"
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ajout des colonnes "created_by" et "fournisseur_id" avec leurs clés étrangères
        Schema::table('produits', function (Blueprint $table) {
            // Colonne pour l'ID de l'utilisateur qui a créé le produit
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('utilisateurs');

            // Colonne pour l'ID du fournisseur associé au produit
            $table->unsignedBigInteger('fournisseur_id');
            $table->foreign('fournisseur_id')->references('id')->on('fournisseurs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Suppression des colonnes et de leurs clés étrangères
        Schema::table('produits', function (Blueprint $table) {
            // Suppression des clés étrangères dans l'ordre inverse de leur création
            $table->dropForeign(['fournisseur_id']);
            $table->dropForeign(['created_by']);

            // Suppression des colonnes ajoutées
            $table->dropColumn(['fournisseur_id', 'created_by']);
        });
    }
};
