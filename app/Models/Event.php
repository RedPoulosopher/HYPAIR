<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Event extends Model
{
    use HasUuids;

    protected $table = 'events';

    protected $primaryKey = 'uid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'entite_uid',
        'title',
        'description',
        'banner_uid',
        'published_at',
        'started_at',
        'ended_at',
        'validation_status',
        'max_participants',
        'visible_all',
        'sub_registrations',
        'tags',
        'lieu',
        'json_data',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
            'visible_all' => 'boolean',
            'sub_registrations' => 'boolean',
            'json_data' => 'array',
        ];
    }

    public function entite()
    {
        return $this->belongsTo(Entite::class, 'entite_uid', 'uid');
    }

    public function banner()
    {
        return $this->belongsTo(FilesRegistre::class, 'banner_uid', 'uid');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'participants', 'event_uid', 'user_uid')
            ->withPivot(['status', 'valider_uid']);
    }

    public function sites()
    {
        return $this->belongsToMany(Site::class, 'event_sites', 'event_uid', 'site_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'event_uid', 'uid');
    }

    function entite_collab()
    {
        return $this->morphToMany(
            Entite::class,
            'object',
            'com_collabs',
            'object_uid',
            'entite_uid',
            'uid',
            'uid'
        );
    }

    public static function index($annee, $mois)
    {
        $mois_padding = str_pad($mois,2,'0',STR_PAD_LEFT);
        $evenements_mois_courant =
            self::select('events.*', 'entites.name', 'entites.color_1', 'entites.color_2')
            ->where("started_at", ">=", $annee . '-' . $mois_padding . "-01 00:00:00")->where("started_at", "<=", $annee . '-' .  $mois_padding . "-31 23:59:59")
            ->orWhere("ended_at", ">=", $annee . '-' . $mois_padding . "-01 00:00:00")->where("ended_at", "<=", $annee . '-' .  $mois_padding . "-31 23:59:59")
            ->join('entites', 'entites.uid', '=', 'events.entite_uid');
        return $evenements_mois_courant;
    }
}