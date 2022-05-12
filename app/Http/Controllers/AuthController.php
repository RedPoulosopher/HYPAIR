<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function username(){
        return 'uid';
    }

    public function affichage_formulaire(Request $request){
        if(!session()->has('url.intended')) {
            session()->put('url.intended', url()->previous());
        }

        return view('connexion');
    }

    public function connexion(Request $request) {
        $credentials = $request->validate([
            'uid' => ['required'],
            'password' => ['required'],
        ]);

        sleep(1); //pour l'animation

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/air/accueil');
        }

        return back()->withErrors([
            'uid' => 'The provided credentials do not match our records.',
        ]);
    }

    public function deconnexion(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('connexion'));
    }
}
