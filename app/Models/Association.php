<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Association extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'uid',
        'bureau_de_ratachement',
        'type',
        'courriel',
        'alias',
        'sites',
        'privee',
        'annee_creation',
        'annee_fin',
        'description',
        'couleur_claire',
        'couleur_sombre',
    ];
    
    public function documentations(){
        return $this->hasMany(Documentation::class);
    }
    
    public function logos(){
        return $this->hasMany(Logo::class);
    }
    
    public function logo_actuel(){
        return $this->logos()->orderBy('nom', 'desc')->first();
    }
}
