<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request, Post $post){
        $post->likes()->create([
            'user_id' => $request->user()->id
        ]);
        return back();
    }

    public function destroy(Request $request, Post $post){
        //se establece primero la relación en el modelo user y se le pone likes
        $request->user()->likes()->where('post_id', $post->id)->delete();
        return back();
    }
}
