<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'association_id',
        'slug',
        'description',
        'temps_debut',
        'temps_fin',
        'lieu',
        'max_participation',
        'confidentialite',
        'pour_cotisant',
        'important',
        'validation',
    ];
    
    public function association(){
        return $this->belongsTo(Association::class);
    }
}
