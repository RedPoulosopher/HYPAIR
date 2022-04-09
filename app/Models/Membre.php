<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Membre extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'entite_id',
        'user_id',
        'role_id',
        'fin_mandat',
        'created_at',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function entite(){
        return $this->belongsTo(Entite::class);
    }
    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function nouveau_membre($annee=null){
        $info = ['role_id' => $this->role_id,];

        if(!is_null($annee) && $annee != date('y')){ //on rajoute une date de début de mandat
            $annee_fin_mandat = $annee;
            $created_at = $annee-1 . "-03-01";
            $info["created_at"] = $created_at;
        } else {
            $annee_fin_mandat = date('Y');
        }

		$fin_mandat = $annee_fin_mandat."-05-01";

        return self::updateOrCreate([
			'entite_id' => $this->entite_id,
			'user_id' => $this->user_id,
			'fin_mandat' => $fin_mandat,
			],
			$info
		);
    }
    
    public function promouvoir(){
        //s'il est juste membre, on recreer une fiche avec son nouveau role
        //sinon, on met à jour son entrée
    }

    public function demettre(){
        //si on le repasse juste membre, et que date_fin > mai de l'année courrante, on supprime l'entrée, et on met à jour l'ancienne entrée avec la bonne date de fin
        //sinon, on met juste l entrée à jour
    }
}
