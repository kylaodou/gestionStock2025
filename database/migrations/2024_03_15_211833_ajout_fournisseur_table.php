<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration pour ajouter la colonne "created_by" et sa clé étrangère dans la table "fournisseurs"
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ajout de la colonne "created_by" avec une clé étrangère
        Schema::table('fournisseurs', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by'); // Champ pour l'ID de l'utilisateur qui a créé le fournisseur
            $table->foreign('created_by')->references('id')->on('utilisateurs'); // Clé étrangère vers la table "utilisateurs"
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Suppression de la colonne "created_by" et de sa clé étrangère
        Schema::table('fournisseurs', function (Blueprint $table) {
            // Suppression de la clé étrangère
            $table->dropForeign(['created_by']);

            // Suppression de la colonne "created_by"
            $table->dropColumn(['created_by']);
        });
    }
};
