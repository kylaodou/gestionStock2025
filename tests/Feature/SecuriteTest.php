<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecuriteTest extends TestCase
{
    use RefreshDatabase;

    private function utilisateur(): Utilisateur
    {
        $user = new Utilisateur();
        $user->nom = 'Ouedraogo';
        $user->prenom = 'Awa';
        $user->email = 'awa@gmail.com';
        $user->password = bcrypt('motdepasse');
        $user->save();

        return $user;
    }

    private function nouveauCompte(): array
    {
        return [
            'nom' => 'Pirate', 'prenom' => 'X', 'email' => 'pirate@gmail.com',
            'password' => 'motdepasse', 'password_confirmation' => 'motdepasse',
        ];
    }

    public function test_le_premier_utilisateur_est_cree_par_le_seeder(): void
    {
        putenv('ADMIN_EMAIL=premier@gmail.com');
        putenv('ADMIN_PASSWORD=motdepasse');

        $this->seed();

        $this->assertDatabaseHas('utilisateurs', ['email' => 'premier@gmail.com']);

        putenv('ADMIN_EMAIL');
        putenv('ADMIN_PASSWORD');
    }

    public function test_un_visiteur_ne_peut_pas_creer_de_compte(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $this->get('/inscription')->assertRedirect(route('login'));
        $this->post('/inscription', $this->nouveauCompte())->assertRedirect(route('login'));

        $this->assertDatabaseMissing('utilisateurs', ['email' => 'pirate@gmail.com']);
    }

    public function test_un_utilisateur_connecte_peut_ajouter_un_compte(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $this->actingAs($this->utilisateur())
            ->post('/inscription', $this->nouveauCompte())
            ->assertRedirect('/inscription');

        $this->assertDatabaseHas('utilisateurs', ['email' => 'pirate@gmail.com']);
    }

    public function test_un_visiteur_ne_peut_ni_consulter_ni_supprimer_les_donnees(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $user = $this->utilisateur();

        foreach (['/dashboard', '/liste_utilisateur', '/liste_produit', '/liste_fournisseur', '/liste_commande', '/rapport', '/export-utilisateurs', '/pdf-utilisateurs'] as $page) {
            $this->get($page)->assertRedirect(route('login'));
        }

        $this->post("/liste/supprimer/{$user->id}")->assertRedirect(route('login'));
        $this->assertDatabaseHas('utilisateurs', ['id' => $user->id]);
    }

    public function test_la_connexion_ne_revele_pas_si_le_compte_existe(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $this->utilisateur();

        $this->from('/connexion')->post('/connexion', ['email' => 'inconnu@gmail.com', 'password' => 'x'])
            ->assertSessionHasErrors(['email' => '*Email ou mot de passe incorrect.']);
        $this->from('/connexion')->post('/connexion', ['email' => 'awa@gmail.com', 'password' => 'x'])
            ->assertSessionHasErrors(['email' => '*Email ou mot de passe incorrect.']);
    }

    public function test_la_connexion_fonctionne_et_le_nombre_d_essais_est_limite(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $this->utilisateur();

        $this->post('/connexion', ['email' => 'awa@gmail.com', 'password' => 'motdepasse'])->assertRedirect('/dashboard');
        $this->assertAuthenticated();
        $this->get('/deconnexion');

        for ($i = 0; $i < 4; $i++) {
            $this->post('/connexion', ['email' => 'awa@gmail.com', 'password' => 'faux']);
        }
        $this->post('/connexion', ['email' => 'awa@gmail.com', 'password' => 'faux'])->assertStatus(429);
    }
}
