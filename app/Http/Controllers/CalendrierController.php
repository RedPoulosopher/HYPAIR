<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Evenement;
use \App\Services\AutorisationGestion;
use \App\Models\Entite;

class CalendrierController extends Controller
{
    public static function calendrier_asso(){
        //on doit recuperer l annee et le mois courant. ca sera l affichage par defaut
        $annee = date('Y');
        $mois = date('m');
        //$evenements= Evenement::index($annee, $mois);
        $evenements_publics = Evenement::index($annee, $mois)//::select('titre', 'entite_id', 'slug', 'description', 'temps_debut', 'temps_fin', 'confidentialite', 'lieu', 'max_participation', 'pour_cotisant', 'validation')
            ->where('confidentialite', '=', 0);
        //->get();
        $evenements_publics_array = array();
        foreach ($evenements_publics as $evenement_pub) {
            $evenements_publics_array[] = $evenement_pub;
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
            ->where('entite_id', '=', session('entite_id'));
        $evenements_prives_array = array();
        foreach ($evenements_prives as $evenement_priv) {
            $evenements_prives_array[] = $evenement_priv;
        }    
	
        
        return view("evenements.calendrier", [
            //"events" => $evenements->toArray(),	
			'events' => $evenements_publics_array, 
            'evenements_prives' => $evenements_prives_array,
			'gerer_evenement' => AutorisationGestion::gestion("gerer_evenement"),
            'entite' => session('entite_uid')
            ],
        );

    }

    public static function calendrier_index_json(Request $request){
        $annee = $request["annee"];
        $mois = $request["mois"] +1;

        
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
        $evenements_publics = Evenement::index($annee, $mois)
            ->where('confidentialite', '=', 0);
        $evenements_publics_array = array();
        foreach ($evenements_publics as $evenement_pub) {
            $evenements_publics_array[] = $evenement_pub;
        }

        $evenements_prives = Evenement::index($annee, $mois)
            ->where('confidentialite', '>', 0)
            ->where('confidentialite', '<=', $confidentialite)
            ->where('entite_id', '=', session('entite_id'));
        $evenements_prives_array = array();
        foreach ($evenements_prives as $evenement_priv) {
            $evenements_prives_array[] = $evenement_priv;
        }  
       
        return [
            "events" => $evenements_publics_array,
            "evenements_prives" => $evenements_prives_array,
        ];
    }
    

    public static function validation(Request $request) {        
		AutorisationGestion::protectionPage("gerer_evenement");       

        $resultat = ["id" => $request->id,];
        $evenement = Evenement::where('id', '=', $request["id"])->get();
        $evenement[0]->update(['validation' => 1]);
		
        return redirect(session('entite_uid') . "/calendrier");
    }

    public static function invalidation(Request $request) {        
		AutorisationGestion::protectionPage("gerer_evenement");       

        $resultat = ["id" => $request->id,];
        $evenement = Evenement::where('id', '=', $request["id"])->get();
        $evenement[0]->update(['validation' => 0]);
		
        return redirect(session('entite_uid') . "/calendrier");
    }

    public static function suppression(Request $request) {        
		AutorisationGestion::protectionPage("gerer_evenement");       

        $resultat = ["id" => $request->id,];
        $evenement = Evenement::find($request["id"])->delete();

        return redirect(session('entite_uid') . "/calendrier");
    }

}
