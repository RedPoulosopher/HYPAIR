<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Validator;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use MongoDB\Driver\Session;

class AuthController extends Controller
{
    public function username(){
        return 'uid';
    }

    public function connexion(Request $request){

        $req = $request->validate([
            'code' => ['nullable'],
            'state' => ['nullable']
        ]);

        if(!isset($req['code'])) {
            $url = config('auth.oauth2.authorize_url')
                . '?response_type=code'
                . '&client_id='  . config('auth.oauth2.id')
                . '&redirect_uri='. config('auth.oauth2.redirect_uri')
                . '&scope=profile email'
                . '&state=' . hash('sha1', session_id());

            return redirect($url);
        } else {
            if(!isset($req['state']) || $req['state'] != hash('sha1', session_id())) {
                return abort(400, "L'état n'a pas pu être vérifié");
            }

            $token_response = Http::post(config('auth.oauth2.token_url'), [
                'grant_type' => 'authorization_code',
                'client_id' => config('auth.oauth2.id'),
                'client_secret' => config('auth.oauth2.secret'),
                'code' => $req['code']
            ]);

            if ($token_response->failed()) {
                return abort(401);
            }

            $token = $token_response['access_token'];

            $user_response = Http::withToken($token)->get(config('auth.oauth2.user_endpoint_url'));

            if ($user_response->failed()) {
                return abort(401);
            }

            $user = null;
            $uid = $user_response['uid'];
            $prenom = $user_response['first_name'];
            $nom = $user_response['last_name'];
            $email = $user_response['email'];
            if(User::existe($uid)) {
                $user = User::where('uid', $uid)->first();
                if(!isset($user->email)) {
                    $user->email = $email;
                }

                if(!isset($user->nom)) {
                    $user->nom = $nom;
                }

                if(!isset($user->prenom)) {
                    $user->prenom = $prenom;
                }

                $user->save();
            } else {
                $user = User::create([
                    'uid' => $uid,
                    'prenom' => ($prenom ?? "PasDePrénom"),
                    'nom' => ($nom ?? "PasDeNom"),
                    'email' => $email,
                    'password' => ''
                ]);
            }

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended();
        }

    }

    public function deconnexion(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function admin() {
        dd(Hash::make('hypairadmin'));
    }

    public function connexion_admin() {
        dd('connexion admin yes');
    }
}
