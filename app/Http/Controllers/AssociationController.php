<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Association;
use \App\Models\Logo;

use Illuminate\Support\Str;
use \App\Services\AutorisationGestion;
use Illuminate\Validation\Rule;

class AssociationController extends Controller
{
    public function create(){ //réservé à l'AIR
		AutorisationGestion::protectionPage("gerer_association");

		$assos_existantes = Association::get();

		return view('association.creer', ['assos_existantes' => $assos_existantes]);
	}

	public function store(Request $request){
		AutorisationGestion::protectionPage("gerer_association");
		
		$validation = [
			'nom' => ['filled','max:120'],
			'bureau_de_ratachement' => ['filled', Rule::in(['bda', 'bde', 'bdh', 'bds'])],
			'type' => ['filled',Rule::in(['bureau', 'club', 'comité', 'liste', 'fakeliste'])],
		];
		$this->validate($request, $validation);

		//on se moque d'avoir des doublons d'uid pour les listes
		$asso_uid = Str::slug($request->nom, '.');
		$asso = Association::where('uid', $asso_uid)->where('type', '!=', 'liste');
		if($asso->exists()){
			$asso = $asso->first();
		}
		else {
			$asso = new Association;
			$asso->nom = $request->nom;
			$asso->uid = $asso_uid;
			$asso->bureau_de_ratachement = $request->bureau_de_ratachement;
			$asso->type = $request->type;
			$asso->save();
		}


		return redirect()->route('modifier', ['asso_id' => $asso->id, 'creation' => true]);
	}

	public function edit(Request $request)
	{
		AutorisationGestion::protectionPage("gerer_association");

		$asso = Association::find($request->route('asso_id'));
		if(is_null($asso)){
			abort(404);
		}

		return view('association.modifier', [
			'association' => $asso,
			'titre' => "Modifier une association",
			'creation' => $request->query('creation', 0),
		]);
	}

	public function update(Request $request)
	{
		AutorisationGestion::protectionPage("gerer_association");
		
		$asso = Association::find($request->route('asso_id'));
		if(is_null($asso)){
			abort(404);
		}

		$request->categories = array_map('strtolower',array_map('trim',explode(",",$request->categories)));
		sort($request->categories);
		$validation = [
			'sites' => ['filled','array',Rule::in(['douai', 'dunkerque', 'lille', 'valenciennes'])],
			'categories' => ['filled','distinct'],
			'description' => ['filled'],
			'annee_creation' => ['filled','numeric'],
			'annee_fin' => ['nullable','numeric'],
			'courriel' => ['nullable','max:191','email:rfc'],
			'alias' => ['nullable','max:191','email:rfc'],
		];
		$this->validate($request, $validation);

		$request->has('privee') ? $privee=true : $privee=false;
		$request->has('ouvert') ? $ouvert=true : $ouvert=false;

		$asso->description = $request->description;
		$asso->sites = json_encode($request->sites);
		$asso->categories = json_encode($request->categories);
		$asso->privee = $request->has('privee');
		$asso->ouvert = $request->has('ouvert');
		$asso->annee_creation = $request->annee_creation;
		$asso->annee_fin = $request->annee_fin;
		$asso->courriel = $request->courriel;
		$asso->alias = $request->alias;
		$asso->save();

		if($request->query('creation')){
			return redirect()->route('logotype', ['asso_id' => $asso->id, 'creation' => true]);
		} else {
			return redirect($asso->url());
		}
	}

	public function index(){
		$bureau = Association::find(session('association_id'));

		$site_bureau = json_decode($bureau->sites)[0];

		$assos_dependantes = Association::where('bureau_de_ratachement', $bureau->bureau_de_ratachement)
							->where('sites','LIKE', '%'. $site_bureau .'%')
							->where('type','!=', 'bureau')
							->get();

		return view('association.index', ["bureau" => $bureau, "assos_dependantes" => $assos_dependantes]);
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
