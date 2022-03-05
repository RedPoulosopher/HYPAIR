<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'association_id',
        'nom',
        'extension',
    ];

    
    public function association(){
        return $this->belongsTo(Association::class);
    }
}
