<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livro;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{

    public function return_book_iduser($id_user){
        return Livro::where('id_usuario', $id_user)->get(); //busca livro pelo usuario
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Autenticação bem-sucedida, gera e retorna um token JWT
            $token = auth()->user()->createToken('ReadBookAppToken')->accessToken;
            
            return response()->json(['token' => $token], 200);
        } else {
            // Autenticação falhou
            return response()->json(['error' => 'Credenciais inválidas'], 401);
        }
    }

}