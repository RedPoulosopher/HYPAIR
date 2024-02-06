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

    public function changer_role($annee=null){
        $info = ['role_id' => $this->role_id,];

        if(!is_null($annee) && $annee != date('y')){ //on rajoute une date de début de mandat si c'est une création d'archive
            $annee_fin_mandat = $annee;
            $created_at = $annee-1 . "-".config('mandat.date_defaut_creation');
            $info["created_at"] = $created_at;
        } else {
            $annee_fin_mandat = date('Y');
        }
        if(date('m') >= config('mandat.mois_debut_passation')){$annee_fin_mandat++;}

		$fin_mandat = $annee_fin_mandat."-".config('mandat.date_fin_mandat'); //on désactive toutes les fiches membres après cette date

        return self::updateOrCreate([
			'entite_id' => $this->entite_id,
			'user_id' => $this->user_id,
			'fin_mandat' => $fin_mandat,
			],
			$info
		);
    }

    public static function existe($membre_id)
    {
        $membre = self::where('id', $membre_id);

        if (!$membre->exists()) {
            return false;
        }

        return $membre->first();
    }
}
