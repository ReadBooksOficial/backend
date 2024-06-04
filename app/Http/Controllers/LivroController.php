<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livro;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class LivroController extends Controller
{

    public function comoCompartilhar(){
        return view('books.como_compartilhar');
    }

    // Lista todos os livros do usuario logado
    public function listarLivros(){
        $user = auth()->user(); //verifica qual usuario esta logado
        $livros = Livro::where('id_usuario', $user->id)->get(); //busca livro pelo usuario
        $quantidadeLivros = Livro::where('id_usuario', $user->id)->where('data_inicio', '!=', null)->count();
        $quantidadeListaDesejo = Livro::where('id_usuario', $user->id)->where('lido', 'não')->where('data_inicio', null)->count();
        $quantidadeLivrosLidos = Livro::where('lido', 'sim')->where('id_usuario', $user->id)->count();

        return view("books.listar_livros", ['livros' => $livros, 'quantidadeLivros' => $quantidadeLivros, 'quantidadeLivrosLidos' => $quantidadeLivrosLidos, 'quantidadeListaDesejo'=> $quantidadeListaDesejo]);
    }

    public function compartilharLivros($user_id){
        // if(auth()->check())
        //     return redirect('/livros');

        $user = User::find($user_id);

        if(!$user){
            return view('errors.404');
        }
        $livros = Livro::where('id_usuario', $user->id)->get(); //busca livro pelo usuario
        $quantidadeLivros = Livro::where('id_usuario', $user->id)->where('data_inicio', '!=', null)->count();
        $quantidadeListaDesejo = Livro::where('id_usuario', $user->id)->where('lido', 'não')->where('data_inicio', null)->count();
        $quantidadeLivrosLidos = Livro::where('lido', 'sim')->where('id_usuario', $user->id)->count();
        $compartilhado = true;

        return view("books.listar_livros", compact('compartilhado', 'user'), ['livros' => $livros, 'quantidadeLivros' => $quantidadeLivros, 'quantidadeLivrosLidos' => $quantidadeLivrosLidos, 'quantidadeListaDesejo'=> $quantidadeListaDesejo]);
    }

    public function compartilharUmLivro($livro_id){
        $user = auth()->user(); //verifica qual usuario esta logado

        $livros = Livro::where('id_livro', $livro_id)
        ->get();

        //caso tenha um livro cadastrado
        if(isset($livros) && $livros != "[]"){
            $livro = $livros[0];
            return view("books.consultar_livro", ['livro' => $livro]);
        }

        else{//caso tenha não um livro cadastrado
            return view("errors/404");
        }
    }

    //busca livro pelo id
    public function consultarLivro(){
        $user = auth()->user(); //verifica qual usuario esta logado

        $livros = Livro::where('id_livro', $_GET['id'])
        ->where('id_usuario', $user->id )
        ->get();

        //caso tenha um livro cadastrado
        if(isset($livros) && $livros != "[]"){
            $livro = $livros[0];
            return view("books.consultar_livro", ['livro' => $livro]);
        }

        else{//caso tenha não um livro cadastrado
            return view("errors/404");
        }
    }

    //pesquisa livro por nome
    public function pesquisarLivro(){
        $user = auth()->user();

        if(!$_GET['livro']){
            return redirect()->route('index');
        }

        $livros = Livro::where('nome_livro', 'LIKE', "%" . $_GET['livro'] . "%")
        ->where('id_usuario', $user->id )
        ->get();
        return view("books.pesquisar_livro", ['livros' => $livros]);
    }

    public function resumo_leitura(){
        $livros = Livro::where('id_usuario', auth()->user()->id)->get();

        return view('books.resumo_leitura', ['livros' => $livros]);
    }

   public function pegarCapaLivro($book_title){
    if(!$book_title){
        return;
    }
        return Livro::where('nome_livro', 'like', "$book_title")->get('img_livro'); //busca livro pelo usuario
   }

    //google api
   public function bookByName($name){
        $book_title = $name; // insira aqui o título do livro que você está procurando
        $capas_cadastradas = ""; //capa dentro do próprio site
        $book_name = $book_title;
        $descricao = "";
        $url_capa = "";
        $page_count = "";

        // Codifica o título do livro para ser usado como parâmetro na URL da API
        $book_title_encoded = urlencode($book_title);
        $language = 'pt'; // Defina o idioma para português


        // Faz a requisição HTTP para a API do Google Books e obtém os dados do livro em formato JSON
        //$url = 'https://www.googleapis.com/books/v1/volumes?q=' . $book_title_encoded;
        $url = "https://www.googleapis.com/books/v1/volumes?q=$book_title_encoded&langRestrict=$language";

        // return $url;
        $json_data = file_get_contents($url);

        // Decodifica os dados JSON em um objeto PHP e obtém a URL da imagem da capa do primeiro livro encontrado (se houver)
        $data = json_decode($json_data);

        if (isset($data->items[0]->volumeInfo->imageLinks)) {
            $book = $data->items[0]->volumeInfo;
            if(isset($book->imageLinks->smallThumbnail)){
                $url_capa = $book->imageLinks->smallThumbnail;
            }

            if(isset($book->title)){
                $book_name = $book->title;
            }

            if(isset($book->description)){
                $descricao = $book->description;
            }

            if(isset($book->pageCount)){
                $page_count = $book->pageCount;
            }

        }
        $capas_cadastradas = Livro::where('nome_livro', 'like', "%$book_title%")->get('img_livro'); //busca livro pelo usuario

        return response()->json(['dados_livro' => $json_data, 'book_name' => $book_name, 'url_capa' => $url_capa, 'url_capas' => $capas_cadastradas, 'descricao' => $descricao, 'page_count' => $page_count]);
   }

    //cadastra livro
    //verifica se há um livro com o nome na API de livros da Google para preecher autotatico
    public function createLivro(Request $request){
        $dados = $request->validate([
            'nome1' => ['required', 'string']
        ]);

        $book_title = $request->nome1; // insira aqui o título do livro que você está procurando
        $capas_cadastradas = ""; //capa dentro do próprio site
        $book_name = $book_title;
        $descricao = "";
        $url_capa = "";
        $page_count = "";

        // Codifica o título do livro para ser usado como parâmetro na URL da API
        $book_title_encoded = urlencode($book_title);
        $language = 'pt'; // Defina o idioma para português


        // Faz a requisição HTTP para a API do Google Books e obtém os dados do livro em formato JSON
        //$url = 'https://www.googleapis.com/books/v1/volumes?q=' . $book_title_encoded;
        $url = "https://www.googleapis.com/books/v1/volumes?q=$book_title_encoded&langRestrict=$language";

        // return $url;
        $json_data = file_get_contents($url);

        // Decodifica os dados JSON em um objeto PHP e obtém a URL da imagem da capa do primeiro livro encontrado (se houver)
        $data = json_decode($json_data);

        if (isset($data->items[0]->volumeInfo->imageLinks)) {
            $book = $data->items[0]->volumeInfo;
            if(isset($book->imageLinks->smallThumbnail)){
                $url_capa = $book->imageLinks->smallThumbnail;
            }

            if(isset($book->title)){
                $book_name = $book->title;
            }

            if(isset($book->description)){
                $descricao = $book->description;
            }

            if(isset($book->pageCount)){
                $page_count = $book->pageCount;
            }

        }

        // $book_name = "jbjihvdhjscdghsfcd";
        $capas_cadastradas = Livro::where('nome_livro', 'like', "%$book_title%")->get('img_livro'); //busca livro pelo usuario

        return view("books.criar_livro", ['dados_livro' => $json_data, 'book_name' => $book_name, 'url_capa' => $url_capa, 'url_capas' => $capas_cadastradas, 'descricao' => $descricao, 'page_count' => $page_count]);
    }

    //salva livro no banco
    public function createLivroDois(Request $request){
        $user = auth()->user();
        try{
            $dados = $request->validate([
                'nome_livro' => ['required', 'string'],
                'descricao_livro' => ['required', 'string']
            ]);

            $livro = Livro::create([
                'img_livro' => $request->img_livro,
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

            return redirect('livros?cad=sucess');
        }
        catch(Exeption $e){
            return redirect('livros?cad=danger');
        }


        return back()->withErrors([
            'descricao_livro' => 'Invalido'
        ]);
    }

    //view para editar livro
    public function editar($id){
        $user = auth()->user(); //verifica qual usuario esta logado

        $livro = Livro::where('id_livro',  $id)
        ->where('id_usuario', $user->id )
        ->get()
        ->first();
        //return view("books.editar", ["livro" => $livro]);

        //caso tenha um livro cadastrado
        if(isset($livro) && $livro != "[]"){
            return view("books.editar", ["livro" => $livro]);
        }

        else{//caso tenha não um livro cadastrado
            return view("errors/404");
        }
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

            $livros = Livro::where('id_livro', $request->id_livro)->get();
            $livro = $livros[0];
            // return view("books.consultar_livro", ['livro' => $livro, 'erro' => $erro])->with('book-update-success', 'Livro editado com sucesso');
            return redirect('/livro?id='.$request->id_livro)->with('book-update-success', 'Livro editado com sucesso');

        }
        catch(Exeption $e){
            // return view("books.consultar_livro", ['livro' => $livro, 'erro' => $erro])->with('book-update-danger', 'Não foi possível editar livro');
            return redirect('/livro?id='.$request->id_livro)->with('book-update-danger', 'Não foi possível editar livro');
        }
    }

    //apaga livro
    public function delete($id){
        try{
            Livro::where('id_livro',  $id)->delete();
            $img_livro = 'img_livros/' . $id . '.png';

            // Verifique se o arquivo existe antes de excluir
            if (Storage::exists($img_livro)) {
                Storage::delete($img_livro);
            }

            return redirect('livros?exc=sucess');
            // return redirect('/livro?exc=sucess')->with('book-delete-success', 'Livro excluido com sucesso');
        }
        catch(Exeption $e){
            return redirect('livros?exc=danger');
            // return redirect('/livro?exc=sucess')->with('book-delete-danger', 'Livro excluido com erro');
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

    // Lista todos os livros do usuario logado
    public function listarLivrosAdmin($id){
        $user = User::where('id', $id)->get()->first(); //verifica qual usuario esta logado
        $livros = Livro::where('id_usuario', $id)->get(); //busca livro pelo usuario
        $quantidadeLivros = Livro::where('id_usuario', $id)->count();
        $quantidadeLivrosLidos = Livro::where('lido', 'sim')->where('id_usuario', $id)->count();

        return view("admin.listar_livros", ['livros' => $livros, 'user' => $user, 'quantidadeLivros' => $quantidadeLivros, 'quantidadeLivrosLidos' => $quantidadeLivrosLidos]);
    }


    public function listarlivrosUsuario($id){
        $user = User::find($id); //verifica qual usuario esta logado
        $livros = Livro::where('id_usuario', $id)->get(); //busca livro pelo usuario
        $quantidadeLivros = Livro::where('id_usuario', $id)->count();
        $quantidadeLivrosLidos = Livro::where('lido', 'sim')->where('id_usuario', $id)->count();

        if($user){
            return view("books.books_user", ['user' => $user, 'livros' => $livros, 'quantidadeLivros' => $quantidadeLivros, 'quantidadeLivrosLidos' => $quantidadeLivrosLidos]);
        }


        return view("errors/404");
    }
}
