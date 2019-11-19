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

	<div class="col-12 text-center mt-5">
		<form class="form" method="post" action="pagar/pg_boleto">
			<input type="hidden" class="form-control" id="hash_pagamento" name="hash_pagamento">
			<div class="form-group">
				<label for="exampleInputEmail1">Nome</label>
				<input type="text" class="my-2 form-control" name="nome" placeholder="NOME">
				<label for="exampleInputEmail1">CPF</label>
				<input type="text" class="my-2 form-control" name="cpf" placeholder="CPF">

			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Email</label>
				<input type="text" class="my-2 form-control" name="email" placeholder="EMAIL">
			</div>
			<input type="submit" class="btn btn-info btn-pagar-boleto" onclick="pagarBoleto(event)" value="Pagar com boleto bancário"></input>
			<div class="msg"></div>
		</form>

		<div>

			<script>
				function pagarBoleto(e) {
					e.preventDefault();

					var hash_pagamento = PagSeguroDirectPayment.getSenderHash();
					$('#hash_pagamento').val(hash_pagamento);

					//alert(hash_pagamento);

					$.ajax({
						type: 'post',
						url: 'pagar/pg_boleto',
						data: $('.form').serialize(),
						dataType: 'json',
						beforeSend: function() {
							$('.msg').html('<div class="alert alert-info" role="alert">Enviando dados</div>')
						}
					}).done(function(res) {
						if (res.error == 0) {
							$('.msg').html('<div class="alert alert-success" role="alert">Enviado com sucesso. Link do boleto: <a target="_blank" href="'+res.code.paymentLink+'">Clique aqui para baixar</a></div>');
						} else {
							$('.msg').html('<div class="alert alert-info" role="alert">Ocorreu um erro: '+res.error + ' ' + res.message+'</div>')
						}
					}).fail(function(res) {
						$('.msg').html('<div class="alert alert-info" role="alert">Ocorreu um erro: '+res.error + ' ' + res.message+'</div>')
						
					});

				}

				function setSessionIdPagSeguro() {
					$.ajax({
						url: 'pagar/pg_session_id',
						dataType: 'json',
						success: function(res) {
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