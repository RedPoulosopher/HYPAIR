<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\FilesRegistre;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasUuids;

    /**
     * Clé primaire UUID.
     */
    protected $primaryKey = 'uid';

    /**
     * La clé primaire n'est pas auto-incrémentée.
     */
    public $incrementing = false;

    /**
     * Type de la clé primaire.
     */
    protected $keyType = 'string';

    /**
     * Champs assignables en masse.
     */
    protected $fillable = [
        'nom',
        'prenom',
        'prenoms',
        'email',
        'bio',
        'num_tel',
        'uid_carte_etu',
        'lang_pref',
        'date_naissance',
        'certifier',
        'RGPD',
        'password',
        'auth_mode',
    ];

    /**
     * Champs cachés.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'date_naissance' => 'date',
            'certifier' => 'boolean',
            'RGPD' => 'boolean',
            'password' => 'hashed',
        ];
    }

    /**
     * Nom complet.
     */
    public function getNomCompletAttribute(): string
    {
        return trim(
            implode(' ', array_filter([
                $this->prenom,
                $this->nom,
            ]))
        );
    }

    public function reseauxSociaux()
    {
        return $this->belongsToMany(
            ReseauSocial::class,
            'user_reseaux_sociaux',
            'user_uid',
            'reseau_social_id'
        )->withPivot('url');
    }

    public function sites()
    {
        return $this->belongsToMany(
            Site::class,
            'user_sites',
            'user_uid',
            'site_id'
        );
    }

    public function profilePicture()
    {
        return $this->belongsTo(
            FilesRegistre::class,
            'profile_picture',
            'uid'
        );
    }

    public function idPhoto()
    {
        return $this->belongsTo(
            FilesRegistre::class,
            'id_photo',
            'uid'
        );
    }

    public function organizerWithinEntities(){
        return $this->belongsToMany(
            Entite::class,
            'roles',
            'user_uid',
            'entite_uid'
        );
    }
}