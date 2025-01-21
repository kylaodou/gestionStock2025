<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ConnexionController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\RapportControllerController;


use App\Models\Fournisseur;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

route::get('', [UsersController::class, 'home']);
route::get('/dashboard', [DashboardController::class, 'dashboardUsers']);

route::get('/connexion', [ConnexionController::class, 'formulaire'])->name('login');
route::post('/connexion', [ConnexionController::class, 'traitement']);

route::get('/deconnexion', [ConnexionController::class, 'deconnexion']);

route::get('/inscription', [UsersController::class, 'formulaire']);
route::post('/inscription', [UsersController::class, 'traitement']);

route::get('/liste_utilisateur', [UsersController::class, 'read']);
route::post('/liste/supprimer/{id}', [UsersController::class, 'delete']);
route::post('/liste_utilisateur/modifier/{id}', [UsersController::class, 'modifier']);

route::get('/ajout_produit', [ProduitController::class, 'formulaire']);
route::post('/ajout_produit', [ProduitController::class, 'traitement'])->middleware('auth')/* ->middleware('createdby') */;
route::get('/liste_produit', [ProduitController::class, 'read']);
route::post('/liste_produit/supprimer/{id}', [ProduitController::class, 'delete']);
route::post('/liste_produit/modifier/{id}', [ProduitController::class, 'modifier']);

route::get('/ajout_fournisseur', [FournisseurController::class, 'formulaire']);
route::post('/ajout_fournisseur', [FournisseurController::class, 'traitement'])->middleware('auth')/* ->middleware('createdby') */;
route::get('/liste_fournisseur', [FournisseurController::class, 'read']);
route::post('/liste_fournisseur/supprimer/{id}', [FournisseurController::class, 'delete']);
route::post('/liste_fournisseur/modifier/{id}', [FournisseurController::class, 'modifier']);

route::get('/commande', [CommandeController::class, 'formulaire']);
Route::get('/produits/{id}/infos', [CommandeController::class, 'getProductInfo'])->name('produits.infos');
route::post('/ajout_commande', [CommandeController::class, 'traitement']);
route::get('/liste_commande', [CommandeController::class, 'read']);
route::post('/liste_commande/supprimer/{id}', [CommandeController::class, 'delete']);
route::post('/liste_commande/modifier/{batch}', [CommandeController::class, 'modifier']);

route::get('/rapport', [RapportController::class, 'read']);
route::get('/export-produits', [RapportController::class, 'exportproduits']);
route::get('/export-fournisseurs', [RapportController::class, 'exportfournisseurs']);
route::get('/export-commandes', [RapportController::class, 'exportcommandes']);
route::get('/export-utilisateurs', [RapportController::class, 'exportutilisateurs']);
route::get('/export-livraisons', [RapportController::class, 'exportlivraisons']);


route::get('/pdf-produits', [RapportController::class, 'exportProduitsToPDF']);
route::get('/pdf-fournisseurs', [RapportController::class, 'exportFournisseursToPDF']);
route::get('/pdf-commandes', [RapportController::class, 'exportCommandesToPDF']);
route::get('/pdf-utilisateurs', [RapportController::class, 'exportUtilisateursToPDF']);
route::get('/pdf-livraisons', [RapportController::class, 'exportLivraisonsToPDF']);










