<?php
namespace App\Services;

use \App\Models\Association;
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

    public static function stocker_logo($image, $asso_id){
        $asso = Association::existe($asso_id);
        $chemin = self::chemin_logos($asso->uid, $asso_id, $asso->type);

        $image_nom = self::stocker_fichier_logo($image, $chemin);
        $logo = new Logo;
        $logo->association_id = $asso_id;
        $logo->nom = $image_nom;
        $logo->save();
    }

    static function chemin_logos($uid, $id, $type){
        if($type == 'liste'){
            $type = 'listes';
        } else {
            $type = 'associations';
        }

        return Storage::url('images/'. $type .'/'. $uid .'-'. $id .'/logos/');   
    }

    public static function stocker_logo_depuis_url($url, $asso_id){
        $logo = file_get_contents($url);

        self::stocker_logo($logo, $asso_id);
    }
}
