@extends('layouts.main')
@section('title', 'Read Books')

@section('content')
    <main class="main-index container-index-mobile">
        <div class="container container-container-index-mobile">
            <div class="row row-index-mobile">
                <div class="col col-index-mobile">
                    <div class="div img-index-mobile">
                        <div class="col col-img-index-mobile">
                            <img class="img-index-mobile" src="{{asset('img_index/1984.webp')}}">
                            <img class="img-index-mobile" src="{{asset('img_index/percy - mar de monstros.jpg')}}">
                            <img class="img-index-mobile" src="{{asset('img_index/percy - maldicao do tita.jpg')}}">
                            <img class="img-index-mobile" src="{{asset('img_index/percy - o ultimo olimpiano.jpg')}}">
                        </div>
                        <div class="col col-img-index-mobile">
                            <img class="img-index-mobile" src="{{asset('img_index/percy - a maldicao do tita 2.jpg')}}">
                            <img class="img-index-mobile" src="{{asset('img_index/herry - a pedra filosofal.jpg')}}">
                            <img class="img-index-mobile" src="{{asset('img_index/harry - a ordem de fenix.jpg')}}">
                            <img class="img-index-mobile" src="{{asset('img_index/harry - enigma do principe.jpg')}}">
                            <img class="img-index-mobile" src="{{asset('img_index/assim que acaba.jpeg')}}">
                        </div>

                        <div class="col col-img-index-mobile">
                            <img class="img-index-mobile" src="{{asset('img_index/percy - e os olimpianos.jpg')}}">
                            <img class="img-index-mobile" src="{{asset('img_index/percy - a batalha do labirinto.jpg')}}">
                            <img class="img-index-mobile" src="{{asset('img_index/biblioteca da meia noite.jpg')}}">
                            <img class="img-index-mobile" src="{{asset('img_index/diario de anne frank.jpg')}}">
                        </div>

                        <div class="col col-img-index-mobile">
                            <img class="img-index-mobile" src="{{asset('img_index/harry - o calice de fogo.jpg')}}">
                            <img class="img-index-mobile" src="{{asset('img_index/percy - ladrao de raios.jpg')}}">
                            <img class="img-index-mobile" src="{{asset('img_index/harry - e a camara secreta.jpg')}}">
                            <img class="img-index-mobile" src="{{asset('img_index/harry - as reliquias da morte.jpg')}}">
                            <img class="img-index-mobile" src="{{asset('img_index/harry - prsioneiro de azkaban.jpg')}}">
                        </div>

                        <div class="col col-img-index-mobile">
                            <img class="img-index-mobile" src="{{asset('img_index/1984.webp')}}">
                            <img class="img-index-mobile" src="{{asset('img_index/percy - mar de monstros.jpg')}}">
                            <img class="img-index-mobile" src="{{asset('img_index/percy - maldicao do tita.jpg')}}">
                            <img class="img-index-mobile" src="{{asset('img_index/percy - o ultimo olimpiano.jpg')}}">
                        </div>

                        <div class="col col-img-index-mobile">
                            <img class="img-index-mobile" src="{{asset('img_index/percy - e os olimpianos.jpg')}}">
                            <img class="img-index-mobile" src="{{asset('img_index/percy - a batalha do labirinto.jpg')}}">
                            <img class="img-index-mobile" src="{{asset('img_index/biblioteca da meia noite.jpg')}}">
                            <img class="img-index-mobile" src="{{asset('img_index/diario de anne frank.jpg')}}">
                        </div>
                    </div>
                    {{-- <img class="img-home" src="{{asset('img/read_book_livro.png')}}" height="800" srcset=""> --}}
                </div>
                <div class="col col-btn-home col-btn-home-mobile" style="margin-top: -50px; ">
                    <h1 class="text-white text-center">Read Books</h1>
                    <p class="text-white">Cadastre os livros que você leu ou está lendo para manter um controle de todas as informações de todos os seus livros.</p>

                    <div class="div-btn-home">
                        <a href="/register" class="btn-home btn btn-outline-light">Criar Conta</a>
                        <a href="/login" class="btn-home btn btn-outline-light" style="margin-left: 20px">Fazer Login</a>
                        <a href="/download" class="btn-home btn btn-home-download btn-light">Baixar</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <main class="main-index container-index">
        <div class="">
            <div class="row" style="margin: 0;">
                {{-- <h1 class="text-center">Entre para cadastrar seus livros</h1> --}}
                <div class="col-6 col-novo-index-pc">
                    <h1 class="text-white text-center">Read Books</h1>
                    <p class="text-white">Cadastre os livros que você leu ou está lendo para manter um controle de todas as informações de todos os seus livros.</p>

                    <div class="div-btn-home-pc">
                        <a href="/register" class="btn-home btn btn-outline-light">Criar Conta</a>
                        <a href="/login" class="btn-home btn btn-outline-light">Fazer Login</a>
                        <a href="/download" class="btn-home btn-home-download btn btn-light">Baixar</a>
                    </div>
                </div>

                <div class="col-6">
                    <div class="div img-index">
                        <div class="col col-img-index">
                            <img class="img-index" src="{{asset('img_index/1984.webp')}}">
                            <img class="img-index" src="{{asset('img_index/percy - o ultimo olimpiano.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/percy - mar de monstros.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/percy - maldicao do tita.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/percy - o ultimo olimpiano.jpg')}}">
                        </div>
                        <div class="col col-img-index">
                            <img class="img-index" src="{{asset('img_index/percy - a maldicao do tita 2.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/herry - a pedra filosofal.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/harry - a ordem de fenix.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/harry - enigma do principe.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/assim que acaba.jpeg')}}">
                        </div>

                        <div class="col col-img-index">
                            <img class="img-index" src="{{asset('img_index/percy - e os olimpianos.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/biblioteca da meia noite.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/percy - a batalha do labirinto.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/diario de anne frank.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/harry - prsioneiro de azkaban.jpg')}}">
                        </div>

                        <div class="col col-img-index">
                            <img class="img-index" src="{{asset('img_index/harry - o calice de fogo.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/percy - ladrao de raios.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/harry - e a camara secreta.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/harry - as reliquias da morte.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/biblioteca da meia noite.jpg')}}">
                        </div>

                        <div class="col col-img-index">
                            <img class="img-index" src="{{asset('img_index/1984.webp')}}">
                            <img class="img-index" src="{{asset('img_index/percy - mar de monstros.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/percy - maldicao do tita.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/percy - o ultimo olimpiano.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/percy - mar de monstros.jpg')}}">
                        </div>

                        <div class="col col-img-index">
                            <img class="img-index" src="{{asset('img_index/percy - e os olimpianos.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/biblioteca da meia noite.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/percy - a batalha do labirinto.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/diario de anne frank.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/harry - prsioneiro de azkaban.jpg')}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

<style>
    .col-novo-index-pc{
        margin-top: 400px;
        padding: 200px 100px!important;
        margin: 0;
    }
    .col-novo-index-pc p {
        font-size: 17px;
        color: var(--color-menu) !important;
    }

    .col-novo-index-pc h1 {
        font-size: 90px;
        color: var(--color-menu) !important;
    }

    .container-index-mobile{
        display: none;
    }
    .row-index-mobile{
        height: 100%;
        overflow: hidden;
        background: #fff;
    }
    .container-container-index-mobile{
        min-width: 100%;
    }
    .col-btn-home-mobile{
        z-index: 5!important;
        background: #5bb4ff;
        border-radius: 50px 50px 0 0;
        height: auto!important;
        padding: 20px 20px 0 20px!important;
        margin-top: 200px !important;
        min-width: 100%!important;
        height: 500px;
    }
    main{
        max-height: 100vh!important;
    }

    .col-btn-home{
        margin-left: -150px!important;
    }

    nav{
        z-index: 2!important;
    }
    .col-img-index{
        /* position: absolute; */
        gap: 5px;
        display: flex;
        flex-direction: column;
        z-index: 5;
    }

    .col-img-index-mobile{
        /* position: absolute; */
        display: flex;
        flex-direction: column;
        z-index: 5;
        gap: 5px;
    }

    .img-index-mobile{
        display: flex;
        gap: 3px;
        max-height: 150px;
    }

    .col-img-index:nth-child(1), .col-img-index:nth-child(3), .col-img-index:nth-child(5){
        margin-top: -250px;
    }

    .col-img-index:nth-child(2), .col-img-index:nth-child(4), .col-img-index:nth-child(6){
        margin-top: -100px;
    }


    .img-index{
        height: 250;
        border-radius: 7px;
        display: flex;
        gap: 5px;
    }
    .col-img-index{
        width: 150px;
    }

    .container-index{
        position: relative;
    }

    @media (max-width: 1580px) {
        .col-btn-home{
            margin-left: -70px!important;
            width: 40%!important;
        }

        .col-img-index:nth-child(1), .col-img-index:nth-child(3), .col-img-index:nth-child(5){
            margin-top: -250px;
        }

        .col-img-index:nth-child(2), .col-img-index:nth-child(4), .col-img-index:nth-child(6){
            margin-top: -200px;
        }

        .col-novo-index-pc {
            padding: 200px 50px !important;
        }
    }

    @media (max-width: 1195px) {
        .col-btn-home{
            margin-left: -30px!important;
        }

        .img-index{
            height: 200;
        }
        .img-index-mobile{
            height: 250;
        }
    }

    @media (max-width: 1175px) {
        .col-img-index:nth-child(1){
            display: none;
        }
        .col-btn-home{
            margin-left: 0px!important;
        }
        .col-novo-index-pc {
           padding: 100px 50px!important;
        }
    }

    @media (max-width: 890px) {
        .img-index{
            height: 200px;
        }
        
        .col-img-index-mobile:nth-child(1){
            margin-left: -20px;
        }

        .col-img-index-mobile:nth-child(2){
            margin-top: -70px;
        }

        .col-img-index-mobile:nth-child(4){
            margin-top: -70px;
        }

        .container-index-mobile{
            display: flex;
        }
        .container-index{
            display: none!important;
        }

        p.text-white{
            font-size: 15px
        }

        .navbar{
            display: none!important;
        }

        main{
            background: #5bb4ff
        }

        h1{
            margin-top: 20px!important;
        }
    }
</style>
