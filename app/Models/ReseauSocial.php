<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ReseauSocial extends Model
{
    use HasFactory;

    protected $table = 'reseaux_sociaux';
    
    protected $fillable = [
        'reseau_social_id',
        'reseau_social_type',
        'reseaux_sociaux_liste_id',
        'lien',
    ];

    
    public function reseaux_sociaux(){
        return $this->morphTo();
    }

    public function liste(){
        return $this->belongsTo(ReseauSocialListe::class, 'reseaux_sociaux_liste_id', 'id'); //pour une raison inconnue, ce que j'ai fait ne respecte pas la convention, donc je précise les colonnes de la relation
    }

    public static function changer_reseau_social($model, $reseau_social_model){
        $info = ['lien' => $reseau_social_model->lien];
        $recherche = [
			'reseau_social_id' => $model->id,
			'reseau_social_type' => get_class($model),
			'reseaux_sociaux_liste_id' => $reseau_social_model->reseaux_sociaux_liste_id,
        ];

        if($reseau_social_model->lien == ""){
            return self::firstWhere($recherche)->delete();
        }

        return self::updateOrCreate($recherche,$info);
    }

    public function type_de_lien(){
        $tel_regex = '/^([+]?\d{1,2}[-\s]?|)\d{3}[-\s]?\d{3}[-\s]?\d{4}$/';
        $url_regex = '/^((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[.\!\/\\w]*))?)/';


        preg_match($tel_regex, $this->lien, $telMatch);
        preg_match($url_regex, $this->lien, $urlMatch);

        $isTel = count($telMatch) > 0;
        $isUrl = count($urlMatch) > 0;


        //Si le lien est reconnu comme un numéro de tel et qu'il s'agit du réseau Whatsapp,
        //On le considère bien comme un lien vers un numéro de téléphone
        if($isTel && strtolower($this->liste->nom) == "whatsapp"){
            return "tel:";
        }

        //Si c'est une url, on force le protocole https si pas spécifié
        if($isUrl){
            if(Str::startsWith($this->lien, 'http://') || Str::startsWith($this->lien, 'https://') ){
                return "";
            }else{
                return "https://";
            }
        }

        //Si c'est ni un lien ni un numéro de téléphone, on copiera la valeur quand l'utilisateur clique sur le bouton
        return "COPY";
    }
}
