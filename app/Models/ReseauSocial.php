<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReseauSocial extends Model
{
    use HasFactory;

    protected $table = 'reseaux_sociaux';
    
    protected $fillable = [
        'reseau_sociable_id',
        'reseau_sociable_type',
        'reseaux_sociaux_liste_id',
        'cle',
    ];

    
    public function reseaux_sociaux(){
        return $this->morphTo();
    }

    public function liste(){
        return $this->belongsTo(ReseauSocialListe::class, 'reseaux_sociaux_liste_id', 'id'); //pour une raison inconnue, ce que j'ai fait ne respecte pas la convention, donc je précise les colonnes de la relation
    }

    public static function changer_reseau_social($model, $reseau_social_model){
        $info = ['cle' => $reseau_social_model->cle];
        $recherche = [
			'reseau_sociable_id' => $model->id,
			'reseau_sociable_type' => get_class($model),
			'reseaux_sociaux_liste_id' => $reseau_social_model->reseaux_sociaux_liste_id,
        ];

        if($reseau_social_model->cle == ""){
            return self::firstWhere($recherche)->delete();
        }

        return self::updateOrCreate($recherche,$info);
    }
}
