<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentationController;

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
Route::get('/connexion', function() {  return view('connexion'); });

Route::domain('{slug_asso}.' . env('SITE_URL'))
    ->middleware('existence_asso')
    ->group(function () {
        Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'contact'])->name('ContactController.contact');
        Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'contactPost'])->name('ContactController.contactPost');

        Route::get('/', function() {  return view('attente'); });
        Route::get('/accueil', function($slug_asso) { return view('accueils_asso.' . $slug_asso); });

        Route::get('/nouvelle_documentation', [DocumentationController::class, 'create']);
        Route::post('/nouvelle_documentation', [DocumentationController::class, 'store']);
        Route::get('/nouvelle_documentation/{slug}', [DocumentationController::class, 'edit']);
        Route::post('/nouvelle_documentation/{slug}', [DocumentationController::class, 'update']);
        Route::get('/documentations', [DocumentationController::class, 'index']);
        Route::get('/documentation/{slug}', [DocumentationController::class, 'show']);
});

// easter eggs
Route::get('/matrix', function() {  return view('oeufs_de_paques.matrix'); });
Route::get('/ecriture', function() {  return view('oeufs_de_paques.ecriture'); });
Route::get('/cookies', function() {  return view('cookies'); });

// accéder aux erreurs
Route::get('/{erreur}', function($erreur) { return abort($erreur); })->where(['erreur'=>'401|403|404|405|419|429|500|503']);