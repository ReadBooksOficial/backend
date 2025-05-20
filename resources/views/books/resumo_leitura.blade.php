@extends('layouts.main')

@section('title', 'Read Books - Resumo da leitura')

@section('meta_title', 'Read Books - Reumo da Leitura')
@section('meta_description', 'Saiba quantos livros você já leu, quantos não finalizou e quantos estão na sua lista de desejos')
@section('meta_keywords', 'livros, leitura, rede social, Read Books, criar livro, resumo leitura, resumo, controle leitura, controle de leitura, estante virtual, estante de livros, estante de leitura, compartilhar livros, compartilhar leitura, gerenciar leitura')
@section('meta_image', asset('img/estante_icon_fundo.png'))
@section('meta_url', url()->current())

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container container-resumo">
    <h1 class="mt-5 titulo-controle-leitura" style="text-align: center">Dados da sua leitura</h1>

    <div class="row mt-5 row-controle-leitura">
		<div class="col-text-resumo">
            <!-- Contagem dos livros -->
            <h2>Livros lidos: {{$countLidos}}</h2>
            <h2>Não finalizados: {{$countNaoLidos}}</h2>
            <h2>Lista de desejo: {{$countListaDesejo}}</h2>
        </div>
        <div class="col-12">
            <!-- Gráfico de Pizza -->
            <div id="chartContainer2" style="height: 370px; width: 100%;background: #A8A8A8"></div>
        </div>
        
    </div>

    <!-- Adicionando o gráfico de barras -->
    <div class="row mt-5">
        <div class="col">
            <canvas id="barChart"></canvas>
        </div>
    </div>

    <!-- Gráfico de Linha (exemplo de progresso ao longo do tempo) -->
    <div class="row mt-5">
        <div class="col">
            <canvas id="lineChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

<script>
    window.onload = function() {

        // Gráfico de Pizza
        var chart = new CanvasJS.Chart("chartContainer2", {
            theme: "light2",
            exportEnabled: true,
            animationEnabled: true,
            title: {
                text: "Resumo"
            },
            data: [{
                type: "pie",
                startAngle: 25,
                toolTipContent: "<b>{label}</b>: {y}%",
                showInLegend: "true",
                legendText: "{label}",
                indexLabelFontSize: 16,
                indexLabel: "{label} - {y}%",
                dataPoints: [
                    { y: {{$countLidos / count($livros) * 100}}, label: "Lidos" },
                    { y: {{$countNaoLidos / count($livros) * 100}}, label: "Não finalizados" },
                    { y: {{$countListaDesejo / count($livros) * 100}}, label: "Lista de desejo" },
                ]
            }]
        });
        chart.render();

        // Gráfico de Barras - Número de livros por categoria
        var ctxBar = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Lidos', 'Não finalizados', 'Lista de desejo'],
                datasets: [{
                    label: 'Número de livros',
                    data: [{{$countLidos}}, {{$countNaoLidos}}, {{$countListaDesejo}}],
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                    borderColor: ['#28a745', '#ffc107', '#dc3545'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Gráfico de Linha - Progresso ao longo dos últimos 5 meses
        var ctxLine = document.getElementById('lineChart').getContext('2d');
        var lineChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: @json($meses), // Meses dinâmicos (Janeiro, Fevereiro, etc.)
                datasets: [{
                    label: 'Livros lidos por mês',
                    data: [@foreach($meses as $mes) {{$dadosMeses[$mes]}}, @endforeach], // Dados dinâmicos para livros lidos por mês
                    fill: false,
                    borderColor: '#0078D4',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
</script>

@endsection
