<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    use HasFactory;
    protected $fillable = [
        'entite_id',
        'titre',
        'slug',
        'entite_id',
        'confidentialite',
        'chef_projet',
        'description_courte',
        'date_fin',
    ];
    public function entite(){
        return $this->belongsTo(Entite::class);
    }
    public function Avancee(){
        return $this->hasMany(Avancee::class);
    }
    public static function existe($projet_id){
        $projet = self::find($projet_id);
		if(is_null($projet)){return false;}
        return $projet;
    }

    public static function existe_slug($slug, $entite_id){
        $projet_id = self::where('slug', $slug)->where('entite_id', $entite_id);
		if(is_null($projet)){return false;}
        return $projet_id;
    }
    public static function index(){
        return self::select('id', 'titre','description_courte', 'slug', 'confidentialite','chef_projet','date_fin')
                        ->where("entite_id", session('entite_id'))
                        ->orderBy('date_fin', 'desc');
    }
}
