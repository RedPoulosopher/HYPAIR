<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use \App\Models\User;
use \App\Enums\EntiteTypeEnum;
use \App\Models\Entite;
use \App\Models\Role;
use \App\Services\GestionLogo;
use Illuminate\Support\Facades\Auth;

use \App\Services\AutorisationGestion;

class ExistenceEntite
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
        $entite_uid = $request->route('entite_uid') ?? $request->route('air_uid');//(voir explication dans web.php)
        //Set 'entite_uid' parameter in the request object to $entite_uid (in case it is air_uid was passed in route)
        $request->request->add(['entite_uid' => $entite_uid]);

        $entites_model = Entite::where('uid', $entite_uid);
        if($type=="liste"){
                $entites_model = $entites_model->where('id',  $request->route('liste_id'));
            }
            if(!$entites_model->exists()){ return abort(405);}
            
            $entite = $entites_model->first();
            
            
            if($entite["type"] != EntiteTypeEnum::Liste && $type == "liste"){ //essaye d'acceder a une liste via {liste}.imt-ne.fr/
            abort(405);
    }
    else if($type == "bureau" && $entite["type"] != EntiteTypeEnum::Bureau){ //les routes réservées aux bureaux
        abort(403);
    }
    else if($type == "air" && $entite["uid"] != "air"){ //les routes réservées à l'AIR
        abort(403);
    }
    
        session([
            "entite_uid" => $entite["uid"],
            "entite_id" => $entite["id"],
            "entite_lien" => $entite->lien_relatif(),
            "entite_logo_moyen" => $entite->logo_url("moyen"),
            "entite_logo_petit" => $entite->logo_url("petit"),
            "entite_logo_tres_petit" => $entite->logo_url("tres-petit"),
            "entite_couleur_claire" => $entite["couleur_claire"],
            "entite_couleur_sombre" => $entite["couleur_sombre"],
            "entite_couleur_police_accentuation_claire" => $entite["couleur_police_accentuation_claire"],
            "entite_couleur_police_accentuation_sombre" => $entite["couleur_police_accentuation_sombre"],
        ]);
        
        session([
            "gerer_entite" => false, //on réinitialise cette valeur pour éviter d'avoir le lien sur les entités qu'on ne gère pas
        ]);

        if( Auth::check() ){
            $membre = Auth::user()->membres_actuel()->where("entite_id", $entite["id"]);

            if($membre->exists()){
                $role = $membre->first()->role();
                session([
                    "membre_id" => $membre->first()["id"],
                    "role_id" => $role->first()["id"],
                ]);
                session([
                    "gerer_entite" => AutorisationGestion::gestion("gerer_entite"),
                ]);
            } else {
                session([
                    "membre_id" => false,
                    "role_id" => Role::role_id('public'), //iel n'est pas membre de l'entite
                ]);
            }
        }
        return $next($request);
    }
}
