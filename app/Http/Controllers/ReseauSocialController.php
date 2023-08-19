<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use \App\Models\Entite;
use \App\Models\ReseauSocial;
use \App\Models\ReseauSocialListe;
use \App\Services\AutorisationGestion;

use Illuminate\Support\Facades\Route;

class ReseauSocialController extends Controller
{
    public function create()
    {
        $reseaux_sociaux_existants = ReseauSocialListe::get();

        $model = self::reseau_sociable_model();
        $reseaux_sociaux = $model->reseaux_sociaux()->get();

        return view('reseaux_sociaux.index_gestion', [
            'reseaux_sociaux_existants'=> $reseaux_sociaux_existants,
            'reseaux_sociaux'=> $reseaux_sociaux,
            'gerer_reseau' => AutorisationGestion::gestion("gerer_reseau")
        ]);
    }

    public function store(Request $request)
    {
        $reseau_social_model = new ReseauSocial();
        $reseau_social_model->reseaux_sociaux_liste_id = $request["reseaux_sociaux_liste_id"];
        $reseau_social_model->cle = $request["cle"];

        $model = self::reseau_sociable_model();
        ReseauSocial::changer_reseau_social($model, $reseau_social_model);

        return back()->with('success');
    }

    public function reseau_sociable_model()
    {
        if (str_contains($_SERVER["REQUEST_URI"], "entite")) { //si une entite ajoute un réseau social
            $entite_id = request()->route('entite_id') ?? session('entite_id');

            return Entite::existe($entite_id);
        } else { //si un utilisateur ajoute un réseau social
            if (Auth::check()) {
                return Auth::user();
            }
        }
    }
}
