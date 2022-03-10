<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\AssociationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EvenementController;

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


//les routes pour les associations, les clubs et les listes
$routes_asso = function () {
    Route::get('/', function() { return view('accueils.#accueil'); });
    Route::get('/accueil', function() { return view('accueils.#accueil'); });

    Route::controller(DocumentationController::class)->group(function(){
        Route::get('/documentation/nouvelle', 'create');
        Route::post('/documentation/nouvelle', 'store');
        Route::get('/documentation/modifier/{id}', 'edit');
        Route::post('/documentation/modifier/{id}', 'update');
        Route::get('/documentation', 'index');
        Route::get('/documentation/{slug}', 'show');
    });

    Route::controller(EvenementController::class)->group(function(){
        Route::get('/evenement', function() {  return view('evenements.formulaire'); });
        Route::post('/evenement', 'formulaire_evenement');
    });
};

Route::domain('liste.' . env('SITE_URL')) //pour les listes
    ->prefix('{uid_asso}-{id_asso}')
    ->middleware('existence_asso:liste')
    ->group($routes_asso);

Route::domain('{uid_asso}.' . env('SITE_URL')) //pour le reste
    ->middleware('existence_asso:association')
    ->group($routes_asso);

Route::domain('{uid_asso}.' . env('SITE_URL')) //les routes réservées aux bureaux
    ->middleware('existence_asso:bureau')
    ->group(function(){
        Route::controller(AssociationController::class)->group(function(){
            Route::get('/association', 'index');
            Route::get('/association/{slug}', 'show');
        });
    });


// easter eggs
Route::get('/matrix', function() {  return view('oeufs_de_paques.matrix'); });
Route::get('/ecriture', function() {  return view('oeufs_de_paques.ecriture'); });
Route::get('/cookies', function() {  return view('cookies'); });

// accéder aux erreur
Route::get('/{erreur}', function($erreur) { return abort($erreur); })->where(['erreur'=>'401|403|404|405|419|429|500|503']);