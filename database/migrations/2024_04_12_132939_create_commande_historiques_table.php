<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration pour créer la table "commande_historiques"
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commande_historiques', function (Blueprint $table) {
            $table->id(); // Identifiant unique de l'historique de commande
            $table->unsignedBigInteger('commande_id'); // Clé étrangère faisant référence à la table des commandes
            $table->foreign('commande_id')->references('id')->on('commandes'); // Contrainte de clé étrangère
            $table->unsignedBigInteger('quantite'); // Quantité associée à cet historique de commande
            $table->timestamps(); // Ajoute automatiquement les champs created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commande_historiques'); // Supprime la table 'commande_historiques' si la migration est annulée
    }
};
