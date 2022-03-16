<?php
namespace App\Services;

use \App\Models\Role;
use Illuminate\Support\Facades\Auth;

class AutorisationGestion {

    public static function gestion($gestion){
        $role = self::recuperer_role();
        
        if($role == "non authentifié") return false;
        else if($role == "non membre") return false;

        return $role[$gestion];
    }

    public static function protectionPage($gestion){
        $role = self::recuperer_role();

        if($role == "non authentifié") abort(401);
        else if($role == "non membre") abort(403);

        if( $role[$gestion] != 1) abort(403);
    }

    public static function niveau_administration(){
        $role = self::recuperer_role();

        if($role == "non authentifié") return 0;
        else if($role == "non membre") return 0;

        return $role["niveau_admin"];
    }

    public static function recuperer_role(){
        if( !Auth::check() ) return "non authentifié";

        if( is_null(session("role_id")) ) abort(500, "L'identifiant de votre rôle n'a pas été écrit correctement."); //erreur serveur, l'id de la session n'a pas été écrit

        if(session("role_id") === false) return "non membre";

        return Role::find(session("role_id"));
    }
}
