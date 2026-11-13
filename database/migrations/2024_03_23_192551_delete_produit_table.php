<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration pour supprimer la colonne "fournisseur_id" de la table "produits"
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Supprimer la contrainte de clé étrangère d'abord
        Schema::table('produits', function (Blueprint $table) {
            // Contrainte « produits_fournisseur_id_foreign », désignée par sa colonne
            // (forme acceptée par MySQL comme par SQLite)
            $table->dropForeign(['fournisseur_id']);
        });

        // Ensuite, supprimer la colonne "fournisseur_id"
        Schema::table('produits', function (Blueprint $table) {
            $table->dropColumn('fournisseur_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Ajouter la colonne "fournisseur_id"
        Schema::table('produits', function (Blueprint $table) {
            $table->unsignedBigInteger('fournisseur_id');
        });

        // Ajouter la contrainte de clé étrangère après avoir recréé la colonne
        Schema::table('produits', function (Blueprint $table) {
            $table->foreign('fournisseur_id')->references('id')->on('fournisseurs');
        });
    }
};
