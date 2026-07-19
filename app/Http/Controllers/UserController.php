<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function home() {
        if (Auth::check()) {
            $user = Auth::user();
            $user["chemin_photo_de_profil"] = $user->profilePicture?->path;
            $reseaux_sociaux = $user->reseauxSociaux()->get();
            //Get entites
            $entites_admin = $user->organizerWithinEntities;
            $entites_membre = [];//$user->membres_actuel;

            return view('espace_utilisateur.home', ['user'=>$user, 'reseaux_sociaux'=>$reseaux_sociaux, 'entites_admin'=>$entites_admin ,'entites_membre'=>$entites_membre]);
        }

        return redirect('/connexion');
    }
}
