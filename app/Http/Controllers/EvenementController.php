<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
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

		// Peut-être besoin de gérer le cas où aucun campus n'est entré
		if (!empty($request->campus_id)) {
			foreach ($request->campus_id as $id) {
				$event->campus()->attach($id);
			}
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
		$all_event_campus_id = [];
		foreach ($evenement->campus as $campus) {
			array_push($all_event_campus_id, $campus->id);
		}

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
			'campus' => $sites,
			'all_event_campus_id' => $all_event_campus_id
		]);
	}


	public function update(Request $request, $entite_uid, $event_id)
	{
		AutorisationGestion::protectionPage("gerer_evenement");

		$traitement = $this->formulaire_traitement($request);
		$event = Evenement::find($event_id);
		$event->update($traitement);

		$campus_array = Site::all();
		// Attention : on considère que les id des campus se suivent (pas de trou)
		$campus_nbr = count($campus_array);
		for ($i = 1; $i <= $campus_nbr; $i++) {
			$event->campus()->detach($i);
		}

		if (!empty($request->campus_id)) {
			foreach ($request->campus_id as $id) {
				$event->campus()->attach($id);
			}
		}

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



		$entite = Entite::where('id', $evenement->entite_id);

        if (!$entite->exists()) {
			abort(404);
		}

		$entite = $entite->first();
		if ($entite["confidentialite"] > $niveau_administration) {
			abort(403);
		}

		$canSeeEvent = false;
		if (!$evenement->confidentiel) {
			$canSeeEvent = true;
		}
		else {
			if (Auth::check()) {
				$user = Auth::user();
				$campus = $evenement->campus;
				foreach ($campus as $site)
					if ($user->campus->contains($site)) {
							$canSeeEvent = true;
					}
			}
		}

		
        $now = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s');
        $eventIsVisible = $now > $evenement->date_apparition;

		return view('evenements.show-evenement', [
			'evenement' => $evenement,
			'entite' => $entite,
			'gerer_evenement' => AutorisationGestion::gestion("gerer_evenement"),
			'canSeeEvent' => $canSeeEvent,
			'eventIsVisible' => $eventIsVisible
		]);
	}


	public function show_home()
	{
        AutorisationGestion::protectionPage("gerer_evenement");

		$evenements = Evenement::where('entite_id', session('entite_id'))->get();

		$user_id = Membre::select('user_id')
			->where('id', session('membre_id'))
			->pluck('user_id')
			->first();

		$users = Entite::join('membres', 'membres.entite_id', '=', 'entites.id')
			->join('users', 'users.id', '=', 'membres.user_id')
			->get('users.id')->pluck('id');


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
			'evenements' => $evenements,
			'entite' => session('entite_uid'),
			'entite_user' => $entite_user
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
			"confidentiel" => $request->confidentialite
		];

		return $eventRequest;
	}

	static function comingEvents(){
		if(Auth::check()){
            $now = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d');
			$nowFullDate = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s');
            $dateInSevenDays =  date('Y-m-d', strtotime("+7 day", strtotime($now)));

			$user = Auth::user();
			//Récupère tous les id de campus de l'utilisateur
			$user_site_ids = $user->campus->map(function ($campus) {
				return $campus->id;
			})->toArray();
			
            return Evenement::select('evenements.titre', 'evenements.slug', 'evenements.temps_debut', 'evenements.temps_fin', 'evenements.id', 'entites.nom as entite_nom', 'entites.uid', 'sites_evenements.site_id')
                ->where('temps_debut',  '<', $dateInSevenDays)
                ->where('temps_fin', '>', $now)
				->where('date_apparition', '<', $nowFullDate)
				->whereIn('sites_evenements.site_id', $user_site_ids)//Filtre pour ne garder que les évènements du/des campus de l'utilisateur
				->groupBy('evenements.id')//S'assure qu'il n'y a pas de duplicata
                ->orderBy('temps_debut', 'asc')//Dans l'ordre chronologique	
                ->limit(5)
                ->join('entites', 'entites.id', '=', 'evenements.entite_id')
                ->join('sites_evenements', 'sites_evenements.evenement_id', '=', 'evenements.id')->get();
        }

        return [];
	}
}
