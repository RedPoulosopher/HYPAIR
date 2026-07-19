<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $table = 'participants';

    public $timestamps = false;

    protected $fillable = [
        'event_uid',
        'user_uid',
        'valider_uid',
        'status',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_uid', 'uid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uid', 'uid');
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'valider_uid', 'uid');
    }
}