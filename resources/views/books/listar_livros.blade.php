@extends('layouts.main')
@section('title', 'Pagina principal')

@section('content')
    <div class="container">

        @if (empty($compartilhado))
            @php
                $text = "Meus livros"
            @endphp
            <input type="text" style="position: absolute; top: 0; z-index: -1;" id="link" value="https://readbook.x10.mx/compartilhar-livro/{{auth()->user()->id}}">

        @else
            @php
                $text = "Livros de $user->name"
            @endphp

        @endif

        @if(isset($_GET['filtro']) && $_GET['filtro'])
                @if($_GET['filtro'] == 'lidos')
                    <h1  class="text-center titulo-livros">{{ $text }} lidos</h1>

                @elseif($_GET['filtro'] == 'nao_lidos')
                    <h1  class="text-center titulo-livros">{{ $text }}</h1> <h2 class="text-center mb-3">Não finalizados</h2>

                @elseif($_GET['filtro'] == 'lista_desejo')
                    <h1  class="text-center titulo-livros">{{ $text }}</h1> <h2 class="text-center mb-3">Lista de desejo</h2>
                @endif

                <p class="text-center text-quantidade-livros">livros encontrados {{$quantidadeLivrosLidos}}</p>

                {{-- @if(isset($_GET['filtro']) && $_GET['filtro'])
                    <p class="text-center text-quantidade-livros">livros encontrados {{$quantidadeLivrosLidos}}</p>
                @else
                    <p class="text-center text-quantidade-livros">Você terminou de ler {{$quantidadeLivrosLidos}} de {{$quantidadeLivros}} livros</p>
                @endif --}}

        @else
            @if ($livros != "[]")
                <h1  class="text-center titulo-livros">{{ $text }}</h1>
                @if(isset($_GET['filtro']) && $_GET['filtro'])
                    <p class="text-center text-quantidade-livros">livros encontrados {{$quantidadeLivrosLidos}}</p>
                @else
                    <p class="text-center text-quantidade-livros">Terminou de ler {{$quantidadeLivrosLidos}} de {{$quantidadeLivros}} livros</p>
                    @if($quantidadeListaDesejo)
                        <p class="text-center text-quantidade-livros" style="margin-top: -10px">Lista de desejo: {{$quantidadeListaDesejo}}</p>
                        <p class="text-center text-quantidade-livros" style="margin-top: -10px">Total de livros: {{count($livros)}}</p>
                    @endif
                @endif
            @endif
        @endif


        @if (empty($compartilhado))

            <div class="alert alert-success alert-dismissible fade show" role="alert" style="">
                <strong>Novidade. </strong> É possível compartilhar os livros que está lendo <a href="/como-compartilhar">Saiba Mais</a>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- NOTIFICACAO DE CADASTRO -->
        <?php
         if(isset($_GET['cad'])){
            if($_GET['cad'] == 'sucess'){ ?>
                <!-- MENSAGEM DE CONTA CRIADA-->
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: -50px!important;margin-bottom: 50px!important;">
                    <strong>Livro Cadastrado!</strong> Confira todos os livros cadastrados.
                    <button onclick="window.location.href = '/livros'" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

            <!-- MENSAGEM DE CONTA NÃO CRIADA-->
            <?php }elseif($_GET['cad'] == 'danger'){ ?>
                <div class="alert alert-danger alert-dismissible fade show " role="alert" style="margin-top: -50px!important;margin-bottom: 50px!important;">
                    <strong>Livro não Cadastrado!</strong> Não foi possível cadastrar um livro.
                    <button onclick="window.location.href = '/livros'" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php }
        } ?>

        {{-- BOTÃO ADICIONAR LIVRO --}}
        {{-- <a class="btn-adicionar-livro" href="/criar" style="background: @if (auth()->check()) {{auth()->user()->primary_color}} @else #5bb4ff @endif!important;">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"></path>
            </svg>
        </a> --}}


        @if(empty($compartilhado))
            <div class="btn-group dropup" style="border: 0">
                <button style="border: 0; z-index: 999" type="button" class="btn-adicionar-livro" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                        <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                    </svg>
                </button>
                <ul class="dropdown-menu">
                    <li><a id="btnCopiar" data-bs-toggle="modal" data-bs-target="#compartilhar-livro" class="dropdown-item" id="btnCopiar" href="#">Compartilhar</a></li>
                    <li><a class="dropdown-item" href="/criar">Adicionar livro</a></li>
                </ul>
            </div>
        @endif


        <!-- NOTIFICACAO DE EXCLUSÃO -->
        <?php
         if(isset($_GET['exc'])){
            if($_GET['exc'] == 'sucess'){ ?>
                <!-- MENSAGEM DE CONTA CRIADA-->
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: -50px!important;margin-bottom: 50px!important;">
                    <strong>Livro Excluido com sucesso!</strong>
                    <button onclick="window.location.href = '/livros'" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

            <!-- MENSAGEM DE CONTA NÃO CRIADA-->
            <?php }elseif($_GET['exc'] == 'danger'){ ?>
                <div class="alert alert-danger alert-dismissible fade show " role="alert" style="margin-top: -50px!important;margin-bottom: 50px!important;">
                    <strong>Não foi possível excluir o livro.</strong> Tente novamente mais tarde.
                    <button onclick="window.location.href = '/livros'" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php }
        } ?>

        {{-- PESQUISA --}}

        @if (empty($compartilhado))
            @if (count($livros) && !isset($_GET['filtro']) || isset($_GET['filtro']))
                <div class="row row-pesquisa-livro" style="margin-bottom: 100px">
                    <div class="col">
                        <form class="d-flex" method="GET" action="/pesquisa">
                            @csrf
                            <input class="form-control me-2" type="search" id="livro" name="livro" placeholder="Nome do Livro" aria-label="Search">
                            <button class="btn" style="background: @if (auth()->check()) {{auth()->user()->primary_color}} @else #5bb4ff @endif!important; color: #fff; padding: 0; min-width: 50px;" type="submit">
                                <img height="40px" src="{{asset('img/search.png')}}" alt="" srcset="">
                            </button>
                        </form>
                        <form action="{{ route('livros.filtrar') }}" method="get">
                            <select name="filtro" class="form-select mt-4" aria-label="Default select example" onchange="this.form.submit()">
                                <option value="todos" {{ request('filtro') == 'todos' ? 'selected' : '' }}>Todos</option>
                                <option value="lidos" {{ request('filtro') == 'lidos' ? 'selected' : '' }}>Lidos</option>
                                <option value="nao_lidos" {{ request('filtro') == 'nao_lidos' ? 'selected' : '' }}>Não lidos</option>
                                <option value="lista_desejo" {{ request('filtro') == 'lista_desejo' ? 'selected' : '' }}>Lista de desejo</option>
                            </select>
                        </form>
                    </div>
                </div>
            @endif
        @endif


        <div class="row row-list-livros">
            @if ($livros == "[]" && !isset($_GET['filtro']))
                <h1 class="text-center">Você não tem nenhum livro cadastrado</h1>
                <a class="btn mt-5" href="/criar" style="background: @if (auth()->check()) {{auth()->user()->primary_color}} @else #5bb4ff @endif!important; color: #fff">Clique aqui para cadastrar</a>
            @else
                @foreach ($livros as $livro)
                    @php
                        if(empty($compartilhado))
                            $link = "/livro?id=$livro->id_livro";
                        else
                            $link = "https://readbook.x10.mx/compartilhar-um-livro/$livro->id_livro";
                    @endphp

                    <div class="col col-livro">
                        <a class="link-livro" href="{{$link}}">
                            <div class="livro"  @if ($livro->img_livro) style="background-image:url('{{ asset($livro->img_livro) }}');" @else style="background-image:url('../img/book_transparent.png');" @endif>
                                @if ($livro->img_livro == null)
                                    <h1>{{ $livro->nome_livro }}</h1>
                                @endif
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>


    @if(auth()->check())
        <!-- Modal de apar livro -->
        <div class="modal fade" id="compartilhar-livro" tabindex="-1" aria-labelledby="compartilhar-livro" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title compartilhar-livro" id="compartilhar-livro">Compartilhar todos os livros</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Link: <a href="https://readbook.x10.mx/compartilhar-livro/{{auth()->user()->id}}">https://readbook.x10.mx/compartilhar-livro/{{auth()->user()->id}}</a>
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
