<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;

    protected $table = 'roles';

    protected $fillable = [
        'entite_uid',
        'user_uid',
        'role_uid',
        'ordre',
    ];

    public function entite()
    {
        return $this->belongsTo(Entite::class, 'entite_uid', 'uid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uid', 'uid');
    }

    public function role()
    {
        return $this->belongsTo(RoleList::class, 'role_uid', 'uid');
    }
}