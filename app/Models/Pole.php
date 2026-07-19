<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Pole extends Model
{
    use HasUuids;

    protected $table = 'poles_list';

    protected $primaryKey = 'uid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'ordre',
        'create_by',
    ];

    public function creator()
    {
        return $this->belongsTo(Entite::class, 'create_by', 'uid');
    }

    public function roles()
    {
        return $this->hasMany(RoleList::class, 'pole_uid', 'uid');
    }
}