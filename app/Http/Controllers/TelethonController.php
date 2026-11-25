<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TelethonController extends Controller
{
    public function index(Request $request){


        $user = Auth::user();

        if(!$user){
            return view('telethon.home');
        }
        $teams = Team::withSum('pointsTelethon', 'nb_points')
            ->orderByRaw('COALESCE(points_telethon_sum_nb_points, 0) DESC')
            ->get();



        $personalPoints = $user->pointsTelethon()->sum('nb_points');

        $personalRanking = \App\Models\User::withSum('pointsTelethon', 'nb_points')
            ->orderByDesc('points_telethon_sum_nb_points')
            ->get()
            ->search(fn ($u) => $u->uid === $user->uid);

        $personalRanking = $personalRanking !== false ? $personalRanking + 1 : '-';
        return view('telethon.home',["teams"=>$teams,"user"=>$user,"personalPoints"=>$personalPoints,"personalRanking"=>$personalRanking]);
    }
}
