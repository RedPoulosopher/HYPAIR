<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ReseauSocial extends Model
{
    protected $table = 'reseaux_sociaux';

    protected $fillable = [
        'nom',
        'color',
        'font_color',
        'placeholder_entite',
        'placeholder_user',
    ];

    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function entites()
    {
        return $this->belongsToMany(
            Entite::class,
            'entite_reseaux_sociaux',
            'reseau_social_id',
            'entite_uid'
        )->withPivot('url');
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'user_reseaux_sociaux',
            'reseau_social_id',
            'user_uid'
        )->withPivot('url');
    }


    public function type_de_lien(){
        $tel_regex = '/^([+]?\d{1,2}[-\s]?|)\d{3}[-\s]?\d{3}[-\s]?\d{4}$/';
        $url_regex = '/^((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[.\!\/\\w]*))?)/';


        preg_match($tel_regex, $this->pivot->url, $telMatch);
        preg_match($url_regex, $this->pivot->url, $urlMatch);

        $isTel = count($telMatch) > 0;
        $isUrl = count($urlMatch) > 0;


        //Si le lien est reconnu comme un numéro de tel et qu'il s'agit du réseau Whatsapp,
        //On le considère bien comme un lien vers un numéro de téléphone
        if($isTel && strtolower($this->liste->nom) == "whatsapp"){
            return "tel:";
        }
        //Si c'est une url, on force le protocole https si pas spécifié
        if($isUrl){
            if(Str::startsWith($this->pivot->url, 'http://') || Str::startsWith($this->pivot->url, 'https://') ){
                return "";
            }else{
                return "https://";
            }
        }

        //Si c'est ni un lien ni un numéro de téléphone, on copiera la valeur quand l'utilisateur clique sur le bouton
        return "COPY";
    }
}