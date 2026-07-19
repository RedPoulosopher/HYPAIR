<?php

namespace App\Services;

use App\Enums\Permisions;
use App\Enums\PermisionsEntite;
use App\Models\Entite;
use App\Models\FilesRegistre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AutorisationGestion
{
    /**
     * Vérifie une permission dans une entité
     */
    public static function can(int $perm, string $entite_uid): bool
    {
        $entitePerm = DB::table('entites_perms')
            ->where('entite_uid', $entite_uid)
            ->where('perm', 0)
            ->exists();
        //if(!$entitePerm) return False;

        
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        $user_uid = $user->uid;

        /*
        -------------------------------------------------
        1. Perm Super User
        -------------------------------------------------
        */

        $override = DB::table('user_perms')
            ->where('user_uid', $user_uid)
            ->where('perm','=', Permisions::SU)
            ->first();

        if ($override) {
            if($override->add_or_remove === 'add'){
                return true;
            }
        }else{
            if(DB::table('roles')
                ->join('perm_role_list', 'roles.role_uid', '=', 'perm_role_list.role_uid')
                ->where('roles.user_uid', $user_uid)
                ->where('perm_role_list.perm', Permisions::SU)
                ->exists()){
                return true;
            }
        }

        /*
        -------------------------------------------------
        1. USER OVERRIDE (priorité absolue)
        -------------------------------------------------
        */

        $override = DB::table('user_perms')
            ->where('entite_uid', $entite_uid)
            ->where('user_uid', $user_uid)
            ->where('perm','=', $perm)
            ->first();

        if ($override) {
            return $override->add_or_remove === 'add';
        }

        /*
        -------------------------------------------------
        2. ROLES DU USER
        -------------------------------------------------
        */

        return DB::table('roles')
            ->join('perm_role_list', 'roles.role_uid', '=', 'perm_role_list.role_uid')
            ->where('roles.entite_uid', $entite_uid)
            ->where('roles.user_uid', $user_uid)
            ->where('perm_role_list.perm', $perm)
            ->exists();
    }

    /**
     * Vérifie si l'utilisateur a AU MOINS une permission
     */
    public static function any(array $perms, string $entite_uid): bool
    {
        foreach ($perms as $perm) {
            if (self::can($perm, $entite_uid)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Protection de page (abort 403)
     */
    public static function require(int $perm, string $entite_uid): void
    {
        if (!self::can($perm, $entite_uid)) {
            abort(403);
        }
    }

    public static function requireRole( string $entite_uid): void{
        $entite = Entite::find($entite_uid)->exists();
        if(!$entite) abort(403);

        $user = Auth::user();

        if (!$user) abort(403);

        $user_uid = $user->uid;

        /*
        -------------------------------------------------
        1. Perm Super User
        -------------------------------------------------
        */

        $override = DB::table('user_perms')
            ->where('user_uid', $user_uid)
            ->where('perm','=', Permisions::SU)
            ->first();

        if ($override) {
            if($override->add_or_remove === 'add'){
                return;
            }
        }else{
            if(DB::table('roles')
                ->join('perm_role_list', 'roles.role_uid', '=', 'perm_role_list.role_uid')
                ->where('roles.user_uid', $user_uid)
                ->where('perm_role_list.perm', Permisions::SU)
                ->exists()){
                return;
            }
        }

        /*
        -------------------------------------------------
        1. USER OVERRIDE (priorité absolue)
        -------------------------------------------------
        */

        $override = DB::table('user_perms')
            ->where('entite_uid', $entite_uid)
            ->where('user_uid', $user_uid)
            ->first();

        if ($override && $override->add_or_remove === 'add') {
            return;
        }

        /*
        -------------------------------------------------
        2. ROLES DU USER
        -------------------------------------------------
        */

        if(DB::table('roles')
            ->join('perm_role_list', 'roles.role_uid', '=', 'perm_role_list.role_uid')
            ->where('roles.entite_uid', $entite_uid)
            ->where('roles.user_uid', $user_uid)
            ->exists())return;

        abort(403);
    }

    public static function require_for_file(int $perm,string $path,string $disk = 'public'): void{
        self::can_for_file($perm,$path,$disk);
    }

    public static function can_for_file(int $perm,string $path,string $disk = 'public'): void{
        if(FileService::exists($path,$disk)){
            $file = FilesRegistre::where("path","=",$path)->firstOrFail();
            $json = $file->json_data;
            switch($json['acces']){
                case 'public':
                    return;
                case 'certifier':
                    break;
                case 'imtne':
                    break;
                case 'private':
                    break;
                
            }
        }
        abort(404);
    }
}