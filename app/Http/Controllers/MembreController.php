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
    public function ajout_membre(Request $request){
		//on vérifie que l'entite existe
		$entite_id = $request->route('entite_id') ?? session('entite_id');
		$entite = Entite::existe($entite_id);
		
		$membre_role_id = $request["role_id"];
		$user = User::existe($request["user_uid"]);
		if(!$user){
			return back()->withErrors(["msg"=>"L'uid fourni ne correspond à aucun utilisateur."]);
		}

		$membre_model = new Membre;
		$membre_model->entite_id = $entite_id;
		$membre_model->user_id =  $user->id;
		$membre_model->role_id =  $membre_role_id;
		$membre_model->changer_role();

		return back();
    }

	public function mandat(){
		$entite = Entite::existe(session('entite_id'));

		return $entite->mandat()->get();
	}

	public function index_admin(Request $request){
		$entite_id = $request->route('entite_id') ?? session('entite_id');
		$type = $request->route('type');

		$entite = Entite::existe($entite_id);
		$roles = Role::index();

		if($type == "membres"){
			$personnes_concernees = $entite->personnes_a_responsabilites();
		}
		else if($type == "abonnes") {
			$personnes_concernees = $entite->abonnes();
		}

		return view('membre.index_admin', [
			"personnes_concernees" => $personnes_concernees->get(),
			"roles" => $roles,
			"gerer_membre" => AutorisationGestion::gestion("gerer_membre")
		]);
	}
}
