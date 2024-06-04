@extends('layouts.main')
@section('title', 'Livro - ' . $livro->nome_livro)
@section('content')
{{-- href="/excluir/{{$livro->id_livro}}" --}}
{{-- <script>
    function confirmDelete(delUrl) {
        if (confirm("Deseja apagar o livro? Não é possivel recuperar.")) {
            document.location = delUrl;
        }
    }
</script> --}}
    <div class="container container-livro">
         <!-- NOTIFICACAO DE EDIÇÃO -->
        <!-- MENSAGEM DE CONTA CRIADA-->
         @if(session()->has('book-update-success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: -50px!important;margin-bottom: 50px!important;">
                <strong>Livro editado com sucesso!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- MENSAGEM DE CONTA NÃO CRIADA-->
        @if(session()->has('conta-update-danger'))
            <div class="alert alert-danger alert-dismissible fade show " role="alert" style="margin-top: -50px!important;margin-bottom: 50px!important;">
                <strong>Não foi possível editar o livro.</strong> Tente novamente mais tarde.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-4">
                <div class="div-img-livro-selecionado" @if ($livro->img_livro == null)style="background-image: url('../img/book_transparent.png');" @endif>
                    @if ($livro->img_livro)
                        <img src="{{ $livro->img_livro }}"  class="img-livro-selecionado">
                    @endif

                    @if ($livro->img_livro == null)
                        <h1>{{  $livro->nome_livro }}</h1>
                    @endif
                </div>
            </div>

            <div class="col-8 col-info-livro">
                <h1 class="nome-livro-lido">{{  $livro->nome_livro  }}</h1>
                <p><textarea style="min-height: 4px!important;" disabled class="text-descricao" id="descricao">{{  $livro->descricao_livro  }}</textarea></p>

                <div class="row row-livro-lido">
                    <div class="col">
                        <h3>Tempo de leitura: {{$livro->tempo_lido }}</h3>
                        <h3>Páginas Lidas: {{$livro->paginas_lidas}} @if($livro->total_paginas) / {{$livro->total_paginas}} @endif</h3>
                        <h3>Terminou: {{$livro->lido}}</h3>

                        @if($livro->data_inicio)
                            @php
                                $data_inicio = date("d/m/Y", strtotime($livro->data_inicio));
                            @endphp
                            <h3>Data de inicio: {{$data_inicio}}</h3>
                        @endif

                        @if ($livro->data_termino)
                        @php
                            $data_termino = date("d/m/Y", strtotime($livro->data_termino));
                        @endphp
                            <h3>Data de término: {{$data_termino}}</h3>
                        @endif
                    </div>

                    @if (auth()->check() && auth()->user()->id == $livro->id_usuario)
                        <div class="col col-livro-lido">
                            <div class="col-12" style="display: flex; justify-content: space-between;">
                                <a href="/editar/{{$livro->id_livro}}" class="btn-livro btn btn-outline-primary">Editar</a>
                                <a class="btn-livro btn btn-outline-danger" type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#apagar-livro">
                                    Excluir
                                </a>
                            </div>
                            <a id="btnCopiar" class="btn-livro btn btn-outline-primary" style="width: 100%; margin-top: 10px" type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#compartilhar-livro">
                                Compartilhar
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Obtém o elemento textarea
        var textarea = document.getElementById('descricao');

        // Define a altura inicial com base no conteúdo
        textarea.style.height = (textarea.scrollHeight) + 'px';

        // Adiciona um ouvinte de eventos para ajustar a altura quando o conteúdo é modificado
        textarea.addEventListener('input', function () {
          this.style.height = 'auto';
          this.style.height = (this.scrollHeight) + 'px';
        });
      </script>


<!-- Modal de apar livro -->
<div class="modal fade" id="apagar-livro" tabindex="-1" aria-labelledby="apagar-livro" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="apagar-livro">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tem certeza de que deseja apagar esse livro? Não é possivel recuperar os dados.
            </div>
            <div class="modal-footer" style="flex-wrap: nowrap">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 100%">
                    Cancelar
                </button>

                <a class="btn btn-danger" style="width: 100%" href="/excluir/{{$livro->id_livro}}">
                    Remover
                </a>
            </div>
        </div>
    </div>
</div>


<!-- Modal de apar livro -->
<div class="modal fade" id="compartilhar-livro" tabindex="-1" aria-labelledby="compartilhar-livro" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title compartilhar-livro" id="compartilhar-livro">Compartilhar Livro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Link: <a href="https://readbook.x10.mx/compartilhar-um-livro/{{  $livro->id_livro  }}">https://readbook.x10.mx/compartilhar-um-livro/{{  $livro->id_livro  }}</a>.
                do livro "{{  $livro->nome_livro  }}
            </div>
            <div class="modal-footer" style="flex-wrap: nowrap">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 100%">
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>



<input type="text" style="position: absolute; top: 0; z-index: -1;" id="link" value="https://readbook.x10.mx/compartilhar-um-livro/{{$livro->id_livro}}">

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
                document.querySelector(".compartilhar-livro").innerHTML = "Erro ao copiar link"
                // alert("Erro ao copiar texto: " + err);
            }
        });
    });
    </script>

@endsection



