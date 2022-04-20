<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\BureauEnum;
use App\Enums\EntiteTypeEnum;
use \App\Models\Entite;
use \App\Models\Logo;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

use App\Services\GestionPhotoDeProfil;

use Carbon\Carbon;

class EntiteController extends Controller
{
	public function show()
	{
		$entite = Entite::existe(session('entite_id'));
		$reseaux_sociaux = $entite->reseaux_sociaux()->with('liste')->get();

		$mandat = $entite->mandat()->get();
		
		foreach($mandat as &$mandat_user){
			$mandat_user["lien_photo"] = GestionPhotoDeProfil::chemin_membre_photo($mandat_user);
		}

		return view('entite.a_propos')->with('entite', $entite)->with('mandat', $mandat)->with('reseaux_sociaux', $reseaux_sociaux);
	}

	public function gestion(Request $request)
	{
		$entite = Entite::existe(session('entite_id'));

		return view('entite.gestion')
			->with('entite', $entite);
	}

    public function create() //réservé à l'AIR
	{
		return view('entite.creer');
	}

	public function store(Request $request) //réservé à l'AIR
	{
		$this->validate($request, [
			'sites' => ['filled','array',Rule::in(['douai', 'dunkerque', 'lille', 'valenciennes'])],
			'nom' => ['filled','max:120'],
			'uid' => ['filled','max:30'],
			'bureau_de_ratachement' => ['filled', new Enum(BureauEnum::class)],
			'type' => ['filled', new Enum(EntiteTypeEnum::class)],
		]);

		//on se moque d'avoir des doublons d'uid pour les listes
		$entite = Entite::where('uid', $request->uid)->where('type', '!=', EntiteTypeEnum::Liste);
		
		if($entite->exists()){
			$entite = $entite->first();
		}
		else {
			$entite = new Entite;
			$entite->nom = $request->nom;
			$entite->uid = $request->uid;
			$entite->sites = json_encode($request->sites);
			$entite->bureau_de_ratachement = $request->bureau_de_ratachement;
			$entite->type = $request->type;
			$entite->save();
		}

		return redirect()->route('modifier_infos', ['entite_uid' => $request->route('entite_uid'), 'entite_id' => $entite->id, 'creation' => true]);
	}

	public function modifier_infos(Request $request) //réservé à l'AIR
	{
		$entite = Entite::existe($request->route('entite_id'));

		return view('entite.modifier_infos', [
			'entite' => $entite,
			'titre' => "Modifier une entite",
			'creation' => $request->query('creation', 0),
		]);
	}
	
	public function maj_infos(Request $request) //réservé à l'AIR
	{
		$entite = Entite::existe($request->route('entite_id'));

		$request->categories = array_map('strtolower',array_map('trim',explode(",",$request->categories)));
		sort($request->categories);
		$validation = [
			'annee_creation' => ['filled','numeric'],
			'annee_fin' => ['nullable','numeric'],
			'courriel' => ['nullable','max:191','email:rfc'],
			'alias' => ['nullable','max:191','email:rfc'],
		];
		$this->validate($request, $validation);

		$request->has('privee') ? $privee=true : $privee=false;
		$request->has('ouvert') ? $ouvert=true : $ouvert=false;

		$entite->privee = $request->has('privee');
		$entite->ouvert = $request->has('ouvert');
		$entite->annee_creation = $request->annee_creation;
		$entite->annee_fin = $request->annee_fin;
		$entite->courriel = $request->courriel;
		$entite->alias = $request->alias;
		$entite->save();

		if($request->query('creation')){
			return redirect()->route('modifier_description', ['entite_uid' => $request->route('entite_uid'), 'entite_id' => $entite->id, 'creation' => true]);
		} else {
			return redirect($entite->url());
		}
	}

	public function modifier_description(Request $request){ //pour l'entité
		$entite_id = $request->route('entite_id') ?? session('entite_id');

		$entite = Entite::existe($entite_id);

		return view('entite.modifier_description')->with('entite', $entite);
	}

	public function maj_description(Request $request){ //pour l'entité
		$entite_id = $request->route('entite_id') ?? session('entite_id');

		$entite = Entite::existe($entite_id);
		
		$request->categories = array_map('strtolower',array_map('trim',explode(",",$request->categories)));
		sort($request->categories);
		
		$this->validate($request, [
			'description_courte' => ['filled','max:300'],
			'description_md' => ['filled','min:300'],
			'categories' => ['filled','distinct'],
		]);

		$entite->description_courte = $request->description_courte;
		$entite->description_md = $request->description_md;
		$entite->categories = json_encode($request->categories);
		$entite->save();

		if($request->query('creation')){
			return redirect()->route('modifier_logotype', ['entite_uid' => $request->route('entite_uid'), 'entite_id' => $entite->id, 'creation' => true]);
		} else {
			return redirect()->route('a_propos', ['entite_uid' => $entite->uid]);
		}
	}

	public function index_site(Request $request) //réservé aux bureaux
	{
		$site = $request["site"];

		$bureaux = Entite::bureaux_site($site)->get();

		$comites_clubs_dependants = array();
		foreach($bureaux as $bureau){
			$bureau_ratachement = $bureau->bureau_de_ratachement->value;
			$comites_clubs_dependants[$bureau_ratachement] = $bureau->comites_clubs_dependants()->get();
		}

		return view('entite.index_site', [
			"bureaux" => $bureaux,
			"comites_clubs_dependants" => $comites_clubs_dependants,
			]
		);
	}

	public function index_bureau() //réservé aux bureaux
	{
		$bureau = Entite::existe(session('entite_id'));

		$comites_clubs_dependants = $bureau->comites_clubs_dependants();

		$listes_dependantes = $bureau->listes_dependantes();

		return view('entite.index_bureau', [
			"bureau" => $bureau,
			"comites_clubs_dependants" => $comites_clubs_dependants->get(),
			"listes_dependantes" => $listes_dependantes->get()
			]
		);
	}

	public function index_admin(Request $request) //réservé à l'AIR
	{
		$asso_gerante = Entite::existe(session('entite_id'));

		if(isset($request["type"])){

			if($request["type"] == EntiteTypeEnum::Bureau->value){ //seule l'AIR peut gérer les bureaux
				$assos = $asso_gerante->bureaux();
			}
			else if($request["type"] == EntiteTypeEnum::Comite->value) {
				$assos = $asso_gerante->comites_clubs_dependants();
			}
			else if($request["type"] == EntiteTypeEnum::Liste->value){
				$assos = $asso_gerante->listes_dependantes();
			}

			$parametres = ["entites" => $assos->orderBy('nom', 'asc')->get()];
		} else {
			$parametres = [];
		}

		return view('entite.index_admin', array_merge($parametres, ['est_bureau' => $asso_gerante->type == EntiteTypeEnum::Bureau]));
	}

}
