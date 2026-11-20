<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ControllerAcces extends Model
{
    use HasFactory;

    protected $table = 'controller_acces';

    protected $fillable = [
        'name',
        'token',
    ];

    /**
     * Entités associées à ce contrôleur d'accès.
     */
    public function entites(): BelongsToMany
    {
        return $this->belongsToMany(
            Entite::class,
            'entite_acces',
            'controller_id',
            'entite_uid',
            'id',
            'uid'
        );
    }

    /**
     * Utilisateurs autorisés à utiliser ce contrôleur.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'user_acces',
            'controller_id',
            'user_uid',
            'id',
            'uid'
        )
            ->withPivot([
                'entite_uid',
                'add_by_user',
            ])
            ->withTimestamps();
    }

}
