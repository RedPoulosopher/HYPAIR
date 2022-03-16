<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\AssoBureauEnum;
use App\Enums\AssoTypeEnum;
use \App\Models\Association;
use \App\Models\Logo;

use Illuminate\Support\Str;
use \App\Services\AutorisationGestion;
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
		AutorisationGestion::protectionPage("gerer_association");

		$asso = Association::existe(session('association_id'));

		return view('association.gestion')->with('asso', $asso);
	}

    public function create() //réservé à l'AIR
	{
		AutorisationGestion::protectionPage("gerer_association");

		$assos_existantes = Association::get();

		return view('association.creer', ['assos_existantes' => $assos_existantes]);
	}

	public function store(Request $request) //réservé à l'AIR
	{
		AutorisationGestion::protectionPage("gerer_association");
		
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
		AutorisationGestion::protectionPage("gerer_association");

		$asso = Association::existe($request->route('asso_id'));

		return view('association.modifier', [
			'association' => $asso,
			'titre' => "Modifier une association",
			'creation' => $request->query('creation', 0),
		]);
	}

	public function description_edit(){
		AutorisationGestion::protectionPage("gerer_association");

		$asso = Association::existe(session('association_id'));

		return view('association.description')->with('association', $asso);
	}

	public function description_update(Request $request){
		AutorisationGestion::protectionPage("gerer_association");

		$asso = Association::existe(session('association_id'));
		
		$request->categories = array_map('strtolower',array_map('trim',explode(",",$request->categories)));
		sort($request->categories);
		
		$this->validate($request, [
			'description' => ['filled','min:300'],
			'categories' => ['filled','distinct'],
		]);

		$asso->description = $request->description;
		$asso->categories = json_encode($request->categories);
		$asso->save();

		return redirect()->route('a_propos', ['uid_asso' => $asso->uid]);
	}

	public function update(Request $request) //réservé à l'AIR
	{
		AutorisationGestion::protectionPage("gerer_association");
		
		$asso = Association::existe($request->route('asso_id'));

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

	public function index() //réservé aux bureaux
	{
		$bureau = Association::find(session('association_id'));

		$site_bureau = json_decode($bureau->sites)[0];

		$assos_dependantes = Association::where('bureau_de_ratachement', $bureau->bureau_de_ratachement)
							->where('sites','LIKE', '%'. $site_bureau .'%');

		$comites_dependants = clone $assos_dependantes->where('type', AssoTypeEnum::Comite)->orderBy('nom');;
		$listes_dependantes = clone $assos_dependantes->where('type', AssoTypeEnum::Liste)->where('annee_creation', Carbon::now()->year);

		return view('association.index', ["bureau" => $bureau, "comites_dependants" => $comites_dependants->get(), "listes_dependantes" => $listes_dependantes->get()]);
	}

	public function index_admin() //réservé à l'AIR
	{
		AutorisationGestion::protectionPage("gerer_association");

		return view('association.index_admin');
	}

	public function index_admin_json(Request $request) //réservé à l'AIR
	{
		AutorisationGestion::protectionPage("gerer_association");

		$assos = Association::select('id','uid','nom','bureau_de_ratachement','type','annee_fin','sites');

		if($request["type"] == AssoTypeEnum::Liste){
			$assos->where('type', AssoTypeEnum::Liste)
					->orWhere('type', AssoTypeEnum::Fakeliste)
					->orderBy('annee_creation', 'desc');
		}
		else if($request["type"] == AssoTypeEnum::Bureau) {
			$assos->where('type', AssoTypeEnum::Comite);
		}
		else if($request["type"] == AssoTypeEnum::Comite) {
			$assos->where('type', AssoTypeEnum::Comite);
		}

		return Response()->json($assos->orderBy('nom', 'asc')->get()->toArray());
	}

}
