<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Membre extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'entite_id',
        'user_id',
        'role_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function entite(){
        return $this->belongsTo(Entite::class);
    }
    public function role(){
        return $this->belongsTo(Role::class);
    }
    
    public function promouvoir(){
        //s'il est juste membre, on recreer une fiche avec son nouveau role
        //sinon, on met à jour son entrée
    }

    public function demettre(){
        //si on le repasse juste membre, et que date_fin > mai de l'année courrante, on supprime l'entrée, et on met à jour l'ancienne entrée avec la bonne date de fin
        //sinon, on met juste l entrée à jour
    }
}
