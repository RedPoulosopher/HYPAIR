<?php

namespace App\Models;

use App\Enums\EntiteType;
use App\View\Components\entite as ComponentsEntite;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Entite extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * Table associée
     */
    protected $table = 'entites';

    /**
     * Clé primaire UUID
     */
    protected $primaryKey = 'uid';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Champs modifiables
     */
    protected $fillable = [
        'name',
        'parent_uid',
        'type',
        'short_description',
        'description',
        'founded_year',
        'visible',
        'color_1',
        'color_2',
        'email',
        'alias',
        'logo',
    ];

    /**
     * Casts
     */
    protected function casts(): array
    {
        return [
            'type' => EntiteType::class,
            'visible' => 'boolean',
            'founded_year' => 'integer',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS HIÉRARCHIQUES
    |--------------------------------------------------------------------------
    */

    /**
     * Parent (BDE, asso principale, etc.)
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_uid', 'uid');
    }

    /**
     * Enfants (sous-assos, pôles, clubs)
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_uid', 'uid');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGO (FILE REGISTRE)
    |--------------------------------------------------------------------------
    */

    public function getLogo()
    {
        return $this->belongsTo(FilesRegistre::class, 'logo', 'uid');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * Nom + type (utile UI)
     */
    public function getFullLabelAttribute(): string
    {
        return "{$this->name} ({$this->type})";
    }

    /**
     * Est une entité visible
     */
    public function isVisible(): bool
    {
        return (bool) $this->visible;
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS UI (PWA BDE)
    |--------------------------------------------------------------------------
    */

    public function getTheme(): array
    {
        return [
            'primary' => $this->color_1,
            'secondary' => $this->color_2,
        ];
    }

    public function reseauxSociaux()
    {
        return $this->belongsToMany(
            ReseauSocial::class,
            'entite_reseaux_sociaux',
            'entite_uid',
            'reseau_social_id'
        )->withPivot('url');
    }

    public function sites()
    {
        return $this->belongsToMany(
            Site::class,
            'entite_sites',
            'entite_uid',
            'site_id'
        );
    }

    public function lien_relatif()
    {
        return "/entite/" . $this->uid;
    }

    public function lien_gestion_relatif()
    {
        return $this->lien_relatif() . '/dashboard';
    }

    public static function existe($entite_uid)
    {
        $entite = Entite::find($entite_uid);
        if (is_null($entite)) {
            abort(405);
        }

        return $entite;
    }


    public function setSites($sites_labels)
    {
        $sites_id = Site::whereIn('id', $sites_labels)->pluck('id')->toArray();
        $this->sites()->sync($sites_id);
    }

    public function getParent(){
        return $this->belongsTo(self::class, 'parent_uid');
    }

    public function getEntitesDependants(){
        return $this->hasMany(self::class, 'parent_uid');
    }
}