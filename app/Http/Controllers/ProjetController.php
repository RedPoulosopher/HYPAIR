<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Association;
use \App\Models\User;
use \App\Models\Membre;
use \App\Models\Projet;
use \App\Models\Avancee;

use Illuminate\Support\Str;
use \App\Services\AutorisationGestion;
use Illuminate\Validation\Rule;

class ProjetController extends Controller
{
    public function create(){ //réservé à l'AIR
		AutorisationGestion::protectionPage("gerer_projet");
		return view('projet.creation');
	}

	public function store(Request $request)
	{
		AutorisationGestion::protectionPage("gerer_projet");

		$traitement = $this->fomulaire_projet($request);
		Projet::create($traitement);

		return redirect("/projet/" . $traitement["titre"]);
	}

	public function fomulaire_projet(Request $request){
		$validation = [
			'titre' => ['filled','max:120'],
			'confidentialite' => ['filled','numeric','max:20'],
			"description_courte"=>['filled','max:1000'],
			'date_fin' => ['filled','date_format:Y-m-d'],
			'chef_projet' => ['filled','numeric'] 
		];

		$this->validate($request, $validation);

		$resultat =[
			"titre" => $request->titre,
			"slug" => Str::slug($request->titre, '-'),
			'association_id' => session('association_id'),
			"confidentialite" => $request->confidentialite,
			"chef_projet" => $request->chef_projet,
			"description_courte"=> $request->description_courte,
			"creadted_at"=> $request->created_at,
			"date_fin"=> $request->date_fin,
		];

		return $resultat;
	}

	public function index(){
		AutorisationGestion::protectionPage("gerer_projet");
		$projet = Projet::select('id','titre','association_id','description_courte','chef_projet','created_at')
		->orderBy('created_at')
		->get();
		return view('projet.index',[
			'projets' => $projet,
			'gerer_projet' => AutorisationGestion::gestion("gerer_projet")
		]);
	}

	public function index_projet_json(Request $request){
		AutorisationGestion::protectionPage("gerer_projet");

		$projet = Projet::select('id','asssociation_id','titre','description_courte','chef_projet','created_at');

		if($request["titre"] == "titre"){
			$projet->where('titre')
					->like('*titre*')->orderBy('titre','asc');

		return Response()->json($projet->get()->toArray());
	}
	}
	public function show(Request $request)
	{
		$projet = Projet::where('titre', $request->route('titre'))
			->where('uid', session('association_id'));
		if(!$projet->exists()){
			abort(404);
		}
		$projet = $projet->first();
		return view('projet.show', [
			'projet' => $projet,
			'gerer_projet' => AutorisationGestion::gestion("gerer_projet")
		]);
	}
}