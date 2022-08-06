<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GestionImages {
    public static function stocker($usage, $id_associe, $image){

    }

    /**
     * Permet de supprimmer les images qui sont dans la base de données, mais pas dans la liste de liens des images toujours présentes.
     *
     * @var array
     */
    public static function toujours_utilise($usage, $id_associe, $liste_liens_presents){

    }

    public static function supprimer($image_id){
        //supprimer du stockage

        //supprimer de la bdd
    }

    public static function url_vers_image_id($url){

    }
}
