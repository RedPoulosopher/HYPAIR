<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = [
        'label',
    ];

    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'user_sites',
            'site_id',
            'user_uid'
        );
    }

    public function entites()
    {
        return $this->belongsToMany(
            Entite::class,
            'entite_sites',
            'site_id',
            'entite_uid'
        );
    }

    public function events()
    {
        return $this->belongsToMany(
            Event::class,
            'event_sites',
            'site_id',
            'event_uid'
        );
    }
}