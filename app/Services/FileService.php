<?php

namespace App\Services;

use App\Models\FilesRegistre;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

class FileService
{
    /**
     * Upload un fichier.
     */
    public static function upload(
        UploadedFile $file,
        string $directory = 'uploads',
        string $disk = 'public',
        array $json = [ "acces" => "certifier"]
    ): string {
        $path = $file->store($directory, $disk);

        $file = FilesRegistre::create([
            'name' => $file->getClientOriginalName(),
            'filename' => basename($path),
            'path' => $path,
            'disk' => $disk,
            'extension' => $file->extension(),
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'json_data' => $json
        ]);

        return $file->uid;
    }

    /**
     * Supprime un fichier.
     */
    public static function delete(
        string $path,
        string $disk = 'public'
    ): bool {
        return Storage::disk($disk)->delete($path);
    }

    /**
     * Vérifie l'existence d'un fichier.
     */
    public static function exists(
        string $path,
        string $disk = 'public'
    ): bool {
        return Storage::disk($disk)->exists($path);
    }

    /**
     * Retourne l'URL publique du fichier.
     */
    public static function url(
        string $path,
        string $disk = 'public'
    ): string {
        return Storage::disk($disk)->url($path);
    }

    /**
     * Télécharge un fichier.
     */
    public static function download(
        string $path,
        string $disk = 'public'
    ) {
        abort_unless(Auth::check(), 403);
        return Storage::disk($disk)->download($path);
    }

    public static function validation_img(?UploadedFile $image){
        $validation = [
            'logo' => ['required','image','dimensions:min_width=256,min_height=256','max:10000']
        ];
        $messages_custom = [
            'logo.dimensions' => 'L\'image doit faire au minimum 256px en largeur et en hauteur.',
            'logo.max' => 'L\'image est trop lourde, réessayez avec une image d\'une taille inférieure à 10 méga-octets.',
            'logo.uploaded' => 'L\'image est trop lourde, réessayez avec une image d\'une taille inférieure à 10 méga-octets.'
        ];
        Validator::make(["logo" => $image], $validation, $messages_custom)->validate();
    }

    public static function transformImagePathToSquare512(string $disk,string $path)
    {
        $manager = new ImageManager(new Driver());
        $path2 = Storage::disk($disk)->path($path);
        $manager->decodePath($path2)
        ->cover(512,512)
        ->save($path2);
    }
}