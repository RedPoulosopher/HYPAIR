<?php

namespace App\Http\Controllers;

use App\Enums\Permission;
use App\Models\CardModel;
use Illuminate\Http\Request;
use App\Models\Entite;
use App\Services\AutorisationGestion;
use App\Services\FileService;

class CardController extends Controller
{

    public function index_card(Request $request)
    {
        AutorisationGestion::require(Permission::MEMBER_MANAGE,$request['entite_uid']);
        
        $entite = Entite::where('uid', $request['entite_uid'])->first();

        return view('adherants.index_card')->with([
            'entite' => $entite
        ]);
    }

    public function create_card(Request $request)
    {
        AutorisationGestion::require(Permission::MEMBER_MANAGE,$request['entite_uid']);
        
        $entite = Entite::where('uid', $request['entite_uid'])->first();

        return view('adherants.create_card')->with([
            'entite' => $entite
        ]);
    }

    public function store_card(Request $request)
    {
        AutorisationGestion::require(Permission::MEMBER_MANAGE,$request['entite_uid']);

        $entite = Entite::where('uid', $request['entite_uid'])->first();

        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string',
            'logo_img' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'couleur_text1' => 'required|string|max:7',
            'couleur_text2' => 'required|string|max:7',
            'conditions_expiration' => 'nullable|string|max:255',
            'expiration_date' => 'nullable|date',
        ]);


        $card = new CardModel();
        $card->title = $request->title;
        $card->subtitle = $request->subtitle;
        $card->entite_uid = $entite->uid;
        $card->font_color_1 = $request->couleur_text1;
        $card->font_color_2 = $request->couleur_text2;
//        $card->background_1 = $request->background_1;
        //$card->conditions_expiration = $request->conditions_expiration;
        //$card->expiration_date = $request->expiration_date;

        $logo = null;
        if ($request->hasFile('logo_img')) {
            FileService::validation_img($request->logo);
			$card->logo = FileService::upload($request->logo,"logo_entites","public",["acces"=>'public']);
        }else{
            $card->logo = $entite->getLogo->uid;
        }
        
        $card->save();

        return redirect()->route('entite.card.index')->with('success', 'Carte créée avec succès.');
    }

    public function list_users($card_id)
    {
        AutorisationGestion::protectionPage("gerer_membre");

        $est_bureau = AutorisationGestion::gestion('gerer_bureau');

        $entite = Entite::where('id', session('entite_id'))->first();

        return view('entite.card.list_users')->with([
            'entite' => $entite,
            'est_bureau' => $est_bureau,
        ]);
    }
}
