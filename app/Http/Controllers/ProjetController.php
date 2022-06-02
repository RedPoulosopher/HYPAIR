<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Association;
use \App\Models\User;
use \App\Models\Membre;
use \App\Models\Projet;
use \App\Models\Avancee;
namespace App\Http\Controllers;

use Illuminate\Support\Str;
use \App\Services\AutorisationGestion;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use DateTimeZone;

class ProjetController extends Controller
{
    public function create(){ //réservé à l'AIR

		$niveau_administation = AutorisationGestion::protectionPage("gerer_projet");
		$confidentialites = config('roles');

		return view('projet.creation')->with('titre','Nouveau projet')->with('confidentialites',$confidentialites);
	}

	public function store(Request $request)
	{
		$projet = $this->fomulaire_projet($request);

		$existe = Projet::existe_slug($projet->slug, $projet->entite_id)->first();
		if($existe){ return back()->withErrors(["Ce porjet existe déjà pour votre entité."]); }
		
		$projet->save();

		return redirect()->route('projet_afficher',['entite_uid' =>$request->route('entite_uid'), 'slug'=>$projet->slug ]);
	}

	public function fomulaire_projet(Request $request,$update=false){
		$validation = [
			'titre' => ['filled','max:120'],
			'confidentialite' => ['filled','numeric','max:20'],
			'description_courte'=>['filled','max:1000'],
			'date_fin' => ['filled','date_format:Y-m-d'],
			'chef_projet' => ['filled','numeric'] 
		];

		$this->validate($request, $validation);
		
		if($update){
			$projet = Projet::existe($request->route('projet_id'));
		} else{
			$projet = new Projet;
		}
		$projet->titre = $request->titre;
		$projet->slug = Str::slug($request->titre, '-');
		$projet->entite_id = session('entite_id');
		$projet->confidentialite = $request->confidentialite;
		$projet->chef_projet = $request->chef_projet;
		$projet->description_courte = $request->description_courte;
		$projet->creadted_at = $request->created_at;
		$projet->date_fin= $request->date_fin;

		return $projet;
	}

	public function index(){
		$niveau_administration = AutorisationGestion::protectionPage("gerer_projet");
		$projet = Projet::index($niveau_administration)->get();
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
		$niveau_administration = AutorisationGestion::niveau_administration();
		$projet = Projet::existe_slug($request->route('slug'), session('entite_id'));
		if(!$projet){
			abort(404);;;
		}
		$projet = $projet->first();
		return view('projet.show', [
			'projet' => $projet,
			'date' =>$date,
			'gerer_projet' => AutorisationGestion::gestion("gerer_projet")
		]);
	}
	

	public function update(Request $request)
	{
		$projet = $this->formulaire_projet($request,true);
		$projet->save();

		return redirect()->route('projet_afficher',['entite_uid' => $request->route('entite_uid'),'slug'=>$projet->slug]);
	
	}
	/*public function update(Resquet $request)
	{
		$niveau_administration = AutorisationGestion::niveau_administration();
	}*/


	public function edit(Request $request)
	{
		$niveau_administration = AutorisationGestion::niveau_administration();

		$projet = Projet::existe($request->route('projet_id'));
		if(!$projet){abort(404);}
		
		if($projet->confidentialite > $niveau_administration){abort(403);}

		$confidentialites = config('roles');
		
		return view('projet.creation')
				->with('projet', $projet)
				->with('titre','Modifier le  projet')
				->with('confidentialites',$confidentialites);
	}

}