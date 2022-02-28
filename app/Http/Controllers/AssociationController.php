<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Association;
use \App\Models\User;
use \App\Models\Membre;
use \App\Models\Role;

use Illuminate\Support\Str;
use \App\Services\AutorisationGestion;
use Illuminate\Validation\Rule;

class AssociationController extends Controller
{
    public function create(){ //réservé à l'AIR
		AutorisationGestion::protectionPage("gerer_association");

		$assos_existantes = Association::get();

		return view('association.creation', ['assos_existantes' => $assos_existantes]);
	}

	public function store(Request $request){
		AutorisationGestion::protectionPage("gerer_association");
		
		$traitement = $this->fomulaire_traitement_admin($request);
		
		$asso = Association::where('uid', $traitement["uid"])->where('type', '!=', 'liste'); //le lien des listes est unique, odnc on peut avoir des doublons
		if($asso->exists()){
			return back()->withErrors(["msg"=>"Cette association existe déjà."]);
		}

		$role_id_president = Role::role_id("président·e");
		$user_id = User::existe($request["uid_president"]);
		if(!$user_id){
			return back()->withErrors(["msg"=>"L'uid du président ne correspond à aucun utilisateur."]);
		}
		
		$asso_id = Association::create($traitement)->id;

		Membre::create([
			'association_id' => $asso_id,
			'user_id' => $user_id,
			'role_id' => $role_id_president,
		]);

		//ajouter dans le LDAP

		return back()->with("success","success");
	}

	public function fomulaire_traitement_admin(Request $request){
		$validation = [
			'nom' => ['filled','max:120'],
			'bureau_de_ratachement' => ['filled', Rule::in(['BDA', 'BDE', 'BDH', 'BDS'])],
			'type' => ['filled',Rule::in(['bureau', 'club', 'comité', 'liste'])],
			'courriel' => ['nullable','max:191','email:rfc'],
			'alias' => ['nullable','max:191','email:rfc'],
			'sites' => ['filled','array',Rule::in(['douai', 'dunkerque', 'lille', 'valenciennes'])],
			'annee_creation' => ['filled','numeric'],
		];
		$this->validate($request, $validation);

		$request->has('privee') ? $privee=true : $privee=false;
		$request->has('ouvert') ? $ouvert=true : $ouvert=false;

		$resultat = [
			"nom" => $request->nom,
			"uid" => Str::slug($request->nom, '.'),
			"bureau_de_ratachement" => $request->bureau_de_ratachement,
			"type" => $request->type,
			"courriel" => $request->courriel,
			"alias" => $request->alias,
			"sites" => json_encode($request->sites),
			"privee" => $privee,
			"ouvert" => $ouvert,
			"annee_creation" => $request->annee_creation,
			"annee_fin" => $request->annee_fin,
		];

		return $resultat;
	}

	public function index_admin(){
		AutorisationGestion::protectionPage("gerer_association");

		return view('association.index_admin');
	}

	public function index_admin_json(Request $request){
		AutorisationGestion::protectionPage("gerer_association");

		$assos = Association::select('id','uid','nom','bureau_de_ratachement','type','annee_fin','sites');

		if($request["type"] == "liste"){
			$assos->where('type', 'liste')
					->orderBy('annee_creation', 'desc')
					->orderBy('nom', 'asc');
		} else {
			$assos->where('type', "!=", 'liste')
					->orderBy('nom', 'asc');
		}

		return Response()->json($assos->get()->toArray());
	}

}
