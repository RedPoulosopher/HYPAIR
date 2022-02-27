<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class avancees_projets extends Model
{
    use HasFactory;
    protected $fillable=[
        'projet_id',
        'description',
        'date_publicatio'
    ];
    
}
