@extends('layouts.main')

@section('title', 'Pagina principal')



@section('content')

    <div class="container">

        {{-- {{$dados_livro}} --}}

        {{-- @if(!isset($dados_livro))

            <form class="form-cadastrar-livro" action="/create" method="post">
                @csrf
                <h1 class="text-center">Cadastre um Livro</h1>
                <div class="mb-3">
                    <label for="nome1" class="form-label">Nome do Livro</label>

                    <input type="text" class="form-control @error('nome1') is-invalid @enderror" id="nome1" name="nome1">
                    @error('nome1')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
                <button type="submit" class="btn btn-blue" style="width: 100%"> Cadastrar</button>
            </form>
        @endif --}}

        {{-- CASO A API DO GOOGLE ACHE OS DADOS DO LIVRO --}}
        {{-- @if(isset($dados_livro)) --}}
        {{-- o  enctype="multipart/form-data" serve para salvar arquivos --}}
            <form class="form-cadastrar-livro" action="/createDois" method="post" enctype="multipart/form-data">
                @csrf
                <h1 class="text-center">Cadastre um Livro</h1>
                <div class="mb-3">
                    <label for="nome_livro" class="form-label">Nome do Livro</label>
                    {{-- <input onkeyup="buscarLivro()" type="text" class="form-control"> --}}
                    <input type="text" class="campo-nome-livro form-control" id="nome_livro" name="nome_livro">

                    @error('nome_livro')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                {{-- @php
                    if($url_capas == "[]"){
                        $livroController = app(App\Http\Controllers\livroController::class);
                        $url_capas = $livroController->pegarCapaLivro($book_name);
                    }
                @endphp --}}


                {{-- Caso tenha uma imagem do livro dentro do próprio site --}}
                {{-- @if(isset($url_capas) && count($url_capas)) --}}
                    <div class="mb-4">
                        <label class="col-12 form-label">Capa do Livro</label>
                        <input type="text" class="d-none" id="img_livro" name="img_livro">
                        {{-- <img height="300px" width="200px" src="{{asset('img_livros/42.png')}}" class=""> --}}

                        <div class="livro" style="height: 300px; width: 200px">
                            {{-- @if ($livro->img_livro == null)
                                <h1>{{ $livro->nome_livro }}</h1>
                            @endif --}}
                        </div>
                        {{-- @for($i=0; $i<count($url_capas); $i++)
                            @if(isset($url_capas[$i]->volumeInfo->imageLinks))
                                <img height="300px" width="200px" src="{{$url_capas[$i]->volumeInfo->imageLinks->smallThumbnail}}" class="">
                             @endif
                        @endfor --}}
                    </div>

                {{-- Caso não tenha uma imagem do livro dentro do próprio site --}}
                {{-- @else --}}


                    {{-- Caso a api do google ache capa do livro --}}
                    {{-- @if($url_capa != "")
                        <div class="mb-4">
                            <label class="col-12 form-label">Capa do Livro</label>
                            <input type="text" class="d-none" id="img_livro" name="img_livro" value="{{$url_capa}}">
                            <img height="300px" width="200px" src="{{$url_capa}}" class="">

                            {{-- @for($i=0; $i<count($url_capas); $i++)
                                @if(isset($url_capas[$i]->volumeInfo->imageLinks))
                                    <img height="300px" width="200px" src="{{$url_capas[$i]->volumeInfo->imageLinks->smallThumbnail}}" class="">
                                @endif
                            @endfor
                        </div>

                    @else
                        <div class="mb-4">
                            <label for="img_livro_usuario" data-label-image class="form-label">Capa do Livro
                                <input type="file" class="d-none" data-input-image id="img_livro_usuario" name="img_livro_usuario" value="{{$url_capa}}">
                                <div class="img-escolher-capa">
                                    Clique para escolher imagem
                                    <img data-image-preview height="300px" width="200px" class="img-escolher-capa">
                                </div>
                            </label>
                        </div>
                    @endif
                @endif --}}

                <div class="mb-4">
                    <label for="data_inicio" class="form-label">Data de inicio da leitura</label>
                    <input id="data_inicio" name="data_inicio" placeholder="06/06/2023" type="date" class="form-control">
                    <div id="passwordHelpBlock" class="form-text">
                        Deixe esse campo em branco para o livro ser adicionado na lista de desejos. Preecnha esse campo se você já começou a ler esse livro
                    </div>

                    @error('nome_livro')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

                <input type="text" class="d-none form-control" id="pagina_total" name="pagina_total" value="">
                <div class="mb-4">
                    <label for="descricao" class="form-label">Descrição do Livro</label>
                    <textarea placeholder="Temas do livro ou sinopse" class="form-control @error('descricao_livro') is-invalid @enderror" id="descricao_livro" required name="descricao_livro" rows="1"></textarea>

                    @error('descricao_livro')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror

                </div>

                <button type="submit" style="width: 100%" class="btn btn-blue">Cadastrar</button>
            </form>
        {{-- @endif --}}
    </div>

    <script>
        // Obtém o elemento textarea
        var textarea = document.getElementById('descricao_livro');

        // Define a altura inicial com base no conteúdo
        textarea.style.height = (textarea.scrollHeight) + 'px';

        // Adiciona um ouvinte de eventos para ajustar a altura quando o conteúdo é modificado
        textarea.addEventListener('input', function () {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight + 5) + 'px';
        });
    </script>


    <script>
        var xhr; // Variável para armazenar o objeto XMLHttpRequest


        $('.campo-nome-livro').on('input', function(){
            nome = this.value
            $(".livro").css('background-image', ``)

            if(!nome){
                if (xhr) xhr.abort(); // Abortar qualquer requisição AJAX pendente
                return;
            }

            if (xhr) xhr.abort();

            xhr = $.ajax({
                url: `/google-api/bookByName/${nome}`,
                success: function(response){
                    console.log(response);
                    $(".livro").css('background-image', `url('${response.url_capa}')`)
                },
                error: function(error){
                    console.log(error);
                }
            })
        })
    </script>

    <script src="{{asset('js\preview_image.js')}}"></script>
@endsection
