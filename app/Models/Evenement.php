<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DateTime;
use DateTimeZone;

class Evenement extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'entite_id',
        'slug',
        'description',
        'date_apparition',
        'temps_debut',
        'temps_fin',
        'lieu',
        'confidentialite', // ne sert plus (a une valeur par défaut)
        'max_participation',
        'pour_cotisant',
        'validation', // ne sert plus non plus,
        'confidentiel'
    ];

    public function entite()
    {
        return $this->belongsTo(Entite::class);
    }

    public function campus()
    {
        return $this->belongsToMany(Site::class, 'sites_evenements')->groupBy('sites_evenements.site_id');
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }


    public static function index($annee, $mois)
    {
        $mois_padding = str_pad($mois,2,'0',STR_PAD_LEFT);
        //ca doit retourner tous les evenements de l annee et du mois demandes. Faudra regarder la doc sur eloquent
        $evenements_mois_courant =
            self::select('evenements.*', 'entites.uid', 'entites.nom', 'entites.couleur_claire', 'entites.couleur_sombre')
            // ->whereMonth("temps_debut", $mois)
            // ->whereYear("temps_debut", $annee)
            // ->orWhere(function ($query) use ($annee, $mois) {
            //     $query->whereMonth("temps_fin", $mois)
            //         ->whereYear("temps_fin", $annee);
            // })
            ->where("temps_debut", "<=", $annee . '-' .  $mois_padding . "-31 23:59:59")
            ->where("temps_fin", ">=", $annee . '-' . $mois_padding . "-01 00:00:00")
            ->join('entites', 'entites.id', '=', 'evenements.entite_id');
        return $evenements_mois_courant->get();
    }
}
