<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class UserController extends Controller
{
    //Funcao que cadastra Usuário
    public function store(Request $request){
        try{
            $request->validate([
                'name' => ['required', 'string', 'max:50'],
                'user_name' => [
                    'required',
                    'string',
                    'max:20',
                    Rule::unique('pacoca.users', 'user_name'),
                    'regex:/^[^@\s?#&%\/:;=\'"{}\[\]\\\\|+]+$/'
                ],
                'email' => ['required', 'string', 'email', 'max:50', Rule::unique('pacoca.users', 'email')],
                'password' => ['required', 'string', 'min:8', 'max:50', 'confirmed'],
                'password_confirmation' => ['required', 'string', 'max:50', 'min:8'],
                'termos' => ['required'],
            ]);
    

            $dados = $request->only(['name', 'user_name', 'email', 'phone', 'password', 'site', 'biography', 'sexo', 'birth_date']);
            $dados['password'] = Hash::make($dados['password']);
            $dados_login = $request->only(['email', 'password']);


            $user = User::create($dados);
            Auth::login($user);
            return redirect('/');

            if($user){
                return redirect()->route('login')->with('conta-create-success', 'Conta criada com sucesso');
            }
            return redirect()->route('login')->with('conta-create-danger', 'Conta criada com erro');

        }catch(Exeption $e){
            return redirect()->route('login')->with('conta-create-danger', 'Conta criada com erro');
        }
        // return redirect()->route('login');
    }

    //Funcao que faz login
    public function login(Request $request){
        $dados = $request->validate([
            'login' => ['required'],
            'password' => ['required']
        ]);
    
        // Verificar se o campo fornecido é um email ou um nome de usuário
        $fieldType = filter_var($dados['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';
    
        // Ajustar os dados para autenticação
        $credentials = [
            $fieldType => $dados['login'], // Usa o tipo de campo detectado
            'password' => $dados['password'],
        ];
    
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('');
        }
    
        return back()->withErrors([
            'password' => 'O email e/ou senha estão inválidos'
        ])->withInput();
    }

    ///Funcao que sai da conta logada
    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    //Veriica se usuário logado é admin
    public function isAdmin(){
        $user = auth()->user();

        if(auth()->check()){
            $admin = Admin::where('idUsuario', $user->id)->get();
            return count($admin);
        }

        return 0;
    }

    //Funcao para listar administradores
    public function listAdmin(){
        //listar usuário que são administrador
        // $usuariosAdmin = User::join('admins', 'users.id', '=', 'admins.idUsuario')
        //     ->select('users.id', 'users.name', 'users.email', 'users.password')
        //     ->get();
        $users = User::select('id', 'name', 'email', 'password')->where("adm", 1)->limit(5)
        ->get();

        return view("admin.listar_admins", ['admins' => $users]);
    }

    //Funcao para listar usuário que não são administradores
    public function listUser(){
        //listar usuário que não são administrador
        // $usuariosNaoAdmin = User::whereNotIn('id', function ($query) {
        //     $query->select('idUsuario')->from('admins');
        // })
        // ->select('id', 'name', 'email', 'password')
        // ->get();

        $users = User::select('id', 'name', 'email', 'password')->limit(5)
        ->get();

        return view("admin.listar_usuarios", ['users' => $users]);
    }

    //apagar usuário
    public function deleteUser($id){
        try{
            $user = User::where('id', $id)->delete();
            return redirect('/consulta?exc=sucess');
        }catch(Exeption $e){
            return redirect('/consulta?exc=danger');
        }
    }

    // AGORA ATUALIZA PELO SITE DO PAÇOCA
    //atualizar usuário
    // public function update(Request $request){
    //     try{

    //         $request->validate([
    //             'name' => ['required', 'string', 'max:255'],
    //             'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(auth()->id())],
    //             'password' => ['required', 'string', 'min:8', 'confirmed'],
    //         ]);


    //         $user = auth()->user();
    //         $erro = 0;

    //         $dados = $request->only(['name', 'email', 'password']);
    //         $dados['password'] = Hash::make($dados['password']);

    //         User::where('id', $request->id)->update($dados);

    //         // return view("conta.conta", ['user' => $user, 'erro' => $erro]);
    //         return redirect()->route('conta')->with('conta-update-success', 'Conta criada com sucesso');
    //     }
    //     catch(Exeption $e){
    //         $erro = 1;
    //         // return view("conta.conta", ['livro' => $livro, 'erro' => $erro]);
    //         return redirect()->route('conta')->with('conta-update-danger', 'Conta criada com sucesso');
    //     }
    // }

    public function chooseColor(Request $request){
        $user = User::find(auth()->user()->id);

        $user->update([
            'primary_color' => $request->primary_color,
        ]);

        return redirect()->route('conta')->with('conta-choose-color-success', '');
    }

    public static function verifyTokenInternal($token)
    {
        if(App::environment('local')){
            return [
                'valid' => false
            ];
        }
        $record = DB::table('user_tokens')->where('token', $token)->first();
        $user = User::find($record->user_id);

        if (!$record) {
            return [
                'valid' => false
            ];
        }

        return [
            'valid' => true,
            'id' => $record->user_id,
            'name' => $user->name ?? null,
            'email' => $email->email ?? null,
            'token_id' => $record->id,
        ];
    }
}
