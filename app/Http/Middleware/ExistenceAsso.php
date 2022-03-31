<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use \App\Models\User;
use \App\Enums\AssoTypeEnum;
use \App\Models\Association;
use \App\Models\Role;
use \App\Services\GestionLogo;
use Illuminate\Support\Facades\Auth;

class ExistenceAsso
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $type)
    {
        $input =$request->all();

        if($type == "air"){ //pour les routes réservées à l'AIR
            $uid_asso = "air";
            $request->route()->setParameter('uid_asso', "air");
        } else {
            $uid_asso = $request->route('uid_asso');
        }

        $asso = Association::where('uid', $uid_asso);
        if(!$asso->exists()){ return abort(405); }
        $asso = $asso->first();

        if($asso["type"] == AssoTypeEnum::Liste && $type != "liste"){ //essaye d'acceder a une liste via {liste}.imt-ne.fr/
            abort(405, "les listes sont seulement accessibles via liste.imt-ne.fr/{nom_de_la_liste}");
        }
        else if($type == "bureau" && $asso["type"] != AssoTypeEnum::Bureau){ //les routes réservées aux bureaux
            abort(403);
        }

        session([
            "association_uid" => $asso["uid"],
            "association_id" => $asso["id"],
            "association_logo_moyen" => $asso->logo_url("moyen"),
            "association_logo_petit" => $asso->logo_url("petit"),
            "association_logo_tres_petit" => $asso->logo_url("tres-petit"),
            "association_couleur_claire" => $asso["couleur_claire"],
            "association_couleur_sombre" => $asso["couleur_sombre"],
            "association_couleur_police_accentuation_claire" => $asso["couleur_police_accentuation_claire"],
            "association_couleur_police_accentuation_sombre" => $asso["couleur_police_accentuation_sombre"],
        ]);
        
        if( Auth::check() ){
            $membre = Auth::user()->membres()->where("association_id", $asso["id"]);

            if($membre->exists()){
                $role = $membre->first()->role();
                session([
                    "membre_id" => $membre->first()["id"],
                    "role_id" => $role->first()["id"],
                ]);
            } else {
                session([
                    "membre_id" => false,
                    "role_id" => Role::role_id('public'), //il n'est pas membre de l'asso
                ]);
            }
        }

        return $next($request);
    }
}
