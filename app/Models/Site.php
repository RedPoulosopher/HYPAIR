<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function entites()
    {
        return $this->belongsToMany(Entite::class, EntiteSite::class);
    }
    public function evenements()
    {
        return $this->belongsToMany(Evenement::class, SiteEvenement::class);
    }
    public function posts()
    {
        return $this->belongsToMany(Post::class, SitePost::class);
    }
}
