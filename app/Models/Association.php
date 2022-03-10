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
        'categories',
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

    public function url(){
        if($this->type == "liste"){
            return "https://liste.". env('SITE_URL') ."/". $this->uid .'-'. $this->id;
        } else {
            //local
            return $this->uid .".". env('SITE_URL') .":8000";
            //deployé
            return "https://". $this->uid .".". env('SITE_URL');
        }
    }
}
