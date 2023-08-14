<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_id',
        'titre',
        'description',
        'date_apparition',
        'date_expiration',
        'entite_id',
        'campus_id'
    ];

    function event()
    {
        return $this->belongsTo(Evenement::class);
    }
    function entite()
    {
        return $this->belongsTo(Entite::class);
    }
    function tags()
    {
        return $this->belongsToMany(Tag::class, TagPost::class);
    }
    function campus()
    {
        return $this->belongsTo(Site::class);
    }
}
