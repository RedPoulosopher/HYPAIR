<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\EntiteController;
use App\Http\Controllers\MembreController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReseauSocialController;
use App\Http\Controllers\UserController;

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
Route::get('/', function(){return redirect('/entites/douai');});

Route::get('/entites', function(){return view('entite.choix_site');})->name('racine');
Route::get('/entites/{site}', [EntiteController::class, 'index_site'])->where(['site'=>'douai|lille|valencienne|dunkerke']); //liste de toutes les entite d'un site de l'école (e.g. Douai)

Route::controller(AuthController::class)->group(function(){
    Route::get('/connexion', 'affichage_formulaire')->name("connexion");
    Route::post('/connexion', 'connexion');
    Route::get('/deconnexion', 'deconnexion');
});
Route::get('/cookies', function() {  return view('cookies'); });
Route::get('/rgpd', function() {  return redirect('/air/documentation/rgpd'); });

//easter eggs
//============
Route::get('/matrix', function() {  return view('oeufs_de_paques.matrix'); });
Route::get('/ecriture', function() {  return view('oeufs_de_paques.ecriture'); });

//accéder aux erreurs
//====================
Route::get('/{erreur}', function($erreur) { return abort($erreur); })->where(['erreur'=>'401|403|404|405|419|429|500|503']);

//fenêtres contextuelles
//====================
Route::get('/fenetre_contextuelle/cookies', function(){return view('fenetre_contextuelle.cookies');});
Route::get('/fenetre_contextuelle/rgpd', function(){return view('fenetre_contextuelle.rgpd');});

//users profile
//====================
Route::controller(UserController::class)->group(function(){
  Route::get('/home', 'home');
  Route::get('/editer_photo_profil', 'editer_photo_profil');
  Route::post('/editer_photo_profil', 'maj_photo_profil');
  Route::get('/editer_infos_profil', 'editer_infos_profil');
  Route::post('/editer_infos_profil', 'maj_infos_profil');
  Route::get('/editer_reseaux_profil', 'editer_reseaux_profil');
  Route::post('/editer_reseaux_profil', 'enregistrer_reseaux_profil');
});

//les routes réservées à l'AIR
//============================
$routes_AIR = function(){
        Route::middleware('protection.autorisation:gerer_entite')->group(function(){

            Route::controller(EntiteController::class)->group(function(){
                Route::get('/entites/admin', 'index_admin');
                Route::get('/entites/index/json', 'index_admin_json');

                Route::get('/entite/nouvelle', 'create');
                Route::post('/entite/nouvelle', 'store');
                Route::get('/entite/{entite_id}/modifier/informations', 'modifier_infos')->name('modifier_infos');
                Route::post('/entite/{entite_id}/modifier/informations', 'maj_infos');
                Route::get('/entite/{entite_id}/modifier/description', 'modifier_description')->name('modifier_description');
                Route::post('/entite/{entite_id}/modifier/description', 'maj_description');
            });

            Route::controller(LogoController::class)->group(function(){
                Route::get('/entite/{entite_id}/logotype', 'modifier_logo')->name('modifier_logotype');
                Route::post('/entite/{entite_id}/logotype', 'maj_logo');
                Route::get('/entite/{entite_id}/couleur', 'modifier_couleur')->name('modifier_couleur');
                Route::post('/entite/{entite_id}/couleur', 'maj_couleur');
            });

            Route::controller(MembreController::class)->group(function(){
                Route::get('/entite/{entite_id}/{type}', 'index_admin')->where(['type'=>'membres|abonnes'])->name('gestion_membres');
                Route::post('/entite/{entite_id}/{type}', 'ajout_membre')->where(['type'=>'membres|abonnes']);
            });

            Route::controller(ReseauSocialController::class)->group(function(){
                Route::get('/entite/{entite_id}/reseau_social', 'create');
                Route::post('/entite/{entite_id}/reseau_social', 'store');
                Route::delete('/entite/{entite_id}/reseau_social', 'delete');
            });
        });
    };


//les routes réservées aux différents bureaux
//===========================================
$routes_bureaux = function(){
        Route::controller(EntiteController::class)->group(function(){
            Route::get('/entites', 'index_bureau');

            Route::middleware('protection.autorisation:gerer_entite')->group(function(){
                Route::get('/entites/gestion', 'index_admin');

                Route::get('/entite/{entite_id}/modifier/informations', 'modifier_infos');
                Route::post('/entite/{entite_id}/modifier/informations', 'maj_infos');
                Route::get('/entite/{entite_id}/modifier/description', 'modifier_description');
                Route::post('/entite/{entite_id}/modifier/description', 'maj_description');
            });

            Route::controller(MembreController::class)->group(function(){
                Route::get('/entite/{entite_id}/{type}', 'index_admin')->where(['type'=>'membres|abonnes']);
                Route::post('/entite/{entite_id}/{type}', 'ajout_membre')->where(['type'=>'membres|abonnes']);
            });
        });
    };


//les routes pour les entites, les clubs et les listes
//=========================================================
$routes_entites = function () {

    Route::controller(DocumentationController::class)->group(function(){
        Route::middleware('protection.autorisation:gerer_documentation')->group(function(){
            Route::get('/documentation/nouvelle', 'create');
            Route::post('/documentation/nouvelle', 'store');
            Route::get('/documentation/{documentation_id}/modifier', 'edit');
            Route::post('/documentation/{documentation_id}/modifier', 'update');
        });
        Route::get('/documentation', 'index');
        Route::get('/documentation/{slug}', 'show')->name('documentation_afficher');
    });

    Route::controller(EntiteController::class)->group(function(){
        Route::get('/a_propos', 'show')->name('a_propos');
        Route::get('/accueil', 'show');
        Route::get('/', 'show')
            ->name('entite');
        Route::middleware('protection.autorisation:gerer_entite')->group(function(){
            Route::get('/entite/gestion', 'gestion');
            Route::get('/entite/modifier/description/', 'modifier_description');
            Route::post('/entite/modifier/description/', 'maj_description');
        });
    });

    Route::controller(ReseauSocialController::class)->group(function(){
        Route::middleware('protection.autorisation:gerer_entite')->group(function(){
            Route::get('/entite/reseau_social', 'create');
            Route::post('/entite/reseau_social', 'store');
            Route::delete('/entite/reseau_social', 'delete');
        });
    });

    Route::controller(MembreController::class)->group(function(){
        Route::get('/entite/{type}', 'index_admin')->where(['type'=>'membres|abonnes']);
        Route::post('/entite/{type}', 'ajout_membre')->where(['type'=>'membres|abonnes']);
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
