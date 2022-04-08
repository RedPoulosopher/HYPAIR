<?php
namespace App\Services;

use \App\Models\Entite;
use \App\Models\Logo;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class GestionLogo {
    public static function validation_logo($image){
        Validator::make(["logo" => $image], ['logo' => ['required','file','mimes:png','dimensions:min_width=512,min_height=512,ratio=1']])->validate();
    }

    static function stocker_fichier_logo($image, $chemin){
        $image_nom = date("Y-m-d");
        $image_chemin = $chemin . $image_nom;

        $image_rz = Image::make($image);
        $image_rz->resize(512, 512);
        Storage::put($image_chemin ."-moyen.png", $image_rz->encode("png"));
        Storage::put($chemin ."moyen", $image_rz->encode("png"));
        $image_rz->resize(256, 256);
        Storage::put($image_chemin ."-petit.png", $image_rz->encode("png"));
        Storage::put($chemin ."petit", $image_rz->encode("png"));
        $image_rz->resize(128, 128);
        Storage::put($image_chemin ."-tres-petit.png", $image_rz->encode("png"));
        Storage::put($chemin ."tres-petit", $image_rz->encode("png"));
        
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

    static function chemin_logos($uid, $id, $type, $storage=true){
        if($type->value == 'liste'){
            $type = 'listes';
        } else {
            $type = 'entites';
        }
        $chemin = 'images/'. $type .'/'. $uid .'-'. $id .'/logos/';
        
        if($storage){return Storage::url($chemin);}
        return $chemin;
    }

    public static function stocker_logo_depuis_url($url, $entite_id){
        $logo = file_get_contents($url);

        self::stocker_logo($logo, $entite_id);
    }
}
