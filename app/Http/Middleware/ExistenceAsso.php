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
            "association_couleur_police_accentuation_claire" => self::couleur_ecriture($asso["couleur_claire"]),
            "association_couleur_police_accentuation_sombre" => self::couleur_ecriture($asso["couleur_sombre"]),
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

    static function couleur_ecriture($couleur_accent){
        $blanc = self::lum_diff($couleur_accent, '#ffffff');
        $noir = self::lum_diff($couleur_accent, '#000000');

        if($blanc > $noir){
            return '#ffffff';
        } else {
            return '#000000';
        }
    }
    
    static function lum_diff($couleur_1, $couleur_2){
        list($R1, $G1, $B1) = sscanf($couleur_1, "#%02x%02x%02x");
        list($R2, $G2, $B2) = sscanf($couleur_2, "#%02x%02x%02x");

        $L1 = 0.2126 * pow($R1/255, 2.2) +
              0.7152 * pow($G1/255, 2.2) +
              0.0722 * pow($B1/255, 2.2);
     
        $L2 = 0.2126 * pow($R2/255, 2.2) +
              0.7152 * pow($G2/255, 2.2) +
              0.0722 * pow($B2/255, 2.2);
     
        if($L1 > $L2){
            return ($L1+0.05) / ($L2+0.05);
        }else{
            return ($L2+0.05) / ($L1+0.05);
        }
    }
}
