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
        return self::where('label', $role_label)->first()["id"];
    }
}
