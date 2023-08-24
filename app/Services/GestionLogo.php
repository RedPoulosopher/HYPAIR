<?php
namespace App\Services;

use \App\Models\Entite;
use \App\Models\Logo;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class GestionLogo {
    public static function validation_logo($image){
        $validation = [
            'logo' => ['required','image','dimensions:min_width=512,min_height=512','max:100000']
        ];
        $messages_custom = [
            'logo.dimensions' => 'L\'image doit faire au minimum 512px en largeur et en hauteur.',
            'logo.max' => 'L\'image est trop lourde, réessayez avec une image d\'une taille inférieure à 100 méga-octets.',
            'logo.uploaded' => 'L\'image est trop lourde, réessayez avec une image d\'une taille inférieure à 100 méga-octets.'
        ];
        Validator::make(["logo" => $image], $validation, $messages_custom)->validate();
    }

    static function stocker_fichier_logo($image, $chemin){
        $image_nom = date("Y-m-d");
        $image_chemin = $chemin . $image_nom;

        $image_rz = Image::make($image);

        $hauteur = $image_rz->height();
        $largeur = $image_rz->width();
        $taille_carre = $hauteur > $largeur ? $largeur : $hauteur;
        
        $image_rz->crop($taille_carre,$taille_carre);
        $image_rz->orientate();

        //remove previous images
        Storage::deleteDirectory($chemin);

        //add new image in all sizes
        $image_rz->resize(512, 512);
        Storage::put($image_chemin ."-moyen.png", $image_rz->encode("png"));
        $image_rz->resize(256, 256);
        Storage::put($image_chemin ."-petit.png", $image_rz->encode("png"));
        $image_rz->resize(128, 128);
        Storage::put($image_chemin ."-tres-petit.png", $image_rz->encode("png"));

        return $image_nom;
    }

    public static function stocker_logo($image, $entite_id){
        $entite = Entite::existe($entite_id);
        $chemin = self::chemin_logos($entite->uid, $entite_id, $entite->type, false);

        $image_nom = self::stocker_fichier_logo($image, $chemin);
        $logo = new Logo;
        $logo->entite_id = $entite_id;
        $logo->nom = $image_nom;
        $logo->save();
    }

    static function chemin_logos($uid, $id, $type, $storage=true, $taille="petit"){
        if($type->value == 'liste'){
            $type = 'listes';
        } else {
            $type = 'entites';
        }
        $chemin = 'images/'. $type .'/'. $uid .'-'. $id .'/logos/';

        if($storage){
            if(Storage::exists($chemin))
                return Storage::url($chemin . date('Y-m-d', Storage::lastModified($chemin)) . '-' . $taille . '.png');//Récupère l'image avec la date la plus récente
            else
                return $chemin;//Tant pis, si l'image existe pas on va pas l'inventer
        }
        return $chemin;
    }

    public static function stocker_logo_depuis_url($url, $entite_id){
        $logo = file_get_contents($url);

        self::stocker_logo($logo, $entite_id);
    }
}
