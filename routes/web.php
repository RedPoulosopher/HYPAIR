<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/connexion', function() {  return view('connexion'); })->name("connexion");
Route::post('/connexion', [AuthController::class, 'connexion']);
Route::get('/deconnexion', [AuthController::class, 'deconnexion']);

$routes_asso = function () {
    Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'contact'])->name('ContactController.contact');
    Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'contactPost'])->name('ContactController.contactPost');

    Route::get('/', function() { return view('accueils.#accueil'); });
    Route::get('/accueil', function() { return view('accueils.#accueil'); });

    Route::get('/test', [DocumentationController::class, 'test']);

    Route::get('/nouvelle_documentation', [DocumentationController::class, 'create']);
    Route::post('/nouvelle_documentation', [DocumentationController::class, 'store']);
    Route::get('/nouvelle_documentation/{slug}', [DocumentationController::class, 'edit']);
    Route::post('/nouvelle_documentation/{slug}', [DocumentationController::class, 'update']);
    Route::get('/documentations', [DocumentationController::class, 'index']);
    Route::get('/documentation/{slug}', [DocumentationController::class, 'show']);
};

Route::domain('liste.' . env('SITE_URL')) //pour les listes
    ->prefix('{uid_asso}')
    ->middleware('existence_asso:liste')
    ->group($routes_asso);

Route::domain('{uid_asso}.' . env('SITE_URL')) //pour le reste
    ->middleware('existence_asso:association')
    ->group($routes_asso);


// easter eggs
Route::get('/matrix', function() {  return view('oeufs_de_paques.matrix'); });
Route::get('/ecriture', function() {  return view('oeufs_de_paques.ecriture'); });
Route::get('/cookies', function() {  return view('cookies'); });

// accéder aux erreurs
Route::get('/{erreur}', function($erreur) { return abort($erreur); })->where(['erreur'=>'401|403|404|405|419|429|500|503']);