<?php

namespace App\Http\Controllers;

use App\Enums\Permission;
use App\Models\Entite;
use App\Models\Pole;
use App\Models\Role;
use App\Models\RoleList;
use App\Models\User;
use App\Services\AutorisationGestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /**
     * Liste des rôles, pôles et utilisateurs.
     */
    public function index(Request $request)
    {
        $entite = Entite::existe($request['entite_uid']);

        AutorisationGestion::require(Permission::ROLE_MANAGE, $request['entite_uid']);

        $list_roles = RoleList::where('create_by', "=", null)->orWhere('create_by', $entite->uid)->with(['permissions', 'pole'])->orderBy('ordre')->get();
        $list_poles = Pole::where('create_by', "=", null)->orWhere('create_by', $entite->uid)->orderBy('ordre')->get();

        $roles = Role::where("entite_uid", "=", $entite->uid)->with(['user', 'role.pole'])->get()
            ->sortBy([
                fn ($r) => $r->role->pole->ordre ?? -10000,
                fn ($r) => $r->role->ordre ?? 0,
            ])
            ->values();
        $listUsers = User::all();
        return view('role.index_admin', [
            "list_roles" => $list_roles,
            "list_poles" => $list_poles,

            "roles" => $roles,
            "listUsers" => $listUsers,
            "entite" => $entite
        ]);
    }

    public function index_role(Request $request)
    {
        $entite = Entite::existe($request['entite_uid']);

        AutorisationGestion::require(Permission::ROLE_MANAGE, $request['entite_uid']);

        $list_roles = RoleList::where('create_by', "=", null)->orWhere('create_by', $entite->uid)->with(['permissions', 'pole'])->orderBy('ordre')->get();
        $list_poles = Pole::where('create_by', "=", null)->orWhere('create_by', $entite->uid)->orderBy('ordre')->get();

        return view('role.role.index', [
            "list_roles" => $list_roles,
            "list_poles" => $list_poles,
            "entite" => $entite
        ]);
    }

    public function index_pole(Request $request)
    {
        $entite = Entite::existe($request['entite_uid']);
        AutorisationGestion::require(Permission::ROLE_MANAGE, $request['entite_uid']);
        $list_poles = Pole::where('create_by', "=", null)->orWhere('create_by', $entite->uid)->orderBy('ordre')->get();

        return view('role.pole.index', [
            "list_poles" => $list_poles,
            "entite" => $entite
        ]);
    }

    /**
     * Attribuer un rôle à un utilisateur.
     */
    public function give_role_user(Request $request)
    {
        $entite = Entite::existe($request['entite_uid']);
        AutorisationGestion::require(Permission::ROLE_MANAGE, $request['entite_uid']);

        $request->validate([
            'user_uid' => 'required|exists:users,uid',
            'role_uid' => 'required|exists:roles_list,uid',
        ]);
        
        $user = User::where('uid', $request['user_uid'])->first();
        if (!$user) {
            return back()->withErrors(["msg" => "L'uid fourni ne correspond à aucun utilisateur."]);
        }

        // Le rôle doit être global ou appartenir à l'entité
        $roleList = RoleList::where('uid', $request['role_uid'])
            ->where(function ($q) use ($entite) {
                $q->whereNull('create_by')->orWhere('create_by', $entite->uid);
            })
            ->first();
        
        
        if($request['type']=="supp"){
            Role::where('entite_uid', $entite->uid)
                ->where('user_uid', $user->uid)
                ->where('role_uid', $roleList->uid)
                ->delete();
            return back()->with('success', 'Rôle supprimé avec succès.');
        }

        if (!$roleList) {
            return back()->withErrors(["msg" => "Ce rôle n'existe pas ou n'est pas disponible pour cette entité."]);
        }

        Role::firstOrCreate([
            'entite_uid' => $entite->uid,
            'user_uid' => $user->uid,
            'role_uid' => $roleList->uid
        ]);

        return back()->with('success', 'Rôle attribué avec succès.');
    }

    /*
    Modifier les permissions individuelles d'un utilisateur (surcharge indépendante des rôles).
    public function edit_perm_user(Request $request)
    {
        $entite = Entite::existe($request['entite_uid']);
        AutorisationGestion::require(Permission::ROLE_MANAGE, $request['entite_uid']);

        $request->validate([
            'user_uid' => 'required|exists:users,uid',
            'perm' => 'required|integer',
            'action' => 'required|in:add,remove,reset',
        ]);

        $user = User::existe($request['user_uid']);
        if (!$user) {
            return back()->withErrors(["msg" => "L'uid fourni ne correspond à aucun utilisateur."]);
        }

        if ($request['action'] === 'reset') {
            // Retire la surcharge : l'utilisateur retombe sur les permissions de ses rôles
            DB::table('user_perms')
                ->where('entite_uid', $entite->uid)
                ->where('user_uid', $user->uid)
                ->where('perm', $request['perm'])
                ->delete();
        } else {
            DB::table('user_perms')->updateOrInsert(
                [
                    'entite_uid' => $entite->uid,
                    'user_uid' => $user->uid,
                    'perm' => $request['perm'],
                ],
                [
                    'add_or_remove' => $request['action'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        return back()->with('success', 'Permissions mises à jour.');
    }
    */

    /**
     * Formulaire de création d'un rôle.
     */
    public function create_role(Request $request)
    {
        $entite = Entite::existe($request['entite_uid']);
        AutorisationGestion::require(Permission::ROLE_MANAGE, $request['entite_uid']);
        $list_poles = Pole::where('create_by', "=", null)->orWhere('create_by', $entite->uid)->orderBy('ordre')->get();
        return view('role.role.formulaire', ["perms" => Permission::cases(), "poles" => $list_poles,"entite" => $entite]);
    }

    /**
     * Enregistrer un nouveau rôle.
     */
    public function store_role(Request $request)
    {
        $entite = Entite::existe($request['entite_uid']);
        AutorisationGestion::require(Permission::ROLE_MANAGE, $request['entite_uid']);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'pole_uid' => 'nullable|exists:poles_list,uid',
            'ordre' => 'nullable|integer',
            'perms' => 'array',
            'perms.*' => 'integer',
        ]);

        $roleList = new RoleList();
        $roleList->uid = (string) Str::uuid();
        $roleList->name = $data['name'];
        $roleList->pole_uid = $data['pole_uid'] ?? null;
        $roleList->ordre = $data['ordre'] ?? 0;
        $roleList->create_by = $entite->uid;
        $roleList->save();

        foreach ($data['perms'] ?? [] as $perm) {
            DB::table('perm_role_list')->insert([
                'role_uid' => $roleList->uid,
                'perm' => $perm,
            ]);
        }

        return redirect()->route("index_role",[$request['entite_uid']])->with('success', 'Rôle créé.');
    }

    /**
     * Formulaire de modification d'un rôle.
     */
    public function edit_role(Request $request)
    {
        $entite = Entite::existe($request['entite_uid']);
        AutorisationGestion::require(Permission::ROLE_MANAGE, $request['entite_uid']);

        $role = RoleList::where('uid', $request["role_uid"])
            ->where(function ($q) use ($entite) {
                $q->whereNull('create_by')->orWhere('create_by', $entite->uid);
            })
            ->with(['permissions', 'pole'])
            ->firstOrFail();

        $list_poles = Pole::where('create_by', "=", null)->orWhere('create_by', $entite->uid)->orderBy('ordre')->get();

        return view('role.role.formulaire', [
            "role" => $role,
            "role_uid" => $role->uid,
            "perms" => Permission::cases(),
            "poles" => $list_poles,
            "entite" => $entite
        ]);
    }

    /**
     * Mettre à jour un rôle.
     */
    public function update_role(Request $request)
    {
        $entite = Entite::existe($request['entite_uid']);
        AutorisationGestion::require(Permission::ROLE_MANAGE, $request['entite_uid']);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'pole_uid' => 'nullable|exists:poles_list,uid',
            'ordre' => 'nullable|integer',
            'perms' => 'array',
            'perms.*' => 'integer',
        ]);

        $roleList = RoleList::where('uid', $request['role_uid'])
            ->where('create_by', $entite->uid)
            ->firstOrFail();
        $roleList->name = $data['name'];
        $roleList->pole_uid = $data['pole_uid'] ?? null;
        $roleList->ordre = $data['ordre'] ?? 0;
        $roleList->create_by = $entite->uid;
        $roleList->save();

        DB::table('perm_role_list')->where('role_uid', $roleList->uid)->delete();
        foreach ($data['perms'] ?? [] as $perm) {
            DB::table('perm_role_list')->insert([
                'role_uid' => $roleList->uid,
                'perm' => $perm,
            ]);
        }
        return redirect()->route("index_role",[$request['entite_uid']])->with('success', 'Rôle mis à jour.');
    }

    /**
     * Supprimer un rôle.
     */
    public function delete_role(Request $request)
    {
        $entite = Entite::existe($request['entite_uid']);
        AutorisationGestion::require(Permission::ROLE_MANAGE, $request['entite_uid']);

        $role = RoleList::where('uid', $request['role_uid'])
            ->where('create_by', $entite->uid)
            ->first();

        if (!$role) {
            return back()->withErrors(["msg" => "Ce rôle n'existe pas ou ne peut pas être supprimé."]);
        }

        $role->delete(); // cascade sur perm_role_list et roles via les clés étrangères

        return back()->with('success', 'Rôle supprimé.');
    }

    /**
     * Formulaire de création d'un pôle.
     */
    public function create_pole(Request $request)
    {
        $entite = Entite::existe($request['entite_uid']);
        AutorisationGestion::require(Permission::ROLE_MANAGE, $request['entite_uid']);

        return view('role.pole.formulaire', ["entite" => $entite]);
    }

    /**
     * Enregistrer un nouveau pôle.
     */
    public function store_pole(Request $request)
    {
        $entite = Entite::existe($request['entite_uid']);
        AutorisationGestion::require(Permission::ROLE_MANAGE, $request['entite_uid']);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'ordre' => 'nullable|integer',
        ]);

        $pole = new Pole();
        $pole->uid = (string) Str::uuid();
        $pole->name = $data['name'];
        $pole->ordre = $data['ordre'] ?? 0;
        $pole->create_by = $entite->uid;
        $pole->save();

        return redirect()->route("index_pole",[$request['entite_uid']])->with('success', 'Pôle créé.');
    }

    /**
     * Formulaire de modification d'un pôle.
     */
    public function edit_pole(Request $request)
    {
        $entite = Entite::existe($request['entite_uid']);
        AutorisationGestion::require(Permission::ROLE_MANAGE, $request['entite_uid']);

        $pole = Pole::where('uid', $request['pole_uid'])
            ->where(function ($q) use ($entite) {
                $q->whereNull('create_by')->orWhere('create_by', $entite->uid);
            })
            ->firstOrFail();

        return view('role.pole.formulaire',[
            "pole"=>$pole,
            "entite"=>$entite
        ]);
    }

    /**
     * Mettre à jour un pôle.
     */
    public function update_pole(Request $request)
    {
        $entite = Entite::existe($request['entite_uid']);
        AutorisationGestion::require(Permission::ROLE_MANAGE, $request['entite_uid']);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'ordre' => 'nullable|integer',
        ]);

        $pole = Pole::where('uid', $request['pole_uid'])
            ->where('create_by', $entite->uid)
            ->firstOrFail();

        $pole->name = $data['name'];
        $pole->ordre = $data['ordre'] ?? $pole->ordre;
        $pole->save();

        return redirect()->route("index_pole",[$request['entite_uid']])->with('success', 'Pôle mis à jour.');
    }

    /**
     * Supprimer un pôle.
     */
    public function delete_pole(Request $request)
    {
        $entite = Entite::existe($request['entite_uid']);
        AutorisationGestion::require(Permission::ROLE_MANAGE, $request['entite_uid']);

        $pole = Pole::where('uid', $request['pole_uid'])
            ->where('create_by', $entite->uid)
            ->first();

        if (!$pole) {
            return back()->withErrors(["msg" => "Ce pôle n'existe pas ou ne peut pas être supprimé."]);
        }

        $pole->delete(); // cascade sur roles_list (pole_uid) via clé étrangère

        return back()->with('success', 'Pôle supprimé.');
    }
}