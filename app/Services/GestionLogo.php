<?php
namespace App\Services;

use \App\Models\Association;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class GestionLogo {
    public static function validation_logo($image, $required=true){
        if($required){$required='required';}
        else{$require='nullable';}
        
        Validator::make(["logo" => $image], ['logo' => [$required,'file','mimes:svg,png']])->validate();

        if($image->extension() == "png"){
            Validator::make(["logo" => $image], ['logo' => [$required,'dimensions:min_width=512,min_height=512,ratio=1']])->validate();
        } else if($image->extension() == "svg"){
            Validator::make(["logo" => $image], ['logo' => [$required,'max:70']])->validate();
        }
    }

    public static function stocker_logo($image, $asso_id){
        $image_nom = date("Y-m-d");
        
        $asso = Association::find($asso_id);
        $chemin = self::chemin_logo($asso->uid, $asso_id, $asso->type);
        $ext = $image->extension();

        if($ext == "png"){
            $image_rz = Image::make($image);
            $image_rz->resize(512, 512);
            Storage::put($chemin . $image_nom ."-moyen.". $ext, $image_rz->encode("png"));
            $image_rz->resize(256, 256);
            Storage::put($chemin . $image_nom ."-petit.". $ext, $image_rz->encode("png"));
            $image_rz->resize(128, 128);
            Storage::put($chemin . $image_nom ."-tres-petit.". $ext, $image_rz->encode("png"));
        } else {
            Storage::put($chemin . $image_nom .'.'. $ext);
        }

        return array($image_nom, $ext);
    }

    public static function recuperer_dernier_logo($taille = 'petit', $asso_id){
        if(is_null($asso_id)){
            $asso_id = session('association_id');
        }

        $asso = Association::find($asso_id);
        
        $logo = $asso->logo_actuel();
        if(is_null($logo)){
            return '/images/asso_inconnue.png';
        }

        if($logo->extension == "png"){
            $nom_logo = $logo->nom .'-'. $taille .'.'. $logo->extension;
        } else {
            $nom_logo = $logo->nom .'.'. $logo->extension;
        }
        $url_logo = Storage::url(self::chemin_logo($asso->uid, $asso_id, $asso->type));

        return $url_logo . $nom_logo;
    }

    static function chemin_logo($uid, $id, $type){
        if($type == 'liste'){
            $type = 'listes';
        } else {
            $type = 'associations';
        }

        return 'images/'. $type .'/'. $uid .'-'. $id .'/logos/';   
    }
}
