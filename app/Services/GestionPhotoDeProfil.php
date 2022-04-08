<?php
namespace App\Services;

use \App\Models\Entite;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class GestionPhotoDeProfil {
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
        $chemin = self::chemin_logos($entite->uid, $entite_id, $entite->type);

        $image_nom = self::stocker_fichier_logo($image, $chemin);
        $logo = new Logo;
        $logo->entite_id = $entite_id;
        $logo->nom = $image_nom;
        $logo->save();
    }

    static function chemin_membre_photo($membre, $defaut_nuage=false){
        if(!$membre->photo && $defaut_nuage==true){
            return self::chemin_photo_defaut();
        }
        elseif(!$membre->photo && $defaut_nuage==false){
            return self::chemin_utilisateur_photo($membre->user()->first(), true);
        }

        $entite = $membre->entite()->first($membre);

        if($entite->type->value == 'liste'){
            $type = 'listes';
        } else {
            $type = 'entites';
        }

        return Storage::url('images/'. $type .'/'. $entite->uid .'-'. $entite->id .'/membres/'. $membre->id);
    }

    static function chemin_utilisateur_photo($user, $defaut_nuage=false){
        if(!$user->photo && $defaut_nuage==true){
            return self::chemin_photo_defaut();
        }

        return Storage::url('images/utilisateurs/'. $user->id .'/photo_de_profil');
    }

    static function chemin_photo_defaut(){
        return "/images/inconnu.png";
    }

    public static function stocker_logo_depuis_url($url, $entite_id){
        $logo = file_get_contents($url);

        self::stocker_logo($logo, $entite_id);
    }
}
