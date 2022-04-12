<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    use HasFactory;
    protected $fillable = [
        'entite_id',
        'confidentialite',
        'visibilite',
        'derive_de',
        'titre',
        'slug',
        'description',
        'contenu_md',
        'categories',
        'mise_en_avant',
        'debut_mise_en_avant',
        'fin_mise_en_avant'
    ];

    public function entite(){
        return $this->belongsTo(Entite::class);
    }

    public function derivation(){
        return $this->hasMany(Documentation::class);
    }

    public function existe(){
        $doc = Entite::find($this->id);

		if(is_null($doc)){abort(404);}
        
        return $doc; 
    }
}
