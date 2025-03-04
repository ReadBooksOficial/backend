<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livro;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Api\GoogleBookApiController;


class LivroController extends Controller
{
    public $language = 'pt-BR';
    private GoogleBookApiController $google_controller; //controle da api do google

    
    public function __construct(){
        $this->google_controller = new GoogleBookApiController();
    }

    public function comoCompartilhar(){
        return view('books.como_compartilhar');
    }

    // Lista todos os livros do usuario logado
    public function listarLivros(){
        $user = auth()->user(); //verifica qual usuario esta logado
        $livros = Livro::where('id_usuario', $user->id)->orderBy('data_inicio', 'desc')->get(); //busca livro pelo usuario
        $quantidadeLivros = Livro::where('id_usuario', $user->id)->where('data_inicio', '!=', null)->count();
        $quantidadeListaDesejo = Livro::where('id_usuario', $user->id)->where('lido', 'não')->where('data_inicio', null)->count();
        $quantidadeLivrosLidos = Livro::where('lido', 'sim')->where('id_usuario', $user->id)->count();

        // verifica se livro tem capa, se nao tive deixa padrao
        foreach ($livros as $livro) {
            $livro->img_livro = $this->verificarImagemLivro($livro->img_livro);
        }

        return view("books.listar_livros", compact('livros', 'quantidadeLivros', 'quantidadeLivrosLidos', 'quantidadeListaDesejo'));
    }

    // verifica se livro tem capa, se nao tive retorna padrao
    public function verificarImagemLivro($img_livro){
        $path = str_replace('../', "", $img_livro);

        // img contem http (api)
        if (strpos($img_livro, 'books.google.com') != false || (file_exists($path) && $path))
            return str_replace("zoom=5", "zoom=6", $img_livro);

        if(!file_exists($path) || !$path)
            return '../img/book_transparent.png';
    }

    public function compartilharLivros($user_id){
        $user = User::find($user_id);

        if(!$user)
            return view('errors.404');

        $livros = Livro::where('id_usuario', $user->id)->orderBy('data_inicio', 'desc')->get(); //busca livro pelo usuario
        $quantidadeLivros = Livro::where('id_usuario', $user->id)->where('data_inicio', '!=', null)->count();
        $quantidadeListaDesejo = Livro::where('id_usuario', $user->id)->where('lido', 'não')->where('data_inicio', null)->count();
        $quantidadeLivrosLidos = Livro::where('lido', 'sim')->where('id_usuario', $user->id)->count();
        $compartilhado = true;

        // verifica se livro tem capa
        foreach ($livros as $livro) {
            $livro->img_livro = $this->verificarImagemLivro($livro->img_livro);
        }

        return view("books.listar_livros", compact('compartilhado', 'user', 'livros', 'quantidadeLivros', 'quantidadeLivrosLidos', 'quantidadeListaDesejo'));
    }

    public function compartilharUmLivro($livro_id){
        $user = auth()->user(); //verifica qual usuario esta logado

        $livro = Livro::where('id_livro', $livro_id)
        ->first();

        if(!isset($livro) || $livro == "[]")
            return view("errors/404");

        $livro->img_livro = $this->verificarImagemLivro($livro->img_livro);

        return view("books.consultar_livro", compact('livro'));
    }

    //busca livro pelo id
    public function consultarLivro($id){
        $user = auth()->user(); //verifica qual usuario esta logado

        $book = Livro::where('id_livro', $id)->first();
        if (!isset($book) || Gate::denies('edit-book', $book)) {
            abort(403, 'Acesso não autorizado');
        }
        
        $livro = Livro::where('id_livro', $id)
        // ->where('id_usuario', $user->id )
        ->first();


        if(!isset($livro) && $livro != "[]")
            return view("errors/404");

        $livro->img_livro = $this->verificarImagemLivro($livro->img_livro);

        return view("books.consultar_livro", compact('livro'));
    }

    //busca livro do google pelo id
    public function googleLivro($id){
        list($livro, $img) = $this->google_controller->getBookById($id); // controller da api do google

        return view("books.api.consultar_livro", compact('livro', 'img'));
    }

    public function createOutroLivro($book_title){
        return view("books.criar_livro", compact('book_title'));
    }

    //pesquisa livro por nome
    public function pesquisarLivro(){
        $user = auth()->user();

        if(!$_GET['livro'])
            return redirect()->route('index');

        $livros = Livro::where('nome_livro', 'LIKE', "%" . $_GET['livro'] . "%")->where('id_usuario', $user->id )->orderBy('data_inicio', 'desc')->get();
        $text =  $_GET['livro'];

        // verifica se livro tem capa, se nao tive deixa padrao
        foreach ($livros as $livro) {
            $livro->img_livro = $this->verificarImagemLivro($livro->img_livro);
        }

        return view("books.pesquisar_livro", compact('livros', 'text'));
    }


    public function resumo_leitura(){
        $livros = Livro::where('id_usuario', auth()->user()->id)->get();

        $countLidos = Livro::where('lido', 'sim')->where('id_usuario', auth()->user()->id)->count();
        $countNaoLidos = Livro::where('data_inicio', '!=' , null)->where('lido', 'não')->where('id_usuario', auth()->user()->id)->count();
        $countListaDesejo = Livro::where('data_inicio', null)->where('lido', 'não')->where('id_usuario', auth()->user()->id)->count();

        return view('books.resumo_leitura', compact('livros', 'countLidos', 'countNaoLidos', 'countListaDesejo'));
    }

   public function pegarCapaLivro($book_title){
    if(!$book_title)
        return;

        $img = Livro::where('nome_livro', 'like', "%" . "$book_title" . "%")->get('img_livro')->first();

        if(!$img)
            return;
        return $this->verificarImagemLivro($img->img_livro);
   }

    //Pesquisa pelo Livro na API do google e lista
    public function createLivro(Request $request){
        $dados = $request->validate([
            'nome1' => ['required', 'string']
        ]);
        $book_title = $request->nome1;

        $livros = $this->google_controller->getBooksByName($book_title);

        return view("books.api.listar_livros", compact('livros', 'book_title'));
    }

    //view para editar livro
    public function editar($id){
        $user = auth()->user(); //verifica qual usuario esta logado

        $livro = Livro::where('id_livro',  $id)
        // ->where('id_usuario', $user->id )
        ->get()
        ->first();

        if(!isset($livro) || $livro == "[]")
            return view("errors/404");

        $livro->img_livro = $this->verificarImagemLivro($livro->img_livro);

        return view("books.editar", compact('livro'));

    }

    //funcao para editar livro
    public function update(Request $request){
        try{
            $dados = $request->validate([
                'nome_livro' => ['required', 'string'],
                'descricao_livro' => ['required', 'string'],
                'total_paginas' => ['required'],
                'paginas_lidas' => ['required'],
                'tempo_lido' => ['required'],
                // 'data_inicio' => ['required'],
                'descricao_livro' => ['required'],
            ]);

            if($request->total_paginas == $request->paginas_lidas){
                $lido = 'sim';
            }else if($request->paginas_lidas < $request->total_paginas || $request->paginas_lidas == 0){
                $lido = 'não';
            }else if($request->paginas_lidas > $request->total_paginas){
                return back()->withErrors(['paginas_lidas' => 'A número de páginas que você leu não pode ser maior que a quantidade total de páginas'])->withInput();
            }

            $book = Livro::where('id_livro', $request->id_livro)->first();
            if (!isset($book) || Gate::denies('edit-book', $book)) {
                abort(403, 'Acesso não autorizado');
            }

            $livro = Livro::where('id_livro', $request->id_livro)
                ->update([
                    'nome_livro' => $request->nome_livro,
                    'img_livro' => $request->img_livro,
                    'lido' => $lido,
                    'total_paginas' => $request->total_paginas,
                    'tempo_lido' => $request->tempo_lido,
                    'paginas_lidas' => $request->paginas_lidas,
                    'descricao_livro' => $request->descricao_livro,
                    'data_inicio' => $request->data_inicio,
                    'data_termino' => $request->data_termino,
                    'show_in_pacoca' => $request->has("show_in_pacoca"),
                ]);
                

            // CASO USUÁRIO ESCOLHA IMAGEM DO LIVRO
            if ($request->hasFile('img_livro_usuario')) {
                if ($request->file('img_livro_usuario')->isValid()) {
                    $img = $request->img_livro_usuario;
                    $imgName = $request->id_livro . ".png";
                    $path = public_path('img_livros');

                    $request->img_livro_usuario->move($path, $imgName);

                    Livro::where('id_livro', $request->id_livro)->update([
                        'img_livro' => '../img_livros/' . $imgName,
                    ]);

                }
            }

            // $livros = Livro::where('id_livro', $request->id_livro)->get();
            // $livro = $livros[0];

            return redirect("/livro/$request->id_livro")->with('success', 'Livro editado com sucesso');

        }
        catch(Exeption $e){
            return redirect("/livro/$request->id_livro")->with('danger', 'Não foi possível editar livro');
        }
    }

    //apaga livro
    public function delete($id){
        try{
            $book = Livro::where('id_livro', $id)->first();
            if (!isset($book) || Gate::denies('edit-book', $book)) {
                abort(403, 'Acesso não autorizado');
            }

            Livro::where('id_livro',  $id)->delete();
            $img_livro = 'img_livros/' . $id . '.png';

            // Verifique se o arquivo existe antes de excluir
            if (Storage::exists($img_livro))
                Storage::delete($img_livro);

            return redirect('/livros')->with('success', 'Livro excluido com sucesso');
        }
        catch(\Exception $e){
            return redirect('/livros')->with('danger', 'Erro ao excluir livro');
        }
    }

    public function filtrar(Request $request){
        $filtro = $request->input('filtro');
        $user = auth()->user(); //verifica qual usuario esta logado

        // Lógica para filtrar os livros com base na opção selecionada
        if ($filtro == 'todos') {
            return redirect('/');
        }
        elseif ($filtro == 'lidos') {
            $livros = Livro::where('lido', 'sim')->where('id_usuario', $user->id)->get();
        } elseif ($filtro == 'nao_lidos') {
            $livros = Livro::where('lido', 'não')->where('id_usuario', $user->id)->where('data_inicio', '!=' , '')->get();
        } elseif ($filtro == 'lista_desejo') {
            $livros = Livro::where('data_inicio', null)->where('lido', 'não')->where('id_usuario', $user->id)->get();
        } else {
            $livros = Livro::all()->where('id_usuario', $user->id);
        }


        $quantidadeLivros = Livro::where('id_usuario', $user->id)->count();
        $quantidadeLivrosLidos = Livro::where('lido', 'sim')->where('id_usuario', $user->id)->count();

        return view("books.listar_livros", ['livros' => $livros, 'quantidadeLivros' => count($livros), 'quantidadeLivrosLidos' => count($livros)]);
    }

    public function adicionarLeitura(Request $request){
        $user = auth()->user();
        try{
            $dados = $request->validate([
                'nome_livro' => ['required', 'string'],
                'descricao_livro' => ['required', 'string']
            ]);

            $livro = Livro::create([
                'img_livro' => $request->img_livro,
                'id_livro_google' => $request->id_livro_google,
                'id_usuario' => $user->id,
                'nome_livro' => $request->nome_livro,
                'descricao_livro' => $request->descricao_livro,
                'lido' => 'não',
                'tempo_lido' => '0 dias',
                'paginas_lidas' => 0,
                'total_paginas' => $request->pagina_total,
                'data_inicio' => $request->data_inicio,
                'data_termino' => $request->data_termino,
            ]);

            if($request->img_google){
                Livro::where('id_livro', $livro->id_livro)->update([
                    'img_livro' => $request->img_google,
                ]);
            }

            // CASO USUÁRIO ESCOLHA IMAGEM DO LIVRO
            if ($request->hasFile('img_livro_usuario')) {
                if ($request->file('img_livro_usuario')->isValid()) {
                    $img = $request->img_livro_usuario;
                    $imgName = $livro->id_livro . ".png";
                    $path = public_path('img_livros');

                    $request->img_livro_usuario->move($path, $imgName);

                    Livro::where('id_livro', $livro->id_livro)->update([
                        'img_livro' => '../img_livros/' . $imgName,
                    ]);

                }
            }

            return redirect("/livro/$livro->id_livro")->with('success', 'Livro cadastrado');
        }
        catch(Exeption $e){
            return back()->with('danger', 'Erro ao cadastrar livro');
        }
    }
}
