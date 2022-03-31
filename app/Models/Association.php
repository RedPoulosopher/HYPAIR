<?php

namespace App\Models;

use App\Enums\AssoBureauEnum;
use App\Enums\AssoTypeEnum;
use \App\Services\GestionLogo;

use Carbon\Carbon;

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
        'description_courte',
        'description_md',
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

    public static function bureaux_site($site){
        $bureaux = Association::where('type', AssoTypeEnum::Bureau)
                ->where('sites','LIKE', '%'. $site .'%');
        
        return $bureaux;
    }

    public function bureaux(){
        if($this->uid!="air"){
            abort(403, "Hophophop, vous n'avez pas le droit de faire ça. C'est réservé à l'AIR");
        }

        $comites_clubs_dependants = Association::where('type', AssoTypeEnum::Bureau)
                                ->orderBy('nom');
        
        return $comites_clubs_dependants;
    }

    public function comites_clubs_dependants(){
        if($this->uid!="air" && $this->type != AssoTypeEnum::Bureau){
            abort(500, "Vous essayez de récupérer les entités qui dépendent de quelque chose qui n'est pas un bureau.");
        }

        if($this->type == AssoTypeEnum::Bureau){
            $site_bureau = json_decode($this->sites)[0];
            $comites_clubs_dependants = Association::where('bureau_de_ratachement', $this->bureau_de_ratachement)
                        ->where('sites','LIKE', '%'. $site_bureau .'%');
        } else {
            $comites_clubs_dependants = new Association;
        }
        $comites_clubs_dependants = $comites_clubs_dependants
                                ->where('type', AssoTypeEnum::Comite)
                                ->orWhere('type', AssoTypeEnum::Club)
                                ->orderBy('nom');
        
        return $comites_clubs_dependants;
    }

    public function listes_dependantes($annee=null){
        if($this->uid!="air" && $this->type != AssoTypeEnum::Bureau){
            abort(500, "Vous essayez de récupérer les entités qui dépendent de quelque chose qui n'est pas un bureau.");
        }

        if($this->type == AssoTypeEnum::Bureau){
            $site_bureau = json_decode($this->sites)[0];
            $listes_dependantes = Association::where('bureau_de_ratachement', $this->bureau_de_ratachement)
                        ->where('sites','LIKE', '%'. $site_bureau .'%')
                        ->where('type', AssoTypeEnum::Liste);
        } else {
            $listes_dependantes = Association::where('type', AssoTypeEnum::Liste)
                                        ->orWhere('type', AssoTypeEnum::Fakeliste);
        }

        if($annee !== null){
            $listes_dependantes->where('annee_creation', $annee);
        }
        
        $listes_dependantes = $listes_dependantes->orderBy('nom');

        return $listes_dependantes;
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
