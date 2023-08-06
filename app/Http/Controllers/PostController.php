<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

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
        return view('post.home');
    }

    public function store(Request $request)
    {
        // ajouter une authorization dans un service (voir eventcontrolelr)
        // ajouter un traitement post-validation (à voir) dans un PostServcie
        // Post::create($request);
    }
}
