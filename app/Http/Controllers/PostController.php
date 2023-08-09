<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use \App\Services\AutorisationGestion;
use \App\Models\Evenement;

class PostController extends Controller
{
    static $tag_colors = ["3240BD", "E14545", "4FCA63", "43A8A8", "63092C", "CF9F23", "5bbd75", "264d91", "831d64", "422977", "2b918b", "bf6a18", "C12816"];

    static function stringToColorCode($str)
    {
        $code = crc32($str);

        if (strtolower($str) == 'important') return '#bd2020';

        $color = self::$tag_colors[$code % count(self::$tag_colors)];

        return '#' . $color;
    }

    public function accueil()
    {
        $posts = Post::all();
        // dd($posts);
        return view('accueil')->with('posts', $posts);
    }

    public function home()
    {
        $posts = Post::select('id', 'event_id', 'titre', 'description', 'date_apparition', 'date_expiration', 'entite_id')->where([
            ['entite_id', '=', session('entite_id')]
        ])->get();
        
        return view('post.home')->with([
            'posts' => $posts,
            'gerer_post' => AutorisationGestion::gestion("gerer_post")
        ]);
    }

    public function create()
	{
		// AutorisationGestion::protectionPage("gerer_post");
		$niveau_administration = AutorisationGestion::niveau_administration();

		$events_existants = Evenement::select('id', 'titre')
			->where('entite_id', session('entite_id'))
			// ->where("confidentialite", "<=", $niveau_administration)
			->get();

		return view('post.formulaire', [
			'titre' => 'Créer un post',
			'events_existants' => $events_existants,
		]);
	}

    public function edit(Request $request){//TODO : retourner la page de création avec tout de pré-rempli
        		// AutorisationGestion::protectionPage("gerer_post");
		$niveau_administration = AutorisationGestion::niveau_administration();

		$events_existants = Evenement::select('id', 'titre')
			->where('entite_id', session('entite_id'))
			// ->where("confidentialite", "<=", $niveau_administration)
			->get();

		return view('post.formulaire', [
			'titre' => 'Modifier le post',
			'events_existants' => $events_existants,
		]);
    }

    public function store(Request $request)
    {
        // ajouter une authorization dans un service (voir eventcontrolelr)
        // ajouter un traitement post-validation (à voir) dans un PostServcie
        // Post::create($request);
    }
}
