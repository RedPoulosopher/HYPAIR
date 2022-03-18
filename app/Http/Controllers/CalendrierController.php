<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Evenement;

class CalendrierController extends Controller
{
    public static function calendrier_asso(){
        $evenements= Evenement::index();
        return view("evenements.calendrier", ["event" => $evenements]);

    }
    //
}
