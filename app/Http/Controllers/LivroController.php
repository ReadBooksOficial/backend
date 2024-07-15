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
    public $language = 'pt-BR';

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

        $livro = Livro::where('id_livro', $id)
        ->where('id_usuario', $user->id )
        ->first();

        if(!isset($livro) && $livro != "[]")
            return view("errors/404");

        $livro->img_livro = $this->verificarImagemLivro($livro->img_livro);

        return view("books.consultar_livro", compact('livro'));
    }

    //busca livro pelo id
    public function googleLivro($id){
        list($livro, $img) = $this->getGoogleBookById($id);

        return view("books.api.consultar_livro", compact('livro', 'img'));
    }

    public function getGoogleBookById($id){
        $url = "https://www.googleapis.com/books/v1/volumes/$id";
        $json_data = file_get_contents($url);

        $livro = json_decode($json_data);

        if ($livro === null)
            die('Error decoding JSON data.');

        // $img = $livro->volumeInfo->imageLinks->medium ?? '../img/book_transparent.png';


        // if($img == '../img/book_transparent.png' || $dimensions['width'] > 1)
        //     $img = $livro->volumeInfo->imageLinks->thumbnail ?? '../img/book_transparent.png';

        // if($img == '../img/book_transparent.png' || $dimensions['width'] == 200)
        $img = $livro->volumeInfo->imageLinks->smallThumbnail ?? '../img/book_transparent.png';
        // verifica se livro tem capa, se nao tive deixa padrao
        $img = $this->verificarImagemLivro($livro->volumeInfo->imageLinks->smallThumbnail);

        return [$livro, $img];
    }

    public function createOutroLivro($book_title){
        $img = $this->pegarCapaLivro($book_title);
        return view("books.criar_livro", compact('book_title', 'img'));
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
        return $this->verificarImagemLivro($img->img_livro);
   }

    //google api
   public function bookByName($name){
        $data = $this->getGoogleBookByName($name);

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

   public function getGoogleBookByName($name){
        $book_title = $name; // insira aqui o título do livro que você está procurando
        $capas_cadastradas = ""; //capa dentro do próprio site
        $book_name = $book_title;
        $descricao = "";
        $url_capa = "";
        $page_count = "";

        // Codifica o título do livro para ser usado como parâmetro na URL da API
        // $book_title_encoded = urlencode($book_title);
        $book_title_encoded = str_replace(' ', '+', $book_title);

        // Faz a requisição HTTP para a API do Google Books e obtém os dados do livro em formato JSON
        //$url = 'https://www.googleapis.com/books/v1/volumes?q=' . $book_title_encoded;
        $url = "https://www.googleapis.com/books/v1/volumes?q=$book_title_encoded&langRestrict=$this->language";

        // return $url;
        $json_data = file_get_contents($url);

        // Decodifica os dados JSON em um objeto PHP e obtém a URL da imagem da capa do primeiro livro encontrado (se houver)
        return json_decode($json_data);
   }

    //cadastra livro
    //verifica se há um livro com o nome na API de livros da Google para preecher autotatico
    public function createLivro(Request $request){
        $dados = $request->validate([
            'nome1' => ['required', 'string']
        ]);

        $book_title = $request->nome1;
        // $book_title_encoded = urlencode($book_title);
        $book_title_encoded = str_replace(' ', '+', $book_title);

        $url = "https://www.googleapis.com/books/v1/volumes?q=$book_title_encoded&langRestrict=$this->language";
        $json_data = file_get_contents($url);

        $livros = json_decode($json_data);

        // return $livros;

        return view("books.api.listar_livros", compact('livros', 'book_title'));
    }

    //salva livro no banco
    // public function createLivroDois(Request $request){
    //     $user = auth()->user();
    //     try{
    //         $dados = $request->validate([
    //             'nome_livro' => ['required', 'string'],
    //             'descricao_livro' => ['required', 'string']
    //         ]);

    //         $livro = Livro::create([
    //             'img_livro' => $request->img_livro,
    //             'id_usuario' => $user->id,
    //             'nome_livro' => $request->nome_livro,
    //             'descricao_livro' => $request->descricao_livro,
    //             'lido' => 'não',
    //             'tempo_lido' => '0 dias',
    //             'paginas_lidas' => 0,
    //             'total_paginas' => $request->pagina_total,
    //             'data_inicio' => $request->data_inicio,
    //             'data_termino' => $request->data_termino,
    //         ]);

    //         // CASO USUÁRIO ESCOLHA IMAGEM DO LIVRO
    //         if ($request->hasFile('img_livro_usuario')) {
    //             if ($request->file('img_livro_usuario')->isValid()) {
    //                 $img = $request->img_livro_usuario;
    //                 $imgName = $livro->id_livro . ".png";
    //                 $path = public_path('img_livros');

    //                 $request->img_livro_usuario->move($path, $imgName);

    //                 Livro::where('id_livro', $livro->id_livro)->update([
    //                     'img_livro' => '../img_livros/' . $imgName,
    //                 ]);

    //             }
    //         }

    //         return redirect('livros?cad=sucess');
    //     }
    //     catch(Exeption $e){
    //         return redirect('livros?cad=danger');
    //     }
    // }

    //view para editar livro
    public function editar($id){
        $user = auth()->user(); //verifica qual usuario esta logado

        $livro = Livro::where('id_livro',  $id)
        ->where('id_usuario', $user->id )
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

            return redirect("/livro/ $request->id_livro")->with('success', 'Livro editado com sucesso');

        }
        catch(Exeption $e){
            return redirect("/livro/ $request->id_livro")->with('danger', 'Não foi possível editar livro');
        }
    }

    //apaga livro
    public function delete($id){
        try{
            Livro::where('id_livro',  $id)->delete();
            $img_livro = 'img_livros/' . $id . '.png';

            // Verifique se o arquivo existe antes de excluir
            if (Storage::exists($img_livro))
                Storage::delete($img_livro);

            return redirect('/livros')->with('success', 'Livro excluido com sucesso');
        }
        catch(Exeption $e){
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
