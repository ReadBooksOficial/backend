@extends('layouts.main')
@section('title', 'Pagina principal')

@section('content')
    <div class="container">

        <h1  class="text-center mb-5 mt-5">Selecione o Livro</h1>

        <form action="/create" method="post">
            @csrf
            <div class="row mb-5">
                <div class="col-10 mb-3">
                    <input placeholder="Nome do livro" value="{{$book_title}}" type="text" class="form-control @error('nome1') is-invalid @enderror" id="nome1" name="nome1">
                    @error('nome1')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-2">
                    <button type="submit" class="btn btn-blue" style="width: 100%">Pesquisar</button>
                </div>
            </div>
        </form>

        <div class="row row-list-livros">
            <div class="col col-livro cursor-pointer">
                <a class="link-livro" href="/create/outro-livro/{{$book_title}}">
                    <div class="livro"  style="background-image:url('../img/book_transparent.png');">
                        <h1>Outro</h1>
                    </div>
                </a>
            </div>

            @if (!empty($livros))
                @foreach ($livros as $livro)
                    <div class="col col-livro">
                        <a class="link-livro" href="/google-livro/{{$livro['id']}}">
                            <div class="livro" style="background-image:url('{{ asset($livro['thumbnail']) }}');">
                                @if ($livro['thumbnail'] == '../img/book_transparent.png')
                                    <h1>{{ $livro['title']}}</h1>
                                @endif
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif

            {{-- @if (empty($livros) && !isset($_GET['filtro']))
                <!-- Caso não haja livros e o filtro não esteja definido -->
                @else
                    @foreach ($livros->docs as $livro) <!-- A Open Library retorna a lista de livros em 'docs' -->
                        @php
                            $livro_img = $livro->cover_i ?? '../img/book_transparent.png'; // Se não houver imagem, usa uma imagem padrão
                            $livro_nome = $livro->title ?? 'Sem Título';
                        @endphp

                        <div class="col col-livro">
                            <a class="link-livro" href="/openlibrary-livro/">
                                <div class="livro" style="background-image:url('https://covers.openlibrary.org/b/id/{{ $livro_img }}-L.jpg');">
                                    @if ($livro_img == '../img/book_transparent.png')
                                        <h1>{{ $livro_nome }}</h1>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif --}}



    @if(auth()->check())

        <!-- Modal de apar livro -->
        <div class="modal fade" id="compartilhar-livro" tabindex="-1" aria-labelledby="compartilhar-livro" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title compartilhar-livro" id="compartilhar-livro">Lik copiado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Link: <a href="{{ env('APP_URL') }}/compartilhar-livro/{{auth()->user()->id}}">{{ env('APP_URL') }}/compartilhar-livro/{{auth()->user()->id}}</a>
                        De todos os livros.
                    </div>
                    <div class="modal-footer" style="flex-wrap: nowrap">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 100%">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(auth()->check())
        <div class="modal fade" id="outro-livro" tabindex="-1" aria-labelledby="outro-livro" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-cadastrar-livro">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title outro-livro" id="outro-livro">Cadastrar livro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="form-cadastrar-livro-google" action="/createDois" method="post" enctype="multipart/form-data">
                            @csrf
                            <h1 class="text-center">Cadastre um Livro</h1>
                            <div class="mb-3">
                                <label for="nome_livro" class="form-label">Nome do Livro</label>
                                <input type="text" class="form-control" id="nome_livro" name="nome_livro">
                                @error('nome_livro')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="img_livro_usuario" data-label-image class="form-label">Capa do Livro
                                    <input type="file" class="d-none" data-input-image id="img_livro_usuario" name="img_livro_usuario">
                                    <div class="img-escolher-capa">
                                        Clique para escolher imagem
                                        <img data-image-preview height="300px" width="200px" class="img-escolher-capa">
                                    </div>
                                </label>
                            </div>

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
                    </div>
                    <div class="modal-footer" style="flex-wrap: nowrap">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 100%">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Adiciona um evento de clique ao botão
        document.getElementById("btnCopiar").addEventListener("click", function() {
            // Seleciona o texto da área de texto
            var texto = document.getElementById("link");
            texto.select();
            texto.setSelectionRange(0, 99999); // Para dispositivos móveis

            // Tenta copiar o texto para a área de transferência
            try {
                document.execCommand("copy");
                document.querySelector(".compartilhar-livro").innerHTML = "Link Copiado"
                // alert("Link copiado, agora você pode compartilhar para quem quiser");
            } catch (err) {
                // alert("Erro ao copiar texto: " + err);
                document.querySelector(".compartilhar-livro").innerHTML = "Erro ao copiar link"
            }
        });
    });
    </script>
@endsection
