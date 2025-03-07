<?php

namespace App\Http\Controllers;

use App\Models\Banniere;
use App\Models\Post;
use App\Models\Evenement;
use App\Services\BanniereService;
use Illuminate\Http\Request;
use \App\Services\AutorisationGestion;
use App\Models\Site;
use App\Models\Entite;
use App\Models\Tag;
use App\Models\PostCollab;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Auth;

use DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    static $tag_colors = ["3240BD", "E14545", "4FCA63", "43A8A8", "63092C", "CF9F23", "1b4426", "264d91", "831d64", "422977", "0e6e69", "bf6a18", "C12816", "5c75a7", "661664", "438949", "104547", "494993", "346a58", "a9363b", "D7263D", "1d8ed5", "871c5b", "32965D", "6a3351", "31676a", "27345c", "53409b", "af2f80", "414361", "4c5c2e"];
    static function stringToColorCode($str)
    {
        $code = crc32($str);

        $color = self::$tag_colors[$code % count(self::$tag_colors)];

        return '#' . $color;
    }

    public static function getVisiblePostsByCampus($campus){
        $now = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s');
        
        $posts = $campus->posts->where('date_apparition', '<', $now)
                               ->filter(function($post){
                                    $now = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s');
                                    if(!$post->date_expiration || $post->date_expiration > $now)
                                        return $post;
                                })
                               ->sortByDesc('date_apparition');

        return $posts;
    }

    public function accueil($site = null)
    {
        $campus = Site::getFromLabel($site);

        // On récupère seulement les 10 derniers posts du site
        $posts = PostController::getVisiblePostsByCampus($campus);
        $allPostsVisible = count($posts) <= 10;
        $posts = $posts->take(10);
        
        // On regarde si l'utilisateur à ce site en tant que campus
        $canSeeConfidentiel = false;
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->campus->contains($campus)) {
                $canSeeConfidentiel = true;
            }
        }

        return view('accueil')
                ->with('posts', $posts)
                ->with('site', $campus->label)
                ->with('allPostsVisible', $allPostsVisible)
                ->with('canSeeConfidentiel', $canSeeConfidentiel);
    }

    public function posts($site = null)
    {
        $campus = Site::getFromLabel($site);
        // On récupère seulement les 10 derniers posts du site
        $posts = PostController::getVisiblePostsByCampus($campus);
        
        // On regarde si l'utilisateur à ce site en tant que campus
        $canSeeConfidentiel = false;
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->campus->contains($campus)) {
                $canSeeConfidentiel = true;
            }
        }

        return view('post.posts')->with('posts', $posts)->with('site', $campus->label)->with('canSeeConfidentiel', $canSeeConfidentiel);
    }

    static function date_apparition_to_duration($date_apparition){
        $now = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s');
        $nbSeconds = strtotime($now) - strtotime($date_apparition);

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
        $entites = Entite::where('id','!=',session('entite_id'))->get();//On récupére toutes les assos sauf celles dont on crée le post

        return view('post.formulaire', [
            'titre' => 'Créer un post',
            'events' => $events,
            'campus' => $sites,
            'entites' => $entites
        ]);
    }

    public function store(Request $request)
    {
        AutorisationGestion::protectionPage('gerer_post');
                
        $postRequest = $this->formulaire_traitement($request);
        
        $post = Post::create($postRequest);
        
        if($request->banniere) {
            for($i = 0; $i < count($request->banniere); $i++) {
                $file = $request->banniere[$i];
                // $filename = $i . '_' . time() . '.' . $request->banniere[$i]->extension();
                // $path = $file->storeAs('images/posts/'.$post->id, $filename);
                $path = BanniereService::stockerBanniere($file, $post, $i);
                $banniere = new Banniere();
                $banniere->path = $path;
                // voir la méthode saveMany pour améliorer le code
                $post->bannieres()->save($banniere);      
            }

        }
        //Detach previous collabs
        $post->entite_collab()->detach();
        //Attach new ones
        if (!empty($request->entite_collab_id)) {
			foreach ($request->entite_collab_id as $id) {
				$post->entite_collab()->attach($id);
			}
		}
        
        
        // TAGS
        if (!empty($request->tags)) {
            $tag_names = array_map('trim', explode(',', $request->tags)); //On sépare par les virgules et on enlève les espaces devant et derrière chaque string

            foreach($tag_names as $tag_name){
                if($tag_name != ""){
                    
                    //Collate pour ne pas prendre en compte les majuscules et les accents
                    $tag = Tag::whereRaw("lower(name) like '$tag_name' collate utf8mb4_unicode_ci");
    
                    if (!$tag->exists()) {//Si le tag n'existe pas, on le créé
                        $tag = Tag::create([                        
                            'name' => ucfirst(strtolower($tag_name)),
                            'couleur' => self::stringToColorCode(strtolower($tag_name))
                        ]);
                        $post->tags()->attach($tag->id);
                    }else{

                        $post->tags()->attach($tag->first()->id);
                    }
    
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
    function stripAccents($str) {
        return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }

    public function edit($entite_uid, $post_id)
    {
        AutorisationGestion::protectionPage("gerer_post");
    
        // $tag = Tag::where(DB::raw('lower(name)'), mb_strtolower($tag_name, 'UTF-8'));

        // $niveau_administration = AutorisationGestion::niveau_administration();
        
        $now = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s');
        $oneMonthAgo = date('Y-m-d', strtotime("-1 month", strtotime($now)));

        $events = Evenement::where('entite_id', session('entite_id'))
                            ->where('temps_fin', '>', $oneMonthAgo)->get();//On ne montre que les events qui ne sont pas fini ou on terminé il y a moins d'un mois
        $sites = Site::all();
        $post = Post::find($post_id);
        $entites = Entite::where('id','!=',session('entite_id'))->get();//On récupére toutes les assos sauf celles dont on crée le post

        $all_post_campus_id = [];
        foreach($post->campus as $campus) {
            array_push($all_post_campus_id, $campus->id);
        }

        return view('post.formulaire', [
            'titre' => 'Modifier le post',
            'events' => $events,
            'campus' => $sites,
            'post' => $post,
            'all_post_campus_id' => $all_post_campus_id,
            'entites' => $entites
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
                // 'entite_collab_id' => 'nullable',
            ]
        );

        $postRequest = [
            "entite_id" => session('entite_id'),
            "titre" => $request->titre,
            "description" => $request->description_md,
            "date_apparition" => $request->date_apparition ? $request->date_apparition : new DateTime('now', new DateTimeZone('Europe/Paris')),
            "date_expiration" => $request->date_expiration,
            "event_id" => $request->event_id == 0 ? null : $request->event_id,
            "confidentiel" => $request->confidentialite,
            // "entite_collab_id" => $request-> entite_collab_id == 0 ? null : $request->entite_collab_id,
        ];

        return $postRequest;
    }

    public function update(Request $request, $entite_uid, $post_id)
    {
        AutorisationGestion::protectionPage("gerer_post");
        $traitement = $this->formulaire_traitement($request);
        $post = Post::find($post_id);
        $post->update($traitement);


        if ($request->checkbox_banniere) {
            foreach($post->bannieres as $banniere) {
                Storage::delete($banniere->path);
                $banniere->delete();
            }

            if($request->banniere) {
                for($i = 0; $i < count($request->banniere); $i++) {
                    $file = $request->banniere[$i];
                    $path = BanniereService::stockerBanniere($file, $post, $i);
                    $banniere = new Banniere();
                    $banniere->path = $path;
                    // voir la méthode saveMany pour améliorer le code
                    $post->bannieres()->save($banniere);
                }
            }
        }

        // TAGS
        //Detach previous tags
        $post->tags()->detach();
        //Attach new ones
        if (!empty($request->tags)) {
            $tag_names = array_map('trim', explode(',', $request->tags)); //On sépare par les virgules et on enlève les espaces devant et derrière chaque string

            foreach($tag_names as $tag_name){
                if($tag_name != ""){
                    
                    //Collate pour ne pas prendre en compte les majuscules et les accents
                    $tag = Tag::whereRaw("lower(name) like '$tag_name' collate utf8mb4_unicode_ci");
    
                    if (!$tag->exists()) {//Si le tag n'existe pas, on le créé
                        $tag = Tag::create([                        
                            'name' => ucfirst(strtolower($tag_name)),
                            'couleur' => self::stringToColorCode(strtolower($tag_name))
                        ]);
                        $post->tags()->attach($tag->id);

                    }else{
                        $post->tags()->attach($tag->first()->id);
                    }
    
                }

            }
        }
        
        //Detach previous collabs
        $post->entite_collab()->detach();
        //Attach new ones
        if (!empty($request->entite_collab_id)) {
			foreach ($request->entite_collab_id as $id) {
				$post->entite_collab()->attach($id);
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
        AutorisationGestion::protectionPage("gerer_post");
        $post = Post::find($post_id);
        foreach($post->bannieres as $banniere) {
            Storage::delete($banniere->path);
            $banniere->delete();
        }
        $post->delete();
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

        $canSeePost = false;
		if (!$post->confidentiel) {
			$canSeePost = true;
		}
		else {
			if (Auth::check()) {
				$user = Auth::user();
				$campus = $post->campus;
				foreach ($campus as $site)
					if ($user->campus->contains($site)) {
							$canSeePost = true;
					}
			}
		}

        $now = (new DateTime(null, new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s');
        if($post->date_expiration) {
            $postIsVisible = $now > $post->date_apparition && $now < $post->date_expiration;
        } else {
            $postIsVisible = $now > $post->date_apparition;
        }

		return view('post.show-post', [
			'post' => $post,
			'entite' => $entite,
			'gerer_post' => AutorisationGestion::gestion("gerer_post"),
            'canSeePost' => $canSeePost,
            'postIsVisible' => $postIsVisible
		]);
	}
}
