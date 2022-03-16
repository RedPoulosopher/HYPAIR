<?php

namespace App\Models;

use App\Enums\AssoBureauEnum;
use App\Enums\AssoTypeEnum;
use \App\Services\GestionLogo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Association extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'uid',
        'bureau_de_ratachement',
        'type',
        'courriel',
        'alias',
        'sites',
        'categories',
        'privee',
        'annee_creation',
        'annee_fin',
        'description',
        'couleur_claire',
        'couleur_sombre',
    ];

    protected $casts = [
        'bureau_de_ratachement' => AssoBureauEnum::class,
        'type' => AssoTypeEnum::class,
    ];

    public static function existe($asso_id){
        $asso = Association::find($asso_id);

		if(is_null($asso)){abort(405);}
        
        return $asso;
    }
    
    public function documentations(){
        return $this->hasMany(Documentation::class);
    }
    
    public function logos(){
        return $this->hasMany(Logo::class);
    }

    public function url(){
        if($this->type == "liste"){
            return "https://liste.". env('SITE_URL') ."/". $this->uid .'-'. $this->id;
        } else {
            //local
            return "http://". $this->uid .".". env('SITE_URL') .":8000";
            //deployé
            return "https://". $this->uid .".". env('SITE_URL');
        }
    }

    public function logo_url($taille){
        $chemin = GestionLogo::chemin_logos($this->uid, $this->id, $this->type);

        return $chemin . $taille;
    }
}
