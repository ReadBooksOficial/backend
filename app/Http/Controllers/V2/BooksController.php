<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Livro;
use Illuminate\Support\Facades\Storage;

class BooksController extends Controller
{
    public function index(Request $request){
        $user = $request->get('user');
        $page = $request->input('page', 1); // Pega o número da página a partir da requisição
        $limit = 100;
        $offset = ($page - 1) * $limit;
        $search = $request->input('search');
        $filter = $request->input('filter');

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

        return response()->json(compact('books', 'totalBooks', 'totalReadBooks', "totalNotReadBooks", 'totalWishList'));
    }
    public function find(Request $request, $uuid)
    {
        $user = $request->get('user');
        $book = Livro::where('uuid', $uuid)->first();
        if(!$book)return response()->json(['message' => 'Livro não encontrado' . ($user && isMyLove($user["id"]) ? ", meu amor" : "")], 404);

        return response()->json(['book' => $book], 200);
    }

    public function update(Request $request, $uuid){
        $request->validate([
            'nome_livro' => ['required', 'string'],
            'descricao_livro' => ['required', 'string'],
            'total_paginas' => ['required'],
            'paginas_lidas' => ['required'],
            'tempo_lido' => ['required'],
            'lido' => ['required'],
            // 'data_inicio' => ['required'],
        ]);

        $book = Livro::where('uuid', $uuid)->first();
        $user = $request->get('user');

        if(!$book) return response()->json(['message' => 'Livro não encontrado' . (isMyLove($user["id"]) ? ", meu amor" : "")], 404);
        if($book->id_usuario != $user["id"]) return response()->json(['message' => 'Acesso negado'. (isMyLove($user["id"]) ? ", meu amor" : "")], 403);

        Livro::where('id_livro', $request->id_livro)
        ->update([
            'nome_livro' => $request->nome_livro,
            'lido' => $request->lido,
            'total_paginas' => $request->total_paginas,
            'tempo_lido' => $request->tempo_lido,
            'paginas_lidas' => $request->paginas_lidas,
            'descricao_livro' => $request->descricao_livro,
            'data_inicio' => $request->data_inicio,
            'data_termino' => $request->data_termino,
            'show_in_pacoca' => $request->show_in_pacoca,
        ]);

        return response()->json(['message' => 'Livro atualizado' . (isMyLove($user["id"]) ? ", meu amor" : "")], 200);
    }

    public function delete(Request $request, $uuid)
    {
        $user = $request->get('user');
        $book = Livro::where('uuid', $uuid)->first();
        
        if(!$book) return response()->json(['message' => 'Livro não encontrado' . (isMyLove($user["id"]) ? ", meu amor" : "")], 404);
        if($book->id_usuario != $user["id"]) return response()->json(['message' => 'Acesso negado' . (isMyLove($user["id"]) ? ", meu amor" : "")], 403);

        $book->delete();
        $img_livro = 'img_livros/' . $book->id_livro . '.png';

        if (Storage::exists($img_livro))
            Storage::delete($img_livro);

        return response()->json(['message' => "Livro Apagado" . (isMyLove($user["id"]) ? ", meu amor" : "")], 200);//busca livro pelo id
    }

    public function getUserId(Request $request, $id_user)
    {
        $user = $request->get('user');
        if(!$id_user) return response()->json(['message' => 'Informe o id do usuário' . (isMyLove($user["id"]) ? ", meu amor" : "")], 404);
        $books = Livro::where('id_usuario', $request->id_user)->orderBy('data_inicio', 'desc')->where("show_in_pacoca", true)->get(); //busca livro pelo usuario

        return response()->json(['books' => $books]);//busca livro pelo usuario
    }
}
