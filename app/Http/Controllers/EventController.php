<?php

namespace App\Http\Controllers;

use App\Enums\Permisions;
use App\Models\Entite;
use App\Models\Event;
use App\Models\Site;
use App\Services\AutorisationGestion;
use App\Services\FileService;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

class EventController extends Controller
{


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

	public function show_home(Request $request)
	{
        AutorisationGestion::require(Permisions::EVENT_MANAGE,$request['entite_uid']);

		$evenements = Event::where('entite_uid', $request['entite_uid'])->get();

		/*$user_id = Membre::select('user_id')
			->where('id', session('membre_id'))
			->pluck('user_id')
			->first();*/

		/*$users = Entite::join('membres', 'membres.entite_id', '=', 'entites.id')
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
		};*/
		$entite_user = array();

		return view('event.home-evenement', [
			'evenements' => $evenements,
			'entite' => $request['entite_uid'],
			'entite_user' => $entite_user
		]);
	}

	public function create(Request $request)
	{
        AutorisationGestion::require(Permisions::EVENT_MANAGE,$request['entite_uid']);

		$evenements_existants = Event::select('uid', 'title')->where('entite_uid', $request['entite_uid'])->get();

		$sites = Site::all();

		$entite = Entite::existe($request['entite_uid']);
		$entites = Entite::where('uid','!=',$request['entite_uid'])->get();//On récupére toutes les assos sauf celles dont on crée le post


		return view('event.formulaire', [
			'evenements_existants' => $evenements_existants,
			'sites' => $sites,
			'my_entite' => $entite,
			'entites' => $entites
		]);
	}

    public function store(Request $request)
	{
        AutorisationGestion::require(Permisions::EVENT_MANAGE,$request['entite_uid']);
		$eventRequest = $this->formulaire_traitement($request,$request['entite_uid']);
        if($request['event_uid']){
            $event = Event::findOrFail($request['event_uid']);
            $event->update($eventRequest);
        }else{
            $event = Event::create($eventRequest);
        }
	
		if($request->has('banniere')){
			FileService::validation_img($request->banniere);
			$event->banner_uid = FileService::upload($request->banniere,"logo_entites","public",["acces"=>'public']);
		}

        $json_data = ["acces"=>"certifie","acces_details"=> ["cards"=> [],"groups"=> [],"users"=> [],"membres"=> [],"sites"=> []]];
        
        if (!empty($request->campus_id)) {
            foreach ($request->campus_id as $id) {
                array_push($json_data["acces_details"]["sites"],["id"=>$id,"notify"=>true]);
            }
        }
        $event->json_data = $json_data;
        $event->save();

        $event->refresh();
        //Detach previous collabs
        $event->entite_collab()->detach();
        //Attach new ones
        if (!empty($request->entite_collab_id)) {
            $event->entite_collab()->syncWithoutDetaching($request->entite_collab_id);
        }

		//Detach previous campus
        $event->sites()->detach();
        //Attach new ones
        if (!empty($request->campus_id)) {
            $event->sites()->syncWithoutDetaching($request->campus_id);
        }
        
        return redirect('entite/' . $request['entite_uid'] . '/dashboard/event');
	}



    public function formulaire_traitement(Request $request,$entite_uid){
        if($request['event_uid']){
            $event = Event::findOrFail($request['event_uid']);
            if($event->entite->uid != $entite_uid && !in_array($entite_uid, $event->entite_collab()->pluck("uid"))){
                abort(403);
            }
		}

		$validated = $request->validate(
			[
				'title' => 'required|max:128',
				'description_md' => 'nullable|max:2500',
				'lieu' => 'nullable|max:255',
				'started_at' => 'required|date',
				'ended_at' => 'required|date|after:started_at',
				'published_at' => 'nullable|date',
				'validation_status' => 'required',
				'max_participants' => 'nullable',
				'visibility_all' => 'required',
				'sub_registrations' => 'required',
				'tags' => 'nullable',
				'entite_collab_id' => 'nullable',
			]
		);

        $eventRequest = [
            "entite_uid" => $entite_uid,
            "title" => $request->title,
            "description" => $request->description_md ? $request->description_md : "",
			"lieu" => $request->lieu ? $request->lieu : "",
            "published_at" => $request->published_at ? $request->published_at : (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d\TH:i'),
            "started_at" => $request->started_at,
            "ended_at" => $request->ended_at,
			"validation_status" => $request->validation_status,
			"max_participants" => $request->max_participants,
			"visibility_all" => $request->visibility_all,
			"sub_registrations" => $request->sub_registrations,
            "tags" => $request->tags ? $request->tags : "",
			
        ];

        return $eventRequest;


    }



	public function edit($entite_uid, $event_uid){
        AutorisationGestion::require(Permisions::EVENT_MANAGE,$entite_uid);
		$event = Event::findOrFail($event_uid);
		$entite = Entite::findOrFail($entite_uid);
		if($event->entite->uid != $entite_uid && !in_array($entite_uid, $event->entite_collab()->pluck("uid"))){
			abort(403);
		}
		$evenements_existants = Event::select('uid', 'title')->where('entite_uid', $entite_uid)->get();
		$sites = Site::all();
		$entites = Entite::where('uid','!=',$entite_uid)->get();//On récupére toutes les assos sauf celles dont on crée le post


		return view('event.formulaire', [
			'event' => $event,
			'evenements_existants' => $evenements_existants,
			'sites' => $sites,
			'my_entite' => $entite,
			'entites' => $entites
		]);
		
	}

	public static function delete($entite_uid,$event_uid)
	{
        AutorisationGestion::require(Permisions::EVENT_MANAGE,$entite_uid);
		$event = Event::findOrFail($event_uid);
		$event->delete();

        return redirect()->back();
	}
}



/*

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use \App\Models\Evenement;
use \App\Models\Entite;
use \App\Models\Membre;
use \App\Models\Site;
use \App\Services\AutorisationGestion;
use DateTime;
use DateTimeZone;

class EvenementController extends Controller
{

	public function store(Request $request)
	{
		AutorisationGestion::protectionPage("gerer_evenement");
		$eventRequest = $this->formulaire_traitement($request);
		$event = Evenement::create($eventRequest);

		//Add 'id' to the slug to make it unique
		$event->slug = $event->id . '-' . $event->slug ;
		$event->save();

		// Peut-être besoin de gérer le cas où aucun campus n'est entré
		if (!empty($request->campus_id)) {
			foreach ($request->campus_id as $id) {
				$event->campus()->attach($id);
			}
		}

		return redirect(session('entite_uid') . "/entite/evenement");
	}




	public function update(Request $request, $entite_uid, $event_id)
	{
		AutorisationGestion::protectionPage("gerer_evenement");

		$traitement = $this->formulaire_traitement($request);
		$event = Evenement::find($event_id);
		$event->update($traitement);

		//Add 'id' to the slug to make it unique
		$event->slug =  $event_id . '-' . $event->slug;
		$event->save();

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
				'description_md' => 'required|min:30|max:500',
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
			"description" => $request->description_md,
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
                ->where('temps_fin', '>=', $now)
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
*/