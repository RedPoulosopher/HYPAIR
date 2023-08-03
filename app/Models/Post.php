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
        'tags',
        'entite_id'
    ];

    function event()
    {
        return $this->belongsTo(Evenement::class);
    }
    function entite()
    {
        return $this->belongsTo(Entite::class);
    }
}
