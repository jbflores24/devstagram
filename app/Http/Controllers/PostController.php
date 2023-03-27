<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['show','index']);
    }

    public function index(User $user)
    {   /* Va en el tema 21 del word asi como el paso de parametros post en el arreglo */
        $posts = Post::where('user_id',$user->id)->latest()->paginate(8);
        return view('dashboard',[
            'user'=>$user,
            'posts'=>$posts //De aquí ir a la vista a recibir el valor (dashboard)
        ]);
    }

    public function create(){ //Crea la vista, retorna la vista
        return view ('posts.create');
    }

    public function store(Request $request) //lo almacena en la bd
    {
        $this->validate($request,[
            'titulo' => 'required|max:255',
            'descripcion'=>'required',
            'imagen'=>'required',
        ]);
        /*Post::create(
            [
                'titulo'=>$request->titulo,
                'descripcion'=>$request->descripcion,
                'imagen'=>$request->imagen,
                'user_id'=>auth()->user()->id
            ]
        );*/

        /*Segunda forma de guardar registro
        $post = new Post;
        $post->titulo = $request->titulo;
        $post->descripcion = $request->descripcion;
        $post->imagen = $request->imagen;
        $post->user_id = auth()->user()->id;
        $post->save();
        */

        /* Tercera forma de almacenar registro, pero cuando ya esta creada la relación */
        $request->user()->posts()->create([
            'titulo'=>$request->titulo,
                'descripcion'=>$request->descripcion,
                'imagen'=>$request->imagen,
                'user_id'=>auth()->user()->id
        ]);

        return redirect()->route('posts.index', auth()->user()->username);
    }

    public function show(User $user, Post $post){
        return view ('posts.show',[
            'post'=>$post,
            'user'=>$user
        ]);
    }

    public function destroy(Post $post){
        //dd('Eliminando ',$post->id);
        /*if ($post->user_id === auth()->user()->id)  Se ocupa mejor policy
            dd('si es la misma persona');
        else
            dd('no es la misma persona');*/
        $this->authorize('delete',$post);
        $post->delete();
        $imagen_path = public_path('uploads/'.$post->imagen);
        if (File::exists($imagen_path)){
            unlink($imagen_path);
        }
        return redirect()->route('posts.index', auth()->user()->username);
    }
}
