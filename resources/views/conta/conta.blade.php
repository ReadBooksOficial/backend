@extends('layouts.main')
@section('title', 'Read Books - Conta')

@section('content')

<div class="container container-conta">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <h1 class="text-center" style="margin-bottom: 20px; font-size: 40px">Conta</h1>
                <p>Atualize as informações da sua conta pelo central de contas: <a href="{{config("app.pacoca_url")}}/conta" target="_blank" rel="noopener noreferrer">{{config("app.pacoca_url")}}/conta</a></p>

                {{-- NOME --}}
                <div class="form-group row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-right">Nome</label>
                    <div class="col">
                        <input disabled placeholder="Email ou nome de usuário" id="email" type="login" class="input-login form-control @error('login') is-invalid @enderror" name="login" value="{{ auth()->user()->name }}" autocomplete="login" autofocus>
                    </div>

                    @error('name')
                        <span class="invalid-feedback" role="alert" style="display: block!important">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>



                {{-- EMAIl --}}
                <div class="form-group row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                    <div class="col">
                        <input disabled placeholder="Email ou nome de usuário" id="email" type="login" class="input-login form-control @error('login') is-invalid @enderror" name="login" value="{{ auth()->user()->email }}" autocomplete="login" autofocus>
                    </div>

                    @error('email')
                        <span class="invalid-feedback" role="alert" style="display: block!important">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <div class="form-group row mt-4 mb-0">
                       <div class="col">
                        <a href="/logout" class="btn btn-atualizar-conta btn-outline-danger" style="width: 100%">
                            Sair
                        </a>
                       </div>
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

