@extends('layouts.main')
@section('title', 'Livro - ' . $livro->volumeInfo->title)
@section('content')

    <div class="container container-livro">
        @include('components.message_danger')
        @include('components.message_success')
        
        <div class="row">
            <div class="col-4">
                <div class="div-img-livro-selecionado" @if ($img == '../img/book_transparent.png')style="background-image: url('../img/book_transparent.png');" @endif>
                    @if ($img != '../img/book_transparent.png')
                        <img src="{{$img}}"  class="img-livro-selecionado">
                    @else
                        <h1>{{  $livro->volumeInfo->title }}</h1>
                    @endif
                </div>
            </div>

            <div class="col-8 col-info-livro">
                <h1 class="nome-livro-lido">{{  $livro->volumeInfo->title  }}</h1>

                <div class="mt-4 row row-livro-lido">
                    <div class="col">
                        <p style="line-height: 30px">
                            @if(isset($livro->volumeInfo->authors) && is_array($livro->volumeInfo->authors))
                            <b>Autores:</b> {{ implode(", ", $livro->volumeInfo->authors) }}<br>
                        @endif
                        
                        @if(isset($livro->volumeInfo->pageCount))
                            <b>Páginas:</b> {{$livro->volumeInfo->pageCount}}<br>
                        @endif
                        
                            
                        @if(isset($livro->volumeInfo->publishedDate))
                            <b>Data de publicação:</b>  {{ Carbon\Carbon::parse($livro->volumeInfo->publishedDate)->format('d/m/Y') }} <br>
                        @endif

                            @if(isset($livro->saleInfo->buyLink))
                                <b>Preview: </b><a target="_BLANK" href="{{$livro->volumeInfo->previewLink}}">Google livros - {{  $livro->volumeInfo->title  }}</a><br>
                            @endif

                            @if(isset($livro->saleInfo->retailPrice->amount))
                                <b>Preço do PDF: </b>  R$ <span class="precoPDF">{{str_replace('.', ',', $livro->saleInfo->retailPrice->amount)}}</span></a><br>
                            @endif

                            @if(isset($livro->saleInfo->buyLink))
                                <b>Comprar PDF: </b>  <a target="_BLANK" href="{{$livro->saleInfo->buyLink}}">Google livros - {{  $livro->volumeInfo->title  }}</a>
                            @endif
                        </p>
                    </div>

                    @if (auth()->check())
                        <div class="col col-livro-lido">
                            <div class="col-12" style="display: flex; justify-content: space-between;">
                                <form class="w-100" method="POST" action="/adicionar-leitura">
                                    @csrf
                                    <input type="hidden" name="descricao_livro" id="descricao_livro" value="{{isset($livro->volumeInfo->description) ? $livro->volumeInfo->description : ""}}">
                                    <input type="hidden" name="nome_livro" id="nome_livro" value="{{isset($livro->volumeInfo->title) ? $livro->volumeInfo->title : "Autor: $livro->volumeInfo->authors"}}">
                                    <input type="hidden" name="id_livro_google" id="id_livro_google" value="{{isset($livro->id) ? $livro->id : 0}}">
                                    <input type="hidden" name="pagina_total" id="pagina_total" value="{{isset($livro->volumeInfo->pageCount) ? $livro->volumeInfo->pageCount : 0}}">
                                    <textarea class="d-none" name="img_google" id="img_google">{{isset($img) && $img != '../img/book_transparent.png' ? $img : ''}}</textarea>

                                    <button type="submit" class="btn-livro btn btn-primary" style="width: 100%; margin-top: 10px" >
                                        Adicionar a leitura
                                    </button>
                                </form>
                            </div>
                            <a id="btnCopiar" class="btn-livro btn btn-outline-primary" style="width: 100%; margin-top: 10px" type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#compartilhar-livro">
                                Compartilhar
                            </a>
                        </div>
                    @endif
                </div>
                <h3 class="mt-5">Descrição</h3>
                <p>{!!  isset($livro->volumeInfo->description) ? $livro->volumeInfo->description : '' !!}</p>

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
                Link: <a href="{{ env('APP_URL') }}/google-livro/{{  $livro->id  }}">{{ env('APP_URL') }}/google-livro/{{  $livro->id  }}</a>.
                do livro "{{  $livro->volumeInfo->title  }}
            </div>
            <div class="modal-footer" style="flex-wrap: nowrap">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: 100%">
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>



<input type="text" style="position: absolute; top: 0; z-index: -1;" id="link" value="{{ env('APP_URL') }}/google-livro/{{  $livro->id  }}">

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



