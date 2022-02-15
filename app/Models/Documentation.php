<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    use HasFactory;
    protected $fillable = [
        'association_id',
        'langue',
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

    public function association(){
        return $this->belongsTo(Association::class);
    }

    public function traductions(){
        return $this->hasMany(Documentation::class);
    }
}
