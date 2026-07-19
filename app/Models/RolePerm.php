<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePerm extends Model
{
    public $timestamps = false;

    protected $table = 'perm_role_list';

    protected $fillable = [
        'role_uid',
        'perm',
    ];

    public function role()
    {
        return $this->belongsTo(RoleList::class, 'role_uid', 'uid');
    }
}