<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class LocalAuthController extends Controller
{
    public function index()
    {
        if (App::environment('local')) {
            $users = User::all();
            return view('dev.authentification')->with('users', $users);
        } else {
            return redirect('/403');
        }
    }

    public function connexion(Request $request)
    {
        $user = User::find($request->utilisateur);
        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->intended();
    }
}
