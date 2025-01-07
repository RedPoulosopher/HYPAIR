<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\RatachementEnum;
use App\Enums\EntiteTypeEnum;
use \App\Models\Entite;
use \App\Models\Logo;
use \App\Models\Site;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\Auth;

use \App\Services\AutorisationGestion;
use App\Services\GestionPhotoDeProfil;

use Carbon\Carbon;

class EntiteController extends Controller
{
	public function show()
	{
		$entite = Entite::existe(session('entite_id'));
		$reseaux_sociaux = $entite->reseaux_sociaux()->with('liste')->get();

		$categories = $entite->categories()->get();

		$mandat = $entite->mandat()->get();

		foreach ($mandat as &$mandat_user) {
			$mandat_user["lien_photo"] = GestionPhotoDeProfil::chemin_membre_photo($mandat_user);
			$mandat_user["user_info"] = $mandat_user->user()->first();
			$mandat_user["lien_photo_utilisateur"] = GestionPhotoDeProfil::chemin_utilisateur_photo($mandat_user["user_info"]);
			$mandat_user["reseaux_sociaux"] = $mandat_user["user_info"]->reseaux_sociaux()->get();
		}

		return view('entite.a_propos')
			->with('entite', $entite)
			->with('mandat', $mandat)
			->with('categories', $categories)
			->with('reseaux_sociaux', $reseaux_sociaux);
	}

	public function gestion(Request $request)
	{
		$entite = Entite::existe(session('entite_id'));

		return view('entite.gestion')
			->with('entite', $entite);
	}

	public function create() //réservé à l'AIR et aux bureaux
	{
		$sites = Site::all();

		$asso_gerante = Entite::existe(session('entite_id'));

		return view('entite.creer')->with([
			'sites' => $sites,
			'est_bureau' => $asso_gerante->type == EntiteTypeEnum::Bureau
		]);
	}

	public function store(Request $request) //réservé à l'AIR et aux bureaux
	{
		$asso_gerante = Entite::existe(session('entite_id'));
		
		//Si c'est un bureau qui créé une entité, elle lui est automatiquement rattachée
		if($asso_gerante->type == EntiteTypeEnum::Bureau){
			$request['ratachement'] = $asso_gerante->uid;
		}

		$this->validate($request, [
			'sites' => ['filled', 'array', Rule::in(['douai', 'dunkerque', 'lille', 'valenciennes', 'alençon'])],
			'nom' => ['filled', 'max:120'],
			'uid' => ['filled', 'max:30'],
			'ratachement' => ['filled', new Enum(RatachementEnum::class)],
			'type' => ['filled', new Enum(EntiteTypeEnum::class)],
		]);

		//on se moque d'avoir des doublons d'uid pour les listes
		$entite = Entite::where('uid', $request->uid)->where('type', '!=', EntiteTypeEnum::Liste);

		if ($entite->exists()) {
			$entite = $entite->first();
		} else {
			$entite = new Entite;
		}
		$entite->nom = $request->nom;
		$entite->uid = $request->uid;
		$entite->ratachement = $request->ratachement;
		$entite->type = $request->type;
		$entite->save();

		$entite->ajout_sites($request->sites);

		if ($asso_gerante->type == EntiteTypeEnum::Bureau) {
			return redirect()->route('bdx_modifier_infos', ['entite_uid' => $request->route('entite_uid'), 'entite_id' => $entite->id, 'creation' => true]);
		} else {
			return redirect()->route('air_modifier_infos', ['air_uid' => $request->route('air_uid'), 'entite_id' => $entite->id, 'creation' => true]);
		}
		// $route_name_prefix = $asso_gerante->type == EntiteTypeEnum::Bureau ? 'bdx_' : 'air_';//La route est différente selon si c'est un bureau ou l'air qui créé
	}

	public function modifier_infos(Request $request) //réservé à l'AIR et aux bureaux
	{
		$entite = Entite::existe($request->route('entite_id'));

		return view('entite.modifier_infos', [
			'entite' => $entite,
			'titre' => "Modifier une entite",
			'creation' => $request->query('creation', 0),
		]);
	}

	public function maj_infos(Request $request) //réservé à l'AIR et aux bureaux
	{
		$entite = Entite::existe($request->route('entite_id'));

		$request->categories = array_map('strtolower', array_map('trim', explode(",", $request->categories)));
		sort($request->categories);
		$validation = [
			'annee_creation' => ['filled', 'numeric'],
			'annee_fin' => ['nullable', 'numeric'],
			'courriel' => ['nullable', 'max:191', 'email:rfc'],
			'alias' => ['nullable', 'max:191', 'email:rfc'],
		];
		$this->validate($request, $validation);

		$request->has('privee') ? $privee = true : $privee = false;
		$request->has('ouvert') ? $ouvert = true : $ouvert = false;

		$entite->privee = $request->has('privee');
		$entite->ouvert = $request->has('ouvert');
		$entite->annee_creation = $request->annee_creation;
		$entite->annee_fin = $request->annee_fin;
		$entite->courriel = $request->courriel;
		$entite->alias = $request->alias;
		$entite->save();

		if ($request->query('creation')) {
			$asso_gerante = Entite::existe(session('entite_id'));
			if ($asso_gerante->type == EntiteTypeEnum::Bureau) {
				return redirect()->route('bdx_modifier_description', ['entite_uid' => $request->route('entite_uid'), 'entite_id' => $entite->id, 'creation' => true]);
			} else {
				return redirect()->route('air_modifier_description', ['air_uid' => $request->route('air_uid'), 'entite_id' => $entite->id, 'creation' => true]);
			}
		} else {
			return redirect($entite->lien_relatif());
		}
	}

	public function modifier_description(Request $request)
	{
		$entite_id = $request->route('entite_id') ?? session('entite_id');

		$entite = Entite::existe($entite_id);

		$categories = $entite->categories()->get()->pluck('label')->toArray();

		return view('entite.modifier_description')->with('entite', $entite)->with('categories', $categories);
	}

	public function maj_description(Request $request)
	{
		$entite_id = $request->route('entite_id') ?? session('entite_id');

		$entite = Entite::existe($entite_id);

		$request->categories = array_map('strtolower', array_map('trim', explode(",", $request->categories)));
		$this->validate($request, [
			'description_courte' => ['filled', 'max:255'],
			'categories' => ['filled', 'distinct'],
		]);

		$entite->description_courte = $request->description_courte;
		$entite->description_md = $request->description_md;
		$entite->save();


		sort($request->categories);
		$entite->ajout_categories($request->categories);

		if ($request->query('creation')) {
			$asso_gerante = Entite::existe(session('entite_id'));

			if ($asso_gerante->type == EntiteTypeEnum::Bureau) {
				return redirect()->route('bdx_modifier_logotype', ['entite_uid' => $request->route('entite_uid'), 'entite_id' => $entite->id, 'creation' => true]);
			} else {
				return redirect()->route('air_modifier_logotype', ['air_uid' => $request->route('air_uid'), 'entite_id' => $entite->id, 'creation' => true]);
			}
		} else {
			return redirect($entite->lien_relatif());
		}
	}

	public function index_site(Request $request) // réservé aux bureaux
	{
		$site = $request["site"];

		$entites_independantes = Entite::independants_site($site)->get();
		$bureaux = Entite::bureaux_site($site)->get();

		$comites_clubs_dependants = array();
		$listes_dependantes = array();
		foreach ($bureaux as $bureau) {
			$bureau_ratachement = $bureau->ratachement->value;
			//Comités
			$comites_clubs_dependants[$bureau_ratachement] = $bureau->comites_clubs_dependants()->get();
		}

		return view(
			'entite.index_site',
			[
				"site" => $site,
				"bureaux" => $bureaux,
				"comites_clubs_dependants" => $comites_clubs_dependants,
				"entites_independantes" => $entites_independantes
			]
		);
	}

	public function index_bureau() //réservé aux bureaux
	{
		$bureau = Entite::existe(session('entite_id'));

		$comites_clubs_dependants = $bureau->comites_clubs_dependants();

		$listes_dependantes = $bureau->listes_dependantes();

		return view(
			'entite.index_bureau',
			[
				"bureau" => $bureau,
				"comites_clubs_dependants" => $comites_clubs_dependants->get(),
				"listes_dependantes" => $listes_dependantes->get()
			]
		);
	}

	public function index_admin(Request $request) //réservé à l'AIR et aux bureaux
	{
		$asso_gerante = Entite::existe(session('entite_id'));

		if (isset($request["type"])) {

			if ($request["type"] == EntiteTypeEnum::Bureau->value) { //seule l'AIR peut gérer les bureaux
				$entites_dependantes = $asso_gerante->bureaux();
			} else if ($request["type"] == EntiteTypeEnum::Comite->value) {
				$entites_dependantes = $asso_gerante->comites_clubs_dependants();
			} else if ($request["type"] == EntiteTypeEnum::Liste->value) {
				$entites_dependantes = $asso_gerante->listes_dependantes();
			}

			$entites_dependantes = $entites_dependantes->orderBy('nom', 'asc')->get();
		} else {
			$entites_dependantes = [];
		}

		return view('entite.index_admin')->with('est_bureau', $asso_gerante->type == EntiteTypeEnum::Bureau)->with('entites_dependantes', $entites_dependantes);
	}

	public function campagnes(Request $request) // réservé aux bureaux
	{
		$bureaux = Entite::bureaux_site('douai')->get();
		$listes = array();
		foreach ($bureaux as $bureau) {
			$bureau_ratachement = $bureau->ratachement->value;
			$listes[$bureau_ratachement] = $bureau->listes_dependantes('2025')->get();
		}

		return view(
			'entite.campagnes',
			[
				"bureaux" => $bureaux,
				"listes" => $listes
			]
		);
	}
}
