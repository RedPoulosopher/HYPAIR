<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     */


    public function deconnexion(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function loginPage()
    {
        $user = Auth::user();
        return view('login', compact('user'));
    }
    
    public function login(Request $request): RedirectResponse
    {
        
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials,true)) {
            $request->session()->regenerate();
            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function registerPage()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        Auth::logout();

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'prenoms' => 'nullable|string|max:255',
            'pronoms' => 'nullable|string|max:100',
            'date_naissance' => 'nullable|date',
            'email' => 'required|string|email|max:255|unique:users,email|ends_with:@etu.imt-nord-europe.fr',
            'num_tel' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'accept_cgu' => 'required|accepted',
        ]);

        // Création de l'utilisateur
        $user = User::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'prenoms' => $validated['prenoms'] ?? null,
            'pronoms' => $validated['pronoms'] ?? null,
            'date_naissance' => $validated['date_naissance'] ?? null,
            'email' => $validated['email'],
            'num_tel' => $validated['num_tel'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        // Connexion automatique
        Auth::login($user, true);

        return redirect('/');
    }
}
