<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserApiController extends Controller
{
    // Login
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = User::where('email', $request->email)->first();

                // Autenticação bem-sucedida, gera e retorna um token JWT
                $token = auth()->user()->createToken('ReadBookAppToken')->accessToken;

                return response()->json([
                    'token' => $token,
                    'user' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'id' => $user->id,
                    ],
                ], 200);
            } else {
                // Autenticação falhou
                return response()->json(['message' => 'Email e/ou senha invalidos'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    //Funcao que cadastra Usuário
    public function register(Request $request){
        try{
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed']
            ]);

            $dados = $request->only(['name', 'email', 'password']);
            $dados['password'] = Hash::make($dados['password']);

            $user = User::create($dados);
            if($user)
                return response()->json(['user' => [ 'name' => $user->name,'email' => $user->email,'id' => $user->id,],], 201);

            return response()->json(['message' => "Erro ao criar conta, tente novamente mais tarde"], 500);

        }catch(Exeption $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    
    //atualizar usuário
    public function update(Request $request){
        try{

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(auth()->id())],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $user = auth()->user();
            $erro = 0;

            $dados = $request->only(['name', 'email', 'password']);
            $dados['password'] = Hash::make($dados['password']);

            User::where('id', $request->id)->update($dados);

            return response()->json(['user' => [ 'name' => $user->name,'email' => $user->email,'id' => $user->id,],], 200);
        }
        catch(Exeption $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
