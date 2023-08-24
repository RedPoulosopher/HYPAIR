<?php

namespace App\Models;

use App\Enums\RatachementEnum;
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
        'ratachement',
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
        'hidden'
    ];

    protected $casts = [
        'ratachement' => RatachementEnum::class,
        'type' => EntiteTypeEnum::class,
    ];

    public function evenements()
    {
        return $this->hasMany(Evenement::class);
    }

    public function documentations()
    {
        return $this->hasMany(Documentation::class);
    }

    public function logos()
    {
        return $this->hasMany(Logo::class);
    }

    public function membres()
    {
        return $this->hasMany(Membre::class);
    }

    public function reseaux_sociaux()
    {
        return $this->morphMany(ReseauSocial::class, 'reseau_sociable');
    }

    public function sites()
    {
        return $this->belongsToMany(Site::class, EntiteSite::class);
    }

    public function categories()
    {
        return $this->hasMany(Categorie::class);
    }

    public function ajout_sites($sites_labels)
    {
        $sites_id = Site::whereIn('label', $sites_labels)->get()->pluck('id');
        $this->sites()->sync($sites_id);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function ajout_categories($labels)
    {
        // on supprime toutes les catégories existantes
        $this->categories()->delete();

        // on crée le tableau de catégories
        $entite_id = $this->id;
        $a = array_fill(0, count($labels), []);
        for ($i = 0; $i < count($labels); $i++) {
            $b = array();
            $b['entite_id'] = $entite_id;
            $b["label"] = $labels[$i];

            $a[$i] = $b;
        }

        Categorie::insert($a);
    }

    public static function existe($entite_id)
    {
        $entite = Entite::find($entite_id);

        if (is_null($entite)) {
            abort(405);
        }

        return $entite;
    }

    public static function bureaux_site($site)
    {
        $bureaux = Entite::where('type', EntiteTypeEnum::Bureau)
            ->whereHas('sites', function ($query) use ($site) {
                $query->where('label', $site);
            });

        return $bureaux;
    }

    public static function independants_site($site)
    {
        $entites_independantes = Entite::where('ratachement', RatachementEnum::Independant)
            ->whereHas('sites', function ($query) use ($site) {
                $query->where('label', $site);
            });

        return $entites_independantes;
    }

    public function bureaux()
    {
        if ($this->uid != "air") {
            abort(403, "Hophophop, vous n'avez pas le droit de faire ça. C'est réservé à l'AIR");
        }

        $comites_clubs_dependants = Entite::where('type', EntiteTypeEnum::Bureau)
            ->orderBy('nom');

        return $comites_clubs_dependants;
    }

    public function comites_clubs_dependants()
    {
        if ($this->uid != "air" && $this->type != EntiteTypeEnum::Bureau) {
            abort(500, "Vous essayez de récupérer les entités qui dépendent de quelque chose qui n'est pas un bureau.");
        }

        if ($this->type == EntiteTypeEnum::Bureau) {
            $sites_bureau = $this->sites()->get()->pluck('label')->toArray();

            $comites_clubs_dependants = Entite::where('ratachement', $this->ratachement)
                ->whereHas('sites', function ($query) use ($sites_bureau) {
                    $query->whereIn('label', $sites_bureau);
                });;
        } else { // l'AIR récup toutes les entités
            $comites_clubs_dependants = new Entite;
        }

        $comites_clubs_dependants = $comites_clubs_dependants
            ->whereIn('type', array(EntiteTypeEnum::Association, EntiteTypeEnum::Club, EntiteTypeEnum::Comite))
            ->orderBy('nom');

        return $comites_clubs_dependants;
    }

    public function listes_dependantes($annee = null)
    {
        if ($this->uid != "air" && $this->type != EntiteTypeEnum::Bureau) {
            abort(500, "Vous essayez de récupérer les entités qui dépendent de quelque chose qui n'est pas un bureau.");
        }

        if ($this->type == EntiteTypeEnum::Bureau) {
            $sites_bureau = $this->sites()->get()->pluck('label')->toArray();

            $listes_dependantes = Entite::where('ratachement', $this->ratachement)
                ->whereHas('sites', function ($query) use ($sites_bureau) {
                    $query->whereIn('label', $sites_bureau);
                });;
        } else { // l'ai récup toutes les listes
            $listes_dependantes = new Entite;
        }

        if ($annee !== null) {
            $listes_dependantes->where('annee_creation', $annee);
        }

        $listes_dependantes = $listes_dependantes
            ->whereIn('type', array(EntiteTypeEnum::Liste, EntiteTypeEnum::Fakeliste))
            ->orderBy('nom');

        return $listes_dependantes;
    }

    public function url()
    {
        return "https://hypair.imt-ne.fr" . $this->lien_relatif();
    }

    public function lien_relatif()
    {
        if ($this->type->value == "liste") {
            return "/" . $this->uid . '-' . $this->id;
        } else {
            return "/" . $this->uid;
        }
    }

    public function lien_gestion_relatif()
    {
        return $this->lien_relatif() . '/entite/gestion';
    }

    public function logo_url($taille)
    {
        $chemin = GestionLogo::chemin_logos($this->uid, $this->id, $this->type, $taille);

        return $chemin;
    }

    public function mandat($annee = null)
    {
        $annee_scolaire = $annee ?? date('Y');
        if (date('m') >= config('mandat.mois_affichage_nouveau_mandat')) {
            $annee_scolaire++;
        } //en avril, on change le mandat pour afficher le nouveau

        return $this::membres()
            ->select('membres.id', 'membres.user_id', 'membres.entite_id', 'membres.created_at', 'membres.fin_mandat', 'membres.photo', 'roles.label', 'roles.niveau_admin', 'users.uid', 'users.nom', 'users.prenom')
            ->whereBetween('membres.created_at', [($annee_scolaire - 1) . "-03-01", $annee_scolaire . "-02-01"])
            ->join('roles', 'roles.id', '=', 'membres.role_id')
            ->join('users', 'users.id', '=', 'membres.user_id')
            ->orderBy('niveau_admin', 'desc')
            ->orderBy('nom', 'asc')
            ->where('roles.niveau_admin', '>=', '6');
    }

    public function personnes_a_responsabilites()
    {
        return $this::membres()
            ->select('membres.id', 'membres.user_id', 'membres.created_at', 'membres.fin_mandat', 'roles.id as roles.id', 'roles.label', 'roles.niveau_admin', 'users.uid', 'users.nom', 'users.prenom')
            ->whereRAW("NOW() BETWEEN `membres`.`created_at` AND `fin_mandat`")
            ->join('roles', 'roles.id', '=', 'membres.role_id')
            ->join('users', 'users.id', '=', 'membres.user_id')
            ->where('roles.niveau_admin', '>', '1')
            ->orderBy('niveau_admin', 'desc')
            ->orderBy('nom', 'asc')
            ->orderBy('prenom');
    }

    public function abonnes()
    {
        return $this::membres()
            ->select('membres.id', 'membres.user_id', 'membres.created_at', 'membres.fin_mandat', 'roles.id as roles.id', 'roles.label', 'roles.niveau_admin', 'users.uid', 'users.nom', 'users.prenom')
            ->whereRAW("NOW() BETWEEN `membres`.`created_at` AND `fin_mandat`")
            ->join('roles', 'roles.id', '=', 'membres.role_id')
            ->join('users', 'users.id', '=', 'membres.user_id')
            ->where('roles.niveau_admin', '1')
            ->orderBy('nom', 'asc');
    }

    public function nbr_abonnes()
    {
        return $this::membres()
            ->count()
            ->whereRAW("NOW() BETWEEN `membres`.`created_at` AND `fin_mandat`")
            ->join('roles', 'roles.id', '=', 'membres.role_id')
            ->where('roles.niveau_admin', '>=', '1');
    }
}
