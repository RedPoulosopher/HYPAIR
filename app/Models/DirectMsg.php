<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DirectMsg extends Model
{
    use HasUuids;

    protected $table = 'direct_msg';

    protected $primaryKey = 'uid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'title',
        'content',
        'sender_uid',
        'sender_entite_uid',
        'receiver_uid',
        'receiver_entite_uid',
    ];

    public function senderUser()
    {
        return $this->belongsTo(User::class, 'sender_uid', 'uid');
    }

    public function receiverUser()
    {
        return $this->belongsTo(User::class, 'receiver_uid', 'uid');
    }

    public function senderEntite()
    {
        return $this->belongsTo(Entite::class, 'sender_entite_uid', 'uid');
    }

    public function receiverEntite()
    {
        return $this->belongsTo(Entite::class, 'receiver_entite_uid', 'uid');
    }
}