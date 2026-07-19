<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Group extends Model
{
    use HasUuids;

    protected $table = 'groups';

    protected $primaryKey = 'uid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'type',
        'level',
        'create_by',
    ];

    public function creator()
    {
        return $this->belongsTo(Entite::class, 'create_by', 'uid');
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'group_user',
            'group_uid',
            'user_uid'
        );
    }
}