<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\AssoBureauEnum;
use App\Enums\AssoTypeEnum;
use \App\Models\Association;
use \App\Models\Logo;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

use Carbon\Carbon;

class AssociationController extends Controller
{
	public function show()
	{
		$asso = Association::existe(session('association_id'));

		return view('association.a_propos')->with('asso', $asso);
	}

	public function gestion(Request $request)
	{
		$asso = Association::existe(session('association_id'));

		return view('association.gestion')->with('asso', $asso);
	}

    public function create() //réservé à l'AIR
	{
		$assos_existantes = Association::get();

		return view('association.creer', ['assos_existantes' => $assos_existantes]);
	}

	public function store(Request $request) //réservé à l'AIR
	{
		$this->validate($request, [
			'nom' => ['filled','max:120'],
			'bureau_de_ratachement' => ['filled', new Enum(AssoBureauEnum::class)],
			'type' => ['filled', new Enum(AssoTypeEnum::class)],
		]);

		//on se moque d'avoir des doublons d'uid pour les listes
		$asso_uid = Str::slug($request->nom, '.');
		$asso = Association::where('uid', $asso_uid)->where('type', '!=', AssoTypeEnum::Liste);
		
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

	public function edit(Request $request) //réservé à l'AIR
	{
		$asso = Association::existe($request->route('asso_id'));

		return view('association.modifier', [
			'association' => $asso,
			'titre' => "Modifier une association",
			'creation' => $request->query('creation', 0),
		]);
	}

	public function description_edit(){ //pour l'entité
		$asso = Association::existe(session('association_id'));

		return view('association.description')->with('association', $asso);
	}

	public function description_update(Request $request){ //pour l'entité
		$asso = Association::existe(session('association_id'));
		
		$request->categories = array_map('strtolower',array_map('trim',explode(",",$request->categories)));
		sort($request->categories);
		
		$this->validate($request, [
			'description_courte' => ['filled','max:300'],
			'description_md' => ['filled','min:300'],
			'categories' => ['filled','distinct'],
		]);

		$asso->description_courte = $request->description_courte;
		$asso->description_md = $request->description_md;
		$asso->categories = json_encode($request->categories);
		$asso->save();

		return redirect()->route('a_propos', ['uid_asso' => $asso->uid]);
	}

	public function update(Request $request) //réservé à l'AIR
	{
		$asso = Association::existe($request->route('asso_id'));

		$request->categories = array_map('strtolower',array_map('trim',explode(",",$request->categories)));
		sort($request->categories);
		$validation = [
			'sites' => ['filled','array',Rule::in(['douai', 'dunkerque', 'lille', 'valenciennes'])],
			'categories' => ['filled','distinct'],
			'description_courte' => ['filled','max:300'],
			'description_md' => ['filled','min:300'],
			'annee_creation' => ['filled','numeric'],
			'annee_fin' => ['nullable','numeric'],
			'courriel' => ['nullable','max:191','email:rfc'],
			'alias' => ['nullable','max:191','email:rfc'],
		];
		$this->validate($request, $validation);

		$request->has('privee') ? $privee=true : $privee=false;
		$request->has('ouvert') ? $ouvert=true : $ouvert=false;

		$asso->description_courte = $request->description_courte;
		$asso->description_md = $request->description_md;
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

	public function index_site(Request $request) //réservé aux bureaux
	{
		$site = $request["site"];

		$bureaux = Association::bureaux_site($site)->get();

		$comites_clubs_dependants = array();
		foreach($bureaux as $bureau){
			$bureau_ratachement = $bureau->bureau_de_ratachement->value;
			$comites_clubs_dependants[$bureau_ratachement] = $bureau->comites_clubs_dependants()->get();
		}

		return view('association.index_site', [
			"bureaux" => $bureaux,
			"comites_clubs_dependants" => $comites_clubs_dependants,
			]
		);
	}

	public function index_bureau() //réservé aux bureaux
	{
		$bureau = Association::existe(session('association_id'));

		$comites_clubs_dependants = $bureau->comites_clubs_dependants();

		$listes_dependantes = $bureau->listes_dependantes();

		return view('association.index_bureau', [
			"bureau" => $bureau,
			"comites_clubs_dependants" => $comites_clubs_dependants->get(),
			"listes_dependantes" => $listes_dependantes->get()
			]
		);
	}

	public function index_admin() //réservé à l'AIR
	{
		return view('association.index_admin');
	}

	public function index_admin_json(Request $request) //réservé à l'AIR
	{
		$assos = Association::select('id','uid','nom','bureau_de_ratachement','type','annee_fin','sites');

		if($request["type"] == AssoTypeEnum::Liste->value){
			$assos = $assos->where('type', AssoTypeEnum::Liste)
					->orWhere('type', AssoTypeEnum::Fakeliste)
					->orderBy('annee_creation', 'desc');
		}
		else if($request["type"] == AssoTypeEnum::Bureau->value) {
			$assos = $assos->where('type', AssoTypeEnum::Bureau);
		}
		else if($request["type"] == AssoTypeEnum::Comite->value) {
			$assos = $assos->where('type', AssoTypeEnum::Comite)	
						->orWhere('type', AssoTypeEnum::Club);
		}

		return Response()->json($assos->orderBy('nom', 'asc')->get()->toArray());
	}

}
