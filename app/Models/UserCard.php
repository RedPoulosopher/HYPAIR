<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class UserCard extends Model
{
    //
    use HasUuids;
    protected $primaryKey = 'uid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'user_cards';
    protected $fillable = [
        'card_model_uid',
        'user_uid',
        'added_by',
    ];

    public function cardModel()
    {
        return $this->belongsTo(CardModel::class, 'card_model_uid', 'uid');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_uid', 'uid');
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'added_by', 'uid');
    }
}
