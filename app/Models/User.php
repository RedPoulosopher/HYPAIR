<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function membres(){
        return $this->hasMany(Membre::class);
    }

    function membres_actuel(){
        return $this->membres()
                    ->whereRAW("NOW() BETWEEN `membres`.`created_at` AND `fin_mandat`");
    }

    public static function existe($user_uid){
        $user = self::where('uid', $user_uid);

        if(!$user->exists()){return false;}
        
        return $user->first();
    }
}
