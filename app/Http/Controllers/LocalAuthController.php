<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class LocalAuthController extends Controller
{
    function previous_url(Route|string $fallback = null): Route|string
    {
        $url = url()->previous($fallback);
        if ($url == url()->current()) {
            return $fallback;
        }

        return $url;
    }

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

        $url = '/';
        if ( session()->has('pre_login_url') )
		{
            // Get and delete url
			$url = session()->pull('pre_login_url', '/');
		}

        $request->session()->regenerate();

        return redirect($url);

    }
}
