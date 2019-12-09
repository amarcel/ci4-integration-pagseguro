/**
 * Função responsável por validar e o número de parcelas e chamar a getInstallments
 */

$("#parcelas").on('change', function (e) {
	var parcelas = $(this).val();
	if (parcelas != 0) {
		getInstallments();
		$('#btn_pagar').attr("disabled", false);
		$('#btn_pagar').addClass("btn-success").removeClass("btn-danger");
	} else {
		$('#btn_pagar').attr("disabled", true);
		$('#vparcela').val('');
		$('#btn_pagar').addClass("btn-danger").removeClass("btn-success");
	}
});



/**
 * Função da API para gerar o valor da parcela 
 */
$('#valorTotal').val($('#valor').val() * $('#quantidade').val());
function getInstallments() {

	var parc = $('#parcelas').val() - 1;
	PagSeguroDirectPayment.getInstallments({
		amount: ($('#valor').val() * $('#quantidade').val()),
		maxInstallmentNoInterest: 12,
		brand: 'visa',
		success: function (res) {
			// Retorna as opções de parcelamento disponíveis
			var valor_parcela = res.installments.visa[parc].installmentAmount;
			var valor = res.installments.visa[parc].totalAmount;
			/*
			console.log('Valor parcela:' + valor_parcela);
			console.log('Valor total:' + valor);
			*/
			$('#vparcela').val(parseFloat(valor_parcela));
			$('#valorTotal').val(parseFloat(valor));
		},
		error: function (response) {
			alert('Erro getInstallments() in credito.js' + response.error)
			// callback para chamadas que falharam.
		},
		complete: function (response) {
			// Callback para todas chamadas.
		}
	});

}

/**
 * Função responsável por verificar o token e fazer as atribuições necessárias para o cartão de crédito
 * @param {event} e 
 */
function gerarToken(e) {
	e.preventDefault();

	var numero = $('#ncartao').val();
	var cvv = $('#cvv').val();
	var validade = $('#validade').val();
	validade = validade.split("/");
	var mes = validade[0];
	var ano = validade[1];

	PagSeguroDirectPayment.createCardToken({
		cardNumber: numero, // Número do cartão de crédito
		brand: 'visa', // Bandeira do cartão
		cvv: cvv, // CVV do cartão
		expirationMonth: mes, // Mês da expiração do cartão
		expirationYear: ano, // Ano da expiração do cartão, é necessário os 4 dígitos.
		success: function (response) {
			// Retorna o cartão tokenizado.
			tokenPagamento = response.card.token;

			//Verifica se token não veio vazio
			if (!tokenPagamento) {
				alert('Cartão inválido');
			} else {
				//coloca token no input type hidden
				$('#credit_token').val(tokenPagamento);
				pagarCartao();
			}
		},
		error: function (response) {
			// Callback para chamadas que falharam.
			alert('Erro ao gerar token de pagamento' + response.error);
			console.log(response);
		}
	});
}

/**
 * Função que realiza o pagamento de fato enviando os dados para o controller
 */
function pagarCartao() {

	//Pega o hash de pagamento
	$('#hash_pagamento').val(PagSeguroDirectPayment.getSenderHash());

	$.ajax({
		type: 'post',
		url: 'gerarPagamento',
		data: $('.form').serialize(),
		dataType: 'json',
		beforeSend: function () {
			$('.msg').html('<div class="loading style-2"><div class="loading-wheel"></div></div')
		}
	}).done(function (res) {
		console.log(res);
		if (res.error == 0) {
			$('#btn_pagar').val('Pagamento solicitado com sucesso');
			$('.msg').html('Enviado com sucesso. Código da compra: ' + res.code.code);
		} else {
			$('.msg').html('Ocorreu um erro: ' + res.error + ' ' + res.message)
		}
	}).fail(function (res) {
		$('.msg').html('Ocorreu um erro: ' + res.error + ' ' + res.message)

	}).always(function (res) {
		$('#parcelas').attr("disabled", true);
		$('#btn_pagar').attr("disabled", true);
	});

}