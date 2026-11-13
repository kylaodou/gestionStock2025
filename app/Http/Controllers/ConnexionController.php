<?php

// Définition de l'espace de noms du contrôleur ConnexionController dans l'application Laravel
namespace App\Http\Controllers;

// Importation du modèle Utilisateur pour interagir avec les données des utilisateurs dans la base de données
use App\Models\Utilisateur;

// Importation de la classe Request pour gérer les requêtes HTTP entrantes
use Illuminate\Http\Request;

// Importation de la classe Auth pour gérer l'authentification des utilisateurs
use Illuminate\Support\Facades\Auth;

// Définition du contrôleur ConnexionController
class ConnexionController extends Controller
{
    // Méthode formulaire() pour afficher le formulaire de connexion
    public function formulaire()
    {
        // Titre de la page de connexion
        $pageTitle = 'Se connecter';

        // Retourne la vue du formulaire de connexion avec le titre de la page
        return view('pages.connect', compact('pageTitle'));
    }

    // Méthode deconnexion() pour gérer la déconnexion de l'utilisateur
    public function deconnexion(Request $request)
    {
        // Déconnexion de l'utilisateur actuellement authentifié
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirection vers la page d'accueil après la déconnexion
        return redirect('/');
    }

    // Méthode traitement() pour traiter la soumission du formulaire de connexion
    public function traitement(Request $request)
    {
        // Validation des données du formulaire de connexion
        $request->validate([
            // Le champ 'email' est requis et doit être une adresse email se terminant par '@gmail.com'
            'email' => ['required', 'email', 'ends_with:@gmail.com'],
            // Le champ 'password' est requis
            'password' => ['required'],
        ]);

        // Récupération des identifiants de connexion à partir de la requête
        $credentials = $request->only('email', 'password');

        // Tentative d'authentification de l'utilisateur avec les identifiants fournis
        if (Auth::attempt($credentials)) {
            // Nouvel identifiant de session après connexion (protection contre la fixation de session)
            $request->session()->regenerate();

            // Redirection vers le tableau de bord en cas de succès de l'authentification
            return redirect()->intended('/dashboard');
        }

        // Même message que l'email existe ou non : on ne révèle pas les comptes existants
        return redirect()
            ->back()
            ->withErrors(['email' => '*Email ou mot de passe incorrect.'])
            ->withInput($request->only('email'));
    }
}
