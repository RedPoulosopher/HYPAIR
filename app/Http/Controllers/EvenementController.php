<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use \App\Models\Evenement;
use \App\Services\AutorisationGestion;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class EvenementController extends Controller
{	
	public function create()
	{
		AutorisationGestion::protectionPage("gerer_evenement");
		$niveau_administration = AutorisationGestion::niveau_administration();

		$evenements_existants = Evenement::select('id','titre')
			->where('association_id', session('association_id'))
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

		$traitement = $this->formulaire_traitement($request);
		Evenement::create($traitement);

		return redirect("/evenement");
	}


	public function edit(Request $request)
	{
		AutorisationGestion::protectionPage("gerer_evenement");
		$niveau_administration = AutorisationGestion::niveau_administration();

		$evenement = Evenement::where('id', $request->route('id'));
		if(!$evenement->exists()){
			abort(404);
		}
		
		$evenement = $evenement->first();
		if($evenement["confidentialite"] > $niveau_administration){
			abort(403);
		}

		$docs_existantes = Evenement::select('id','titre')->where('association_id', session('association_id'))->get();

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
			->where('association_id', session('association_id'));
		
		if(!$evenement->exists()){
			abort(404);
		}
		$evenement = $evenement->first();
		if($evenement["confidentialite"] > $niveau_administration){
			abort(403);
		}
		
		return view('evenements.show-evenement', [
			'evenement' => $evenement,
			'gerer_evenement' => AutorisationGestion::gestion("gerer_evenement")
		]);
	}
	

	public function show_home(Request $request)
	{
		$niveau_administration = AutorisationGestion::niveau_administration();

		$tables = Evenement::select('titre', 'description', 'temps_debut', 'temps_fin', 'lieu', 'max_participation', 'pour_cotisant', 'validation')
			->get();
		
		return view('evenements.home-evenement', [			
			'tables' => $tables,
			'gerer_evenement' => AutorisationGestion::gestion("gerer_evenement")
		]);
	}


	public function formulaire_traitement(Request $request)
	{
		$request->categories = array_map('strtolower',array_map('trim',explode(",",$request->categories)));
		sort($request->categories);

		//vérifie que les valeurs qu'on obtient correspondent à ce qu'on attend
		$validation = [
            'titre'=> ['filled','max:128'],
            'description'=> ['filled','min:30','max:250'],
            'temps_debut' =>['filled'],
            'temps_fin' => ['filled'],
            'lieu' => ['nullable','max:128'],
            'max_participation' => ['nullable','max:250'],
            'confidentialite' => ['filled'],
            'pour_cotisant' => ['filled'],
            'important' => ['filled'],
            'validation' => ['filled'],
		];
		$this->validate($request, $validation);


        
		//formate les résultats pour leur entrée dans la table
		$resultat = [
			'association_id' => session("association_id"),
			"titre" => $request->titre,
			"description" => $request->description,
			"slug" => Str::slug($request->titre, '-'),            
            'temps_debut' => $request->temps_debut,
            'temps_fin' => $request->temps_fin,
            'lieu' => $request->lieu,
            'max_participation' => $request->visibilite,
			"confidentialite" => $request->confidentialite,
            'pour_cotisant' => $request->pour_cotisant,
            'important' => $request->important,
            'validation' => $request->validation,
			"derive_de" => $request->derive_de,
		];

		return $resultat;
	}
}
