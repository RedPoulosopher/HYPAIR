<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Evenement;
use Illuminate\Http\Request;
use \App\Services\AutorisationGestion;
use App\Models\Site;
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
        $posts = Post::all();
        return view('accueil')->with('posts', $posts);
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
        Post::create($postRequest);
        return redirect(session('entite_uid') . '/entite/post');
    }

    public function edit($entite_uid, $post_id)
    {
        AutorisationGestion::protectionPage("gerer_evenement");
        $niveau_administration = AutorisationGestion::niveau_administration();

        $events = Evenement::where('entite_id', session('entite_id'));
        $sites = Site::all();
        $post = Post::find($post_id);

        return view('post.formulaire', [
            'titre' => 'Modifier le post',
            'events' => $events,
            'campus' => $sites,
            'post' => $post
        ]);
    }

    public function formulaire_traitement(Request $request)
    {
        $validated = $request->validate(
            [
                'titre' => 'required|max:128',
                'descrption' => 'required|min:30|max:250',
                'event_id' => 'nullable',
                'date_apparition' => 'nullable',
                'date_expiration' => 'nullable',
            ]
        );

        $postRequest = [
            "entite_id" => session('entite_id'),
            "titre" => $request->titre,
            "description" => $request->description,
            "date_apparition" => $request->date_apparition ? $request->date_apparition : new DateTime('now', new DateTimeZone('Europe/Paris')),
            "date_expiration" => $request->date_expiration,
            "event_id" => $request->event_id
        ];

        return $postRequest;
    }

    public function update(Request $request, $entite_uid, $post_id)
    {
        AutorisationGestion::protectionPage("gerer_evenement");
        $traitement = $this->formulaire_traitement($request);
        Post::find($post_id)->update($traitement);
        return redirect(session('entite_uid') . "/entite/post");
    }

    public function delete($entite_uid, $post_id)
    {
        AutorisationGestion::protectionPage("gerer_evenement");
        $post = Post::find($post_id)->delete();
        return redirect(session('entite_uid') . "/entite/post");
    }
}
