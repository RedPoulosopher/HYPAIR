<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    use HasFactory;
    protected $fillable = ['langue', 'associations_id', 'confidentialite', 'titre', 'slug', 'contenu', 'mise_en_avant', 'categories', 'debut_mise_en_avant', 'fin_mise_en_avant'];
}
