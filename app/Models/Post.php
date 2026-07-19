<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

use Illuminate\Database\Eloquent\Relations\MorphMany;
class Post extends Model
{
    use HasUuids;

    protected $table = 'posts';

    protected $primaryKey = 'uid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'entite_uid',
        'event_uid',
        'title',
        'content',
        'banner_uid',
        'published_at',
        'archived_at',
        'tags'
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'archived_at' => 'datetime',
            'json_data' => 'array',
        ];
    }

    public function entite()
    {
        return $this->belongsTo(Entite::class, 'entite_uid', 'uid');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_uid', 'uid');
    }

    public function banner()
    {
        return $this->belongsTo(FilesRegistre::class, 'banner_uid', 'uid');
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

    function url(){
        return '/entite/' . $this->entite()->first()->uid . '/post/' . $this->id;
    }


    
}