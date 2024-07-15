@extends('layouts.main')

@section('title', 'Resumo da leitura')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container">
    <h1 class="mt-5" style="text-align: center">Controle da sua leitura</h1>

    <div class="row mt-5">
        <div class="col">
            <div id="chartContainer2" style="height: 370px; width: 100%;background: #A8A8A8"></div>
        </div>
        <div class="col">
            <h2>Livros lidos: {{$countLidos}}</h2>
            <h2>Não finalizados: {{$countNaoLidos}}</h2>
            <h2>Lista de desejo: {{$countListaDesejo}}</h2>
        </div>
    </div>
</div>

<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

<script>
    window.onload = function() {

var chart = new CanvasJS.Chart("chartContainer2", {
	theme: "light2", // "light1", "light2", "dark1", "dark2"
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

}
    </script>

@endsection
