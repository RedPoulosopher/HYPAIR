<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Liste des rôles, pôles et utilisateurs.
     */
    public function index(Request $request)
    {
        return view('roles.index');
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
    public function create_role()
    {
        return view('roles.roles.create');
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

        return view('roles.roles.edit', compact('role_uid'));
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
        return view('roles.poles.create');
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

        return view('roles.poles.edit', compact('pole_uid'));
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