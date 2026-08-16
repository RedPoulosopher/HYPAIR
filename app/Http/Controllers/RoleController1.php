?php

namespace App\Http\Controllers;

use App\Enums\Permission;
use App\Models\Entite;
use App\Models\Pole;
use App\Models\Role;
use App\Models\RoleList;
use App\Models\User;
use App\Services\AutorisationGestion;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Liste des rôles, pôles et utilisateurs.
     */
    public function index(Request $request)
    {
		$entite = Entite::existe($request['entite_uid']);

        AutorisationGestion::require(Permission::ROLE_MANAGE,$request['entite_uid']);
        
		$list_roles = RoleList::where('create_by',"=",null)->orWhere('create_by',$entite->uid)->with(['permissions','pole'])->get();
        $list_poles = Pole::where('create_by',"=",null)->orWhere('create_by',$entite->uid)->get();

        $roles = Role::where("entite_uid","=",$entite->uid)->with(['user','role'])->get();
		$listUsers = User::all();
        return view('role.index_admin',[
            "list_roles" => $list_roles,
            "list_poles" => $list_poles,

            "roles" => $roles,
            "listUsers" => $listUsers,
            "entite" => $entite
        ]);
		/*return view('membre.index_admin', [
			"personnes_concernees" => $personnes_concernees->get(),
			"roles" => $roles,
			"listUsers" => $listUsers,
			"entite_lien_relatif" => $entite->lien_relatif(),
			"creation" => $request->query('creation')
		]);*/
    }

    public function index_role(Request $request){
		$entite = Entite::existe($request['entite_uid']);

        AutorisationGestion::require(Permission::ROLE_MANAGE,$request['entite_uid']);
        
		$list_roles = RoleList::where('create_by',"=",null)->orWhere('create_by',$entite->uid)->with(['permissions','pole'])->get();
        $list_poles = Pole::where('create_by',"=",null)->orWhere('create_by',$entite->uid)->get();

        return view('role.role.index',[
            "list_roles" => $list_roles,
            "list_poles" => $list_poles,
            "entite" => $entite
        ]);
    }

    public function index_pole(Request $request){
		$entite = Entite::existe($request['entite_uid']);
        AutorisationGestion::require(Permission::ROLE_MANAGE,$request['entite_uid']);
        $list_poles = Pole::where('create_by',"=",null)->orWhere('create_by',$entite->uid)->get();

        return view('role.pole.index',[
            "list_poles" => $list_poles,
            "entite" => $entite
        ]);
    }

    /**
     * Attribuer un rôle à un utilisateur.
     */
    public function give_role_user(Request $request)
    {
        // Validation
        // Attribution du rôle

        return back()->with('success', 'Rôle attribué avec succès.');
    }

    /**
     * Modifier les permissions d'un utilisateur.
     */
    public function edit_perm_user(Request $request)
    {
        // Validation
        // Modification des permissions

        return back()->with('success', 'Permissions mises à jour.');
    }

    /**
     * Formulaire de création d'un rôle.
     */
    public function create_role(Request $request)
    {
		$entite = Entite::existe($request['entite_uid']);
        AutorisationGestion::require(Permission::ROLE_MANAGE,$request['entite_uid']);
        $list_poles = Pole::where('create_by',"=",null)->orWhere('create_by',$entite->uid)->get();
        return view('role.role.formulaire',["perms"=>Permission::cases(),"poles"=>$list_poles]);
    }

    /**
     * Enregistrer un nouveau rôle.
     */
    public function store_role(Request $request)
    {
        // Validation
        // Création du rôle

        return redirect('/roles')->with('success', 'Rôle créé.');
    }

    /**
     * Formulaire de modification d'un rôle.
     */
    public function edit_role($role_uid)
    {
        // $role = Role::where('uid', $role_uid)->firstOrFail();

        return view('role.role.formulaire', compact('role_uid'));
    }

    /**
     * Mettre à jour un rôle.
     */
    public function update_role(Request $request, $role_uid)
    {
        // Validation
        // Mise à jour

        return redirect('/roles')->with('success', 'Rôle mis à jour.');
    }

    /**
     * Supprimer un rôle.
     */
    public function delete_role($role_uid)
    {
        // Suppression

        return back()->with('success', 'Rôle supprimé.');
    }

    /**
     * Formulaire de création d'un pôle.
     */
    public function create_pole()
    {
        return view('role.pole.formulaire');
    }

    /**
     * Enregistrer un nouveau pôle.
     */
    public function store_pole(Request $request)
    {
        // Validation
        // Création du pôle

        return redirect('/roles')->with('success', 'Pôle créé.');
    }

    /**
     * Formulaire de modification d'un pôle.
     */
    public function edit_pole($pole_uid)
    {
        // $pole = Pole::where('uid', $pole_uid)->firstOrFail();

        return view('role.pole.formulaire', compact('pole_uid'));
    }

    /**
     * Mettre à jour un pôle.
     */
    public function update_pole(Request $request, $pole_uid)
    {
        // Validation
        // Mise à jour

        return redirect('/roles')->with('success', 'Pôle mis à jour.');
    }

    /**
     * Supprimer un pôle.
     */
    public function delete_pole($pole_uid)
    {
        // Suppression

        return back()->with('success', 'Pôle supprimé.');
    }
}



















/*
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Entite;
use \App\Models\User;
use \App\Models\Membre;
use \App\Models\Role;

use \App\Services\AutorisationGestion;
use Illuminate\Validation\Rule;

class MembreController extends Controller
{
    public function ajout_membre(Request $request){
		//on vérifie que l'entite existe
		$entite_id = $request->route('entite_id') ?? session('entite_id');
		$entite = Entite::existe($entite_id);
		
		$membre_role_id = $request["role_id"];
		$user = User::existe($request["user_uid"]);
		if(!$user){
			return back()->withErrors(["msg"=>"L'uid fourni ne correspond à aucun utilisateur."]);
		}

		// if($membre_role_id){//Si on donne un id de membre, on créé le membre
			$membre_model = new Membre;
			$membre_model->entite_id = $entite_id;
			$membre_model->user_id =  $user->id;
			$membre_model->role_id =  $membre_role_id;
			$membre_model->changer_role();
		// }else{//Si le rôle sélectionné est "Aucun", on supprime le membre
		// 	$user->membres()->with('entite_id', $entite_id)->delete();
		// }

		return back();
    }

	public function suppression_membre(Request $request){
		//on vérifie que l'entite existe
		$entite_id = $request->route('entite_id') ?? session('entite_id');
		$entite = Entite::existe($entite_id);
		
		$membre_id = $request['membre_id'];
		$membre = Membre::existe($membre_id);
		if(!$membre){
			return back()->withErrors(["msg"=>"L'id de membre n'existe pas"]);
		}

		//Suppression du membre
		$membre->delete();
		return back();
	}

	public function mandat(){
		$entite = Entite::existe(session('entite_id'));

		return $entite->mandat()->get();
	}

	public function index_admin(Request $request){

	}
}
*/