<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'entite_id',
        'nom',
        'extension',
    ];

    
    public function entite(){
        return $this->belongsTo(Entite::class);
    }
}
