<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public function membres(){
        return $this->hasMany(Membre::class);
    }

    public static function role_id($role_label){
        $role = self::where('label', $role_label);

        if($role->exists()){
            return $role->first()["id"];
        }

        throw new \ErrorException("Le rôle '".$role_label."' n'existe pas.");
    }
}
