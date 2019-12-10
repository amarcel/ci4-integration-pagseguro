function pagarBoleto(e) {
	e.preventDefault();

	var hashPagamento = PagSeguroDirectPayment.getSenderHash();
	$('#hash_pagamento').val(hashPagamento);

	$.ajax({
		type: 'post',
		url: 'gerarPagamento',
		data: $('.form').serialize(),
		dataType: 'json',
		beforeSend() {
			$('.msg').html('<div class="loading style-2"><div class="loading-wheel"></div></div');
		}
	}).done(function (res) {
		console.log(res.message);
		if (res.error === 0) {
			$('#btn_pagar').val("Boleto gerado com sucesso");
			$('.msg').html('Enviado com sucesso. Link do boleto: <a target="_blank" href="' + res.code.paymentLink + '">Clique aqui para baixar</a>');
		} else {
			$('.msg').html('Ocorreu um erro: ' + res.error + ' ' + res.message);
		}
	}).fail(function (res) {
		$('.msg').html('Ocorreu um erro: ' + res.error + ' ' + res.message);

	}).always(function (res) {
		$('#btn_pagar').attr('disabled', true);
	});

}