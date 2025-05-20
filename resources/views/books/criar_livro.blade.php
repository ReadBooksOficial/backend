@extends('layouts.main')
@section('title', 'Read Books - Criar Livro')

@section('meta_title', 'Read Books - Cadastrar Livro')
@section('meta_description', 'Cadastre um livro na sua estante virtual e gerencie sua leitura ou compartilhe com amigos')
@section('meta_keywords', 'livros, leitura, rede social, Read Books, criar livro, cadastrar livro, adicionar livro, criar estante virtual, estante virtual, estante de livros, estante de leitura, compartilhar livros, compartilhar leitura, gerenciar leitura')
@section('meta_image', asset('img/estante_icon_fundo.png'))
@section('meta_url', url()->current())

@section('content')

    <div class="container">

        {{-- {{$dados_livro}} --}}

        @if(!isset($book_title))
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
        @endif

        {{-- CASO A API DO GOOGLE ACHE OS DADOS DO LIVRO --}}
        @if(isset($book_title))
        {{-- o  enctype="multipart/form-data" serve para salvar arquivos --}}
            <form class="form-cadastrar-livro" action="/adicionar-leitura" method="post" enctype="multipart/form-data">
                @csrf
                <h1 class="text-center">Cadastre um Livro</h1>
                <div class="mb-3">
                    <label for="nome_livro" class="form-label">Nome do Livro</label>
                    <input type="text" class="form-control" id="nome_livro" name="nome_livro" value="{{$book_title}}">

                    @error('nome_livro')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                @php
                    $livroController = app(App\Http\Controllers\livroController::class);
                    $url_capas = $livroController->pegarCapaLivro($book_title);
                @endphp


                {{-- Caso tenha uma imagem do livro dentro do próprio site --}}
                @if(isset($img) && $img != '../img/book_transparent.png')
                    <div class="mb-4">
                        <label class="col-12 form-label">Capa do Livro</label>
                        <input type="text" class="d-none" id="img_livro" name="img_livro" value="{{$img}}">
                        <img height="300px" width="200px" src="{{asset($img)}}" class="">

                        {{-- @for($i=0; $i<count($url_capas); $i++)
                            @if(isset($url_capas[$i]->volumeInfo->imageLinks))
                                <img height="300px" width="200px" src="{{$url_capas[$i]->volumeInfo->imageLinks->smallThumbnail}}" class="">
                             @endif
                        @endfor --}}
                    </div>

                {{-- Caso não tenha uma imagem do livro dentro do próprio site --}}
                @else
                    <div class="mb-4">
                        <label for="img_livro_usuario" data-label-image class="form-label">Capa do Livro
                            <input type="file" class="d-none" data-input-image id="img_livro_usuario" name="img_livro_usuario" value="">
                            <div class="img-escolher-capa">
                                Clique para escolher imagem
                                <img data-image-preview height="300px" width="200px" class="img-escolher-capa">
                            </div>
                        </label>
                    </div>
                @endif

                <div class="mb-4">
                    <label for="data_inicio" class="form-label">Data de inicio da leitura</label>
                    <input id="data_inicio" name="data_inicio" placeholder="06/06/2023" type="date" class="form-control">
                    <div id="passwordHelpBlock" class="form-text">
                        Deixe esse campo em branco para o livro ser adicionado na lista de desejos. Preecnha esse campo se você já começou a ler esse livro
                    </div>

                    @error('data_inicio')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

                <div class="mb-4">
                    <div class="form-group">
                        <input class="form-check-input" type="checkbox" value="" id="tempo_leitura" checked>
                        <label class="form-check-label" for="tempo_leitura">
                        Calcular tempo de leitura
                        </label>
                    </div>
                    <div id="passwordHelpBlock" class="form-text">
                        Deixe esse campo em branco para colocar o tempo de leitura manualmente
                    </div>
                </div>


                <input type="text" class="d-none form-control" id="pagina_total" name="pagina_total" value="0">
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
        @endif
    </div>

    <script>
        // Obtém o elemento textarea
        var textarea = document.getElementById('descricao_livro');

        // Define a altura inicial com base no conteúdo
        textarea.style.height = (textarea.scrollHeight) + 'px';

        // Adiciona um ouvinte de eventos para ajustar a altura quando o conteúdo é modificado
        textarea.addEventListener('input', function () {
          this.style.height = 'auto';
          this.style.height = (this.scrollHeight) + 'px';
        });
      </script>

    <script src="{{asset('js\preview_image.js')}}"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{asset('js\tempo_lido.js')}}"></script> --}}

@endsection
