<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avancee extends Model
{
    use HasFactory;
    protected $fillable=[
        'projet_id',
        'description',
        'date_publication'
    ];
    public function Avancee(){
        return $this->belongsTo(Projet::class);
}
    
}
