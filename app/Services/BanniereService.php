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
    $ratio = $largeur / $hauteur;
    $new_hauteur = $hauteur < 512 ? $hauteur : 512;
    $new_largeur = $new_hauteur * $ratio;
    $banniereImage->resize($new_largeur, $new_hauteur);
    $path = 'images/posts/'.$post->id . '/' . $filename;
    Storage::put($path, $banniereImage->encode('png'));
    $banniereImage->destroy();
    return $path;
  }
}