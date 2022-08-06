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
        'image',
        'pdf',
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
    public static function existe_slug($slug,$entite_id,$projet_id){
        $avancee = self::where('slug', $slug)->where('entite_id',$entite_id)->where('projet_id', $projet_id);
		if(is_null($avancee)){return false;};
        return $avancee;
    }
    public static function index($projet_id){
        return self::select('id','titre','projet_id','description_md','slug','updated_at')
                        ->where("projet_id",$projet_id)
                        ->orderBy('created_at', 'desc');
    }
}
