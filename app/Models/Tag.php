<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'couleur'
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, TagPost::class);
    }

    public static function existe($tag_name)
    {
        $tag = self::where('name', $tag_name);

        if (!$tag->exists()) {
            return false;
        }

        return $tag->first();
    }
}
