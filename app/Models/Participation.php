<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    use HasFactory;
    protected $fillable = [
        'status',
        'date-maj'
    ];
    
    public function event(){
        return $this->belongsTo(Evenement::class);
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}
