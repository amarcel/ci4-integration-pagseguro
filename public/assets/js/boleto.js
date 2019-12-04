function pagarBoleto(e) {
	e.preventDefault();

	var hash_pagamento = PagSeguroDirectPayment.getSenderHash();
	$('#hash_pagamento').val(hash_pagamento);

	$.ajax({
		type: 'post',
		url: 'pagar/pg_boleto',
		data: $('.form').serialize(),
		dataType: 'json',
		beforeSend: function () {
			$('.msg').html('<div class="loading style-2"><div class="loading-wheel"></div></div')
		}
	}).done(function (res) {
		console.log(res);
		if (res.error == 0) {
			$('#pagar_boleto').val("Boleto gerado com sucesso");
			$('.msg').html('Enviado com sucesso. Link do boleto: <a target="_blank" href="' + res.code.paymentLink + '">Clique aqui para baixar</a>');
		} else {
			$('.msg').html('Ocorreu um erro: ' + res.error + ' ' + res.message)
		}
	}).fail(function (res) {
		$('.msg').html('Ocorreu um erro: ' + res.error + ' ' + res.message)

	}).always(function (res) {
		$('#pagar_boleto').attr('disabled', true);
	});

}

/**
 * Função obrigatória para gerar a sessão de pagamento da API do PagSeguro
 */
function setSessionIdPagSeguro() {
	$.ajax({
		url: 'pagar/pg_session_id',
		dataType: 'json',
		success: function (res) {
			console.log(res);
			if (res.error == 0) {
				var id_sessao = res.id_sessao;
				//Pagamento
				PagSeguroDirectPayment.setSessionId(id_sessao);

			} else {
				//alert('Error entrou no success:' + res.error + ' ' + res.message);
			}
			//alert(res.id_sessao);
		},
		error: function () {
			//alert('Error:' + res.error + ' ' + res.message);
		}
	});
}

//Iniciando a sessão ao abrir a página
setSessionIdPagSeguro();