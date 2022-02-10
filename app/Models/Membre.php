<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membre extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function association(){
        return $this->belongsTo(Association::class);
    }
    public function role(){
        return $this->belongsTo(Role::class);
    }
}
