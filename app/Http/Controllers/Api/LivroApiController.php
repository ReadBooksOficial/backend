<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Livro;

class LivroApiController extends Controller
{
    // public function getBooksByUserId($id_user){
    //     return Livro::where('id_usuario', $id_user)->get(); //busca livro pelo usuario
    // }

    public function getBooksByUserId($id_user){
        // return response()->json(Livro::where('id_usuario', $id_user)->get());//busca livro pelo usuario

        $books = Livro::where('id_usuario', $id_user)->orderBy('data_inicio', 'desc')->get(); //busca livro pelo usuario
        $totalBooks = Livro::where('id_usuario', $id_user)->where('data_inicio', '!=', null)->count();
        $countWishList = Livro::where('id_usuario', $id_user)->where('lido', 'não')->where('data_inicio', null)->count();
        $countBooksRead = Livro::where('lido', 'sim')->where('id_usuario', $id_user)->count();

        // verifica se livro tem capa, se nao tive deixa padrao
        foreach ($books as $book)
            $book->img_livro = $this->verifyImgBook($book->img_livro);

        return response()->json([
            'books' => $books,
            'countBooksRead' => $countBooksRead,
            'countWishList' => $countWishList,
            'totalBooks' => $totalBooks
        ], 200);//busca livro pelo usuario

    }

    public function getBookById($id){
        $book = Livro::where('id_livro', $id)->first();

        // verifica se livro tem capa, se nao tive deixa padrao
        $book->img_livro = $this->verifyImgBook($book->img_livro);

        return response()->json([
            'book' => $book,
        ], 200);//busca livro pelo id
    }

    public function delete($id){
        $book = Livro::where('id_livro', $id)->delete();

        return response()->json([
            'message' => "Livro Apagado",
        ], 200);//busca livro pelo id

    }

    // verifica se livro tem capa, se nao tive retorna padrao
    public function verifyImgBook($img_livro){
        $path = str_replace('../', "", $img_livro);

        // img contem http (api)
        if (strpos($img_livro, 'books.google.com') != false)
            return str_replace("zoom=5", "zoom=6", $img_livro);

        if(!file_exists($path) || !$path)
            return asset('/img/book_transparent.png');

        $baseUrl = url('/');
        return $baseUrl . '/' . $path;
    }
}
