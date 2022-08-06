<?php

namespace App\Http\Controllers;

use App\Enums\EntiteTypeEnum;
use App\Models\Entite;
use Illuminate\Http\Request;

class AccueilController extends Controller
{
    public function accueil() {
        $entites = Entite::where('type', EntiteTypeEnum::Bureau)
            ->orWhere('type', EntiteTypeEnum::Association)
            ->orWhere('type', EntiteTypeEnum::Club)
            ->orWhere('type', EntiteTypeEnum::Comite)
            ->get();

        $res = [];
        foreach ($entites as $entite) {
            $res[] = $entite->uid . '-' . $entite->id;
        }

        shuffle($res);

        while(count($res) < 48) {
            $res = array_merge($res, $res);
        }

        return view('accueil', ['entites' => $res]);
    }
}
