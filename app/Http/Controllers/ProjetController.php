<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Association;
use \App\Models\User;
use \App\Models\Membre;
use \App\Models\Projet;
use \App\Models\Avancee;

use Illuminate\Support\Str;
use \App\Services\AutorisationGestion;
use Illuminate\Validation\Rule;

class ProjetController extends Controller
{
    public function create(){ //réservé à l'AIR
		AutorisationGestion::protectionPage("gerer_projet");
		$niveau_administration = Autorisation::niveau_administration();
		$projets_existantes = Projet::select('projet_id','titre')->where("confidentialite","<=",$niveau_administration)->get();

		return view('projet.creation');
	}

	public function store(Request $request){
		AutorisationGestion::protectionPage("gerer_projet");
		
		$traitement = $this->fomulaire_projet($request);
		
		$projet = Projet::where('uid', $traitement["uid"])->where('type', '!=', 'liste'); //le lien des listes est unique, odnc on peut avoir des doublons
		if($projet->exists()){
			return back()->withErrors(["msg"=>"Cette projet existe déjà."]);
		}

		$role_id_chef_projet = Role::role_id("chef_projet");
		$user_id = User::existe($request["uid_president"]);
		if(!$user_id){
			return back()->withErrors(["msg"=>"L'uid du chef projet ne correspond à aucun utilisateur."]);
		}
		
		$projet_id = Projet::create($traitement)->id;

		Membre::create([
			'projet_id' => $projet_id,
			'user_id' => $user_id,
			'role_id_chef_projet' => $role_id_chef_projet,
		]);

		//ajouter dans le LDAP

		return back()->with("success","success");
	}

	public function fomulaire_projet(Request $request){
		$validation = [
			'titre' => ['filled','max:120'],
			'confidentialite' => ['filled', Rule::in(['Public','Privée'])],
			'courriel' => ['nullable','max:191','email:rfc'],
			'annee_creation' => ['filled','numeric'],
			"description_courte"=>['filled','max:1000']
		];
		$this->validate($request, $validation);

		$request->has('privee') ? $privee=true : $privee=false;
		$request->has('ouvert') ? $ouvert=true : $ouvert=false;

		$resultat =[
			"titre" => $request->titre,
			"projet_id" => Str::slug($request->nom, '.'),
			"association_uid" => $request->association_uid,
			"confidentialite" => $request->confidentialite,
			"description_courte"=> $request->description_courte,
		];

		return $resultat;
	}

	public function index_projet(){
		AutorisationGestion::protectionPage("gerer_projet");

		return view('projet.index_projet');
	}

	public function index_projet_json(Request $request){
		AutorisationGestion::protectionPage("gerer_projet");

		$projet = Projet::select('projet_id','uid','titre','description_courte','chef_projet');

		if($request["titre"] == "titre"){
			$projet->where('titre')
					->like('*titre*')->orderBy('titre','asc');

		return Response()->json($projet->get()->toArray());
	}

}
}