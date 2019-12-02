<!doctype html>
<html>

<head>
	<title>API de Pagamento PagSeguro</title>
	<link rel="shortcut icon" type="image/png" href="/favicon.ico" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
</head>

<body>
	<div class="card">
		<div class=" text-center card-header">
			<a href="/">Voltar</a> - Sandbox
		</div>
		<div class="card-body">
			<div class="text-center">
				<h5 class="card-title">Pagamento API PagSeguro</h5>
				<p class="card-text">Esta funcionalidade está em desenvolvimento.</p>
			</div>
			<form class="form mx-auto col-5" method="POST">
				<input type="hidden" class="form-control" id="hash_pagamento" name="hash_pagamento">
				<input type="hidden" class="form-control" id="credit_token" name="credit_token">
				<div class="form-group mt-4 mb-0">
					<label class="text-left">Nome completo</label>
					<input type="text" class="my-1 form-control" readonly name="nome" placeholder="Gabriela Sueli Aline Rodrigues" value="Gabriela Sueli Aline Rodrigues">
				</div>
				<div class="form-group">
					<label class="text-left ">CPF</label>
					<input type="text" class="my-1 form-control" readonly name="cpf" placeholder="756.624.670-48" value="75662467048">
				</div>
				<div class="form-group">
					<label class="text-left">E-mail</label>
					<input type="text" class="my-1 form-control" readonly name="email" placeholder="v15638893625370231056@sandbox.pagseguro.com.br" value="c19552458299156648365@sandbox.pagseguro.com.br">
				</div>
				<div class="form-group">
					<label class="text-left">Número cartão</label>
					<input id="ncartao" type="text" class="my-1 form-control" readonly name="ncartao" placeholder="4111111111111111" value="4111111111111111">
				</div>
				<div class="form-group">
					<label class="text-left">Validade</label>
					<input id="validade" type="text" class="my-1 form-control" readonly name="validade" placeholder="12/2030" value="12/2030">
				</div>
				<div class="form-group">
					<label class="text-left">CVV</label>
					<input id="cvv" type="text" class="my-1 form-control" readonly name="cvv" placeholder="123" value="123">
				</div>
				<div class="form-group">
					<label class="text-left">Quantidade de Parcelas</label>
					<input id="parcelas" type="text" class="my-1 form-control" readonly name="parcelas" placeholder="2" value="2">
				</div>
				<div class="form-group">
						<label class="my-1">Valor da Parcela</label>
						<input type="text" class="my-1 form-control" readonly id="vparcela" name="valor_parcela" value="50.50">
					</div>
				<div class="form-group">
					<label class="text-left">Referência</label>
					<input type="text" class="my-1 form-control" readonly name="ref" value="<?= md5(uniqid(rand(), true)) ?>">
					<p class="text-muted">Esta é a referência única ao seu pagamento</p>
				</div>

				<div class="form-group">
					<label class="text-left">Valor</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<div class="input-group-text">R$</div>
						</div>
						<input id="valor" type="text" class="form-control" readonly name="valor" value="100">
					</div>
					
				</div>
				<input type="submit" class="btn btn-info btn-pagar-credito" onclick="gerarToken(event)" value="Pagar com boleto bancário"></input>
			</form>

		</div>
		<div class="card-footer text-muted text-center">
			<span class="msg">Status de pagamento

			</span>
		</div>

	</div>

	<script>
		//Função própria da API para calcular o valor total e o valor das parcelas
		function getInstallments(){
			var parc = $('#parcelas').val() - 1;
			PagSeguroDirectPayment.getInstallments({
		        amount: ($('#valor').val()),
		        maxInstallmentNoInterest: $('#parcelas').val(),
		        brand: 'visa',
		        success: function(res){
		       	    // Retorna as opções de parcelamento disponíveis
		       	    console.log(res);
		        	var valor_parcela = res.installments.visa[parc].installmentAmount;
		        	console.log(parseFloat(valor_parcela));
		        	var valor = res.installments.visa[parc].totalAmount;
		        	
		        	$('#vparcela').attr('value',parseFloat(valor_parcela));
		        	$('#valor').attr('value',parseFloat(valor));
		       },
		        error: function(response) {
		       	    // callback para chamadas que falharam.
		       },
		        complete: function(response){
		            // Callback para todas chamadas.
		       }
			});
		}

		function gerarToken(e) {
			e.preventDefault();

			var numero = $('#ncartao').val();
			var cvv = $('#cvv').val();
			var validade = $('#validade').val();
			validade = validade.split("/");
			var mes = validade[0];
			var ano = validade[1];

			//PagSeguroDirectPayment.setSessionId();
			PagSeguroDirectPayment.createCardToken({
			   cardNumber: numero, // Número do cartão de crédito
			   brand: 'visa', // Bandeira do cartão
			   cvv: 'cvv', // CVV do cartão
			   expirationMonth: mes, // Mês da expiração do cartão
			   expirationYear: ano, // Ano da expiração do cartão, é necessário os 4 dígitos.
			   success: function(response) {
			        // Retorna o cartão tokenizado.
			        tokenPagamento = response.card.token;

			        //Verifica se token não veio vazio
			        if(!tokenPagamento){
			        	alert('Cartão inválido');
			        } else{
			        	//coloca token no input type hidden
			        	$('#credit_token').val(tokenPagamento);
			        	pagarCartao();
			        }
			   },
			   error: function(response) {
					    // Callback para chamadas que falharam.
					   // alert('Erro ao gerar token de pagamento, verifique os dados do cartão e tente novamenteq');
					    console.log(response);
			   }
			});
		}

		function pagarCartao(){
			getInstallments();

			var hash_pagamento = PagSeguroDirectPayment.getSenderHash();
			$('#hash_pagamento').val(hash_pagamento);
			
			//$('.form').attr('action','pg_cartao');
			//$('.form').submit();
			$.ajax({
				type: 'post',
				url: 'pg_cartao',
				data: $('.form').serialize(),
				dataType: 'json',
				beforeSend: function() {
					$('.btn-pagar-credito').hide();
					$('.msg').html('<div class="spinner-border" role="status"><span class="sr-only">Enviando dados...</span></div>');
				}
			}).done(function(res) {
				console.log(res);
				if (res.error == 0) {
					$('.msg').html('Enviado com sucesso. Código da compra: ' + res.code.code);
				} else {
					$('.msg').html('Ocorreu um erro: ' + res.error + ' ' + res.message)
				}
			}).fail(function(res) {
				$('.msg').html('Ocorreu um erro: ' + res.error + ' ' + res.message)

			});

		}

		function setSessionIdPagSeguro() {
			$.ajax({
				url: 'pg_session_id_credito',
				dataType: 'json',
				success: function(res) {
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
				error: function() {
					//alert('Error:' + res.error + ' ' + res.message);
				}
			});
		}

		setSessionIdPagSeguro();
	</script>
	<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>