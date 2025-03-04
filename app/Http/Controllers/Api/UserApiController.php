<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;

class UserApiController extends Controller
{
    // Login
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            // Verificar se o campo fornecido é um email ou um nome de usuário
            $fieldType = filter_var($credentials['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';
        
            // Ajustar os dados para autenticação
            $credentials = [
                $fieldType => $credentials['email'], // Usa o tipo de campo detectado
                'password' => $credentials['password'],
            ];

            if (Auth::attempt($credentials)) {
                $user = auth()->user();
                $token = JWTAuth::fromUser($user); // Gera o token JWT  

                $ip = request()->ip();
                $ip = json_decode(file_get_contents("https://api64.ipify.org?format=json"), true)['ip'];
                $location = json_decode(file_get_contents("http://ip-api.com/json/$ip"), true);

                
               // Armazena o token no banco de dados
                DB::table('pacoca.user_tokens')->insert([
                    'user_id' => $user->id,
                    'token' => $token,
                    'ip_address' => $ip,
                    'country' => $location['country'] ?? null,
                    'region_name' => $location['regionName'] ?? null,
                    'city' => $location['city'] ?? null,
                    'user_agent' => request()->header('User-Agent'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return response()->json([
                    'token' => $token,
                    'token_type' => 'Bearer',
                    'user' => [
                        'id' => $user->id,
                        'user_name' => $user->user_name,
                        'name' => $user->name,
                        'img_account' => $user->img_account,
                        'token' => $token,
                        'email' => $user->email,
                    ]
                ]);
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
                'password' => ['required', 'string', 'min:8']
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

            $user = $request->user();
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user)],
                'password' => ['required', 'string', 'min:8'],
            ]);

            $dados = $request->only(['name', 'email', 'password']);
            $dados['password'] = Hash::make($dados['password']);

            User::where('id', $request->id)->update($dados);
            $user = User::where('id', $request->id)->first();

            return response()->json(['user' => [ 'name' => $user->name,'email' => $user->email,'id' => $user->id,],], 200);
        }
        catch(Exeption $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
