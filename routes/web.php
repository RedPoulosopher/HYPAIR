<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\AssociationController;
use App\Http\Controllers\MembreController;
use App\Http\Controllers\LogoController;
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


Route::domain('air.' . env('SITE_URL')) //les routes réservées à l'AIR
    ->middleware('existence_asso:air')
    ->group(function(){
        Route::controller(AssociationController::class)->group(function(){
            Route::get('/associations', 'index_admin');
            Route::get('/association/index/json', 'index_admin_json');

            Route::get('/association/nouvelle', 'create');
            Route::post('/association/nouvelle', 'store');
            Route::get('/association/modifier/{asso_id}', 'edit')->name('modifier');
            Route::post('/association/modifier/{asso_id}', 'update');
        });
        Route::controller(LogoController::class)->group(function(){
            Route::get('/association/logotype/{asso_id}', 'create')->name('logotype');
            Route::post('/association/logotype/{asso_id}', 'store');
        });
        Route::controller(MembreController::class)->group(function(){
            Route::get('/association/passation/{asso_id}', 'passation')->name('passation');
            Route::post('/association/passation/{asso_id}', 'passation_store');
        });
    });

Route::domain('{uid_asso}.' . env('SITE_URL')) //les routes réservées aux bureaux
    ->middleware('existence_asso:bureau')
    ->group(function(){
        Route::controller(AssociationController::class)->group(function(){
            Route::get('/associations', 'index');
            Route::get('/association/passation/{asso_id}', 'passation');
            Route::post('/association/passation/{asso_id}', 'passation_post');
        });
    });
    
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

    Route::controller(AssociationController::class)->group(function(){
        Route::get('/a_propos', 'show');
        Route::get('/association/description/', 'description_edit');
        Route::post('/association/description/', 'description_update');
        Route::get('/association/reseaux_sociaux/', 'reseaux_sociaux');
        Route::post('/association/reseaux_sociaux/', 'reseaux_sociaux');
    });
};

Route::domain('liste.' . env('SITE_URL')) //pour les listes
    ->prefix('{uid_asso}-{id_asso}')
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