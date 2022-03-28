<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'description',
        'temps_debut',
        'temps_fin',
        'lieu',
        'max_participation',
        'confidentialite',
        'pour_cotisant',
        'important'
    ];
    
    public function association(){
        return $this->belongsTo(Association::class);
    }

    public static function index($annee, $mois) {
        //ca doit retourner tous les evenements de l annee et du mois demandes. Faudra regarder la doc sur eloquent
        $evenements_mois_courant = self::whereMonth("temps_debut", $mois)
            ->whereYear("temps_debut", $annee)
            ->orWhere(function($query) use($annee, $mois){
                $query->whereMonth("temps_fin", $mois)
                    ->whereYear("temps_fin", $annee)
                    ->whereTime("temps_fin", ">=","08:00:00");
            });
        return $evenements_mois_courant->get();

    }
}
