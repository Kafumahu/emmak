<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RechercheController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotificationController;

// Page d'accueil
Route::get('/', function () {
    return view('accueil');
})->name('accueil');

// Inscription
Route::get('/inscription', [AuthController::class, 'showInscription'])->name('inscription');
Route::post('/inscription', [AuthController::class, 'inscription']);

// Connexion
Route::get('/connexion', [AuthController::class, 'showConnexion'])->name('connexion');
Route::post('/connexion', [AuthController::class, 'connexion']);

// Déconnexion
Route::post('/deconnexion', [AuthController::class, 'deconnexion'])->name('deconnexion');

// Articles
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

// Recherche
Route::get('/recherche', [RechercheController::class, 'index'])->name('recherche.index');

// Profil public
Route::get('/profil/{id}', [ProfilController::class, 'show'])->name('profil.show');

// Routes protégées
Route::middleware('auth')->group(function () {
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::post('/articles/{articleId}/commentaires', [CommentaireController::class, 'store'])->name('commentaires.store');
    Route::delete('/commentaires/{commentaire}', [CommentaireController::class, 'destroy'])->name('commentaires.destroy');
    Route::get('/mon-profil', [ProfilController::class, 'monProfil'])->name('profil.moi');
    Route::post('/articles/{articleId}/like', [LikeController::class, 'toggle'])->name('articles.like');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/count', [NotificationController::class, 'count'])->name('notifications.count');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});

// Show article
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');