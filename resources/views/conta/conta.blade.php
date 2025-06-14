@extends('layouts.main')
@section('title', 'Read Books - Conta')

@section('content')

<div class="container container-conta">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center" style="margin-bottom: 20px; font-size: 40px">Conta</h1>
            <p>Atualize as informações da sua conta pelo <a href="{{config("app.pacoca_url")}}/conta" target="_blank" rel="noopener noreferrer">Central de Contas</a> Alterações são refletidas no Paçoca, ReadBooks, Cronos e Rita!</p>

            {{-- NOME --}}
            <div class="form-group row mb-3">
                <div class="col">
                    <label for="name" class="col-md-4 col-form-label text-md-right">Nome</label>
                    <input disabled placeholder="Email ou nome de usuário" id="email" type="login" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ auth()->user()->name }}" autocomplete="login" autofocus>
                </div>
            </div>

            {{-- EMAIl --}}
            <div class="form-group row mb-3">
                <div class="col">
                    <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                    <input disabled placeholder="Email ou nome de usuário" id="email" type="login" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ auth()->user()->email }}" autocomplete="login" autofocus>
                </div>
            </div>
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

@endsection

