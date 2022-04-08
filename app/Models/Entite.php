<?php

namespace App\Models;

use App\Enums\BureauEnum;
use App\Enums\EntiteTypeEnum;
use \App\Services\GestionLogo;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entite extends Model
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
        'bureau_de_ratachement' => BureauEnum::class,
        'type' => EntiteTypeEnum::class,
    ];

    public static function existe($entite_id){
        $entite = Entite::find($entite_id);

		if(is_null($entite)){abort(405);}
        
        return $entite;
    }

    public static function bureaux_site($site){
        $bureaux = Entite::where('type', EntiteTypeEnum::Bureau)
                ->where('sites','LIKE', '%'. $site .'%');
        
        return $bureaux;
    }

    public function bureaux(){
        if($this->uid!="air"){
            abort(403, "Hophophop, vous n'avez pas le droit de faire ça. C'est réservé à l'AIR");
        }

        $comites_clubs_dependants = Entite::where('type', EntiteTypeEnum::Bureau)
                                ->orderBy('nom');
        
        return $comites_clubs_dependants;
    }

    public function comites_clubs_dependants(){
        if($this->uid!="air" && $this->type != EntiteTypeEnum::Bureau){
            abort(500, "Vous essayez de récupérer les entités qui dépendent de quelque chose qui n'est pas un bureau.");
        }

        if($this->type == EntiteTypeEnum::Bureau){
            $site_bureau = json_decode($this->sites)[0];
            $comites_clubs_dependants = Entite::where('bureau_de_ratachement', $this->bureau_de_ratachement)
                        ->where('sites','LIKE', '%'. $site_bureau .'%');
        } else {
            $comites_clubs_dependants = new Entite;
        }
        $comites_clubs_dependants = $comites_clubs_dependants
                                ->where('type', EntiteTypeEnum::Comite)
                                ->orWhere('type', EntiteTypeEnum::Club)
                                ->orderBy('nom');
        
        return $comites_clubs_dependants;
    }

    public function listes_dependantes($annee=null){
        if($this->uid!="air" && $this->type != EntiteTypeEnum::Bureau){
            abort(500, "Vous essayez de récupérer les entités qui dépendent de quelque chose qui n'est pas un bureau.");
        }

        if($this->type == EntiteTypeEnum::Bureau){
            $site_bureau = json_decode($this->sites)[0];
            $listes_dependantes = Entite::where('bureau_de_ratachement', $this->bureau_de_ratachement)
                        ->where('sites','LIKE', '%'. $site_bureau .'%')
                        ->where('type', EntiteTypeEnum::Liste);
        } else {
            $listes_dependantes = Entite::where('type', EntiteTypeEnum::Liste)
                                        ->orWhere('type', EntiteTypeEnum::Fakeliste);
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
    
    public function membres(){
        return $this->hasMany(Membre::class);
    }

    public function url(){
        return "https://hypair.imt-ne.fr" . $this->lien_relatif();
    }

    public function lien_relatif(){
        if($this->type->value == "liste"){
            return "/". $this->uid .'-'. $this->id;
        } else {
            return "/". $this->uid;
        }
    }

    public function logo_url($taille){
        $chemin = GestionLogo::chemin_logos($this->uid, $this->id, $this->type);

        return $chemin . $taille;
    }

    public function mandat($annee=null){
        $annee_scolaire = $annee ?? date('Y');
        if(date('m')>=4){$annee_scolaire++;} //en avril, on change le mandat pour afficher le nouveau

        return $this::membres()
        ->select('membres.id','membres.user_id','membres.entite_id','membres.created_at','membres.fin_mandat','membres.photo','roles.label','roles.niveau_admin','users.uid','users.nom','users.prenom')
        ->whereBetween('membres.created_at',[($annee_scolaire-1)."-03-01",$annee_scolaire."-02-01"])
        ->join('roles','roles.id','=','membres.role_id')
        ->join('users','users.id','=','membres.user_id')
        ->where('roles.niveau_admin','>=','6');
    }

    public function personnes_a_responsabilites(){
        return $this::membres()
        ->select('membres.id','membres.user_id','membres.created_at','membres.fin_mandat','roles.id as role.id','roles.label','roles.niveau_admin','users.uid','users.nom','users.prenom')
        ->whereRAW("NOW() BETWEEN `membres`.`created_at` AND `fin_mandat`")
        ->join('roles','roles.id','=','membres.role_id')
        ->join('users','users.id','=','membres.user_id')
        ->where('roles.niveau_admin','>','1')
        ->orderBy('niveau_admin','desc')
        ->orderBy('prenom');
    }

    public function abonnes(){
        return $this::membres()
        ->select('membres.id','membres.user_id','membres.created_at','membres.fin_mandat','roles.id as role.id','roles.label','roles.niveau_admin','users.uid','users.nom','users.prenom')
        ->whereRAW("NOW() BETWEEN `membres`.`created_at` AND `fin_mandat`")
        ->join('roles','roles.id','=','membres.role_id')
        ->join('users','users.id','=','membres.user_id')
        ->where('roles.niveau_admin','1')
        ->orderBy('prenom');
    }

    public function nbr_abonnes(){
        return $this::membres()
        ->count()
        ->whereRAW("NOW() BETWEEN `membres`.`created_at` AND `fin_mandat`")
        ->join('roles','roles.id','=','membres.role_id')
        ->where('roles.niveau_admin','>=','1');
    }
}
