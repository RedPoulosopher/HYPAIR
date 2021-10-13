<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use \App\Models\Documentation;

class DocumentationController extends Controller
{

	public function create()
	{
		return view('documentation.creation', ['title' => "Nouvelle documentation"]);
	}


	public function index()
	{
		$doc = Documentation::select('titre','categories','slug')->where("associations_id", request()->get('association_id'))->get();

		return view('documentation.index', ['documentations' => $doc]);
	}

	public function fomulaire_traitement(Request $request, $is_creation){
		$request->categories = explode(",",$request->categories);
		sort($request->categories);

		$validation = [
			'confidentialite' => ['filled','numeric'],
			'titre' => ['filled','max:128'],
			'contenu' => ['filled','max:65000'],
			'categories' => ['filled','distinct'],
			'debut_mise_en_avant' => 'nullable|date_format:Y-m-d',
			'fin_mise_en_avant' => 'nullable|date_format:Y-m-d'
		];
		if($is_creation){
			$validation['langue'] = ['filled','max:3'];
			$validation['ID_asso'] = ['filled','numeric'];//  ,Rule::in(['liste des ID asso'])
		}
		$this->validate($request, $validation);

		if($request->has('mise_en_avant')){
			$mise_en_avant=true;
		}else{
			$mise_en_avant=false;
		}

		$resultat = [
			"confidentialite" => $request->confidentialite,
			"titre" => $request->titre,
			"slug" => Str::slug($request->titre, '-'),
			"contenu" => $request->contenu,
			"categories" => json_encode($request->categories),
			"mise_en_avant" => $mise_en_avant,
			"debut_mise_en_avant" => strlen($request->debut_mise_en_avant) ? $request->debut_mise_en_avant : null,
			"fin_mise_en_avant" => strlen($request->fin_mise_en_avant) ? $request->fin_mise_en_avant : null
		];
		if($is_creation){
			$resultat['langue'] = $request->langue;
			$resultat['associations_id'] = intval($request->associations_id);
		}
		return $resultat;
	}


	public function store(Request $request)
	{
		$traitement = $this->fomulaire_traitement($request, true);
		
		Documentation::create($traitement);

   		return back()->with('success');
	}


	public function show($slug)
	{
		$doc = Documentation::where('slug', $slug);
		if($doc->exists()){
			$doc=$doc->first();
		}else{
			unset($doc);
			$doc = (object) array();
			$doc->titre = "";
			$doc->contenu = "la documentation que vous demandez n'existe pas ou n'existe plus";
		}
		return view('documentation.show', ['documentation' => $doc]);
	}


	public function edit($slug)
	{
		$doc = Documentation::where('slug', $slug);
		if($doc->exists()){
			$doc=$doc->first();
		}else{
			unset($doc);
			$doc = (object) array();
			$doc->titre = "";
			$doc->contenu = "la documentation que vous demandez n'existe pas ou n'existe plus";
		}
		return view('documentation.creation', ['documentation' => $doc, 'title' => "Modifier la documentation"]);
	}


	public function update(Request $request, $slug)
	{
		$traitement = $this->fomulaire_traitement($request, false);

		Documentation::where('slug', $slug)->update($traitement);

		return back()->with('success');
	}


	public function destroy($id)
	{
		Documentation::where('id', $id)->delete();
	}
}
