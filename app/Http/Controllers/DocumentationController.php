<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use \App\Models\Documentation;
use \App\Services\AutorisationGestion;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class DocumentationController extends Controller
{
	public function create()
	{
		$niveau_administration = AutorisationGestion::niveau_administration();

		$confidentialites = config('roles');
		
		return view('documentation.creation')->with('titre','Nouvelle documentation')->with('confidentialites',$confidentialites);
	}


	public function store(Request $request)
	{
		$traitement = $this->fomulaire_traitement($request);

		$doc = Documentation::where('slug', $traitement["slug"])->where('entite_id', $traitement['entite_id']);
		if($doc->exists()){
			return back()->withErrors(["msg","Cette documentation existe déjà pour votre entite."]);
		}

		Documentation::create($traitement);

		return redirect()->route('documentation_afficher', ['entite_uid' => $request->route('entite_uid'), 'slug' => $traitement["slug"]]);
	}


	public function index()
	{
		$niveau_administration = AutorisationGestion::niveau_administration();

		$doc = Documentation::select('id', 'titre',DB::raw('SUBSTR(contenu_md, 1, 300) as contenu_md'),'description','categories','slug','confidentialite','visibilite')
			->where("entite_id", session('entite_id'))
			->where("confidentialite", "<=", $niveau_administration)
			->orderBy('confidentialite', 'desc')
			->get();

		return view('documentation.index', [
			'documentations' => $doc,
			'gerer_documentation' => AutorisationGestion::gestion("gerer_documentation")
		]);
	}


	public function show(Request $request)
	{
		$niveau_administration = AutorisationGestion::niveau_administration();

		$doc = Documentation::where('slug', $request->route('slug'))
			->where('entite_id', session('entite_id'));
		
		if(!$doc->exists()){
			abort(404);
		}
		$doc = $doc->first();
		if($doc["confidentialite"] > $niveau_administration){
			abort(403);
		}
		
		Carbon::setLocale('fr');
		$date = $documentation->updated_at->setTimezone(new DateTimeZone("EUROPE/PARIS"))->diffForHumans();
		
		return view('documentation.show', [
			'documentation' => $doc,
			'date' => $date,
			'gerer_documentation' => AutorisationGestion::gestion("gerer_documentation")
		]);
	}


	public function edit(Request $request)
	{
		$niveau_administration = AutorisationGestion::niveau_administration();

		$doc = Documentation::where('id', $request->route('id'));
		if(!$doc->exists()){
			abort(404);
		}
		
		$doc = $doc->first();
		if($doc["confidentialite"] > $niveau_administration){
			abort(403);
		}

		$docs_existantes = Documentation::select('id','titre')->where('entite_id', session('entite_id'))->get();

		return view('documentation.creation', [
			'documentation' => $doc,
			'docs_existantes' => $docs_existantes,
			'titre' => "Modifier la documentation",
		]);
	}


	public function update(Request $request)
	{
		$traitement = $this->fomulaire_traitement($request);
		Documentation::where('id', $request->route('id'))->update($traitement);

		return redirect()->route('documentation_afficher', ['entite_uid' => $request->route('entite_uid'), 'slug' => $traitement["slug"]]);
	}


	public function fomulaire_traitement(Request $request)
	{
		$request->categories = array_map('strtolower',array_map('trim',explode(",",$request->categories)));
		sort($request->categories);

		//vérifie que les valeurs qu'on obtient correspondent à ce qu'on attend
		$validation = [
			'confidentialite' => ['filled','numeric'],
			'visibilite' => ['filled','numeric'],
			'titre' => ['filled','max:128'],
			'description' => ['filled','max:250'],
			'contenu_md' => ['filled','max:65000'],
			'categories' => ['filled','distinct'],
			'debut_mise_en_avant' => ['nullable','date_format:Y-m-d'],
			'fin_mise_en_avant' => ['nullable','date_format:Y-m-d'],
		];
		$this->validate($request, $validation);

		$doc = new Documentation;
		$doc->entite_id = session("entite_id");
		$doc->titre = $request->titre;
		$doc->slug = $request->Str::slug($request->titre, '-');
		$doc->confidentialite = $request->confidentialite;
		$doc->visibilite = $request->visibilite;
		$doc->description = $request->description;
		$doc->contenu_md = $request->contenu_md;
		$doc->categories = json_encode($request->categories);
		$doc->mise_en_avant = $request->has('mise_en_avant');
		$doc->titre = strlen($request->debut_mise_en_avant) ? $request->debut_mise_en_avant : null;
		$doc->titre = strlen($request->fin_mise_en_avant) ? $request->fin_mise_en_avant : null;

		return $doc;
	}
}
