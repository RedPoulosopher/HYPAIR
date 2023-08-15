<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use \App\Models\Evenement;
use \App\Models\Entite;
use \App\Models\Membre;
use App\Models\Site;
use \App\Services\AutorisationGestion;
use DateTime;
use DateTimeZone;

class EvenementController extends Controller
{
	public function create()
	{
		AutorisationGestion::protectionPage("gerer_evenement");
		$niveau_administration = AutorisationGestion::niveau_administration();

		$evenements_existants = Evenement::select('id', 'titre')
			->where('entite_id', session('entite_id'))
			->where("confidentialite", "<=", $niveau_administration)
			->get();

		$sites = Site::all();

		return view('evenements.formulaire', [
			'titre' => 'Créer un évènement',
			'evenements_existants' => $evenements_existants,
			'campus' => $sites
		]);
	}


	public function store(Request $request)
	{
		AutorisationGestion::protectionPage("gerer_evenement");
		// if ($request['confidentialite'] != 0) {
		// 	$request['validation'] = 1;
		// } else {
		// 	$request['validation'] = 0;
		// }

		$eventRequest = $this->formulaire_traitement($request);
		$event = Evenement::create($eventRequest);

		foreach ($request->campus_id as $id) {
			$event->campus()->attach($id);
		}

		return redirect(session('entite_uid') . "/entite/evenement");
	}



	public function edit($entite_uid, $event_id)
	{
		AutorisationGestion::protectionPage("gerer_evenement");
		$niveau_administration = AutorisationGestion::niveau_administration();

		$evenement = Evenement::find($event_id);
		if (!$evenement->exists()) {
			abort(404);
		}

		$sites = Site::all();

		// $evenement = $evenement->first();
		// if ($evenement["confidentialite"] > $niveau_administration) {
		// 	abort(403);
		// }

		// $docs_existantes = Evenement::select('id', 'titre')->where('entite_id', session('entite_id'))->get();
		return view('evenements.formulaire', [
			// 'documentation' => $evenement,
			// 'docs_existantes' => $docs_existantes,
			'event' => $evenement,
			'titre' => "Modifier l'évènement",
			'campus' => $sites
		]);
	}


	public function update(Request $request, $entite_uid, $event_id)
	{
		AutorisationGestion::protectionPage("gerer_evenement");

		$traitement = $this->formulaire_traitement($request);
		Evenement::find($event_id)->update($traitement);

		return redirect(session('entite_uid') . "/entite/evenement");
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

		// if ($niveau_administration == 20) {
		// 	$confidentialite = 4;
		// } elseif ($niveau_administration <= 18 && $niveau_administration >= 17) {
		// 	$confidentialite = 3;
		// } elseif ($niveau_administration == 13) {
		// 	$confidentialite = 2;
		// } elseif ($niveau_administration == 8) {
		// 	$confidentialite = 1;
		// } else {
		// 	$confidentialite = 0;
		// }



		$tables = Evenement::where('entite_id', session('entite_id'))->get();

		// $tables_attente_validation = DB::table(DB::raw('evenements', 'entites'))
		// 	->join('entites', 'entites.id', '=', 'evenements.entite_id')
		// 	->select('entites.uid', 'entites.nom', 'evenements.id', 'evenements.entite_id', 'evenements.titre', 'evenements.description', 'evenements.temps_debut', 'evenements.temps_fin', 'evenements.lieu', 'evenements.validation', 'slug')
		// 	->where('validation', 0)
		// 	->get();

		// $array = json_decode(json_encode($tables_attente_validation), true);

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
			// 'tables_attente_validation' => $array,
			'entite' => session('entite_uid'),
			'entite_user' => $entite_user,
			'gerer_evenement' => AutorisationGestion::gestion("gerer_evenement")
		]);
	}



	public static function suppression($id, $event_id)
	{
		AutorisationGestion::protectionPage("gerer_evenement");

		$evenement = Evenement::find($event_id)->delete();

		return redirect(session('entite_uid') . "/entite/evenement");
	}

	// public static function validation(Request $request)
	// {
	// 	AutorisationGestion::protectionPage("gerer_evenement");

	// 	// $resultat = ["id" => $request->id,];
	// 	$evenement = Evenement::where('id', '=', $request["id"])->get();
	// 	$evenement[0]->update(['validation' => 1]);

	// 	return redirect(session('entite_uid') . "/entite/evenement");
	// }

	public function formulaire_traitement(Request $request)
	{
		//vérifie que les valeurs qu'on obtient correspondent à ce qu'on attend
		$validated = $request->validate(
			[
				'titre' => 'required|max:128',
				'description' => 'required|min:30|max:250',
				'temps_debut' => 'required',
				'temps_fin' => 'required',
				'lieu' => 'nullable|max:128',
				'date_apparition' => 'nullable',
				'max_participation' => 'nullable|max:250',
				'pour_cotisant' => 'required'
			]
			// il faut que le slug soit unique
		);

		//formate les résultats pour leur entrée dans la table
		$eventRequest = [
			'entite_id' => session("entite_id"),
			"titre" => $request->titre,
			"description" => $request->description,
			"slug" => Str::slug($request->titre, '-'),
			'temps_debut' => $request->temps_debut,
			'temps_fin' => $request->temps_fin,
			'lieu' => $request->lieu,
			'max_participation' => $request->max_participation,
			"validation" => "1",
			'pour_cotisant' => $request->pour_cotisant,
			'date_apparition' => $request->date_apparition ? $request->date_apparition : new DateTime('now', new DateTimeZone('Europe/Paris')),
		];

		return $eventRequest;
	}
}
