<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\GestionPhotoDeProfil;
use \App\Models\ReseauSocialListe;
use \App\Models\ReseauSocial;

class UserController extends Controller
{

  public function home() {
    if (Auth::check()) {
      $user = Auth::user();
      $user["chemin_photo_de_profil"] = GestionPhotoDeProfil::chemin_utilisateur_photo($user);
      $reseaux_sociaux = $user->reseaux_sociaux()->get();
      return view('espace_utilisateur.home', ['user'=>$user, 'reseaux_sociaux'=>$reseaux_sociaux]);
    }
    return redirect('/connexion');
  }

  public function editer_photo_profil() {
    if (Auth::check()) {
      $user = Auth::user();
      $user["chemin_photo_de_profil"] = GestionPhotoDeProfil::chemin_utilisateur_photo($user);
      return view('espace_utilisateur.editer_photo_profil', ['user'=>$user]);
    }
    return redirect('/connexion');
  }

  public function maj_photo_profil(Request $request) {
    if (Auth::check()) {

      $user = Auth::user();

      $validation = [
        /* lorsque le problème de la bibliothèque GD sera réglé remplacer la validation par le commentaire si dessous */
  			/*'input-photo' => ['required','image','dimensions:min_width=512,min_height=512','max:2000'],*/
        'input-photo' => ['required','file','mimes:png','dimensions:min_width=512,min_height=512','max:2000'],
  		];
  		$this->validate($request, $validation);
      GestionPhotoDeProfil::stocker_photo_profil($request->file('input-photo'), $user);
      $user->photo = 1;
      $user->save();

      return redirect('/home');
    }
    return redirect('/connexion');
  }

  public function editer_infos_profil() {
    if (Auth::check()) {
      return view('espace_utilisateur.editer_infos_profil', ['user'=>Auth::user()]);
    }
    return redirect('/connexion');
  }

  public function maj_infos_profil(Request $request) {
    if (Auth::check()) {

      $user = Auth::user();

      $validation = [
  			'nom' => ['required','max:40'],
  			'prenom' => ['required','max:40'],
  			'pronoms' => ['max:20'],
  			'bio' => ['max:400'],
  		];
  		$this->validate($request, $validation);

      $user->nom = $request->nom;
      $user->prenom = $request->prenom;
      $user->pronom = $request->pronoms;
      $user->bio = $request->bio;
      $user->save();

      return redirect('/home');
    }
    return redirect('/connexion');
  }

  public function editer_reseaux_profil() {
    if (Auth::check()) {
      $user = Auth::user();
      $reseaux_sociaux_existants = ReseauSocialListe::get();
      $reseaux_sociaux = $user->reseaux_sociaux()->get();

      return view('espace_utilisateur.editer_reseaux_profil', ['user'=>$user, 'reseaux_sociaux_existants'=>$reseaux_sociaux_existants, 'reseaux_sociaux'=>$reseaux_sociaux]);
    }
    return redirect('/connexion');
  }

  public function enregistrer_reseaux_profil(Request $request) {
    if (Auth::check()) {
      $reseau_social = new ReseauSocial();
      $reseau_social->reseaux_sociaux_liste_id = $request["reseaux_sociaux_liste_id"];
      $reseau_social->cle = $request["cle"];

      $user = Auth::user();
      ReseauSocial::changer_reseau_social($user, $reseau_social);

      return back()->with('success');
    }
    return redirect('/connexion');
  }

}
