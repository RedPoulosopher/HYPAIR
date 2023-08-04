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
}
