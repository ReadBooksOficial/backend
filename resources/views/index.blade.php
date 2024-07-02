@extends('layouts.main')
@section('title', 'Read Book')

@section('content')
    <main class="main-index container-index">
        <div class="container container-container-index">
            <div class="row row-index">
                {{-- <h1 class="text-center">Entre para cadastrar seus livros</h1> --}}
                <div class="col col-btn-home col-index" style="margin-top: -50px; ">
                    <h1 class="text-white text-center">Read Book</h1>
                    <p class="text-white">Cadastre os livros que você leu ou está lendo para manter um controle de todas as informações de todos os seus livros.</p>

                    <div class="div-btn-home">
                        <a href="/register" class="btn-home btn btn-outline-light">Criar Conta</a>
                        <a href="/login" class="btn-home btn btn-light" style="margin-left: 20px">Fazer Login</a>
                    </div>
                </div>

                <div class="col col-index">
                    <div class="div img-index">
                        <div class="col col-img-index">
                            <img class="img-index" src="{{asset('img_index/percy - mar de monstros.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/percy - maldicao do tita.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/percy - o ultimo olimpiano.jpg')}}">
                        </div>
                        <div class="col col-img-index">
                            <img class="img-index" src="{{asset('img_index/percy - a maldicao do tita 2.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/herry - a pedra filosofal.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/harry - a ordem de fenix.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/harry - enigma do principe.jpg')}}">
                        </div>

                        <div class="col col-img-index">
                            <img class="img-index" src="{{asset('img_index/percy - e os olimpianos.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/percy - a batalha do labirinto.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/harry - prsioneiro de azkaban.jpg')}}">
                        </div>

                        <div class="col col-img-index">
                            <img class="img-index" src="{{asset('img_index/harry - o calice de fogo.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/percy - ladrao de raios.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/harry - e a camara secreta.jpg')}}">
                            <img class="img-index" src="{{asset('img_index/harry - as reliquias da morte.jpg')}}">
                        </div>
                    </div>
                    {{-- <img class="img-home" src="{{asset('img/read_book_livro.png')}}" height="800" srcset=""> --}}
                </div>
            </div>
        </div>
    </main>
@endsection

<style>
    main{
        max-height: 100vh!important;
    }
    .col-btn-home{
        margin-left: -150px!important;
    }

    nav{
        z-index: 9!important;
    }
    .col-img-index{
        position: absolute;
        gap: 10px;
        display: flex;
        flex-direction: column;
        z-index: 999;
    }

    .col-img-index:nth-child(1){
        top: -315px;
        right: 380px
    }

    .col-img-index:nth-child(2){
        top: -470px;
        right: 170px
    }

    .col-img-index:nth-child(3){
        top: -315px;
        right: -40px
    }

    .col-img-index:nth-child(4){
        top: -470px;
        right: -250px
    }

    .img-index{
        /* height: 229.3; */
        /* 229,3; */
        height: 300;
        /* height: 351.15; */
        border-radius: 7px;
    }

    .row-index, .container-index{
        /* overflow: hidden !important; */
        position: relative;
    }

    @media (max-width: 1580px) {
        .col-btn-home{
            margin-left: -70px!important;
        }
    }

    @media (max-width: 1195px) {
        .col-btn-home{
            margin-left: -30px!important;
        }

        .img-index{
            height: 250;
        }
        .col-img-index:nth-child(1) {
            top: -300px;
            right: 380px;
        }
    }

    @media (max-width: 1175px) {
        .col-img-index:nth-child(1){
            display: none;
        }
        .col-btn-home{
            margin-left: 0px!important;
        }
    }

    @media (max-width: 890px) {
        .img-index{
            height: 150;
        }
        .col-img-index:nth-child(1){
            display: grid;
            right: 280px;
            top: -70
        }

        .col-img-index:nth-child(2){
            top: -150px;
            right: 150px
        }

        .col-img-index:nth-child(3){
            right: 30px;
            top: -70
        }

        .col-img-index:nth-child(4){
            top: -150px;
            right: -90px
        }
    }

    @media (max-width: 790px) {
        .col-img-index:nth-child(1){
            display: none;
        }
    }

    @media (max-width: 480px) {
        .col-index{
            position: relative;
            height: 100vh;
            overflow: hidden;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }


        .container {
            max-width: 95% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .col-btn-home{
            padding: 200px 20px 0 20px!important;
        }

        .col-img-index:nth-child(1){
            display: grid;
        }

        .col-btn-home{
            margin-top: 100px !important;
            min-width: 100%!important;
            height: 500px;
        }

        .col-img-index:nth-child(1){
            top: 200px;
            right: 400px
        }

        .col-img-index:nth-child(2){
            top: 90px;
            right: 245px
        }

        .col-img-index:nth-child(3){
            top: 200px;
            right: 90px;
        }

        .col-img-index:nth-child(4){
            top: 90px;
            right: -60px;
        }

        .main-index{
            overflow: auto;
        }
    }

    @media (max-width: 450px) {
        .img-index{
            height: 170px;
        }

        .col-img-index:nth-child(1){
            top: 200px;
            left: -40;
        }

        .col-img-index:nth-child(2){
            top: 90px;
            left: 90px;
            right: auto;
        }

        .col-img-index:nth-child(3){
            top: 200px;
            right: 80px;
        }

        .col-img-index:nth-child(4){
            top: 90px;
            right: -40;
        }
    }

    @media (max-width: 395px) {

        .col-btn-home {
            margin-top: 230px !important;
            height: auto;
        }

        .col-img-index:nth-child(1){
            top: 150px;
            left: -50;
        }

        .col-img-index:nth-child(2){
            top: 50px;
            left: 70px;
            right: auto;
        }

        .col-img-index:nth-child(3){
            top: 150px;
            right: 70px;
        }

        .col-img-index:nth-child(4){
            top: 50;
            right: -50;
        }


        .col-index {
            padding: 0 10px !important;
        }
    }

    @media (max-width: 365px) {
        .img-index{
            height: 150px;
        }
    }

    @media (max-width: 340px) {
        .img-index{
            height: 120px;
        }

        .col-img-index:nth-child(1){
            left: 0;
        }

        .col-img-index:nth-child(2){
            left: 90px;
        }

        .col-img-index:nth-child(3){
            right: 90px;
        }

        .col-img-index:nth-child(4){
            right: 0;
        }

        @media (max-width: 320px) {
            .col-img-index:nth-child(3){
                display: none;
            }
        }
    }
</style>
