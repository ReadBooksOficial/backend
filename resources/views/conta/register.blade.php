@extends('layouts.main')



@section('content')

    <div class="container container-login">

        <div class="col-7 col-left-register">
            <h1>Criar Conta</h1>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    {{-- NOME --}}
                    <div class="form-group row mb-3">
                        <div class="col">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}</label>
                            <input id="name" type="text" class="form-border-bottom-blue form-control form-control-login @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- EMAIL --}}
                    <div class="form-group row mb-3">
                        <div class="col">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
                            <input id="email" type="text" class="form-border-bottom-blue form-control form-control-login @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- SENHA --}}
                    <div class="form-group row mb-3">
                        <div class="col-">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Senha') }}</label>
                            <div style="position: relative;">
                                <input id="password" type="password" class="form-border-bottom-blue form-control form-control-login @error('password') is-invalid @enderror" value="{{ old('password') }}" name="password" autocomplete="new-password">
                                {{-- IMAGEM DE VER SENHA --}}
                                <img class="view-password" id="view-password" src="{{asset('img/eye.svg')}}" onclick="showPassword()" srcset="">
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert" style="display: block!important">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- CONFIRMAR SENHA --}}
                    <div class="form-group row mb-3">
                        <div class="col">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Senha') }}</label>

                            <div style="position: relative;">
                                <input id="password-confirm" type="password" class="form-border-bottom-blue form-control form-control-login" value="{{ old('password') }}" name="password_confirmation" autocomplete="new-password">
                                {{-- IMAGEM DE VER SENHA --}}
                                <img class="view-password" id="view-password-confirm" src="{{asset('img/eye.svg')}}" onclick="showPasswordConfirm()" srcset="">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-register  btn-blue">
                        {{ __('Criar Conta') }}
                    </button>
                    <div class="row" style="margin-top: 15px!important; text-align: center;">
                        <div class="col">
                            <a href="/login">Já tem conta? Faça login</a>
                        </div>
                    </div>
                </form>
            </div>

        <div class="col-5 col-right-register div-text-register" style="overflow: hidden;">
            {{-- <h1>Bem Vindo</h1>
            <p>Faça login e acesse seus livros</p> --}}
            <div class="div img-index" style="position: relative;">
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
    </div>



<script>
    //BOTÃO PARA MOSTRAR SENHA
    function showPassword() {//Botao de olho para mostrar e esconder a senha (pagina entrar)
        var senha = document.querySelector("#password");
        var imgShow = document.querySelector("#view-password");
        if (senha.type === "password") {
        senha.type = "text";
        imgShow.src = "../img/eye-off.svg"
        } else {
        senha.type = "password";
        imgShow.src = "../img/eye.svg"
        }
    }
    //BOTÃO PARA MOSTRAR SENHA
    function showPasswordConfirm() {//Botao de olho para mostrar e esconder a senha (pagina entrar)
        var senha = document.querySelector("#password-confirm");
        var imgShow = document.querySelector("#view-password-confirm");
        if (senha.type === "password") {
        senha.type = "text";
        imgShow.src = "../img/eye-off.svg"
        } else {
        senha.type = "password";
        imgShow.src = "../img/eye.svg"
        }
    }
</script>

<style>
    main{
        max-height: 100vh!important;
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
        right: 200px;
    }

    .col-img-index:nth-child(2){
        top: -470px;
        right: 0px
    }

    .col-img-index:nth-child(3){
        top: -315px;
        right: -200px
    }

    .col-img-index:nth-child(4){
        top: -470px;
        right: -400px;
    }

    .img-index{
        /* height: 229.3; */
        /* 229,3; */
        height: 300px;
        border-radius: 7px;
        /* height: 351.15; */
    }

    .row-index, .container-index{
        /* overflow: hidden !important; */
        position: relative;
    }



    @media (max-width: 1175px) {
        .img-index{
            /* height: 229.3; */
            /* 229,3; */
            height: 250px;
            /* height: 351.15; */
        }


        .col-img-index:nth-child(1){
            top: -250px;
            right: 170px;
        }

        .col-img-index:nth-child(2){
            top: -200px;
        }

        .col-img-index:nth-child(3){
            top: -250px;
            right: -170px;
        }

        .col-img-index:nth-child(4){
            top: -200px;
            right: -350px;
        }
    }

    @media (max-width: 890px) {
        .img-index{
            height: 200px;
        }
        .col-img-index:nth-child(1){
            display: grid;
            right: 280px;
            top: -50;
        }

        .col-img-index:nth-child(2){
            top: -250px;
            right: 100px
        }

        .col-img-index:nth-child(3){
            right: -50px;
            top: -150px;
        }

        .col-img-index:nth-child(4){
            top: -250px;
            right: -200px
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
            margin-top: -200px !important;
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
            margin-top: 0px !important;
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

@endsection

