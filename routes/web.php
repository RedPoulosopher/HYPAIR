<?php

use Illuminate\Support\Facades\Route;

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

Route::get('contact', [\App\Http\Controllers\ContactController::class, 'contact'])->name('ContactController.contact');
Route::post('contact', [\App\Http\Controllers\ContactController::class, 'contactPost'])->name('ContactController.contactPost');

Route::get('/', function() {  return view('attente'); });
Route::get('/attente', function() {  return view('attente'); });
Route::get('accueil', function() {  return view('accueil'); });
Route::get('commande', function() {  return view('commande'); });
Route::get('connexion', function() {  return view('connexion'); });
Route::get('markdown', function() {  return view('markdown'); });

Route::get('doc', function() {  return view('documentation.creation_moche'); });

use App\Http\Controllers\DocumentationController;
Route::get('nouvelle_documentation', [DocumentationController::class, 'create']);
Route::post('nouvelle_documentation', [DocumentationController::class, 'store']);
Route::get('nouvelle_documentation/{slug}', [DocumentationController::class, 'edit']);
Route::post('nouvelle_documentation/{slug}', [DocumentationController::class, 'update']);
Route::get('documentations', [DocumentationController::class, 'index']);
Route::get('documentation/{slug}', [DocumentationController::class, 'show']);
