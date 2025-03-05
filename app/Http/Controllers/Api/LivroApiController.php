<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Livro;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class LivroApiController extends Controller
{
    // public function getBooksByUserId($id_user){
    //     return Livro::where('id_usuario', $id_user)->get(); //busca livro pelo usuario
    // }

    public function getBooksByUserId($id_user)
    {
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

    public function getBooksByUserIdToPacoca(Request $request)
    {
        $user = User::where("user_name", $request->user_name)->first();
        if (!$user)
            return response()->json(["message" => "Usuário não encontrado"], 404);
        $id_user = $user->id;

        $books = Livro::where('id_usuario', $id_user)->orderBy('data_inicio', 'desc')->where("show_in_pacoca", true)->get(); //busca livro pelo usuario
        $totalBooks = Livro::where('id_usuario', $id_user)->where('data_inicio', '!=', null)->count();
        $countWishList = Livro::where('id_usuario', $id_user)->where('lido', 'não')->where('data_inicio', null)->count();
        $countBooksRead = Livro::where('lido', 'sim')->where('id_usuario', $id_user)->count();

        // verifica se livro tem capa, se nao tive deixa padrao
        foreach ($books as $book)
            $book->img_livro = $this->verifyImgBook($book->img_livro);

        return response()->json(['books' => $books]);//busca livro pelo usuario
    }

    //pesquisa livro por nome
    public function getBooksByName(Request $request)
    {
        $user = auth()->user();
        $name = $request->name;

        if (!$name)
            return redirect()->route('index');

        $books = Livro::where('nome_livro', 'LIKE', "%" . $name . "%")->where('id_usuario', $user->id)->orderBy('data_inicio', 'desc')->get();

        // verifica se livro tem capa, se nao tive deixa padrao
        foreach ($books as $book) {
            $book->img_livro = $this->verifyImgBook($book->img_livro);
        }

        return response()->json(['books' => $books]);
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

    public function delete($id)
    {
        $book = Livro::where('id_livro', $id)->first();
        if (!isset($book) || Gate::denies('edit-book', $book)) {
            abort(403, 'Acesso não autorizado');
        }

        Livro::where('id_livro', $id)->delete();
        $img_livro = 'img_livros/' . $id . '.png';

        // Verifique se o arquivo existe antes de excluir
        if (Storage::exists($img_livro))
            Storage::delete($img_livro);


        return response()->json(['message' => "Livro Apagado"], 200);//busca livro pelo id
    }

    // verifica se livro tem capa, se nao tive retorna padrao
    public function verifyImgBook($img_livro)
    {
        $path = str_replace('../', "", $img_livro);

        // img contem http (api)
        if (strpos($img_livro, 'books.google.com') != false)
            return str_replace("zoom=5", "zoom=6", $img_livro);

        if (!file_exists($path) || !$path)
            return asset('/img/book_transparent.png');

        $baseUrl = url('/');
        return $baseUrl . '/' . $path;
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                // 'nome_livro' => ['required', 'string'],
                // 'descricao_livro' => ['required', 'string'],
                'total_paginas' => ['required'],
                'paginas_lidas' => ['required'],
                'tempo_lido' => ['required'],
            ]);

            if ($request->paginas_lidas > $request->total_paginas) {
                return response()->json(['message' => 'A número de páginas que você leu não pode ser maior que a quantidade total de páginas'], 422);
            }

            $book = Livro::where('id_livro', $request->id)->first();
            if (!isset($book)) {
                abort(404, 'Livro excluido');
            }

            if (Gate::denies('edit-book', $book)) {
                abort(403, 'Acesso não autorizado');
            }

            $book
                ->update([
                    // 'nome_livro' => $request->nome_livro,
                    // 'img_livro' => $request->img_livro,
                    'lido' => $request->is_read ? "sim" : "não",
                    'total_paginas' => $request->total_paginas,
                    'tempo_lido' => $request->tempo_lido,
                    'paginas_lidas' => $request->paginas_lidas,
                    // 'descricao_livro' => $request->descricao_livro,
                    'data_inicio' => $request->start_date,
                    'data_termino' => $request->end_date,
                    'show_in_pacoca' => $request->show_in_pacoca,
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

            return response()->json(["message" => "Livro atualizado!", "book" => $book], 201);

        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], status: 500);
        }
    }

}
