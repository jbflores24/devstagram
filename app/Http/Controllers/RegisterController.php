<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        //dd($request->get('name'));
        $request->request->add(['username' => Str::slug ($request->username)]);//evita error de rotura al validar unique
        $this->validate($request,[
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:20',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed',
        ]);
        User::create([
            'name' => $request->name,
            //'username' => Str::slug ($request->username),
            'username' => $request->username,
            'email' => $request->email,
            'password'=> Hash::make($request->password)
        ]);
        //Autenticar usuario
        //auth()->attempt([
        //    'email' => $request->email,
        //    'password'=> $request->password
        //]);

        //Otra forma de autenticar
        auth()->attempt($request->only('email','password'));

        return redirect()->route('posts.index');
    }
}
