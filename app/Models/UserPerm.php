<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPerm extends Model
{
    protected $table = 'user_perms';

    protected $fillable = [
        'entite_uid',
        'user_uid',
        'perm',
        'add_or_remove',
    ];

    public function entite()
    {
        return $this->belongsTo(Entite::class, 'entite_uid', 'uid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uid', 'uid');
    }
}