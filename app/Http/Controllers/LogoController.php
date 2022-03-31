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

		return view('association.modifier_logotype', [
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
		$asso->couleur_police_accentuation_claire = self::couleur_ecriture($request->couleur_claire);
		$asso->couleur_police_accentuation_sombre = self::couleur_ecriture($request->couleur_sombre);
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

	static function couleur_ecriture($couleur_accent){
        $blanc = self::lum_diff($couleur_accent, '#ffffff');
        $noir = self::lum_diff($couleur_accent, '#000000');

        if($blanc > $noir){
            return '#ffffff';
        } else {
            return '#000000';
        }
    }
    
    static function lum_diff($couleur_1, $couleur_2){
        list($R1, $G1, $B1) = sscanf($couleur_1, "#%02x%02x%02x");
        list($R2, $G2, $B2) = sscanf($couleur_2, "#%02x%02x%02x");

        $L1 = 0.2126 * pow($R1/255, 2.2) +
              0.7152 * pow($G1/255, 2.2) +
              0.0722 * pow($B1/255, 2.2);
     
        $L2 = 0.2126 * pow($R2/255, 2.2) +
              0.7152 * pow($G2/255, 2.2) +
              0.0722 * pow($B2/255, 2.2);
     
        if($L1 > $L2){
            return ($L1+0.05) / ($L2+0.05);
        }else{
            return ($L2+0.05) / ($L1+0.05);
        }
    }
}
