<?php

namespace App\Http\Controllers;

use App\Enums\Permisions;
use App\Models\Post;
use App\Models\Evenement;
use Illuminate\Http\Request;
use \App\Services\AutorisationGestion;
use App\Models\Site;
use App\Models\Entite;
use App\Models\Event;
use App\Services\FileService;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    static $tag_colors = ["3240BD", "E14545", "4FCA63", "43A8A8", "63092C", "CF9F23", "1b4426", "264d91", "831d64", "422977", "0e6e69", "bf6a18", "C12816", "5c75a7", "661664", "438949", "104547", "494993", "346a58", "a9363b", "D7263D", "1d8ed5", "871c5b", "32965D", "6a3351", "31676a", "27345c", "53409b", "af2f80", "414361", "4c5c2e"];
    /*static function stringToColorCode($str)
    {
        $code = crc32($str);

        $color = self::$tag_colors[$code % count(self::$tag_colors)];

        return '#' . $color;
    }

    public static function getVisiblePostsByCampus($sites){
        $now = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s');
        
        $posts = $sites->posts->where('published_at', '<', $now)
                               ->filter(function($post){
                                    $now = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s');
                                    if(!$post->archived_at || $post->archived_at > $now)
                                        return $post;
                                })
                               ->sortByDesc('published_at');

        return $posts;
    }

    public function accueil($site = null)
    {
        $sites = Site::getFromLabel($site);

        // On récupère seulement les 10 derniers posts du site
        $posts = PostController::getVisiblePostsByCampus($sites);
        $allPostsVisible = count($posts) <= 10;
        $posts = $posts->take(10);
        
        // On regarde si l'utilisateur à ce site en tant que campus
        $canSeeConfidentiel = false;
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->campus->contains($sites)) {
                $canSeeConfidentiel = true;
            }
        }

        return view('accueil')
                ->with('posts', $posts)
                ->with('site', $sites->label)
                ->with('allPostsVisible', $allPostsVisible)
                ->with('canSeeConfidentiel', $canSeeConfidentiel);
    }*/

/*    public function posts($site = null)
    {
        $sites = Site::getFromLabel($site);
        // On récupère seulement les 10 derniers posts du site
        $posts = PostController::getVisiblePostsByCampus($sites);
        
        // On regarde si l'utilisateur à ce site en tant que campus
        $canSeeConfidentiel = false;
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->campus->contains($sites)) {
                $canSeeConfidentiel = true;
            }
        }

        return view('post.posts')->with('posts', $posts)->with('site', $sites->label)->with('canSeeConfidentiel', $canSeeConfidentiel);
    }*/

    /*static function published_at_to_duration($published_at){
        $now = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s');
        $nbSeconds = strtotime($now) - strtotime($published_at);

        $result = "";

        //Prefix
        if ($nbSeconds > 0) $result = "Il y a ";
        else if ($nbSeconds < 0) $result = "Apparaitra dans ";
        else return "A l'instant";

        $nbSeconds = abs($nbSeconds);

        //Number
        if($nbSeconds < 60) $result = $result . $nbSeconds . "s";
        else if($nbSeconds/60 < 60)  $result = $result . floor($nbSeconds/60) . "min";
        else if($nbSeconds/(60*60) < 24)  $result = $result . floor($nbSeconds/(60*60)) . "h";
        else $result = $result .  floor($nbSeconds/(60*60*24)) . "j";

        return $result;
    }*/

    public function index_entite(Request $request)
    {
        AutorisationGestion::require(Permisions::POST_MANAGE,$request['entite_uid']);

        $posts = Post::where('entite_uid', $request['entite_uid'])->orderBy('published_at', 'desc')->get();

        return view('post.index_entite')->with([
            'posts' => $posts
        ]);
    }

    public function create(Request $request){
        AutorisationGestion::require(Permisions::POST_MANAGE,$request['entite_uid']);

        $now = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s');
        $oneMonthAgo = date('Y-m-d', strtotime("-1 month", strtotime($now)));
        
        $events = Event::all();//Evenement::where('entite_uid', $request['entite_uid'])
        //                    ->where('temps_fin', '>', $oneMonthAgo)->get();//On ne montre que les events qui ne sont pas fini ou on terminé il y a moins d'un mois
        $sites = Site::all();
        $entites = Entite::where('uid','!=',$request['entite_uid'])->get();//On récupére toutes les assos sauf celles dont on crée le post
        $my_entite = Entite::find($request['entite_uid']);
        return view('post.formulaire', [
            'title' => 'Créer un post',
            'events' => $events,
            'sites' => $sites,
            'entites' => $entites,
            'my_entite' => $my_entite
        ]);
    }

    public function store(Request $request){
        AutorisationGestion::require(Permisions::POST_MANAGE,$request['entite_uid']);
                
        $postRequest = $this->formulaire_traitement($request,$request['entite_uid']);
        
        if($request['post_uid']){
            $post = Post::findOrFail($request['post_uid']);
            $post->update($postRequest);
        }else{
            $post = Post::create($postRequest);
        }
    
        if($request->has('banniere')){
            FileService::validation_img($request->banniere);
            $post->banner_uid = FileService::upload($request->banniere,"logo_entites","public",["acces"=>'public']);
        }

        $json_data = ["acces"=>"certifie","acces_details"=> ["cards"=> [],"groups"=> [],"users"=> [],"membres"=> [],"sites"=> []]];
        
        if (!empty($request->campus_id)) {
            foreach ($request->campus_id as $id) {
                array_push($json_data["acces_details"]["sites"],["id"=>$id,"notify"=>true]);
            }
        }
        $post->json_data = $json_data;
        $post->save();

        $post->refresh();
        //Detach previous collabs
        $post->entite_collab()->detach();
        //Attach new ones
        if (!empty($request->entite_collab_id)) {
            $post->entite_collab()->syncWithoutDetaching($request->entite_collab_id);
        }
        
        return redirect('entite/' . $request['entite_uid'] . '/dashboard/post');
    }
    function stripAccents($str) {
        return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }

    public function edit($entite_uid, $post_uid)
    {
        AutorisationGestion::require(Permisions::POST_MANAGE,$entite_uid);
        
        $now = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s');
        $oneMonthAgo = date('Y-m-d', strtotime("-1 month", strtotime($now)));

        $events = Event::where('entite_uid', $entite_uid)->where('ended_at', '>', $oneMonthAgo)->get();//On ne montre que les events qui ne sont pas fini ou on terminé il y a moins d'un mois
        $sites = Site::all();
        $post = Post::findOrFail($post_uid);
        $entites = Entite::where('uid','!=',$entite_uid)->get();//On récupére toutes les assos sauf celles dont on crée le post

        $my_entite = Entite::find($entite_uid);
        return view('post.formulaire', [
            'title' => 'Modifier le post',
            'events' => $events,
            'sites' => $sites,
            'post' => $post,
            'entites' => $entites,
            'my_entite' => $my_entite
        ]);
    }

    public function delete(Request $request)
    {
        AutorisationGestion::require(Permisions::POST_MANAGE,$request['entite_uid']);
        $post = Post::findOrFail($request['post_uid']);
        if($post->entite?->uid!=$request['entite_uid']){
            abort(403);
        }
        $post->delete();
        return redirect()->back();
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

        $canSeePost = false;
		if (!$post->confidentiel) {
			$canSeePost = true;
		}
		else {
			if (Auth::check()) {
				$user = Auth::user();
				$sites = $post->campus;
				foreach ($sites as $site)
					if ($user->campus->contains($site)) {
							$canSeePost = true;
					}
			}
		}

        $now = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s');
        if($post->archived_at) {
            $postIsVisible = $now > $post->published_at && $now < $post->archived_at;
        } else {
            $postIsVisible = $now > $post->published_at;
        }

		return view('post.show-post', [
			'post' => $post,
			'entite' => $entite,
			'gerer_post' => AutorisationGestion::gestion("gerer_post"),
            'canSeePost' => $canSeePost,
            'postIsVisible' => $postIsVisible
		]);
	}



    public function formulaire_traitement(Request $request,$entite_uid){
        if($request['post_uid']){
            $post = Post::findOrFail($request['post_uid']);
            if($post->entite->uid != $entite_uid && !in_array($entite_uid, $post->entite_collab()->pluck("uid"))){
                abort(403);
            }
        }
        

        $validated = $request->validate(
            [
                'title' => 'required|max:128',
                'description_md' => 'required|min:10|max:2500',
                'event_uid' => 'nullable',
                'published_at' => 'nullable|date',
                'archived_at' => 'nullable|date|after:published_at',
                'entite_collab_id' => 'nullable',
            ]
        );

        $postRequest = [
            "entite_uid" => $entite_uid,
            "title" => $request->title,
            "content" => $request->description_md,
            "tags" => $request->tags,
            "plublished_at" => $request->plublished_at ? $request->plublished_at : (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d\TH:i'),
            "archived_at" => $request->archived_at,
            "event_uid" => $request->event_uid == 0 ? null : $request->event_uid,
        ];
        return $postRequest;
    }
}

