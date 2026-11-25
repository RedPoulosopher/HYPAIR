<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Team extends Model
{
    use HasUuids;

    protected $table = 'teams';

    protected $primaryKey = 'uid';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'label',
        'couleur',
    ];


    public function users(){
        return $this->hasMany(User::class, 'team_uid', 'uid');
    }

    public function pointsTelethon()
    {
        return $this->hasManyThrough(
            points_telethon::class,
            User::class,
            'team_uid', // Clé étrangère sur users
            'user_uid', // Clé étrangère sur points_telethon
            'uid',      // Clé locale sur teams
            'uid'       // Clé locale sur users
        );
    }
}
