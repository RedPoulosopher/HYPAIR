<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Item_ventes extends Model
{
    use HasUuids;

    protected $table = 'item_ventes';

    protected $primaryKey = 'uid';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'label',
        'value',
        'prix',
    ];
}
