@extends('layouts.main')

@section('title', 'Resumo da leitura')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container">
    <h1 style="text-align: center">Controle da sua leitura</h1>
    <canvas id="myChart" class="caanva-livro-lido-mes"></canvas>
</div>

<?php
// Seus dados de livros
$dadosLivros = $livros;

// Decodificar o JSON para um array associativo
$livros = json_decode($livros, true);

$labels = [];
$livrosLidos = [];
$livrosIniciados = [];

// Processar dados para o gráfico
foreach ($livros as $livro) {
    if ($livro['data_inicio']) {
        // Converter a data para o formato desejado (você pode ajustar isso conforme necessário)
        $dataFormatada = date('M Y', strtotime($livro['data_inicio']));

        // Verificar se o mês já está no array de labels
        if (!in_array($dataFormatada, $labels)) {
            $labels[] = $dataFormatada;
            $livrosLidos[$dataFormatada] = 0;
            $livrosIniciados[$dataFormatada] = 0;
        }

        // Incrementar a quantidade de livros iniciados
        $livrosIniciados[$dataFormatada]++;

        // Verificar se o livro foi lido (nesse exemplo, consideramos qualquer livro com pelo menos uma página lida como lido)
        if ($livro['paginas_lidas'] > 0) {
            $livrosLidos[$dataFormatada]++;
        }
    }
}

// Converter dados para formato adequado para o JavaScript
$labels = json_encode($labels);
$livrosLidos = json_encode(array_values($livrosLidos));
$livrosIniciados = json_encode(array_values($livrosIniciados));


?>

<script>
    // Use os dados do PHP para configurar o gráfico
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo $labels; ?>,
            datasets: [
                {
                    label: 'Livros Iniciados',
                    data: <?php echo $livrosIniciados; ?>,
                    backgroundColor: '#5bb4ff',
                    borderColor: '#5bb4ff ',
                    borderWidth: 1
                },
                {
                    label: 'Livros Lidos',
                    data: <?php echo $livrosLidos; ?>,
                    backgroundColor: 'rgba(75, 192, 192, 1)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection



