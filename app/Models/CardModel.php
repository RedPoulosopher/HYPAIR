<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;



class CardModel extends Model
{
    protected $table = 'cards_model';

    use HasUuids;
    protected $primaryKey = 'uid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'title',
        'subtitle',
        'entite_uid',
        'logo',
        'color_1',
        'color_2',
        'font_color_1',
        'font_color_2',
        'background',
        'expirate_condition',
    ];
    
    public function entity()
    {
        return $this->belongsTo(Entite::class, 'entite_uid', 'uid');

    }

    public function userCards()
    {
        return $this->hasMany(UserCard::class, 'card_model_uid', 'uid');
    }
}
