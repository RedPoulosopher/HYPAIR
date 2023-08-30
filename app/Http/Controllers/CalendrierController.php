<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use \App\Models\Evenement;
use \App\Services\AutorisationGestion;
use \App\Models\Entite;
use \App\Models\Membre;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


use DateTime;
use DateTimeZone;
use Illuminate\Support\Str;

class CalendrierController extends Controller
{
    public static function calendrier_asso()
    {
        //on doit recuperer l annee et le mois courant. ca sera l affichage par defaut
        $annee = date('Y');
        $mois = date('m');
        //$evenements= Evenement::index($annee, $mois);

        $now = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s');


        $evenements_publics_array = array();
        if (session('entite_uid') == 'bde') {
            $evenements_publics = Evenement::index($annee, $mois)
                ->where('confidentialite', '=', 0)
                ->where('date_apparition', '<', $now);
            foreach ($evenements_publics as $evenement_pub) {
                $evenements_publics_array[] = $evenement_pub;
            }
        } else {
            $evenements_publics = Evenement::index($annee, $mois)
                ->where('entite_id', '=', session('entite_id'))
                ->where('confidentialite', '=', 0)
                ->where('date_apparition', '<', $now);
            foreach ($evenements_publics as $evenement_pub) {
                $evenements_publics_array[] = $evenement_pub;
            }
        }

        $niveau_administration = AutorisationGestion::niveau_administration();

        if ($niveau_administration == 20) {
            $confidentialite = 4;
        } elseif ($niveau_administration <= 18 && $niveau_administration >= 17) {
            $confidentialite = 3;
        } elseif ($niveau_administration == 13) {
            $confidentialite = 2;
        } elseif ($niveau_administration == 8) {
            $confidentialite = 1;
        } else {
            $confidentialite = 0;
        }

        $evenements_prives = Evenement::index($annee, $mois)
            ->where('confidentialite', '>', 0)
            ->where('confidentialite', '<=', $confidentialite)
            ->where('entite_id', '=', session('entite_id'))
            ->where('date_apparition', '<', $now);
        $evenements_prives_array = array();
        foreach ($evenements_prives as $evenement_priv) {
            $evenements_prives_array[] = $evenement_priv;
        }

        return view(
            "evenements.calendrier",
            [
                //"events" => $evenements->toArray(),
                'events' => $evenements_publics_array,
                'evenements_prives' => $evenements_prives_array,
                'gerer_evenement' => AutorisationGestion::gestion("gerer_evenement"),
                'entite' => session('entite_uid')
            ],
        );
    }


    public static function calendrier_general($site = null)
    {
        // --- FONCTION À SIMPLIFIER ---

        //on doit recuperer l annee et le mois courant. ca sera l affichage par defaut
        $annee = date('Y');
        $mois = date('m');

        
        $now = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s');


        if (!isset($site)) {
            if (Auth::check()) {
                $user = Auth::user();
                if (count($user->campus)>0) {
                    $campus = $user->campus->first();
                } else {
                    // if user has no campus saved, show Douai posts by default
                    $campus = Site::all()->first();
                }
            }
            else {
                // if user not connected, show Douai posts by default
                $campus = Site::all()->first();
            }
            $site = $campus->label;
        } else {
            $campus = Site::where('label', $site)->first();
        }
        
        $canSeeConfidentiel = false;
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->campus->contains($campus)) {
                $canSeeConfidentiel = true;
            }
        }
        if($canSeeConfidentiel) {
            $evenements_publics = Evenement::index($annee, $mois)
                ->where('confidentialite', '=', 0)
                ->where('validation', '=', 1)
                ->where('date_apparition', '<', $now)
                ->intersect($campus->evenements);
        } else {
            $evenements_publics = Evenement::index($annee, $mois)
                ->where('confidentialite', '=', 0)
                ->where('validation', '=', 1)
                ->where('date_apparition', '<', $now)
                ->intersect($campus->evenements->where('confidentiel', 0));
        }

        $evenements_publics_array = array();
        foreach ($evenements_publics as $evenement_pub) {
            $evenements_publics_array[] = $evenement_pub;
        }

        $evenements_user = array();
        if (Auth::check()) {

            $user = Auth::user();

            $evenements_prive = DB::table(DB::raw('evenements', 'entites'))
                ->join('entites', 'evenements.entite_id', '=', 'entites.id')
                ->join('membres', 'membres.entite_id', '=', 'entites.id')
                ->join('users', 'users.id', '=', 'membres.user_id')
                ->select('entites.uid', 'entites.nom', 'membres.role_id', 'entites.couleur_claire', 'evenements.titre', 'evenements.slug', 'evenements.validation', 'evenements.id', 'evenements.confidentialite', 'evenements.description', 'evenements.temps_debut', 'evenements.temps_fin', 'evenements.lieu')
                ->where('users.id', '=', $user['id'])
                ->whereMonth("temps_debut", $mois)
                ->whereYear("temps_debut", $annee)                
                ->where('date_apparition', '<', $now)
                ->get();

            $evenements_prive_array = json_decode(json_encode($evenements_prive), true);

            for ($i = 0; $i < count($evenements_prive_array); $i++) {
                if ($evenements_prive_array[$i]['confidentialite'] == 4 && $evenements_prive_array[$i]['role_id'] <= 2) {
                    $evenements_user[] = $evenements_prive_array[$i];
                } elseif ($evenements_prive_array[$i]['confidentialite'] == 3 && $evenements_prive_array[$i]['role_id'] <= 5) {
                    $evenements_user[] = $evenements_prive_array[$i];
                } elseif ($evenements_prive_array[$i]['confidentialite'] == 2 && $evenements_prive_array[$i]['role_id'] <= 17) {
                    $evenements_user[] = $evenements_prive_array[$i];
                } elseif ($evenements_prive_array[$i]['confidentialite'] == 1 && $evenements_prive_array[$i]['role_id'] <= 25) {
                    $evenements_user[] = $evenements_prive_array[$i];
                }
            }

            ///->where('membres.role_id', '<=', 'evenements.confidentialite')
        }

        for($i = 0; $i < count($evenements_publics_array); $i++) {
            $evenements_publics_array[$i]["description"] = Str::markdown($evenements_publics_array[$i]["description"]);
        }

        return
            view("evenements.calendrier", [
                'events' => $evenements_publics_array,
                'evenements_prives' => $evenements_user,
                'entite' => "",
                'site' => $site
            ]);
    }
    public static function calendrier_index_json(Request $request)
    {
        $annee = $request["annee"];
        $mois = $request["mois"] + 1;

        
        $now = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s');

        //$evenements= Evenement::index($annee, $mois);

        $niveau_administration = AutorisationGestion::niveau_administration();

        if ($niveau_administration == 20) {
            $confidentialite = 4;
        } elseif ($niveau_administration <= 18 && $niveau_administration >= 17) {
            $confidentialite = 3;
        } elseif ($niveau_administration == 13) {
            $confidentialite = 2;
        } elseif ($niveau_administration == 8) {
            $confidentialite = 1;
        } else {
            $confidentialite = 0;
        }

        //on recupere les events demandes*
        $evenements_publics_array = array();
        if (session('entite_uid') == 'bde') {
            $evenements_publics = Evenement::index($annee, $mois)
                ->where('confidentialite', '=', 0)
                ->where('date_apparition', '<', $now);
            foreach ($evenements_publics as $evenement_pub) {
                $evenements_publics_array[] = $evenement_pub;
            }
        } else {
            $evenements_publics = Evenement::index($annee, $mois)
                ->where('entite_id', '=', session('entite_id'))
                ->where('confidentialite', '=', 0)
                ->where('date_apparition', '<', $now);
            foreach ($evenements_publics as $evenement_pub) {
                $evenements_publics_array[] = $evenement_pub;
            }
        }

        $evenements_user = array();
        if (Auth::check()) {
            $user = Auth::user();

            $evenements_prive = DB::table(DB::raw('evenements', 'entites'))
                ->join('entites', 'evenements.entite_id', '=', 'entites.id')
                ->join('membres', 'membres.entite_id', '=', 'entites.id')
                ->join('users', 'users.id', '=', 'membres.user_id')
                ->select('entites.uid', 'entites.nom', 'membres.role_id', 'entites.couleur_claire', 'evenements.titre', /*'evenements.slug', 'evenements.validation',*/ 'evenements.id', /*'evenements.confidentialite',*/ 'evenements.description', 'evenements.temps_debut', 'evenements.temps_fin', 'evenements.lieu')
                ->where('users.id', '=', $user['id'])
                ->where('entites.uid', '=', session('entite_uid'))
                ->whereMonth("temps_debut", $mois)
                ->whereYear("temps_debut", $annee)
                ->where('date_apparition', '<', $now)
                ->get();

            $evenements_prive_array = json_decode(json_encode($evenements_prive), true);

            for ($i = 0; $i < count($evenements_prive_array); $i++) {
                if ($evenements_prive_array[$i]['confidentialite'] == 4 && $evenements_prive_array[$i]['role_id'] <= 2) {
                    $evenements_user[] = $evenements_prive_array[$i];
                } elseif ($evenements_prive_array[$i]['confidentialite'] == 3 && $evenements_prive_array[$i]['role_id'] <= 5) {
                    $evenements_user[] = $evenements_prive_array[$i];
                } elseif ($evenements_prive_array[$i]['confidentialite'] == 2 && $evenements_prive_array[$i]['role_id'] <= 17) {
                    $evenements_user[] = $evenements_prive_array[$i];
                } elseif ($evenements_prive_array[$i]['confidentialite'] == 1 && $evenements_prive_array[$i]['role_id'] <= 25) {
                    $evenements_user[] = $evenements_prive_array[$i];
                }
            }
        }


        return [
            "events" => $evenements_publics_array,
            "evenements_prives" => $evenements_user,
        ];
    }

    public static function calendrier_index_json_general(Request $request)
    {
        $annee = $request["annee"];
        $mois = $request["mois"] + 1;
        $site = $request["site"];
        
        $now = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s');

        if (!isset($site)) {
            if (Auth::check()) {
                $user = Auth::user();
                if (count($user->campus)>0) {
                    $campus = $user->campus->first();
                } else {
                    // if user has no campus saved, show Douai posts by default
                    $campus = Site::all()->first();
                }
            }
            else {
                // if user not connected, show Douai posts by default
                $campus = Site::all()->first();
            }
            $site = $campus->label;
        } else {
            $campus = Site::where('label', $site)->first();
        }
        //$evenements= Evenement::index($annee, $mois);
        
        $canSeeConfidentiel = false;
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->campus->contains($campus)) {
                $canSeeConfidentiel = true;
            }
        }

        //on recupere les events demandes*
        if($canSeeConfidentiel) {
            $evenements_publics = Evenement::index($annee, $mois)
                ->where('confidentialite', '=', 0)
                ->where('validation', '=', 1)
                ->where('date_apparition', '<', $now)
                ->intersect($campus->evenements);
        } else {
            $evenements_publics = Evenement::index($annee, $mois)
                ->where('confidentialite', '=', 0)
                ->where('validation', '=', 1)
                ->where('date_apparition', '<', $now)
                ->intersect($campus->evenements->where('confidentiel', 0));
        }

        $evenements_publics_array = array();
        foreach ($evenements_publics as $evenement_pub) {
            $evenements_publics_array[] = $evenement_pub;
        }

        info($evenements_publics_array);

        $evenements_user = array();
        if (Auth::check()) {
            $user = Auth::user();

            $evenements_prive = DB::table(DB::raw('evenements', 'entites'))
                ->join('entites', 'evenements.entite_id', '=', 'entites.id')
                ->join('membres', 'membres.entite_id', '=', 'entites.id')
                ->join('users', 'users.id', '=', 'membres.user_id')
                ->select('entites.uid', 'entites.nom', 'membres.role_id', 'entites.couleur_claire', 'evenements.titre', 'evenements.slug', 'evenements.validation', 'evenements.id', 'evenements.confidentialite', 'evenements.description', 'evenements.temps_debut', 'evenements.temps_fin', 'evenements.lieu')
                ->where('users.id', '=', $user['id'])
                ->whereMonth("temps_debut", $mois)
                ->whereYear("temps_debut", $annee)
                ->where('date_apparition', '<', $now)
                ->get();

            $evenements_prive_array = json_decode(json_encode($evenements_prive), true);

            for ($i = 0; $i < count($evenements_prive_array); $i++) {
                if ($evenements_prive_array[$i]['confidentialite'] == 4 && $evenements_prive_array[$i]['role_id'] <= 2) {
                    $evenements_user[] = $evenements_prive_array[$i];
                } elseif ($evenements_prive_array[$i]['confidentialite'] == 3 && $evenements_prive_array[$i]['role_id'] <= 5) {
                    $evenements_user[] = $evenements_prive_array[$i];
                } elseif ($evenements_prive_array[$i]['confidentialite'] == 2 && $evenements_prive_array[$i]['role_id'] <= 17) {
                    $evenements_user[] = $evenements_prive_array[$i];
                } elseif ($evenements_prive_array[$i]['confidentialite'] == 1 && $evenements_prive_array[$i]['role_id'] <= 25) {
                    $evenements_user[] = $evenements_prive_array[$i];
                }
            }
        }

        for($i = 0; $i < count($evenements_publics_array); $i++) {
            $evenements_publics_array[$i]["description"] = Str::markdown($evenements_publics_array[$i]["description"]);
        }

        return [
            "events" => $evenements_publics_array,
            "evenements_prives" => $evenements_user,
            "site" => $site
        ];
    }

    public static function validation(Request $request)
    {
        AutorisationGestion::protectionPage("gerer_evenement");

        $resultat = ["id" => $request->id,];
        $evenement = Evenement::where('id', '=', $request["id"])->get();
        $evenement[0]->update(['validation' => 1]);

        return redirect(session('entite_uid') . "/calendrier");
    }

    public static function invalidation(Request $request)
    {
        AutorisationGestion::protectionPage("gerer_evenement");

        $resultat = ["id" => $request->id,];
        $evenement = Evenement::where('id', '=', $request["id"])->get();
        $evenement[0]->update(['validation' => 0]);

        return redirect(session('entite_uid') . "/calendrier");
    }

    public static function suppression(Request $request)
    {
        AutorisationGestion::protectionPage("gerer_evenement");

        $resultat = ["id" => $request->id,];
        $evenement = Evenement::find($request["id"])->delete();

        return redirect(session('entite_uid') . "/calendrier");
    }
}
