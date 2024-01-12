<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Entite;

use \App\Services\AutorisationGestion;
use \App\Services\GestionLogo;
use App\Enums\EntiteTypeEnum;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class LogoController extends Controller
{
    public function modifier_logo(Request $request)
    {
		AutorisationGestion::protectionPage("gerer_entite");
        $entite_id =  $request->route('entite_id') ?? session('entite_id');
		$entite = Entite::existe($entite_id);

		return view('entite.modifier_logotype', [
			'entite' => $entite,
			'creation' => $request->query('creation', 0),
		]);
    }

    public function maj_logo(Request $request){
		AutorisationGestion::protectionPage("gerer_entite");

        $request->query('creation') ? $creation=true : $creation=false;
        $presence_logo = $request->has('logo');

		$this->validate($request, [
			'couleur_claire' => ['filled'],
			'couleur_sombre' => ['filled'],
		]);

        $entite_uid =  $request->route('entite_uid') ?? session('entite_uid');
        $entite_id =  $request->route('entite_id') ?? session('entite_id');
        $entite = Entite::existe($entite_id);

        //on stock le logo dans le storage et dans la base de données
		if($creation || $presence_logo){
			GestionLogo::validation_logo($request->logo);
			GestionLogo::stocker_logo($request->file('logo'), $entite_id);
		}

		if($request->query('creation')){
			$asso_gerante = Entite::existe(session('entite_id'));
            if ($asso_gerante->type == EntiteTypeEnum::Bureau) {
                return redirect()->route('bdx_modifier_couleur', ['entite_uid' => $request->route('entite_uid'), 'entite_id' => $entite->id, 'creation' => true]);
            } else {
                return redirect()->route('air_modifier_couleur', ['air_uid' => $request->route('air_uid'), 'entite_id' => $entite->id, 'creation' => true]);
		}
        }else {
			return redirect($entite->lien_relatif());
		}
    }


    public function modifier_couleur(Request $request)
    {
		AutorisationGestion::protectionPage("gerer_entite");

        $entite_id =  $request->route('entite_id') ?? session('entite_id');
        $entite = Entite::existe($entite_id);

		return view('entite.modifier_couleur', [
			'entite' => $entite,
			'creation' => $request->query('creation', 0),
		]);
    }

    public function maj_couleur(Request $request){
		AutorisationGestion::protectionPage("gerer_entite");

        $request->query('creation') ? $creation=true : $creation=false;
        $presence_logo = $request->has('logo');

		$this->validate($request, [
			'couleur_claire' => ['filled'],
			'couleur_sombre' => ['filled'],
		]);

        //comme l'air peut modif les couleurs, l'entite id vient de la route et ne peut pas venir de la session
        $entite_uid =  $request->route('entite_uid') ?? session('entite_uid');
        $entite_id =  $request->route('entite_id') ?? session('entite_id');
        $entite = Entite::existe($entite_id);

        //on sauvegarde les couleurs de l'entite
		$entite->couleur_claire = $request->couleur_claire;
		$entite->couleur_sombre = $request->couleur_sombre;
		$entite->couleur_police_accentuation_claire = self::couleur_ecriture($request->couleur_claire);
		$entite->couleur_police_accentuation_sombre = self::couleur_ecriture($request->couleur_sombre);
		$entite->save();

		if($request->query('creation')){
			$asso_gerante = Entite::existe(session('entite_id'));
            if ($asso_gerante->type == EntiteTypeEnum::Bureau) {
                return redirect()->route('bdx_gestion_membres', ['entite_uid' => $request->route('entite_uid'), 'entite_id' => $entite->id, 'type' => 'membres', 'creation' => true]);
            } else {
                return redirect()->route('air_gestion_membres', ['air_uid' => $request->route('air_uid'), 'entite_id' => $entite->id, 'type' => 'membres', 'creation' => true]);
		}
		} else {
			return redirect($entite->lien_relatif());
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
