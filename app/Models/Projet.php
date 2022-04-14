<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'slug',
        'association_id',
        'confidentialite',
        'chef_projet',
        'description_courte',
        'date_creation',
        'date_fin'
    ];
    public function Projet(){
        return $this->belongsTo(Association::class||User::class);
    }
    public function Avancee(){
        return $this->hasMany(Avancee::class);
    }
}
