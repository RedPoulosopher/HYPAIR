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

    public function passation_store(Request $request){
		//on vérifie que l'entite existe
		$entite = Entite::existe($request->route('entite_id'));
		
		$role_id_president = Role::role_id("président·e");
		$user_id = User::existe($request["uid_president"]);
		if(!$user_id){
			return back()->withErrors(["msg"=>"L'uid du président ne correspond à aucun utilisateur."]);
		}

		Membre::updateOrCreate(
			['entite_id' => $request->route('entite_id'), 'user_id' => $user_id,],
			['role_id' => $role_id_president,]
		);
		
		return redirect($entite->url());
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
		}

		return view('membre.index_admin', ["personnes_a_responsabilites" => $personnes_a_responsabilites, "roles"=>$roles]);
	}
}
