<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Logo;
use \App\Models\Association;

use \App\Services\AutorisationGestion;
use \App\Services\GestionLogo;

class LogoController extends Controller
{
    public function create(Request $request)
    {
		AutorisationGestion::protectionPage("gerer_association");

		$asso = Association::find($request->route('asso_id'));
		if(is_null($asso)){
			abort(404);
		}

		return view('association.logo', [
			'association' => $asso,
			'creation' => $request->query('creation', 0),
		]);
    }

    public function store(Request $request){
		AutorisationGestion::protectionPage("gerer_association");

        $request->query('creation') ? $creation=true : $creation=false;

        //on valide les données
		$validation = [
			'couleur_claire' => ['filled'],
			'couleur_sombre' => ['filled'],
		];
		$this->validate($request, $validation);
		GestionLogo::validation_logo($request->logo, $creation); //pas oligatoire si pas creation

        //on récup le modèle de l'asso qu'on est entrain de modif
        $asso_id = $request->route('asso_id');
		$asso = Association::find($asso_id);
		if(is_null($asso)){
			abort(404);
		}

        //on stock le logo dans le storage et dans la base de données
		list($image_nom, $ext) = GestionLogo::stocker_logo($request->file('logo'), $asso_id);
        $logo = new Logo;
        $logo->association_id = $asso_id;
        $logo->nom = $image_nom;
        $logo->extension = $ext;
        $logo->save();

        //on sauvegarde les couleurs de l'asso
		$asso->couleur_claire = $request->couleur_claire;
		$asso->couleur_sombre = $request->couleur_sombre;
		$asso->save();

		if($request->query('creation')){
			return redirect()->route('passation', ['asso_id' => $asso->id, 'creation' => true]);
		} else {
			return redirect($asso->url());
		}
    }
}
