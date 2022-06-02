<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avancee extends Model
{
    use HasFactory;
    protected $fillable = [
        'entite_id',
        'titre',
        'projet_id',
        'description_md',
        'slug',
    ];
    public function entite(){
        return $this->belongsTo(Entite::class);
    }
    public function projet(){
        return $this->belongsTo(Projet::class);
    }
    public static function existe($avancee_id){
        $avancee = self::find($avancee_id);
		if(is_null($avancee)){return false;}
        return $avancee;
    }
    public static function existe_slug($slug, $entite_id){
        $avancee_id = self::where('slug', $slug)->where('entite_id', $entite_id);
		if(is_null($avancee)){return false;}
        return $avancee_id;
    }
    public static function index(){
        return self::select('id', 'projet_id','description_md', 'slug')
                        ->where("entite_id", session('entite_id'))
                        ->orderBy('created_at', 'desc');
    }
}
