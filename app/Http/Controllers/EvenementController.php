<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use \App\Models\Evenement;
use \App\Models\Entite;
use \App\Models\Membre;
use \App\Services\AutorisationGestion;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class EvenementController extends Controller
{
	public function accueil()
	{
		$events = Evenement::all();
		return view('accueil')->with('events', $events);
	}
	public function create()
	{
		AutorisationGestion::protectionPage("gerer_evenement");
		$niveau_administration = AutorisationGestion::niveau_administration();

		$evenements_existants = Evenement::select('id', 'titre')
			->where('entite_id', session('entite_id'))
			->where("confidentialite", "<=", $niveau_administration)
			->get();

		return view('evenements.formulaire', [
			'titre' => 'Nouvel évènement',
			'evenements_existants' => $evenements_existants,
		]);
	}


	public function store(Request $request)
	{

		AutorisationGestion::protectionPage("gerer_evenement");

		if ($request['confidentialite'] != 0) {
			$request['validation'] = 1;
		} else {
			$request['validation'] = 0;
		}

		$traitement = $this->formulaire_traitement($request);
		Evenement::create($traitement);

		return redirect(session('entite_uid') . "/entite/evenement");
	}



	public function edit(Request $request)
	{
		AutorisationGestion::protectionPage("gerer_evenement");
		$niveau_administration = AutorisationGestion::niveau_administration();

		$evenement = Evenement::where('id', $request->route('id'));
		if (!$evenement->exists()) {
			abort(404);
		}

		$evenement = $evenement->first();
		if ($evenement["confidentialite"] > $niveau_administration) {
			abort(403);
		}

		$docs_existantes = Evenement::select('id', 'titre')->where('entite_id', session('entite_id'))->get();

		return view('evenements.formulaire', [
			'documentation' => $evenement,
			'docs_existantes' => $docs_existantes,
			'titre' => "Modifier l'évènement",
		]);
	}


	public function update(Request $request)
	{
		AutorisationGestion::protectionPage("gerer_evenement");

		$traitement = $this->formulaire_traitement($request);
		Evenement::where('id', $request->route('id'))->update($traitement);

		return redirect("/evenement/" . $traitement["slug"]);
	}


	public function show(Request $request)
	{
		$niveau_administration = AutorisationGestion::niveau_administration();

		$evenement = Evenement::where('slug', $request->route('slug'))
			->where('entite_id', session('entite_id'));

		if (!$evenement->exists()) {
			abort(404);
		}
		$evenement = $evenement->first();
		if ($evenement["confidentialite"] > $niveau_administration) {
			abort(403);
		}

		return view('evenements.show-evenement', [
			'evenement' => $evenement,
			'entite_uid' => session('entite_uid'),
			'gerer_evenement' => AutorisationGestion::gestion("gerer_evenement")
		]);
	}


	public function show_home()
	{
		$niveau_administration = AutorisationGestion::niveau_administration();

		if ($niveau_administration == 20) {
			$confidentialite = 4;
		} elseif ($niveau_administration <= 18 && $niveau_administration >= 17) {
			$confidentialite = 3;
		} elseif ($niveau_administration == 13) {
			$confidentialite = 2;
		} elseif ($niveau_administration == 8) {
			$confidentialite = 1;
		} else {
			$confidentialite = 0;
		}



		$tables = Evenement::select('id', 'entite_id', 'titre', 'description', 'confidentialite', 'temps_debut', 'temps_fin', 'lieu', 'max_participation', 'pour_cotisant', 'validation', 'slug')
			->where([
				['confidentialite', '<=', $confidentialite],
				['entite_id', '=', session('entite_id')]
			])
			->get();

		$tables_attente_validation = DB::table(DB::raw('evenements', 'entites'))
			->join('entites', 'entites.id', '=', 'evenements.entite_id')
			->select('entites.uid', 'entites.nom', 'evenements.id', 'evenements.entite_id', 'evenements.titre', 'evenements.description', 'evenements.temps_debut', 'evenements.temps_fin', 'evenements.lieu', 'evenements.validation', 'slug')
			->where('validation', 0)
			->get();

		$array = json_decode(json_encode($tables_attente_validation), true);

		$user_id = Membre::select('user_id')
			->where('id', session('membre_id'))
			->pluck('user_id')
			->first();

		$users = Entite::join('membres', 'membres.entite_id', '=', 'entites.id')
			->join('users', 'users.id', '=', 'membres.user_id')
			->get('users.id')->pluck('id');

		//$entite->membres;

		$entites = Entite::join('membres', 'membres.entite_id', '=', 'entites.id')
			->join('users', 'users.id', '=', 'membres.user_id')
			->get('entites.id')->pluck('id');

		$entite_user = array();
		for ($i = 0; $i < count($entites); $i++) {
			if ($users[$i] == $user_id) {
				$entite_user[] = $entites[$i];
			}
		};

		return view('evenements.home-evenement', [
			'tables' => $tables,
			'tables_attente_validation' => $array,
			'entite' => session('entite_uid'),
			'entite_user' => $entite_user,
			'gerer_evenement' => AutorisationGestion::gestion("gerer_evenement")
		]);
	}



	public static function suppression(Request $request)
	{
		AutorisationGestion::protectionPage("gerer_evenement");

		$resultat = ["id" => $request->id,];
		$evenement = Evenement::find($request["id"])->delete();

		return redirect(session('entite_uid') . "/entite/evenement");
	}

	public static function validation(Request $request)
	{
		AutorisationGestion::protectionPage("gerer_evenement");

		$resultat = ["id" => $request->id,];
		$evenement = Evenement::where('id', '=', $request["id"])->get();
		$evenement[0]->update(['validation' => 1]);

		return redirect(session('entite_uid') . "/entite/evenement");
	}

	public function formulaire_traitement(Request $request)
	{
		$request->categories = array_map('strtolower', array_map('trim', explode(",", $request->categories)));
		sort($request->categories);

		//vérifie que les valeurs qu'on obtient correspondent à ce qu'on attend
		$validation = [
			'titre' => ['filled', 'max:128'],
			'description' => ['filled', 'min:30', 'max:250'],
			'temps_debut' => ['filled'],
			'temps_fin' => ['filled'],
			'lieu' => ['nullable', 'max:128'],
			'max_participation' => ['nullable', 'max:250'],
			'confidentialite' => ['filled'],
			'pour_cotisant' => ['filled']
		];
		$this->validate($request, $validation);



		//formate les résultats pour leur entrée dans la table
		$resultat = [
			'entite_id' => session("entite_id"),
			"titre" => $request->titre,
			"description" => $request->description,
			"slug" => Str::slug($request->titre, '-'),
			'temps_debut' => $request->temps_debut,
			'temps_fin' => $request->temps_fin,
			'lieu' => $request->lieu,
			'max_participation' => $request->max_participation,
			"confidentialite" => $request->confidentialite,
			"validation" => $request->validation,
			'pour_cotisant' => $request->pour_cotisant,
			"derive_de" => $request->derive_de,
		];

		return $resultat;
	}
}
