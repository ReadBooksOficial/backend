<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Livro;

class BooksController extends Controller
{
    public function index(Request $request){
        $user = $request->get('user');
        $page = $request->input('page', 1); // Pega o número da página a partir da requisição
        $limit = 100;
        $offset = ($page - 1) * $limit;
        $search = $request->input('search');
        $filter = $request->input('filter');

        // $books = Livro::where('id_usuario', $user["id"])->orderBy('data_inicio', 'desc')->get(); //busca livro pelo usuario

        $books = Livro::where('id_usuario', $user["id"]);

        
        if (!empty($search)) {
            $books->where(function ($q) use ($search) {
                $q->where('nome_livro', 'like', '%' . $search . '%')
                ->orWhere('descricao_livro', 'like', '%' . $search . '%');
            });
        }
        
        if ($filter) {
            if ($filter == "read")
                $books->where('lido', 'sim');
            elseif ($filter == "not_read")
                $books->where('lido', 'não');
            elseif ($filter == "wish_list")
                $books->whereNull('data_inicio');
        }

        
        $books = $books->orderBy('data_inicio', "desc")
            ->offset($offset)
            ->limit($limit)->get();


        $totalBooks = Livro::where('id_usuario', $user["id"])->where('data_inicio', '!=', null)->count();
        $totalWishList = Livro::where('id_usuario', $user["id"])->where('lido', 'não')->where('data_inicio', null)->count();
        $totalReadBooks = Livro::where('lido', 'sim')->where('id_usuario', $user["id"])->count();
        $totalNotReadBooks = Livro::where('lido', 'não')->where('id_usuario', $user["id"])->count();

        // verifica se livro tem capa, se nao tive deixa padrao
        foreach ($books as $livro) {
            $livro->img_livro = $this->verifyImgBook($livro->img_livro);
        }

        return response()->json(compact('books', 'totalBooks', 'totalReadBooks', "totalNotReadBooks", 'totalWishList'));
    }

    public function verifyImgBook($img_livro){
        $path = str_replace('../', "", $img_livro);
        $img_livro = str_replace('http://books.google.com', "https://books.google.com", $path);

        // img contem http (api)
        if (strpos($img_livro, 'books.google.com') != false)
            return str_replace("zoom=5", "zoom=6", $img_livro);
        
        // não tem https
        if (strpos($img_livro, 'https') == false)
            return config("app.read_books_backend_url")  . "/$img_livro";

        if(!file_exists($path) || !$path)
            return '../img/book_transparent.png';
    }

    public function getBookById($id)
    {
        try {
            $book = Livro::where('id_livro', $id)->first();
            $book->img_livro = $this->verifyImgBook($book->img_livro);// verifica se livro tem capa, se nao tive deixa padrao

            return response()->json(['book' => $book], 200);//busca livro pelo id
        } catch (\Exception $e) {
            return response()->json(['message'=> $e->getMessage()],500);
        }
    }
}
