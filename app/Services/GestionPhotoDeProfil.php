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

    public static function chemin_membre_photo($membre){
        if(!$membre->photo){
            return self::chemin_utilisateur_photo($membre->user()->first());
        }

        $entite = $membre->entite()->first($membre);

        if($entite->type->value == 'liste'){
            $type = 'listes';
        } else {
            $type = 'entites';
        }

        return Storage::url('images/'. $type .'/'. $entite->uid .'-'. $entite->id .'/membres/'. $membre->id);
    }

    static function chemin_utilisateur_photo($user){
        
        $chemin = 'images/utilisateurs/'. $user->id .'/';
        
        if($user->photo==2){
            $prenom = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $user->prenom);
            $prenom = preg_replace("/[^a-zA-Z ]/m", "", $prenom);
            $prenom = preg_replace("/ /", "", $prenom);
            
            $nom = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $user->nom);
            $nom = preg_replace("/[^a-zA-Z ]/m", "", $nom);
            $nom = preg_replace("/ /", "", $nom);
            
            $svg = self::to_shape($prenom, $nom);
            
            Storage::put($chemin.".svg", $svg);
            
            $user->photo = 0;
            $user->save();
        }
   
        
        
        if($user->photo==1){//si l'utilisateur a upload une pp
            if(Storage::exists($chemin))
                return Storage::url($chemin . date('Y-m-d', Storage::lastModified($chemin)) . '.png');//Récupère l'image avec la date la plus récente
            else
                return Storage::url($chemin . '.png' );//Tant pis, si l'image existe pas on va pas l'inventer

        } else{
            $chemin = Storage::url($chemin);
            return $chemin . 'photo_de_profil.svg';
        }
    }

    public static function stocker_photo_profil($file_photo_profil, $user) {
      $chemin = 'images/utilisateurs/'. $user->id . '/';

      $image_nom = date("Y-m-d");
      $image_chemin = $chemin . $image_nom;

      $photo_profil = Image::make($file_photo_profil);
      $hauteur = $photo_profil->height();
      $largeur = $photo_profil->width();
      $taille_carre = $hauteur > $largeur ? $largeur : $hauteur;
      $photo_profil->crop($taille_carre,$taille_carre);
      $photo_profil->resize(512, 512);
      $photo_profil->orientate();

      //remove previous images
      Storage::deleteDirectory($chemin);

      //add new image
      Storage::put($image_chemin .".png", $photo_profil->encode("png"));
      $photo_profil->destroy();

      return $image_chemin.".png";
    }

    public static function stocker_logo_depuis_url($url, $entite_id){
        $logo = file_get_contents($url);

        self::stocker_logo($logo, $entite_id);
    }

    static function rerange($input, $input_start, $input_end, $output_start, $output_end){
        $reranged = (($input - $input_start)/($input_end - $input_start)) * ($output_end - $output_start) + $output_start;
        return intval($reranged);
    }

    static function to_color($string){
        //regex [a-z][0-9]
        $string_max = str_repeat("z", strlen($string));
        $decimal_max = intval($string_max, 36);

        //fix the maximum possible at pow(2,22)
        $coef_max = $decimal_max/(pow(2,22)-1);
        $to_color_dec = intval(intval($string, 36)/$coef_max);

        $hue = floor($to_color_dec/1000);
        //hue, value of to_color('a'), pow(2,22), ...
        //then start from 310 to have the red colours
        $hue = (self::rerange($hue, 1198, 4195, 0, 360) - 50) % 360;

        $value = ($to_color_dec/100) - intval($to_color_dec/100);
        $value_corrigee = self::rerange($value * 100, 0, 99, 60, 80);

        //for sat min, we avoid harsh color (with sat = 100% and value = 50%)
        $saturation = self::rerange(strlen($string), 3, 10, 85 + 25 * ($value_corrigee-60) / 20, 50);
        $saturation = min($saturation, 85); //si strlen(string) < 3
        $saturation = max($saturation, 45); //si strlen(string) > 10

        return [$hue, $saturation, $value_corrigee];
    }

    static function to_shape($prenom, $nom){
        $hsl = self::to_color($prenom);

        $string_max = str_repeat("z", strlen($nom));
        $decimal_max = intval($string_max, 36);

        $coef_max = $decimal_max/(pow(2,22)-1);
        $to_dec = intval($nom, 36)/$coef_max;
        $base_5 = base_convert($to_dec, 10, 5);
        $base_5_str = strval($base_5);

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9 9" title="identicône par Marc Bresson">';
        foreach(array(0=>'rectangle', 1=>'cercle', 2=>'triangle') as $index=>$type){
            $taille = self::rerange($base_5_str[$index + 6], 0, 5, 2, 5);
            $position_x = $base_5_str[$index] + 2;
            $position_y = $base_5_str[$index + 3] + 2;

            if($type == "rectangle"){
                $position_x -= ($taille-1)/2;
                $position_y -= ($taille-1)/2;

                $svg .= '<rect style="fill:hsl('.$hsl[0].','.$hsl[1].'%,'.$hsl[2].'%);" x="' . (-0.5 + $position_x) . '" y="' . (-0.5 + $position_y) . '" width="' . ($taille) . '" height="' . ($taille) . '"/>';

            } else if ($type == "cercle"){
                $svg .= '<circle style="fill:hsl('. $hsl[0]-60 .','.$hsl[1].'%,'.$hsl[2].'%);" cx="' . ($position_x) . '" cy="' . ($position_y) . '" r="' . (0.5 * $taille) . '"/>';

            } else if($type == "triangle"){
                $svg .= '<polygon style="fill:hsl('. $hsl[0]+60 .','.$hsl[1].'%,'.$hsl[2].'%);" points="' . (0 + $position_x) . ' ' . (-0.5 + $position_y) . ' ' . ((-0.435 + $position_x) - $taille) . ' ' . ((0.245 + $position_y) + $taille) . ' ' . ((0.435 + $position_x) + $taille) . ' ' . ((0.245 + $position_y) + $taille) . ' ' . (0 + $position_x) . ' ' . (-0.5 + $position_y) . '"/>';
            }
        }

        $svg .= '</svg>';
        return $svg;
    }
}
