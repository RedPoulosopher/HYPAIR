<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntitePerm extends Model
{
    public $timestamps = false;

    protected $table = 'entites_perms';

    protected $fillable = [
        'entite_uid',
        'perm',
    ];

    public function entite()
    {
        return $this->belongsTo(Entite::class, 'entite_uid', 'uid');
    }
}