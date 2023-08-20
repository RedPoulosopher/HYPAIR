<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Evenement;
use Illuminate\Http\Request;
use \App\Services\AutorisationGestion;
use App\Models\Site;
use App\Models\Entite;
use App\Models\Tag;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Auth;

use DB;

class PostController extends Controller
{
    static $tag_colors = ["3240BD", "E14545", "4FCA63", "43A8A8", "63092C", "CF9F23", "1b4426", "264d91", "831d64", "422977", "0e6e69", "bf6a18", "C12816", "5c75a7", "661664", "438949", "104547", "494993", "346a58", "a9363b", "D7263D", "1d8ed5", "871c5b", "32965D", "6a3351", "31676a", "27345c", "53409b", "af2f80", "414361", "4c5c2e"];
    static function stringToColorCode($str)
    {
        $code = crc32($str);

        $color = self::$tag_colors[$code % count(self::$tag_colors)];

        return '#' . $color;
    }

    public function accueil($site = null)
    {        
        $now = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s');
        if (!isset($site)) {
            if (Auth::check()) {
                $user = Auth::user();
                if (count($user->campus)>0) {
                    $campus = $user->campus->first();
                } else {
                    // if user has no campus saved, show Douai posts by default
                    $campus = Site::all()->first();
                }
            }
            else {
                // if user not connected, show Douai posts by default
                $campus = Site::all()->first();
            }
            $site = $campus->label;
        } else {
            $campus = Site::where('label', $site)->first();
        }
        $posts = $campus->posts->sortByDesc('date_apparition');

        $canSeeConfidentiel = false;
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->campus->contains($campus)) {
                $canSeeConfidentiel = true;
            }
        }

        return view('accueil')->with('posts', $posts)->with('site', $site)->with('canSeeConfidentiel', $canSeeConfidentiel);
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
        AutorisationGestion::protectionPage("gerer_post");

        $posts = Post::where('entite_id', session(('entite_id')))->orderBy('date_apparition', 'desc')->get();

        return view('post.home')->with([
            'posts' => $posts,
            'gerer_post' => AutorisationGestion::gestion("gerer_post")
        ]);
    }

    public function create()
    {
        AutorisationGestion::protectionPage("gerer_post");
        // $niveau_administration = AutorisationGestion::niveau_administration();

        $now = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s');
        $oneMonthAgo = date('Y-m-d', strtotime("-1 month", strtotime($now)));
        
        $events = Evenement::where('entite_id', session('entite_id'))
                            ->where('temps_fin', '>', $oneMonthAgo)->get();//On ne montre que les events qui ne sont pas fini ou on terminé il y a moins d'un mois
        $sites = Site::all();

        return view('post.formulaire', [
            'titre' => 'Créer un post',
            'events' => $events,
            'campus' => $sites
        ]);
    }

    public function store(Request $request)
    {
        AutorisationGestion::protectionPage('gerer_post');
        $postRequest = $this->formulaire_traitement($request);
        $post = Post::create($postRequest);

        // TAGS
        if (!empty($request->tags)) {
            $tag_names = array_map('trim', explode(',', $request->tags)); //On sépare par les virgules et on enlève les espaces devant et derrière chaque string

            foreach($tag_names as $tag_name){
                if($tag_name != ""){
                    $tag = Tag::where(DB::raw('lower(name)'), strtolower($tag_name));
    
                    if (!$tag->exists()) {//Si le tag n'existe pas, on le créé
                        Tag::create([                        
                            'name' => ucfirst(strtolower($tag_name)),
                            'couleur' => self::stringToColorCode(strtolower($tag_name))
                        ]);
                    }
    
                    $post->tags()->attach($tag->first()->id);
                }

            }
        }

        if (!empty($request->campus_id)) {
            foreach ($request->campus_id as $id) {
                $post->campus()->attach($id);
            }
        }

        return redirect(session('entite_uid') . '/entite/post');
    }

    public function edit($entite_uid, $post_id)
    {
        AutorisationGestion::protectionPage("gerer_post");
        // $niveau_administration = AutorisationGestion::niveau_administration();

        
        $now = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s');
        $oneMonthAgo = date('Y-m-d', strtotime("-1 month", strtotime($now)));

        $events = Evenement::where('entite_id', session('entite_id'))
                            ->where('temps_fin', '>', $oneMonthAgo)->get();//On ne montre que les events qui ne sont pas fini ou on terminé il y a moins d'un mois
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
                'description_md' => 'required|min:30|max:2500',
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
            "confidentiel" => $request->confidentialite
        ];

        return $postRequest;
    }

    public function update(Request $request, $entite_uid, $post_id)
    {
        AutorisationGestion::protectionPage("gerer_post");
        $traitement = $this->formulaire_traitement($request);
        $post = Post::find($post_id);
        $post->update($traitement);

        // TAGS
        //Detach previous tags
        $post->tags()->detach();
        //Attach new ones
        if (!empty($request->tags)) {
            $tag_names = array_map('trim', explode(',', $request->tags)); //On sépare par les virgules et on enlève les espaces devant et derrière chaque string

            foreach($tag_names as $tag_name){
                if($tag_name != ""){
                    $tag = Tag::where(DB::raw('lower(name)'), strtolower($tag_name));
    
                    if (!$tag->exists()) {//Si le tag n'existe pas, on le créé
                        Tag::create([                        
                            'name' => ucfirst(strtolower($tag_name)),
                            'couleur' => self::stringToColorCode(strtolower($tag_name))
                        ]);
                    }
    
                    $post->tags()->attach($tag->first()->id);
                }

            }
        }

        //Detach previous campus
        $post->campus()->detach();
        //Attach new ones
        if (!empty($request->campus_id)) {
            foreach ($request->campus_id as $id) {
                $post->campus()->attach($id);
            }
        }

        return redirect(session('entite_uid') . "/entite/post");
    }

    public function delete(Request $request)
    {
        $post_id = $request->route('id');
        AutorisationGestion::protectionPage("gerer_evenement");
        $post = Post::find($post_id)->delete();
        return redirect(session('entite_uid') . "/entite/post");
    }

    public function show(Request $request)
	{
		$niveau_administration = AutorisationGestion::niveau_administration();

		$post = Post::where('id', $request->route('post_id'));

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
