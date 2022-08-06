<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use \App\Models\User;
use \App\Models\Association;
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

        $asso = Association::where('uid', $request->route('uid_asso'));

        if(!$asso->exists()){
            return abort(405);
        }
        
        $asso = $asso->first();

        if($asso["type"] == "liste" && $type != "liste"){ //essaye d'acceder a une liste via {liste}.imt-ne.fr/
            abort(405, "les listes sont seulement accessibles via liste.imt-ne.fr/{nom_de_la_liste}");
        }
        else if($type == "bureau" && $asso["type"] != "bureau"){ //les routes réservées aux bureaux
            abort(403);
        }

        session([
            "association_id" => $asso["id"],
            "association_couleur_claire" => $asso["couleur_claire"],
            "association_couleur_sombre" => $asso["couleur_sombre"],
        ]);
        
        if( Auth::check() ){
            $membre = Auth::user()->membres()->where("id", $asso["id"]);
            if($membre->exists()){
                $role = $membre->first()->role();
                session([
                    "membre_id" => $membre->first()["id"],
                    "role_id" => $role->first()["id"],
                ]);
            } else {
                session([
                    "membre_id" => false,
                    "role_id" => false,
                ]); //il n'est pas membre de l'asso
            }
        }

        return $next($request);
    }
}
