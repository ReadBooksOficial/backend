<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Models\Livro;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GoogleBooksController extends Controller
{
    public $langRestrict = 'pt-BR';
    private $key = 'AIzaSyDG9HavA17iFwucNnObsHy4qWzwMGhz9ME';

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
        $request->validate([
            'thumbnail' => 'nullable|string',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'is_read' => 'nullable|boolean',
            'time_read' => 'nullable|string',
            'pages_read' => 'nullable|integer',
            'total_pages' => 'nullable|integer',
            'start_date' => 'nullable|date',
        ]);

        $user = $request->get('user');
        // if(!$user) 
        //     return response()->json(['message' => "Usuário não encontrado"], 401);

        $livro = Livro::create([
            'img_livro' => $request->thumbnail,
            'id_livro_google' => $id,
            'id_usuario' => $user["id"],
            'lido' => $request->is_read ? 'sim' : 'não',
            'nome_livro' => $request->name,
            'descricao_livro' => $request->description,
            'tempo_lido' => $request->time_read ?? "0 dias",
            'paginas_lidas' => $request->pages_read ?? 0,
            'total_paginas' => $request?->total_pages,
            'data_inicio' => $request->start_date,
        ]);

        return response()->json(['message' => 'Livro cadastrado' . (isMyLove($user["id"]) ? ", meu amor" : ""), "book" => $livro], 200);
        
    }

   //busca livro pelo id
   public function getBookById(Request $request, $id){
        try {
            $user = $request->get('user');
            $url = "https://www.googleapis.com/books/v1/volumes/$id";
            $json_data = file_get_contents($url);

            $livro = json_decode($json_data);

            if (!$livro) return response()->json(['message' => "Livro não encontrado" . ($user && isMyLove($user["id"]) ? ", meu amor" : "")], 404);

            return response()->json($livro, 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Livro não encontrado"], 404);
        }
    }

}
