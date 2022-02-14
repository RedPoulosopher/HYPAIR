<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projets extends Model
{
    use HasFactory;
    protected $fillable = [
        'association_id',
        'confidentialite',
        'titre',
        'slug',
        'description_courte',
        'chef_projet'
    ];
    public function projets(){
        return $this->belongsTo(Association::class||user::class);
}
}
