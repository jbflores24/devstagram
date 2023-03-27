<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function __invoke()
    {
        //obtenenr a quienes seguimos
        //dd(auth()->user()->followings->pluck('id')->toArray());
        $ids = auth()->user()->followings->pluck('id')->toArray();
        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(8);
        return view('home',[
            'posts' => $posts
        ]);
    }
}
