<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\GestionPhotoDeProfil;
use \App\Services\AutorisationGestion;
use \App\Models\ReseauSocialListe;
use \App\Models\ReseauSocial;
use \App\Models\Site;
use \App\Models\SitesUsers;
use Illuminate\Support\Facades\App;

class UserController extends Controller
{

  public function home() {
    if (Auth::check()) {
      $user = Auth::user();
      $user["chemin_photo_de_profil"] = GestionPhotoDeProfil::chemin_utilisateur_photo($user);
      $reseaux_sociaux = $user->reseaux_sociaux()->get();

      //Get entites
      $entites_admin = [];
      $entites_membre = [];

      $membres = $user->membres_actuel;
      foreach ($membres as $membre) {
        $entite = $membre->entite;
        $admin = AutorisationGestion::gestion_entite($entite);
              

        if($admin)
          array_push($entites_admin, $entite);
        else
          array_push($entites_membre, $entite);
      }

      return view('espace_utilisateur.home', ['user'=>$user, 'reseaux_sociaux'=>$reseaux_sociaux, 'entites_admin'=>$entites_admin ,'entites_membre'=>$entites_membre]);
    }

    if (App::environment('local')) {
      return redirect('/localauth');
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
  			'input-photo' => ['required','image','dimensions:min_width=256,min_height=256','max:100000']
  		];
      $messages_custom = [
        'input-photo.dimensions' => 'L\'image doit faire au minimum 256px en largeur et en hauteur.',
        'input-photo.max' => 'L\'image est trop lourde, réessayez avec une image d\'une taille inférieure à 100 méga-octets.',
        'input-photo.uploaded' => 'L\'image est trop lourde, réessayez avec une image d\'une taille inférieure à 100 méga-octets.'
      ];
  		$this->validate($request, $validation, $messages_custom);
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
      $reseau_social->lien = $request["lien"];

      $user = Auth::user();
      ReseauSocial::changer_reseau_social($user, $reseau_social);

      return back()->with('success');
    }
    return redirect('/connexion');
  }


  public function choix_promo(Request $request){
    if (Auth::check()) {
      $user = Auth::user();
      $promo = $request->route('promo');

      if(in_array($promo, ['CP1', 'CP2', 'CI1', 'CI2', 'CI3'])){//If valid promo
        $user->promo = $promo;
        $user->save();
      }
    }

    return back();
  }

  public function choix_campus(Request $request){
    // Prévoir un reset à un moment !
    if (Auth::check()) {
      $user = Auth::user();
      $site_label_list =  explode("-", $request->route('campus'));

      foreach($site_label_list as $site_label){
        $site_id = Site::select('id')->where('label', $site_label)->first()->id;
        $user->sites()->attach($site_id);
      }
    }

    return back();
  }

}
