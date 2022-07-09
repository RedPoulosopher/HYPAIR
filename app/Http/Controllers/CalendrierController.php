<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Evenement;
use \App\Services\AutorisationGestion;

class CalendrierController extends Controller
{
    public static function calendrier_asso(){
        //on doit recuperer l annee et le mois courant. ca sera l affichage par defaut
        $annee = date('Y');
        $mois = date('m');
        $evenements= Evenement::index($annee, $mois);
        $tables = Evenement::select('titre', 'slug', 'description', 'temps_debut', 'temps_fin', 'lieu', 'max_participation', 'pour_cotisant', 'validation')
        ->get();
        return view("evenements.calendrier", [
            "events" => $evenements->toArray(),	
			'tables' => $tables,            
			'gerer_evenement' => AutorisationGestion::gestion("gerer_evenement")
        ],
    );

    }

    public static function calendrier_index_json(Request $request){
        $annee = $request["annee"];
        $mois = $request["mois"] +1;

        //on recupere les events demandes
        $evenements= Evenement::index($annee, $mois);
       
        return ["events" => $evenements];
    }
    //

}
