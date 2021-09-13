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
Route::get('documentation', function() { return  view('documentation'); });
Route::get('documentations', function() { return  view('documentations'); });
// Route::get('documentations', [\App\Http\Controllers\DocumentationController::class, 'index'])->name('documentations.index');
// Route::get('documentations/{slug}', [\App\Http\Controllers\DocumentationController::class, 'show'])->name('documentations.show');
