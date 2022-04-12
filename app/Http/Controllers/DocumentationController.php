<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use \App\Models\Documentation;
use \App\Services\AutorisationGestion;
use Carbon\Carbon;
use DateTimeZone;

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
		$doc = $this->fomulaire_traitement($request);

		$existe = Documentation::existe_slug($doc->slug, $doc->entite_id)->first();
		if($existe){ return back()->withErrors(["Cette documentation existe déjà pour votre entite."]); }

		$doc->save();

		return redirect()->route('documentation_afficher', ['entite_uid' => $request->route('entite_uid'), 'slug' => $doc->slug]);
	}


	public function index()
	{
		$niveau_administration = AutorisationGestion::niveau_administration();

		$docs = Documentation::index($niveau_administration)->get();

		return view('documentation.index', [
			'documentations' => $docs,
			'gerer_documentation' => AutorisationGestion::gestion("gerer_documentation")
		]);
	}


	public function show(Request $request)
	{
		$niveau_administration = AutorisationGestion::niveau_administration();

		$doc = Documentation::existe_slug($request->route('slug'), session('entite_id'));

		if(!$doc){abort(404);}

		$doc = $doc->first();
		if($doc->confidentialite > $niveau_administration){abort(403);}
		
		Carbon::setLocale('fr');
		$date = $doc->updated_at->setTimezone(new DateTimeZone("EUROPE/PARIS"))->diffForHumans();
		
		return view('documentation.show', [
			'documentation' => $doc,
			'date' => $date,
			'gerer_documentation' => AutorisationGestion::gestion("gerer_documentation")
		]);
	}


	public function edit(Request $request)
	{
		$niveau_administration = AutorisationGestion::niveau_administration();

		$doc = Documentation::existe($request->route('documentation_id'));
		if(!$doc){abort(404);}
		
		$doc = $doc->first();
		if($doc->confidentialite > $niveau_administration){abort(403);}

		$confidentialites = config('roles');
		
		return view('documentation.creation')
				->with('documentation', $doc)
				->with('titre','Modifier la  documentation')
				->with('confidentialites',$confidentialites);
	}


	public function update(Request $request)
	{
		$doc = $this->fomulaire_traitement($request, true);
		$doc->save();

		return redirect()->route('documentation_afficher', ['entite_uid' => $request->route('entite_uid'), 'slug' => $doc->slug]);
	}


	public function fomulaire_traitement(Request $request, $update=false)
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

		if($update){
			$doc = Documentation::existe($request->route('documentation_id'));
		} else {
			$doc = new Documentation;
		}

		$doc->entite_id = session("entite_id");
		$doc->titre = $request->titre;
		$doc->slug = Str::slug($request->titre, '-');
		$doc->confidentialite = $request->confidentialite;
		$doc->visibilite = $request->visibilite;
		$doc->description = $request->description;
		$doc->contenu_md = $request->contenu_md;
		$doc->categories = json_encode($request->categories);
		$doc->mise_en_avant = $request->has('mise_en_avant');
		$doc->debut_mise_en_avant = strlen($request->debut_mise_en_avant) ? $request->debut_mise_en_avant : null;
		$doc->fin_mise_en_avant = strlen($request->fin_mise_en_avant) ? $request->fin_mise_en_avant : null;

		return $doc;
	}
}
