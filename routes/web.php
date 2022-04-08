<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\EntiteController;
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

Route::get('/entites/{site}', [EntiteController::class, 'index_site'])->where(['site'=>'douai','lille','valencienne','dunkerke']); //liste de toutes les entite d'un site de l'école (e.g. Douai)

//les routes réservées à l'AIR
//============================
$routes_AIR = function(){
        //les routes pour les administrateurs (ceux qui peuvent gerer l AIR pourront gerer toutes les entite)
        //================================================================================================
        Route::middleware('protection.autorisation:gerer_entite')->group(function(){

            Route::controller(EntiteController::class)->group(function(){
                Route::get('/entites/gestion', 'index_admin');
                Route::get('/entites/index/json', 'index_admin_json');
    
                Route::get('/entite/nouvelle', 'create');
                Route::post('/entite/nouvelle', 'store');
                Route::get('/entite/modifier/informations/{entite_id}', 'modifier_infos')->name('modifier_infos');
                Route::post('/entite/modifier/informations/{entite_id}', 'maj_infos');
                Route::get('/entite/modifier/description/{entite_id}', 'modifier_description')->name('modifier_description');
                Route::post('/entite/modifier/description/{entite_id}', 'maj_description');
            });

            Route::controller(LogoController::class)->group(function(){
                Route::get('/entite/logotype/{entite_id}', 'create')->name('modifier_logotype');
                Route::post('/entite/logotype/{entite_id}', 'store');
            });

            Route::controller(MembreController::class)->group(function(){
                Route::get('/entite/membres/{entite_id}', 'index_admin');
                Route::post('/entite/membres/{entite_id}', 'passation_store');
            });
        });
    };


//les routes réservées aux différents bureaux
//===========================================
$routes_bureaux = function(){
        Route::controller(EntiteController::class)->group(function(){
            Route::get('/entites', 'index_bureau');
            Route::get('/entites/gestion', 'index_admin');

            Route::get('/entite/modifier/informations/{entite_id}', 'modifier_infos');
            Route::post('/entite/modifier/informations/{entite_id}', 'maj_infos');
            Route::get('/entite/modifier/description/{entite_id}', 'modifier_description');
            Route::post('/entite/modifier/description/{entite_id}', 'maj_description');
        });
    };
    

//les routes pour les entites, les clubs et les listes
//=========================================================
$routes_entites = function () {
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
    
    Route::controller(EntiteController::class)->group(function(){
        Route::get('/a_propos', 'show')->name('a_propos');
        Route::middleware('protection.autorisation:gerer_entite')->group(function(){
            Route::get('/gestion', 'gestion');
            Route::get('/modifier/description/', 'modifier_description');
            Route::post('/modifier/description/', 'maj_description');
        });
        // Route::get('/entite/reseaux_sociaux/', 'reseaux_sociaux');
        // Route::post('/entite/reseaux_sociaux/', 'reseaux_sociaux');
    });
};

Route::prefix('{entite_uid}-{liste_id}') //pour les listes
    ->middleware('existence.entite:liste')
    ->group($routes_entites);

Route::prefix('{entite_uid}') //pour toutes les autres entités
    ->middleware('existence.entite:entite')
    ->group($routes_entites);

Route::prefix('{entite_uid}') //pour les bureaux
    ->middleware('existence.entite:bureau')
    ->group($routes_bureaux);

Route::prefix('{entite_uid}') //pour l'AIR
    ->middleware('existence.entite:air')
    ->group($routes_AIR);



//easter eggs
//============
Route::get('/matrix', function() {  return view('oeufs_de_paques.matrix'); });
Route::get('/ecriture', function() {  return view('oeufs_de_paques.ecriture'); });
Route::get('/cookies', function() {  return view('cookies'); });

//accéder aux erreurs
//====================
Route::get('/{erreur}', function($erreur) { return abort($erreur); })->where(['erreur'=>'401|403|404|405|419|429|500|503']);