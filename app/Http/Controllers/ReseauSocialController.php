<?php

namespace App\Http\Controllers;

use App\Enums\Permisions;
use Illuminate\Http\Request;
use \App\Models\User;
use \App\Models\Entite;
use \App\Models\ReseauSocial;
use \App\Models\ReseauSocialListe;
use \App\Services\AutorisationGestion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ReseauSocialController extends Controller
{
    public function create(Request $request)
    {
        $entite = Entite::where('uid',$request['entite_uid'])->first();
        $user = null;
        $reseaux_sociaux_models = DB::table('reseaux_sociaux')->get();
        if($entite){
            AutorisationGestion::require(Permisions::RESEAU_MANAGE,$request['entite_uid']);
            $mes_reseaux_sociaux = $entite->reseauxSociaux;
            
            return view('reseaux_sociaux.index_gestion', [
                'entite'=> $entite,
                'user'=> $user,
                'mes_reseaux_sociaux'=> $mes_reseaux_sociaux,
                'reseaux_sociaux_models'=> $reseaux_sociaux_models
            ]);
        }else{
            if (Auth::check()) {
                $user = Auth::user();
            }
            return view('reseaux_sociaux.index_gestion', []);
        }
    }

    public function store(Request $request)
    {
        $entite = Entite::where('uid',$request['entite_uid'])->first();
        if($entite){
            AutorisationGestion::require(Permisions::RESEAU_MANAGE,$request['entite_uid']);
            $entite->reseauxSociaux()->detach($request["reseaux_sociaux_liste_id"]);
            if($request["lien"]){
                $entite->reseauxSociaux()->attach($request["reseaux_sociaux_liste_id"], [
                    'url' => $request["lien"]
                ]);
            }
            
        }else{
            if (Auth::check()) {
                $user = Auth::user();
            }
        }

        return back()->with('success');
    }
}
