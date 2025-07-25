<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GoogleBooksController extends Controller
{
    public $langRestrict = 'pt-BR';
    private $key = 'AIzaSyDG9HavA17iFwucNnObsHy4qWzwMGhz9ME';
    public BooksController $book_controller; //livro controller

    public function getBooksByName($book_title) {
        // Codifica o título do livro para ser usado como parâmetro na URL da API
        $book_title_encoded = str_replace(' ', '+', $book_title);

        // Faz a requisição HTTP para a API do Google Books e obtém os dados do livro em formato JSON
        $url = "https://www.googleapis.com/books/v1/volumes?q=$book_title_encoded&langRestrict=$this->langRestrict&key=$this->key";

        $json_data = file_get_contents($url);

        // Decodifica os dados JSON em um objeto PHP
        $data = json_decode($json_data);

        return response()->json($data, 200);
    }

    public function addToRead(Request $request, $id){
        try{
            $user = $request->user();
            if(!$user) 
                return response()->json(['message' => "Usuário não encontrado"], 401);

            
            list($book, $img) = $this->getBookById($id); // controller da api do google

            if(!$book)
                return response()->json(['message' => "Livro não encontrado"], 404);

            $livro = Livro::create([
                'img_livro' => $img,
                'id_livro_google' => $book?->id,
                'id_usuario' => $user->id,
                'nome_livro' => $book?->volumeInfo?->title ?? "Sem título",
                'descricao_livro' => $book?->volumeInfo?->description ?? "",
                'lido' => 'não',
                'tempo_lido' => '0 dias',
                'paginas_lidas' => 0,
                'total_paginas' => $book?->volumeInfo?->pageCount ?? 0,
                'data_inicio' => now(),
            ]);

            return response()->json(['message' => 'Livro Cadastrado'], 200);
        }
        catch(Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

   //busca livro pelo id
   public function getBookById($id){
        $this->book_controller = new BooksController();

        $url = "https://www.googleapis.com/books/v1/volumes/$id";
        $json_data = file_get_contents($url);

        $livro = json_decode($json_data);

        if ($livro === null)
            die('Error decoding JSON data.');
        
        // $thumbnail = $livro->volumeInfo->imageLinks->smallThumbnail ?? '/img/book_transparent.png';
        // $thumbnail = $livro->volumeInfo->imageLinks->thumbnail ?? $thumbnail;
        
        // $img = $this->book_controller->verificarImagemLivro($thumbnail);// verifica se livro tem capa, se nao tive deixa padrao

        return response()->json($livro, 200);
    }
}
