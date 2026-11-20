<?php

namespace App\Http\Controllers;

use App\Enums\Permission;
use App\Models\ControllerAcces;
use App\Models\Entite;
use App\Services\AutorisationGestion;
use Illuminate\Http\Request;

class ControllerAccesController extends Controller
{
    public function index(Request $request)
    {
        AutorisationGestion::isSU();

        $badgeuses = ControllerAcces::all();

        return view('controller_acces.index')->with([
            'badgeuses' => $badgeuses
        ]);
    }

    public function create(Request $request)
    {
        AutorisationGestion::isSU();

        $badgeuses = ControllerAcces::all();

        return view('controller_acces.form')->with([
            'badgeuses' => $badgeuses,
            'entites' => Entite::all()
        ]);
    }

    public function store(Request $request)
    {
        AutorisationGestion::isSU();
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'token' => [
                'required',
                'string',
                'max:255',
                'unique:controller_acces,token',
            ],

            'entite_uid' => [
                'nullable',
                'array',
            ],

            'entite_uid.*' => [
                'exists:entites,uid',
            ],
        ]);

        $controller = ControllerAcces::create([
            'name' => $validated['name'],
            'token' => $validated['token'],
        ]);

        $controller->entites()->sync(
            $validated['entite_uid'] ?? []
        );

        return redirect()
            ->route('controller-acces.index')
            ->with(
                'success',
                'Le contrôleur d’accès a été ajouté avec succès.'
            );
    }
}
