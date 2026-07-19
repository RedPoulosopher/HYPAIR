<?php

use App\Http\Controllers\CalendrierController;
use App\Http\Controllers\ReseauSocialController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntiteController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

Route::get('/', function(){
    return view('accueil');
})->name('accueil');

Route::get('/home',[UserController::class,'home']);

Route::get('/login',[LoginController::class,'loginPage']);
Route::get('/connexion',[LoginController::class,'loginPage']);
Route::post('/login',[LoginController::class,'login']);
Route::get('/register',[LoginController::class,'registerPage']);
Route::post('/register',[LoginController::class,'register'])->name('register');


Route::prefix('/entite/{entite_uid}/dashboard')->group(function(){
    Route::get('', [EntiteController::class,'dashboard']);

    Route::get('/personnalisation',[EntiteController::class,'edit']);
    Route::post('/personnalisation',[EntiteController::class,'store']);

    Route::get('/entites', [EntiteController::class,'index_manager_entites']);
    Route::get('/entites/create',[EntiteController::class,'create']);
    Route::post('/entites/create',[EntiteController::class,'store']);
    Route::post('/entites/{supp_uid}/delete',[EntiteController::class,'delete']);
    
    Route::get('/reseau_social',[ReseauSocialController::class,'create']);
    Route::post('/reseau_social',[ReseauSocialController::class,'store']);

    Route::get('/post', [PostController::class,'index_entite']);
    Route::get('/post/create', [PostController::class,'create']);
    Route::post('/post/create', [PostController::class,'store']);
    Route::get('/post/modifier/{post_uid}/', [PostController::class,'edit']);
    Route::post('/post/modifier/{post_uid}/', [PostController::class,'store']);
    Route::post('/post/suppression/{post_uid}/', [PostController::class,'delete']);

    Route::get('/event', [EventController::class,'show_home']);
    Route::get('/event/create', [EventController::class,'create']);
    Route::post('/event/create', [EventController::class,'store']);
    Route::get('/event/modifier/{event_uid}/', [EventController::class,'edit']);
    Route::post('/event/modifier/{event_uid}/', [EventController::class,'store']);
    Route::post('/event/suppression/{event_uid}/', [EventController::class,'delete']);

    Route::get('/roles', [RoleController::class,'index']);
    Route::post('/roles/user/role', [RoleController::class,'give_role_user']);
    Route::post('/roles/user/perm', [RoleController::class,'edit_perm_user']);

    Route::get('/roles/roles/create', [RoleController::class,'create_role']);
    Route::post('/roles/roles/create', [RoleController::class,'store_role']);
    Route::get('/roles/roles/modifier/{role_uid}', [RoleController::class,'edit_role']);
    Route::post('/roles/roles/modifier/{role_uid}', [RoleController::class,'update_role']);
    Route::post('/roles/roles/suppression/{role_uid}/', [RoleController::class,'delete_role']);

    Route::get('/roles/poles/create', [RoleController::class,'create_pole']);
    Route::post('/roles/poles/create', [RoleController::class,'store_pole']);
    Route::get('/roles/poles/modifier/{pole_uid}', [RoleController::class,'edit_pole']);
    Route::post('/roles/poles/modifier/{pole_uid}', [RoleController::class,'update_pole']);
    Route::post('/roles/poles/suppression/{pole_uid}/', [RoleController::class,'delete_pole']);
});

Route::controller(CalendrierController::class)->prefix("/calendrier")->group(function () {
    Route::get('/{site?}', 'calendrier_general');
    Route::get('/index_mois_json_general/{annee}-{mois}/{site?}', 'calendrier_index_json_general');
});


Route::get('/entites/{site}', [EntiteController::class, 'index_site']);
Route::get('/entites', function(){
    return redirect("/entites/1");
});


Route::get("/entite/{entite_uid}/",[EntiteController::class,'show']);
Route::get('/cookies', function () {
    return view('cookies');
});
Route::get('/rgpd', function () {
    return redirect('/air/documentation/rgpd');
});

Route::get('/contact', function () {
    return view('contact');
});
Route::get('/files/{disk}/{path}', function ($disk,$path) {

    abort_unless(Auth::check(), 403);

    $file = Storage::disk($disk)->path($path);

    abort_unless(file_exists($file), 404);

    return response()->file($file);
})->where('path', '.*');



// ----------------------------------------- NOTIFICATIONS ----------------------------------------- //

//Route::post('/souscrire', [PushNotificationController::class, 'souscrireNotifications']);

// ------------------------------------------------------------------------------------------------ //

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

// Route::get('/', function () {
//     return redirect('/entites/douai');
// });

// ----------------------------------------- NOTIFICATIONS ----------------------------------------- //

/*Route::post('/souscrire', [PushNotificationController::class, 'souscrireNotifications']);

// ------------------------------------------------------------------------------------------------ //

// Offline page for PWA
Route::get('/offline', function () {

    return view('pwa.offline');
});

Route::get('/admin', [AuthController::class, 'admin'])->name('admin');
Route::post('/admin', [AuthController::class, 'connexion_admin']);

Route::get('/add-media', function () {
    Avancee::create()->addMedia(storage_path('images/logo_air.png')->toMediaCollection());
});

Route::get('/a-propos', function () {
    return view('a_propos');
});

Route::get('/campagnes', [EntiteController::class, 'campagnes'])->name('campagnes');

// Route::get('/', [PostController::class, 'accueil']);
// Attention à l'orthographe des campus (uid)
Route::get('/{site?}', [PostController::class, 'accueil'])->where(['site' => 'douai|lille|valenciennes|dunkerque|alençon'])->name('accueil');

Route::get('/posts/{site?}', [PostController::class, 'posts'])->where(['site' => 'douai|lille|valenciennes|dunkerque|alençon'])->name('posts');

Route::get('/entites', function () {
    // return view('entite.choix_site');
    return redirect('entites/'.Site::getFromLabel(null)->toArray()['label']);
})->name('racine');

Route::get('/entites/{site}', [EntiteController::class, 'index_site'])->where(['site' => 'douai|lille|valenciennes|dunkerque|alençon']); // liste de toutes les entités d'un site de l'école (e.g. Douai)

Route::controller(AuthController::class)->group(function () {
    Route::get('/connexion', 'connexion')->name("connexion");
    Route::get('/deconnexion', 'deconnexion');
});

Route::get('/cookies', function () {
    return view('cookies');
});
Route::get('/rgpd', function () {
    return redirect('/air/documentation/rgpd');
});

Route::get('/contact', function () {
    return view('contact');
});

// Easter eggs
//============
Route::get('/matrix', function () {
    return view('oeufs_de_paques.matrix');
});
Route::get('/ecriture', function () {
    return view('oeufs_de_paques.ecriture');
});
Route::get('/cookies', function () {
    return view('cookies');
});

// Accéder aux erreurs
//====================
Route::get('/{erreur}', function ($erreur) {
    return abort($erreur);
})->where(['erreur' => '401|403|404|405|419|429|500|503']);

// Debug
//====================
Route::get('/debug/notifications', function () {
    return view('notifications.debug');
});

// Fenêtres contextuelles
//====================
Route::get('/fenetre_contextuelle/cookies', function () {
    return view('fenetre_contextuelle.cookies');
});
Route::get('/fenetre_contextuelle/rgpd', function () {
    return view('fenetre_contextuelle.rgpd');
});

// users profile
//====================
Route::controller(UserController::class)->group(function () {
    Route::get('/home', 'home');
    Route::get('/editer_photo_profil', 'editer_photo_profil');
    Route::post('/editer_photo_profil', 'maj_photo_profil');
    Route::get('/editer_infos_profil', 'editer_infos_profil');
    Route::post('/editer_infos_profil', 'maj_infos_profil');
    Route::get('/editer_reseaux_profil', 'editer_reseaux_profil');
    Route::post('/editer_reseaux_profil', 'enregistrer_reseaux_profil');
    Route::get('/choix-promo/{promo}', 'choix_promo');
    Route::get('/choix-campus/{campus}', 'choix_campus');
    Route::get('/reset_choix', 'reset_choix_promo_campus');
});

// les routes réservées à l'AIR
//============================
$routes_AIR = function () {
    Route::middleware('protection.autorisation:gerer_entite')->group(function () {

        Route::controller(EntiteController::class)->group(function () {
            Route::get('/entites/admin', 'index_admin');

            Route::get('/entite/nouvelle', 'create');
            Route::post('/entite/nouvelle', 'store');

            Route::get('/entite/{entite_id}/modifier/informations', 'modifier_infos')->name('air_modifier_infos');
            Route::post('/entite/{entite_id}/modifier/informations', 'maj_infos');
            Route::get('/entite/{entite_id}/modifier/description', 'modifier_description')->name('air_modifier_description');
            Route::post('/entite/{entite_id}/modifier/description', 'maj_description');
        });

        Route::controller(LogoController::class)->group(function () {
            Route::get('/entite/{entite_id}/logotype', 'modifier_logo')->name('air_modifier_logotype');
            Route::post('/entite/{entite_id}/logotype', 'maj_logo');
            
            Route::get('/entite/{entite_id}/couleur', 'modifier_couleur')->name('air_modifier_couleur');
            Route::post('/entite/{entite_id}/couleur', 'maj_couleur');
        });

        Route::controller(MembreController::class)->group(function () {
            Route::get('/entite/{entite_id}/{type}', 'index_admin')->where(['type' => 'membres|abonnes'])->name('air_gestion_membres');
            Route::post('/entite/{entite_id}/{type}', 'ajout_membre')->where(['type' => 'membres|abonnes']);
            Route::post('/entite/{entite_id}/{type}/suppression', 'suppression_membre')->where(['type' => 'membres|abonnes']);
        });

        Route::controller(ReseauSocialController::class)->group(function () {
            Route::get('/entite/{entite_id}/reseau_social', 'create');
            Route::post('/entite/{entite_id}/reseau_social', 'store');
            Route::delete('/entite/{entite_id}/reseau_social', 'delete');
        });
    });
};


//les routes réservées aux différents bureaux
//===========================================
$routes_bureaux = function () {
    // Route::controller(EntiteController::class)->group(function () {
        // Route::get('/entites', 'index_bureau'); //Not working
    // });

    Route::middleware('protection.autorisation:gerer_entite')->group(function () {
        
        
        Route::controller(EntiteController::class)->group(function () {
            Route::get('/entites/gestion', 'index_admin');

            Route::get('/entite/nouvelle', 'create');
            Route::post('/entite/nouvelle', 'store');

            Route::get('/entite/{entite_id}/modifier/informations', 'modifier_infos')->name('bdx_modifier_infos');
            Route::post('/entite/{entite_id}/modifier/informations', 'maj_infos');
            Route::get('/entite/{entite_id}/modifier/description', 'modifier_description')->name('bdx_modifier_description');
            Route::post('/entite/{entite_id}/modifier/description', 'maj_description');
            Route::get('/entite/{entite_id}/delete', 'delete');
        });

        Route::controller(MembreController::class)->group(function () {
            Route::get('/entite/{entite_id}/{type}', 'index_admin')->where(['type' => 'membres|abonnes'])->name('bdx_gestion_membres');
            Route::post('/entite/{entite_id}/{type}', 'ajout_membre')->where(['type' => 'membres|abonnes']);
            Route::post('/entite/{entite_id}/{type}/suppression', 'suppression_membre')->where(['type' => 'membres|abonnes']);
        });

        Route::controller(LogoController::class)->group(function () {
            Route::get('/entite/{entite_id}/logotype', 'modifier_logo')->name('bdx_modifier_logotype');
            Route::post('/entite/{entite_id}/logotype', 'maj_logo');
            
            Route::get('/entite/{entite_id}/couleur', 'modifier_couleur')->name('bdx_modifier_couleur');
            Route::post('/entite/{entite_id}/couleur', 'maj_couleur');
        });

    });
};


//les routes pour les entites, les clubs et les listes
//=========================================================
$routes_entites = function () {

    Route::controller(DocumentationController::class)->group(function () {
        Route::middleware('protection.autorisation:gerer_documentation')->group(function () {
            Route::get('/documentation/nouvelle', 'create');
            Route::post('/documentation/nouvelle', 'store');
            Route::get('/documentation/{documentation_id}/modifier', 'edit');
            Route::post('/documentation/{documentation_id}/modifier', 'update');
        });
        Route::get('/documentation', 'index');
        Route::get('/documentation/{slug}', 'show')->name('documentation_afficher');
    });
    Route::controller(ProjetController::class)->group(function () {
        Route::middleware('protection.autorisation:gerer_projet')->group(function () {
            Route::get('/projet/nouveau', 'create');
            Route::post('/projet/nouveau', 'store');
            Route::get('/projet/{projet_id}/modifier', 'edit');
            Route::post('/projet/{projet_id}/modifier', 'update');
        });
        Route::get('/projet', 'index');
    });

    Route::controller(AvanceeController::class)->group(function () {
        Route::middleware('protection.autorisation:gerer_projet')->group(function () {
            Route::get('/projet/{slug}/avancee/nouvelle', 'create');
            Route::post('/projet/{slug}/avancee/nouvelle', 'store');
            Route::get('/projet/{slug}/avancee/{avancee_id}/modifier', 'edit');
            Route::post('/projet/{slug}/avancee/{avancee_id}/modifier', 'update');
        });
        Route::get('/projet/{slug}', 'index')->name('projet_afficher');
        Route::get('/projet/{slug}/avancee/{slug_avancee}', 'show')->name('avancee_afficher');
    });
    Route::controller(EntiteController::class)->group(function () {
        Route::get('/', 'show')
            ->name('entite');

        Route::get('/entite/gestion', 'gestion');
        
        Route::middleware('protection.autorisation:gerer_entite')->group(function () {
            Route::get('/entite/informations/', 'modifier_infos');
            Route::post('/entite/informations/', 'maj_infos');

            Route::get('/entite/description/', 'modifier_description');
            Route::post('/entite/description/', 'maj_description');
        });
        // Route::get('/entite/reseaux_sociaux/', 'reseaux_sociaux');
        // Route::post('/entite/reseaux_sociaux/', 'reseaux_sociaux');

        Route::controller(EvenementController::class)->group(function () {
            Route::get('/entite/evenement', 'show_home');
            Route::post('/entite/evenement/suppression/{event_id}', 'suppression');
            Route::post('/entite/evenement/validation', 'validation');
            Route::get('/entite/evenement/formulaire', 'create');
            Route::post('/entite/evenement/formulaire', 'store');
            Route::get('/entite/evenement/modifier/{id}', 'edit');
            Route::post('/entite/evenement/modifier/{id}', 'update');
            Route::get('/entite/evenement/{slug}', 'show');
        });

        Route::controller(PostController::class)->group(function () {
            Route::get('/entite/post', 'home');
            Route::get('/entite/post/formulaire', 'create');
            Route::post('/entite/post/formulaire', 'store');
            Route::get('/entite/post/modifier/{id}', 'edit');
            Route::post('/entite/post/modifier/{id}', 'update');
            Route::post('/entite/post/suppression/{id}', 'delete');
            Route::get('/entite/post/{post_id}', 'show');
        });
    });


    Route::controller(ReseauSocialController::class)->group(function () {
        Route::middleware('protection.autorisation:gerer_reseau')->group(function () {
            Route::get('/entite/reseau_social', 'create');
            Route::post('/entite/reseau_social', 'store');
            Route::delete('/entite/reseau_social', 'delete');
        });
        // Route::get('/entite/reseaux_sociaux/', 'reseaux_sociaux');
        // Route::post('/entite/reseaux_sociaux/', 'reseaux_sociaux');
    });

    Route::controller(CalendrierController::class)->group(function () {
        Route::get('/calendrier', 'calendrier_asso');
        Route::post('/calendrier/validation', 'validation');
        Route::post('/calendrier/invalidation', 'invalidation');
        Route::post('/calendrier/suppression', 'suppression');
        Route::get('/calendrier/index_mois_json/{annee}-{mois}', 'calendrier_index_json');
    });

    Route::controller(LogoController::class)->group(function () {
        Route::get('/entite/logotype', 'modifier_logo');
        Route::post('/entite/logotype', 'maj_logo');
        Route::get('/entite/couleur', 'modifier_couleur');
        Route::post('/entite/couleur', 'maj_couleur');
    });

    Route::controller(MembreController::class)->group(function () {
        Route::get('/entite/{type}', 'index_admin')->where(['type' => 'membres|abonnes']);
        Route::post('/entite/{type}', 'ajout_membre')->where(['type' => 'membres|abonnes']);
        Route::post('/entite/{type}/suppression', 'suppression_membre')->where(['type' => 'membres|abonnes']);

    });
};

//Important !
Route::controller(CalendrierController::class)->group(function () {
    Route::get('/calendrier/{site?}', 'calendrier_general')->where(['site' => 'douai|lille|valenciennes|dunkerque|alençon']);
    Route::post('/calendrier/validation', 'validation');
    Route::post('/calendrier/invalidation', 'invalidation');
    Route::post('/calendrier/suppression', 'suppression');
    Route::get('/calendrier/index_mois_json_general/{annee}-{mois}/{site?}', 'calendrier_index_json_general')->where(['site' => 'douai|lille|valenciennes|dunkerque|alençon']);
});

Route::controller(LocalAuthController::class)->group(function () {
    Route::get('/localauth', 'index');
    Route::post('/localauth', 'connexion');
});

Route::prefix('{entite_uid}-{liste_id}') //pour les listes
    ->middleware('existence.entite:liste')
    ->group($routes_entites);

Route::prefix('{entite_uid}') //pour toutes les autres entités
    ->middleware('existence.entite:entite')
    ->group($routes_entites);

Route::prefix('{entite_uid}') //pour les bureaux
    ->middleware('existence.entite:bureau')
    ->where(['entite_uid' => '^((?!air).)*$']) #where entite_uid!='air'
    ->group($routes_bureaux);
    
//Les routes de l'air stockent le prefix dans la variable 'air_uid' (pour être sûr de ne pas écraser les routes identiques des bureaux)
Route::prefix('{air_uid}') //pour l'AIR
    ->where(['air_uid' => 'air'])
    ->middleware('existence.entite:air')
    ->group($routes_AIR);
*/