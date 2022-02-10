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

        if($type == "liste"){
            $operateur = "=";
        } else {
            $operateur = "!=";
        }

        $asso = Association::where('uid', $request->route('uid_asso'))->where("type", $operateur, "liste");

        if($asso->exists()){
            $asso = $asso->first();
            session([
                "association_uid" => $asso["uid"],
                "association_couleur_claire" => $asso["couleur_claire"],
                "association_couleur_sombre" => $asso["couleur_sombre"],
                "association_menu_perso" => $asso["menu_perso"],
                "association_accueil_perso" => $asso["accueil_perso"],
            ]);
            
            if( Auth::check() ){
                $membre = Auth::user()->membres()->where("association_uid", $asso["uid"])->first();
                if($membre->exists()){
                    $role = $membre->role();
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
		}else{
			return abort(405);
		}

        return $next($request);
    }
}
