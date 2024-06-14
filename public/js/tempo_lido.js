function calcularTempoLeitura() {
    const checkbox = $("#tempo_leitura");
    const startDateInput = $("#data_inicio");
    const endDateInput = $("#data_termino");
    const readingTimeInput = $("#tempo_lido");

    // Obtém a data atual
    const dataAtual = new Date();
    // Extrai o ano, mês e dia da data atual
    const ano = dataAtual.getFullYear();
    const mes = String(dataAtual.getMonth() + 1).padStart(2, '0'); // Adiciona 1 ao mês, pois é indexado em 0
    const dia = String(dataAtual.getDate()).padStart(2, '0');
    // Formata a data como yyyy-mm-dd
    const dataFormatada = `${ano}-${mes}-${dia}`;

    var dataInicio = startDateInput.val()
    var dataFim = endDateInput.val()

    // Check if start and end date inputs are empty
    if (!startDateInput.val())
        dataInicio = dataFormatada

    if (!endDateInput.val())
        dataFim = dataFormatada

    if((startDateInput.val() && endDateInput.val()) && startDateInput.val() > endDateInput.val()){
        $(".text-data-inicio").text("A data de inicio não pode ser maior que data de fim")
        $(".text-data-inicio").addClass("invalid-feedback")
        $(".text-data-inicio").css("display", 'block')
        $("#data_inicio").addClass("is-invalid")
        $("#data_termino").addClass("is-invalid")
        $("button").prop("disabled", true)
        return;
    }else{
        $(".text-data-inicio").text(`
            Deixe esse campo em branco para o livro ser adicionado na lista de desejos. Preecnha esse campo se você já começou a
            ler esse livro
        `)
        $(".text-data-inicio").removeClass("invalid-feedback")
        $("#data_inicio").removeClass("is-invalid")
        $("#data_termino").removeClass("is-invalid")
        $("button").prop("disabled", false)
    }



    // Validate date formats (consider using a date picker library)
    const startDate = new Date(dataInicio);
    const endDate = new Date(dataFim);

    if (isNaN(startDate.getTime()) || isNaN(endDate.getTime())) {
      console.error("Invalid date format. Please use YYYY-MM-DD");
      return;
    }

    const milliseconds1 = startDate.getTime();
    const milliseconds2 = endDate.getTime();

    const differenceInMilliseconds = milliseconds2 - milliseconds1;

    // Calculate difference in days (consider including hours/minutes for shorter durations)
    const differenceInDays = Math.ceil(differenceInMilliseconds / (1000 * 60 * 60 * 24)) + 1;

    if (checkbox.is(":checked")) {
        if(differenceInDays >=0)
            readingTimeInput.val(`${differenceInDays} dias`);
        else
            readingTimeInput.val("");
    } else {
      readingTimeInput.val(""); // Clear reading time if checkbox is unchecked
    }
  }

  calcularTempoLeitura();

$("#tempo_leitura").change(calcularTempoLeitura);
$("#data_inicio").on('input', calcularTempoLeitura);
$("#data_termino").on('input', calcularTempoLeitura);
