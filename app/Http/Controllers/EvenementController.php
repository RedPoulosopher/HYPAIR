<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use \App\Http\Models\Evenement;
use \App\Http\Services\AutorisationGestion;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class EvenementController extends Controller
{	
	public function formulaire_evenement(Request $request)
	{
		$request->categories = array_map('strtolower',array_map('trim',explode(",",$request->categories)));
		sort($request->categories);

		//vérifie que les valeurs qu'on obtient correspondent à ce qu'on attend
		$validation = [
            'titre'=> ['filled','max:128'],
            'description'=> ['filled','max:250'],
            'temps_debut' =>['filled', 'date_format:Y-m-d'],
            'temps_fin' => ['filled','date_format:Y-m-d'],
            'lieu' => ['nullable','max:128'],
            'max_participation' => ['nullable','max:250'],
            'confidentialite' => ['filled'],
            'pour_cotisant' => ['filled'],
            'important' => ['filled'],
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
		];

		return $resultat;
	}
}
