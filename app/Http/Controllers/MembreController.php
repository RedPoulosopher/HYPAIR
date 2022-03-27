<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Association;
use \App\Models\User;
use \App\Models\Membre;
use \App\Models\Role;

use \App\Services\AutorisationGestion;
use Illuminate\Validation\Rule;

class MembreController extends Controller
{
    public function passation(Request $request){
		AutorisationGestion::protectionPage("gerer_association");

		$asso = Association::existe($request->route('asso_id'));

		return view('association.passation', [
			'association' => $asso,
			'creation' => $request->query('creation', 0),
		]);
    }

    public function passation_store(Request $request){
		//on vérifie que l'asso existe
		$asso = Association::existe($request->route('asso_id'));
		
		$role_id_president = Role::role_id("président·e");
		$user_id = User::existe($request["uid_president"]);
		if(!$user_id){
			return back()->withErrors(["msg"=>"L'uid du président ne correspond à aucun utilisateur."]);
		}

		Membre::updateOrCreate(
			['association_id' => $request->route('asso_id'), 'user_id' => $user_id,],
			['role_id' => $role_id_president,]
		);
		
		return redirect($asso->url());
    }
}
