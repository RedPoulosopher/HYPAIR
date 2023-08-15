<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Evenement;
use Illuminate\Http\Request;
use \App\Services\AutorisationGestion;
use App\Models\Site;
use App\Models\Entite;
use DateTime;
use DateTimeZone;

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
        $now = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s');
        $posts = Post::where('date_apparition', '<', $now)->orderBy('date_apparition', 'desc')->get();
        return view('accueil')->with('posts', $posts);
    }

    static function date_apparition_to_duration($date_apparition){
        $now = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s');
        $nbSeconds = strtotime($now) - strtotime($date_apparition);

        if($nbSeconds < 60) return $nbSeconds . "s";
        else if($nbSeconds/60 < 60) return floor($nbSeconds/60) . "min";
        else if($nbSeconds/(60*60) < 24) return floor($nbSeconds/(60*60)) . "h";
        else return floor($nbSeconds/(60*60*24)) . "j";
    }

    public function home()
    {
        $posts = Post::where('entite_id', session(('entite_id')))->get();


        return view('post.home')->with([
            'posts' => $posts,
            'gerer_post' => AutorisationGestion::gestion("gerer_post")
        ]);
    }

    public function create()
    {
        // Pour l'instant, on considère que si on peut gérer les events, on peut gérer les posts
        AutorisationGestion::protectionPage("gerer_evenement");
        // $niveau_administration = AutorisationGestion::niveau_administration();

        $events = Evenement::where('entite_id', session('entite_id'))->get();
        $sites = Site::all();

        return view('post.formulaire', [
            'titre' => 'Créer un post',
            'events' => $events,
            'campus' => $sites
        ]);
    }

    public function store(Request $request)
    {
        AutorisationGestion::protectionPage('gerer_evenement');
        $postRequest = $this->formulaire_traitement($request);
        $post = Post::create($postRequest);

        if (!empty($request->campus_id)) {
            foreach ($request->campus_id as $id) {
                $post->campus()->attach($id);
            }
        }

        return redirect(session('entite_uid') . '/entite/post');
    }

    public function edit($entite_uid, $post_id)
    {
        AutorisationGestion::protectionPage("gerer_evenement");
        $niveau_administration = AutorisationGestion::niveau_administration();

        $events = Evenement::where('entite_id', session('entite_id'));
        $sites = Site::all();
        $post = Post::find($post_id);

        $all_post_campus_id = [];
        foreach($post->campus as $campus) {
            array_push($all_post_campus_id, $campus->id);
        }

        return view('post.formulaire', [
            'titre' => 'Modifier le post',
            'events' => $events,
            'campus' => $sites,
            'post' => $post,
            'all_post_campus_id' => $all_post_campus_id
        ]);
    }

    public function formulaire_traitement(Request $request)
    {
        $validated = $request->validate(
            [
                'titre' => 'required|max:128',
                'description_md' => 'required|min:30|max:250',
                'event_id' => 'nullable',
                'date_apparition' => 'nullable',
                'date_expiration' => 'nullable',
            ]
        );

        $postRequest = [
            "entite_id" => session('entite_id'),
            "titre" => $request->titre,
            "description" => $request->description_md,
            "date_apparition" => $request->date_apparition ? $request->date_apparition : new DateTime('now', new DateTimeZone('Europe/Paris')),
            "date_expiration" => $request->date_expiration,
            "event_id" => $request->event_id == 0 ? null : $request->event_id,
        ];

        return $postRequest;
    }

    public function update(Request $request, $entite_uid, $post_id)
    {
        AutorisationGestion::protectionPage("gerer_evenement");
        $traitement = $this->formulaire_traitement($request);
        $post = Post::find($post_id);
        $post->update($traitement);

        $campus_array = Site::all();
        // Attention quand le tableau est vide
        $campus_nbr = count($campus_array);
        for($i = 1; $i <= $campus_nbr; $i++) {
            $post->campus()->detach();
        }
        if (!empty($request->campus_id)) {
            foreach ($request->campus_id as $id) {
                $post->campus()->attach($id);
            }
        }

        return redirect(session('entite_uid') . "/entite/post");
    }

    public function delete($entite_uid, $post_id)
    {
        AutorisationGestion::protectionPage("gerer_evenement");
        $post = Post::find($post_id)->delete();
        return redirect(session('entite_uid') . "/entite/post");
    }

    public function show(Request $request)
	{
		$niveau_administration = AutorisationGestion::niveau_administration();

		$post = Post::where('id', $request->route('event_id'));

		if (!$post->exists()) {
			abort(404);
		}

		$post = $post->first();
		if ($post["confidentialite"] > $niveau_administration) {
			abort(403);
		}

        $entite = Entite::where('id', $post->entite_id);

        if (!$entite->exists()) {
			abort(404);
		}

		$entite = $entite->first();
		if ($entite["confidentialite"] > $niveau_administration) {
			abort(403);
		}

		return view('post.show-post', [
			'post' => $post,
			'entite' => $entite,
			'gerer_post' => AutorisationGestion::gestion("gerer_post")
		]);
	}
}
