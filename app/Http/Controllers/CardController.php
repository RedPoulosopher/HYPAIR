<?php

namespace App\Http\Controllers;

use App\Enums\Permission;
use App\Models\CardModel;
use Illuminate\Http\Request;
use App\Models\Entite;
use App\Services\AutorisationGestion;
use App\Services\FileService;
use Illuminate\Support\Facades\Storage;

class CardController extends Controller
{

    public function index_card(Request $request)
    {
        AutorisationGestion::require(Permission::MEMBER_MANAGE,$request['entite_uid']);
        
        $entite = Entite::where('uid', $request['entite_uid'])->first();
        $cardModels = CardModel::where('entite_uid',$request['entite_uid'])->get();

        return view('adherants.index_card')->with([
            'entite' => $entite,
            'cardModels' => $cardModels
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

    public function edit_card(Request $request)
    {
        AutorisationGestion::require(Permission::MEMBER_MANAGE,$request['entite_uid']);
        
        $entite = Entite::where('uid', $request['entite_uid'])->first();
        $carteModel = CardModel::where('uid', $request['card_uid'])->where('entite_uid', $request['entite_uid'])->firstOrFail();

        return view('adherants.create_card')->with([
            'entite' => $entite,
            'cardModel' => $carteModel
        ]);
    }

    public function store_card(Request $request)
    {
        AutorisationGestion::require(Permission::MEMBER_MANAGE, $request['entite_uid']);

        $entite = Entite::where('uid', $request['entite_uid'])->firstOrFail();

        $request->validate([
            'card_model_uid' => 'nullable|exists:cards_model,uid',
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string',
            'image_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'image_background' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'couleur1' => 'required|string|max:7',
            'couleur2' => 'required|string|max:7',
            'couleur_text1' => 'required|string|max:7',
            'couleur_text2' => 'required|string|max:7',
            'conditions_expiration' => 'nullable|string|max:255',
            'expiration_date' => 'nullable|date',
        ]);

        // Récupération de la carte ou création
        if ($request->filled('card_model_uid')) {
            $card = CardModel::where('uid', $request->card_model_uid)
                ->where('entite_uid', $entite->uid)
                ->firstOrFail();

            $message = 'Carte modifiée avec succès.';
        } else {
            $card = new CardModel();
            $card->entite_uid = $entite->uid;

            $message = 'Carte créée avec succès.';
        }

        // Informations de la carte
        $card->title = $request->title;
        $card->subtitle = $request->subtitle;
        $card->color_1 = $request->couleur1;
        $card->color_2 = $request->couleur2;
        $card->font_color_1 = $request->couleur_text1;
        $card->font_color_2 = $request->couleur_text2;

        //$card->conditions_expiration = $request->conditions_expiration;
        //$card->expiration_date = $request->expiration_date;

        // Logo
        if ($request->hasFile('image_logo')) {
            FileService::validation_img($request->image_logo);

            $card->logo = FileService::upload(
                $request->image_logo,
                "logo_cards",
                "public",
                ["acces" => 'public']
            );
        } elseif (!$card->exists) {
            //$card->logo = $entite->getLogo?->uid;
            $logo = $entite->getLogo;

            if ($logo) {
                $card->logo = FileService::copy(
                    $logo->uid,
                    "logo_cards",
                    "public",
                    ["acces" => 'public']
                );
            }
        }

        // Image de fond
        if ($request->hasFile('image_background')) {
            FileService::validation_img($request->image_background);

            $card->background = FileService::upload(
                $request->image_background,
                "background_cards",
                "public",
                ["acces" => 'public']
            );
        }

        $card->save();

        return redirect()
            ->route('index_card', [$entite->uid])
            ->with('success', $message);
    }
    public function list_users($card_id)
    {
        AutorisationGestion::protectionPage("gerer_membre");

        $est_bureau = AutorisationGestion::gestion('gerer_bureau');

        $entite = Entite::where('id', session('entite_id'))->first();

        return view('adherants.list_users')->with([
            'entite' => $entite,
            'est_bureau' => $est_bureau,
        ]);
    }
}
