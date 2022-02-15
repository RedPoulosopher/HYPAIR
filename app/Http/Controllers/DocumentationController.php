<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use \App\Models\Documentation;
use \App\Services\AutorisationGestion;

use Illuminate\Support\Facades\Auth;

class DocumentationController extends Controller
{
	public function create()
	{
		AutorisationGestion::protectionPage("gerer_documentation");
		$niveau_administration = AutorisationGestion::niveau_administration();

		$docs_existantes = Documentation::select('id','titre')
			->where('association_id', session('association_id'))
			->where("confidentialite", "<=", $niveau_administration)
			->get();
		
		return view('documentation.creation', [
			'titre' => 'Nouvelle documentation',
			'docs_existantes' => $docs_existantes,
		]);
	}


	public function index()
	{
		$niveau_administration = AutorisationGestion::niveau_administration();

		$doc = Documentation::select('titre','contenu_md','categories','slug')
			->where("association_id", session('association_id'))
			->where("confidentialite", "<=", $niveau_administration)
			->get();

		return view('documentation.index', [
			'documentations' => $doc,
			'gerer_documentation' => AutorisationGestion::gestion("gerer_documentation")
		]);
	}


	public function fomulaire_traitement(Request $request)
	{
		$request->categories = array_map('strtolower',array_map('trim',explode(",",$request->categories)));
		sort($request->categories);

		$validation = [
			'confidentialite' => ['filled','numeric'],
			'visibilite' => ['filled','numeric'],
			'titre' => ['filled','max:128'],
			'description' => ['filled','max:250'],
			'contenu_md' => ['filled','max:65000'],
			'categories' => ['filled','distinct'],
			'debut_mise_en_avant' => 'nullable|date_format:Y-m-d',
			'fin_mise_en_avant' => 'nullable|date_format:Y-m-d',
			'langue' => ['filled','max:3']
		];
		$this->validate($request, $validation);

		if($request->has('mise_en_avant')){
			$mise_en_avant=true;
		}else{
			$mise_en_avant=false;
		}

		$resultat = [
			"titre" => $request->titre,
			"slug" => Str::slug($request->titre, '-'),
			"confidentialite" => $request->confidentialite,
			"visibilite" => $request->visibilite,
			"derive_de" => $request->derive_de,
			'langue' => $request->langue,
			"description" => $request->description,
			"contenu_md" => $request->contenu_md,
			"categories" => json_encode($request->categories),
			"mise_en_avant" => $mise_en_avant,
			"debut_mise_en_avant" => strlen($request->debut_mise_en_avant) ? $request->debut_mise_en_avant : null,
			"fin_mise_en_avant" => strlen($request->fin_mise_en_avant) ? $request->fin_mise_en_avant : null,
		];
		
		$resultat['association_id'] = session("association_id");

		return $resultat;
	}


	public function store(Request $request)
	{
		AutorisationGestion::protectionPage("gerer_documentation");

		$traitement = $this->fomulaire_traitement($request);
		Documentation::create($traitement);

		return redirect("/documentation/" . $traitement["slug"]);
	}


	public function show(Request $request)
	{
		$niveau_administration = AutorisationGestion::niveau_administration();

		$doc = Documentation::where('slug', $request->route('slug'))
			->where('association_id', session('association_id'));
		
		if(!$doc->exists()){
			abort(404);
		}
		$doc = $doc->first();
		if(!$doc["confidentialite"] > $niveau_administration){
			abort(403);
		}
		
		return view('documentation.show', [
			'documentation' => $doc,
			'gerer_documentation' => AutorisationGestion::gestion("gerer_documentation")
		]);
	}


	public function edit(Request $request)
	{
		AutorisationGestion::protectionPage("gerer_documentation");
		$niveau_administration = AutorisationGestion::niveau_administration();

		$doc = Documentation::where('id', $request->route('id'));
		if(!$doc->exists()){
			abort(404);
		}
		
		$doc = $doc->first();
		if(!$doc["confidentialite"] > $niveau_administration){
			abort(403);
		}

		$docs_existantes = Documentation::select('id','titre')->where('association_id', session('association_id'))->get();

		return view('documentation.creation', [
			'documentation' => $doc,
			'docs_existantes' => $docs_existantes,
			'titre' => "Modifier la documentation",
		]);
	}


	public function update(Request $request)
	{
		AutorisationGestion::protectionPage("gerer_documentation");

		$traitement = $this->fomulaire_traitement($request);
		Documentation::where('id', $request->route('id'))->update($traitement);

		return redirect("/documentation/" . $traitement["slug"]);
	}


	public function destroy($id)
	{
		AutorisationGestion::protectionPage("gerer_documentation");
		Documentation::where('id', $id)->delete();
	}
}
