<?php

namespace Tests\Feature;

use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_toutes_les_pages_s_affichent_pour_un_utilisateur_connecte(): void
    {
        $user = new Utilisateur();
        $user->nom = 'Ouedraogo';
        $user->prenom = 'Awa';
        $user->email = 'awa@gmail.com';
        $user->password = bcrypt('motdepasse');
        $user->save();

        $this->actingAs($user);

        $pages = [
            '/dashboard', '/inscription', '/liste_utilisateur',
            '/ajout_produit', '/liste_produit',
            '/ajout_fournisseur', '/liste_fournisseur',
            '/commande', '/liste_commande', '/rapport',
            '/export-produits', '/export-fournisseurs', '/export-commandes', '/export-utilisateurs', '/export-livraisons',
            '/pdf-produits', '/pdf-fournisseurs', '/pdf-commandes', '/pdf-utilisateurs', '/pdf-livraisons',
        ];

        foreach ($pages as $page) {
            $this->get($page)->assertOk();
        }
    }

    public function test_les_pages_publiques_s_affichent(): void
    {
        $this->get('/')->assertOk();
        $this->get('/connexion')->assertOk();
    }
}
