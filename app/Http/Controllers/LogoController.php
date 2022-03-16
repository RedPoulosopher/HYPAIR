<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Association;

use \App\Services\AutorisationGestion;
use \App\Services\GestionLogo;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class LogoController extends Controller
{
    public function create(Request $request)
    {
		AutorisationGestion::protectionPage("gerer_association");

		$asso = Association::existe($request->route('asso_id'));

		return view('association.logo', [
			'association' => $asso,
			'creation' => $request->query('creation', 0),
		]);
    }

    public function store(Request $request){
		AutorisationGestion::protectionPage("gerer_association");

        $request->query('creation') ? $creation=true : $creation=false;
        $presence_logo = $request->has('logo');

		$this->validate($request, [
			'couleur_claire' => ['filled'],
			'couleur_sombre' => ['filled'],
		]);

		$asso = Association::existe($request->route('asso_id'));

        //on sauvegarde les couleurs de l'asso
		$asso->couleur_claire = $request->couleur_claire;
		$asso->couleur_sombre = $request->couleur_sombre;
		$asso->save();

        //on stock le logo dans le storage et dans la base de données
		if($creation || $presence_logo){
			GestionLogo::validation_logo($request->logo);
			GestionLogo::stocker_logo($request->file('logo'), $request->route('asso_id'));
		}

		if($request->query('creation')){
			return redirect()->route('passation', ['asso_id' => $asso->id, 'creation' => true]);
		} else {
			return redirect($asso->url());
		}
    }
}
