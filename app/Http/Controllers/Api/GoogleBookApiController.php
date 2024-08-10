<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\LivroController;

class GoogleBookApiController extends Controller
{
    public $langRestrict = 'pt-BR';
    public LivroController $book_controller; //livro controller

    // retorna lista pelo nome
    public function getBooksByName($book_title){
        // Codifica o título do livro para ser usado como parâmetro na URL da API
        $book_title_encoded = str_replace(' ', '+', $book_title);

        // Faz a requisição HTTP para a API do Google Books e obtém os dados do livro em formato JSON
        //$url = 'https://www.googleapis.com/books/v1/volumes?q=' . $book_title_encoded;
        $url = "https://www.googleapis.com/books/v1/volumes?q=$book_title_encoded&langRestrict=$this->langRestrict";

        $json_data = file_get_contents($url);

        // Decodifica os dados JSON em um objeto PHP e obtém a URL da imagem da capa do primeiro livro encontrado (se houver)
        return json_decode($json_data);
   }

   //busca livro pelo id
   public function getBookById($id){
        $this->book_controller = new LivroController;

        $url = "https://www.googleapis.com/books/v1/volumes/$id";
        $json_data = file_get_contents($url);

        $livro = json_decode($json_data);

        if ($livro === null)
            die('Error decoding JSON data.');
        
        $img = $livro->volumeInfo->imageLinks->smallThumbnail ?? '../img/book_transparent.png';
        
        $img = $this->book_controller->verificarImagemLivro($livro->volumeInfo->imageLinks->smallThumbnail);// verifica se livro tem capa, se nao tive deixa padrao

        return [$livro, $img];
    }
}
