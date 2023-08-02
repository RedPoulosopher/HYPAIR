<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'max_participation',
        'campus_id',
        'pour_cotisant',
        'is_actualite',
        'validation',
    ];

    public function entite()
    {
        return $this->belongsTo(Entite::class);
    }

    public function campus()
    {
        return $this->belongsTo(Site::class);
    }

    // Vieille fonction
    public static function index($annee, $mois)
    {
        //ca doit retourner tous les evenements de l annee et du mois demandes. Faudra regarder la doc sur eloquent
        $evenements_mois_courant =
            self::select('evenements.*', 'entites.uid', 'entites.nom', 'entites.couleur_claire', 'entites.couleur_sombre')
            ->whereMonth("temps_debut", $mois)
            ->whereYear("temps_debut", $annee)
            ->orWhere(function ($query) use ($annee, $mois) {
                $query->whereMonth("temps_fin", $mois)
                    ->whereYear("temps_fin", $annee);
            })
            ->join('entites', 'entites.id', '=', 'evenements.entite_id');
        return $evenements_mois_courant->get();
    }
}
