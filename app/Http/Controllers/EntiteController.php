<?php

namespace App\Http\Controllers;

use App\Enums\EntiteType;
use App\Enums\Permisions;
use App\Models\Entite;
use App\Models\Site;
use App\Services\AutorisationGestion;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class EntiteController extends Controller
{
    public function dashboard(Request $request)
	{
        AutorisationGestion::require(Permisions::POST_MANAGE,$request['entite_uid']);
		$entite = Entite::existe($request['entite_uid']);
		$logo_path = $entite->getLogo?->url();
		return view('entite.dashboard')->with('entite', $entite)->with('logo_path',$logo_path);
	}


	public function create(Request $request){
        AutorisationGestion::require(Permisions::ENTITE_MANAGE,$request['entite_uid']);

		$entite_courante = Entite::where('uid',$request['entite_uid'])->first();
		$sites = Site::all();
		$entites = Entite::all();
		$entite_types = array();
		if($entite_courante->type==EntiteType::Administration
			|| $entite_courante->type==EntiteType::Association
			|| $entite_courante->type==EntiteType::Syndicat
			|| $entite_courante->type==EntiteType::Comite
			|| $entite_courante->type==EntiteType::Club){
			$entite_types = [EntiteType::Liste];
		}else if($entite_courante->type==EntiteType::Bureau){
			$entite_types = [EntiteType::Comite,EntiteType::Club,EntiteType::Liste];
		}else if($entite_courante->type==EntiteType::Liste){
			abort(405);
		}else{
			$entite_types = array_map(
				fn(EntiteType $case) => $case,
				EntiteType::cases()
			);
		}

		
		return view('entite.personalisation')
			->with('entite_parant_uid', $entite_courante->uid)
			->with('entite_types',$entite_types)
			->with('entites',$entites)
			->with('sites',$sites)
			->with('creation',1)
			->with('entite_courante_uid',$entite_courante->uid);
	}


	public function store(Request $request)
	{
		$entite_courante = $request->entite_courante_uid;
		AutorisationGestion::require(0,$entite_courante);

		$sites = Site::pluck('id')->toArray();
		$parents_uids = array();
		if($request["type"]==EntiteType::Bureau->value
			|| $request["type"]==EntiteType::Administration->value
			|| $request["type"]==EntiteType::Association->value
			|| $request["type"]==EntiteType::Syndicat->value){
			array_push($parents_uids, 'independant');
		}else if($request["type"]==EntiteType::Comite->value || $request["type"]==EntiteType::Club->value){
			$parents_uids = Entite::where('type','bureau')->pluck('uid')->toArray();
		}else if($request["type"]==EntiteType::Liste->value){
			$parents_uids = Entite::pluck('uid')->toArray();
		}

		if($request['creation']){
			$pre_validator = Validator::make($request->all(), [
				'uid' => ['filled', 'max:30',Rule::notIn(Entite::pluck('uid')->toArray())],
				'parent_uid' => ['filled', Rule::in($parents_uids)],
				'type' => ['filled', new Enum(EntiteType::class)],
			],[
				// UID
				'uid.filled'   => 'Le champ UID est obligatoire.',
				'uid.max'      => 'L’UID ne doit pas dépasser 30 caractères.',
				'uid.not_in'   => 'Cet UID est déjà utilisé par une autre entité.',

				// parent_uid
				'parent_uid.filled' => 'Le rattachement est obligatoire.',
				'parent_uid.enum'   => 'Le rattachement fourni n’est pas valide.',

				// Type
				'type.filled' => 'Le type est obligatoire.',
				'type.enum'   => 'Le type fourni n’est pas valide.',
			]);
		}else{
			$pre_validator = Validator::make($request->all(), [
				'uid' => ['filled', 'max:30',Rule::In(Entite::pluck('uid')->toArray())],
			],[
				// UID
				'uid.filled'   => 'Le champ UID est obligatoire.',
				'uid.max'      => 'L’UID ne doit pas dépasser 30 caractères.',
				'uid.in'       => 'Aucune entité ne correspond à cette UID.',
			]);
		}


		if ($pre_validator->fails()) {
			return redirect()
				->back()
				->withErrors($pre_validator->messages())
				->withInput();
		}

		$validator = Validator::make($request->all(), [
			'sites' => ['filled', 'array', Rule::in($sites)],
			'name' => ['filled', 'max:120'],

			'founded_year' => ['filled', 'numeric'],
			'email' => ['nullable', 'max:191', 'email:rfc'],
			'alias' => ['nullable', 'max:191', 'email:rfc'],
			'tags' => ['filled', 'max:300'],
			'visible' => ['nullable', 'boolean'],
			'short_description' => ['nullable', 'max:255'],
			'description' => ['nullable'],
			'color_1' => ['filled'],
			'color_2' => ['filled'],
		], [
			// Sites
			'sites.filled' => 'Veuillez sélectionner au moins un site.',
			'sites.array'  => 'Le champ sites doit être un tableau.',
			'sites.in'     => 'Le site choisi est invalide.',

			// Nom
			'name.filled'   => 'Le champ nom est obligatoire.',
			'name.max'      => 'Le nom ne doit pas dépasser 120 caractères.',
		]);
		if ($validator->fails()) {
			return redirect()
				->back()
				->withErrors($validator->messages())
				->withInput();
		}

		$entite = Entite::where('uid', $request->uid);

		if ($entite->exists()) {
			$entite = $entite->first();
		} else {
			$entite = new Entite;
		}

		$entite->name = $request->name;
		$entite->uid = $request->uid;
		if($request['creation']){
			$entite->type = $request->type;
			if($request->parent_uid == 'independant'){
				$entite->parent_uid = null;
			}else{
				$entite->parent_uid = $request->parent_uid;
			}
		}

		$entite->tags = $request->tags;
		$entite->founded_year = $request->founded_year;
		$entite->email = $request->email;
		$entite->alias = $request->alias;
		$entite->visible = $request->has('visible');
		$entite->short_description = $request->short_description;
		$entite->description = $request->description;
		$entite->color_1 = $request->color_1;
		$entite->color_2 = $request->color_2;

		if($request['creation'] || $request->has('logo')){
			FileService::validation_img($request->logo);
			$entite->logo = FileService::upload($request->logo,"logo_entites","public",["acces"=>'public']);
			FileService::transformImagePathToSquare512('public',$entite->getLogo->path);
		}
		$entite->save();
		$entite->setSites($request->sites);
		return redirect("/entite/" . $request['uid'] . "/dashboard");
	}

	public function edit(Request $request){
        AutorisationGestion::require(Permisions::ENTITE_MANAGE,$request['entite_uid']);
		$entite = Entite::where('uid',$request['entite_uid'])->first();

		$sites = Site::all();
		$entites = Entite::all();
		$entite_types = array_map(
			fn(EntiteType $case) => $case,
			EntiteType::cases()
		);

		return view('entite.personalisation')
			->with('entite_parant_uid', $entite->parent_uid)
			->with('entite_types',$entite_types)
			->with('entites',$entites)
			->with('sites',$sites)
			->with('creation',0)
			->with('entite',$entite);
	}

	public function delete(Request $request) //réservé à l'AIR et aux bureaux
	{
		$asso_gerante = Entite::existe($request["entite_uid"]);
		$entite = Entite::existe($request["supp_uid"]);
		
		if($asso_gerante->uid == $entite->parent_uid){
			$entite->delete();	
		}
		return redirect()->back();
	}


	public function index_site(Request $request) // réservé aux bureaux
	{
		$site = Site::where("id",$request["site"])->firstOrFail();
		$entites_independantes = $site->entites->where("parent_uid","=",null)->where("parent_uid","!=",null)->where("visible","=",1);
		$bureaux = Entite::where("type","=",EntiteType::Bureau->value)->get();
		//$entites_dependantes = $site->entites->where("parent_uid","!=",null);

		$len_bureaux = count($bureaux);
		$clubs_comites = array();
		for ($i=0; $i < $len_bureaux; $i++) {
			$test=true;
			foreach($bureaux[$i]->getEntitesDependants as $entity) {
				if($entity->sites->contains('id', $site->id)){
					$test=false;
					break;
				}
			}
			if($test && !$bureaux[$i]->sites->contains('id', $site->id)){
				unset($bureaux[$i]);
			}else{
				$clubs_comites[$bureaux[$i]->uid] = $bureaux[$i]->getEntitesDependants()->whereHas('sites', function ($query) use ($site) {
					$query->where('id', $site->id);
				})->where("visible","=",1)->get();
			}
		}
		
		return view(
			'entite.index_site',
			[
				"site" => $site,
				"bureaux" => $bureaux,
				"clubs_comites" => $clubs_comites,
				"entites_independantes" => $entites_independantes
			]
		);
	}

	public function show(Request $request)
	{
		$entite = Entite::existe($request["entite_uid"]);
		$reseaux_sociaux = $entite->reseauxSociaux()->get();

		/*$mandat = $entite->mandat()->get();

		foreach ($mandat as &$mandat_user) {
			$mandat_user["lien_photo"] = GestionPhotoDeProfil::chemin_membre_photo($mandat_user);
			$mandat_user["user_info"] = $mandat_user->user()->first();
			$mandat_user["lien_photo_utilisateur"] = GestionPhotoDeProfil::chemin_utilisateur_photo($mandat_user["user_info"]);
			$mandat_user["reseaux_sociaux"] = $mandat_user["user_info"]->reseaux_sociaux()->get();
		}*/

		return view('entite.a_propos')
			->with('entite', $entite)
			//->with('mandat', $mandat)
			->with('reseaux_sociaux', $reseaux_sociaux);
	}


	public function index_manager_entites(Request $request) //réservé aux bureaux
	{
		$asso_gerante = Entite::existe($request["entite_uid"]);

		$entites_dependantes = $asso_gerante->getEntitesDependants();

		switch($request->query('type')){
			case "independants":
				$entites_dependantes=$entites_dependantes->where("type",EntiteType::Administration->value)
				->orWhere("type",EntiteType::Syndicat->value)
				->orWhere("type",EntiteType::Association->value);
			case "bureau":
				$entites_dependantes=$entites_dependantes->where("type",EntiteType::Bureau->value);
			case "comite":
				$entites_dependantes=$entites_dependantes->where("type",EntiteType::Comite->value)
				->orWhere("type",EntiteType::Club->value);
			case "liste":
				$entites_dependantes=$entites_dependantes->where("type",EntiteType::Liste->value);
		}


		return view(
			'entite.index_admin',
			[
				"asso_gerante" => $asso_gerante,
				"entites_dependantes" => $entites_dependantes->get()
			]
		);
	}

	/*public function index_admin(Request $request) //réservé à l'AIR et aux bureaux
	{
		$asso_gerante = Entite::existe(session('entite_id'));

		if (isset($request["type"])) {

			if ($request["type"] == EntiteType::Bureau->value) { //seule l'AIR peut gérer les bureaux
				$entites_dependantes = $asso_gerante->bureaux();
			} else if ($request["type"] == EntiteType::Comite->value) {
				$entites_dependantes = $asso_gerante->comites_clubs_dependants();
			} else if ($request["type"] == EntiteType::Liste->value) {
				$entites_dependantes = $asso_gerante->listes_dependantes();
			}

			$entites_dependantes = $entites_dependantes->orderBy('nom', 'asc')->get();
		} else {
			$entites_dependantes = [];
		}

		return view('entite.index_admin')->with('est_bureau', $asso_gerante->type == EntiteTypeEnum::Bureau)->with('entites_dependantes', $entites_dependantes);
	}*/
}
