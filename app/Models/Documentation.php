<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Documentation extends Model
{
    use HasFactory;
    protected $fillable = [
        'entite_id',
        'confidentialite',
        'visibilite',
        'derive_de',
        'titre',
        'slug',
        'description',
        'contenu_md',
        'categories',
        'mise_en_avant',
        'debut_mise_en_avant',
        'fin_mise_en_avant'
    ];

    public function entite(){
        return $this->belongsTo(Entite::class);
    }

    public static function existe($documentation_id){
        $doc = self::find($documentation_id);
		if(is_null($doc)){return false;}
        return $doc;
    }

    public static function existe_slug($slug, $entite_id){
        $doc = self::where('slug', $slug)->where('entite_id', $entite_id);
		if(is_null($doc)){return false;}
        return $doc;
    }

    public static function index($niveau_administration){
        return self::select('id', 'titre', DB::raw('SUBSTR(contenu_md, 1, 300) as contenu_md'), 'description', 'categories', 'slug', 'confidentialite', 'visibilite')
                        ->where("entite_id", session('entite_id'))
                        ->where("confidentialite", "<=", $niveau_administration)
                        ->orderBy('confidentialite', 'desc');
    }
}
