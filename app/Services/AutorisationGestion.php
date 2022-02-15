<?php
namespace App\Services;

use \App\Models\Role;
use Illuminate\Support\Facades\Auth;

class AutorisationGestion {

    public static function gestion($gestion){
        
        if( !Auth::check() || !session("role_id") ){
            return false;
        }

        $role = Role::find(session("role_id"));

        return $role[$gestion];
    }

    public static function protectionPage($gestion){
        if( !Auth::check() ) abort(401);

        if( !session("role_id") ) abort(500);

        $role = Role::find(session("role_id"));
        if( $role[$gestion] != 1) abort(403);
    }

    public static function niveau_administration(){
        $role = Role::find(session("role_id"));

        if($role===null) return 0;

        return $role["niveau_admin"];
    }
}
