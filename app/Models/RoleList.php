<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RoleList extends Model
{
    use HasUuids;

    protected $table = 'roles_list';

    protected $primaryKey = 'uid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'pole_uid',
        'ordre',
        'create_by',
    ];

    public function pole()
    {
        return $this->belongsTo(Pole::class, 'pole_uid', 'uid');
    }

    public function creator()
    {
        return $this->belongsTo(Entite::class, 'create_by', 'uid');
    }

    public function permissions()
    {
        return $this->hasMany(RolePerm::class, 'role_uid', 'uid');
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'roles',
            'role_uid',
            'user_uid'
        )->withPivot(['entite_uid', 'ordre']);
    }
}