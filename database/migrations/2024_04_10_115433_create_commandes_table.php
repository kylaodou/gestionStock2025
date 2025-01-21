<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration pour créer la table "commandes"
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id(); // Identifiant unique de la commande
            $table->unsignedBigInteger('fournisseur'); // Clé étrangère faisant référence à la table des fournisseurs
            $table->unsignedBigInteger('produit'); // Clé étrangère faisant référence à la table des produits
            $table->unsignedBigInteger('quantite_commander'); // Quantité commandée
            $table->unsignedBigInteger('quantite_recu'); // Quantité reçue
            $table->unsignedBigInteger('quantite_restante'); // Quantité restante
            $table->string('statut'); // Statut de la commande (en attente, complète, incomplète, etc.)
            $table->bigInteger('batch'); // Numéro de lot
            $table->unsignedBigInteger('created_by'); // Clé étrangère faisant référence à la table des utilisateurs
            $table->foreign('created_by')->references('id')->on('utilisateurs'); // Contrainte de clé étrangère
            $table->foreign('produit')->references('id')->on('produits'); // Contrainte de clé étrangère
            $table->foreign('fournisseur')->references('id')->on('fournisseurs'); // Contrainte de clé étrangère
            $table->timestamps(); // Ajoute automatiquement les champs created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes'); // Supprime la table 'commandes' si la migration est annulée
    }
};
