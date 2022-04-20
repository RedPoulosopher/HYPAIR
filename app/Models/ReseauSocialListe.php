<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReseauSocialListe extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'reseaux_sociaux_liste';


    public function res(){
        return $this->hasMany(ReseauSocial::class);
    }
}
