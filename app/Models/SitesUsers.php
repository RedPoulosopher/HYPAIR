<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitesUsers extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'site_id',
        'user_id',
    ];
}
