<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function accueil()
    {
        $posts = Post::all();
        return view('accueil')->with('posts', $posts);
    }

    public function store(Request $request)
    {
        // ajouter une authorization dans un service (voir eventcontrolelr)
        // ajouter un traitement post-validation (à voir) dans un PostServcie
        // Post::create($request);
    }
}
