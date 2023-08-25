<?php
namespace App\Services;

use \App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class BanniereService {
  
  public static function stockerBanniere($banniereFile, $post, $order) {
    $filename = $order . '_' . time() . '.png';
    $banniereImage = Image::make($banniereFile);
    $hauteur = $banniereImage->height();
    $largeur = $banniereImage->width();
    $taille_carre = $hauteur > $largeur ? $largeur : $hauteur;
    $banniereImage->crop($taille_carre,$taille_carre);
    $banniereImage->resize(512, 512);
    $path = 'images/posts/'.$post->id . '/' . $filename;
    Storage::put($path, $banniereImage->encode('png'));
    $banniereImage->destroy();
    return $path;
  }
}