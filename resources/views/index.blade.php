@extends('layouts.main')
@section('title', 'Read Book')

@section('content')
    <main class="main-index container-index">
        <div class="container container-container-index">
            <div class="row row-index">
                {{-- <h1 class="text-center">Entre para cadastrar seus livros</h1> --}}
                <div class="col col-btn-home col-index" style="margin-top: -50px!important">
                    <h1 class="text-white">Read Book</h1>
                    <p class="text-white">Cadastre os livros que você leu ou está lendo para manter um controle de todas as informações de todos os seus livros.</p>
                    
                    <div class="div-btn-home">
                        <a href="/register" class="btn-home btn btn-outline-light">Criar Conta</a>
                        <a href="/login" class="btn-home btn btn-light" style="margin-left: 20px">Fazer Login</a>
                    </div>
                </div>

                <div class="col col-index">
                    <img class="img-home" src="{{asset('img/read_book_livro.png')}}" height="800" srcset="">
                </div>
            </div>
        </div>
    </main>
@endsection