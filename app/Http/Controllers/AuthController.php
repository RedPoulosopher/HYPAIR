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

    function previous_url(Route|string $fallback = null): Route|string
    {
        $url = url()->previous($fallback);
        if ($url == url()->current()) {
            return $fallback;
        }

        return $url;
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

            // Store previous url for redirect when response from cerbair
            session(['pre_login_url' => $this->previous_url()]);


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

            // Get saved previous url
            $url = '/';
            if ( session()->has('pre_login_url') )
            {
                // Get and delete url
                $url = session()->pull('pre_login_url', '/');
            }


            Auth::login($user, $remember = true);
            $request->session()->regenerate();

            return redirect($url);
        }

    }

    public function deconnexion(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function admin() {
        // dd(Hash::make('hypairadmin'));
        return view('admin');
    }

    public function connexion_admin(Request $request) {
        if(Hash::check($request->mdp, getenv('ADMIN_PASSWORD'))) {
            $user = User::where('uid', 'admin.admin')->get()->first();
            Auth::login($user);
            return redirect()->route('accueil');
        } else {
            return redirect()->route('admin');
        }
    }
}
