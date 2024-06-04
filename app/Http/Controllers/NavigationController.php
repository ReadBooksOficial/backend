<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livro;

class NavigationController extends Controller
{
    //pagina principal
    public function index(){
        $livros = Livro::all();

        //caso esteja logado, mostra os livros da conta
        if(auth()->check()){
            return redirect("livros");
        }

        //caso não esteja logado
        return view("index");
    }

    public function login(){
        return view("conta.login");
    }

    public function register(){
        return view("conta.register");
    }

    public function criarLivro(){
        return view("books.criar_livro");
    }

    //funcao que redireciona usuario para a conta
    public function conta()    {
        $user = auth()->user();
        
        return view('conta.conta', ['user' => $user]);
    }

    public function pageNotFound(){
        return view('page_not_found');
    }
}
