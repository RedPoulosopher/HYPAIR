<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_id',
        'titre',
        'description',
        'date_apparition',
        'date_expiration',
        'entite_id',
        'confidentiel',
        'photo_name',
        'notification_sent',
    ];

    function event()
    {
        return $this->belongsTo(Evenement::class);
    }
    function entite()
    {
        return $this->belongsTo(Entite::class);
    }
    function tags()
    {
        return $this->belongsToMany(Tag::class, 'tags_posts');
    }
    function campus()
    {
        return $this->belongsToMany(Site::class, 'sites_posts');
    }
    function bannieres() {
        return $this->hasMany(Banniere::class);
    }
    function entite_collab()
    {
        return $this->belongsToMany(Entite::class,'post_collabs');
    }    

    function url(){
        return '/' . $this->entite()->first()->uid . '/entite/post/' . $this->id;
    }
}
