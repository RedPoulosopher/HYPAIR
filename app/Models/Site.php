<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Site extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function entites()
    {
        return $this->belongsToMany(Entite::class, EntiteSite::class);
    }
    public function evenements()
    {
        return $this->belongsToMany(Evenement::class, 'sites_evenements');
    }
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'sites_posts');
    }
    public function users() {
        return $this->belongsToMany(User::class, 'sites_users');
    }

    public static function getFromLabel($site = null){
        if (!isset($site)) {

            // If user not connected, show Douai posts by default
            if (!Auth::check()){
                return Site::all()->first();
            }

            // If connected, check the campus in the session and if exists, go to it
            $session_campus = session('campus', null);
            if(isset($session_campus)){
                return $session_campus;
            }

            // If no session campus, go to first one in the user's campus list
            $user = Auth::user();
            if (count($user->campus)>0) {
                return $user->campus->first();
            }

            // If user has no campus saved, show Douai posts by default
            return Site::all()->first();
            
        } else {
            //If a campus is selected
            $campus = Site::where('label', $site)->first();

            // Save the campus in the session as the future default
            session(['campus' => $campus]);

            return $campus;
        }
    }
}
