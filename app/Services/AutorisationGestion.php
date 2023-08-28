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

    public static function gestion_dans_entite($gestion, $entite){
        $role = self::recuperer_role_dans_entite($entite);
        
        if($role == "non authentifié") return false;
        else if($role == "non membre") return false;

        return $role[$gestion];
    }

    public static function gestion_entite($entite){
        $role = self::recuperer_role_dans_entite($entite);
        
        if($role == "non authentifié") return false;
        else if($role == "non membre") return false;
        
        return $role["gerer_post"]  || $role["gerer_entite"] || $role["gerer_evenement"] || $role["gerer_membre"] || $role["gerer_reseau"];
        // TODO : Ajouter les autres droits lorsque les boutons pour la docu, les tickets et les projets seront faits
    }


    public static function protectionPage($gestion){
        $role = self::recuperer_role();
        if ($role == "non authentifié") abort(403);
        else if($role == "non membre") abort(403);
        else if( $role[$gestion] != 1) abort(403);
    }
    public static function recuperer_role(){
        if( !Auth::check() ) return "non authentifié";

        if( is_null(session("role_id")) ){ abort(500, "L'identifiant de votre rôle n'a pas été écrit correctement.");} //erreur serveur, l'id de la session n'a pas été écrit

        if(session("role_id") === false){ return "non membre";}

        return Role::find(session("role_id"));
    }

    public static function niveau_administration(){
        $role = self::recuperer_role();

        if($role == "non authentifié") return 0;
        else if($role == "non membre") return 0;

        return $role["niveau_admin"];
    }


    public static function recuperer_role_dans_entite($entite){
        if( !Auth::check() ) return "non authentifié";

        $membre = Auth::user()->membres_actuel()->where("entite_id", $entite["id"]);
        $role = $membre->first()->role();

        $role_id = $role->get()->first()->id;

        if( is_null($role_id) ){ abort(500, "L'identifiant de votre rôle n'a pas été écrit correctement.");} //erreur serveur, l'id de la session n'a pas été écrit

        if($role_id === false){ return "non membre";}

        return Role::find($role_id);
    }
}
