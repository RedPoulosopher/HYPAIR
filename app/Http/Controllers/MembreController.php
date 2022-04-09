<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Entite;
use \App\Models\User;
use \App\Models\Membre;
use \App\Models\Role;

use \App\Services\AutorisationGestion;
use Illuminate\Validation\Rule;

class MembreController extends Controller
{
    public function passation(Request $request){
		AutorisationGestion::protectionPage("gerer_entite");

		$entite = Entite::existe($request->route('entite_id'));

		return view('entite.passation', [
			'entite' => $entite,
			'creation' => $request->query('creation', 0),
		]);
    }

    public function ajout_membre(Request $request){
		//on vérifie que l'entite existe
		$entite = Entite::existe($request->route('entite_id'));
		
		$membre_role_id = Role::role_id("membre");
		$user = User::existe($request["user_uid"]);
		if(!$user){
			return back()->withErrors(["msg"=>"L'uid fourni ne correspond à aucun utilisateur."]);
		}

		$membre_model = new Membre;
		$membre_model->entite_id = $request->route('entite_id');
		$membre_model->user_id =  $user->id;
		$membre_model->role_id =  $membre_role_id;
		$membre_model->nouveau_membre();

		return back();
    }

	public function mandat(){
		$entite = Entite::existe(session('entite_id'));

		return $entite->mandat()->get();
	}

	public function index_admin(Request $request){
		$entite_id = $request->route('entite_id') ?? session('entite_id');

		$entite = Entite::existe($entite_id);

		if(isset($request["type"])){

			if($request["type"] == "membre"){ //seule l'AIR peut gérer les bureaux
				$personnes_a_responsabilites = $entite->personnes_a_responsabilites();
			}
			else if($request["type"] == "abonne") {
				$personnes_a_responsabilites = $entite->abonnes();
			}

			$personnes_a_responsabilites = $personnes_a_responsabilites->get();

			$roles = Role::index();
		} else {
			$personnes_a_responsabilites = null;

			$roles = array();
		}

		return view('membre.index_admin', ["personnes_a_responsabilites" => $personnes_a_responsabilites, "roles"=>$roles]);
	}
}
