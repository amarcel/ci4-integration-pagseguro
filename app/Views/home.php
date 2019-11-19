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
			<form class="form mx-auto col-5">
				<input type="hidden" class="form-control" id="hash_pagamento" name="hash_pagamento">
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
					<input type="text" class="my-1 form-control" readonly name="email" placeholder="v15638893625370231056@sandbox.pagseguro.com.br" value="v15638893625370231056@sandbox.pagseguro.com.br">
				</div>
				<div class="form-group">
					<label class="text-left">Referência</label>
					<input type="text" class="my-1 form-control" readonly name="red" placeholder="<?= rand(1000, 9999) ?>" value="<?= rand(1000, 9999) ?>">
				</div>

				<div class="form-group">
					<label class="text-left">Valor</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<div class="input-group-text">R$</div>
						</div>
						<input type="text" class="form-control" readonly name="valor" value="<?= rand(100.1, 200.9).'.'.rand(10, 99) ?>">
					</div>
				</div>
				<input type="submit" class="btn btn-info btn-pagar-boleto" onclick="pagarBoleto(event)" value="Pagar com boleto bancário"></input>
			</form>

		</div>
		<div class="card-footer text-muted text-center">
			Status de pagamento: <span class="msg">**********</span>
		</div>
	</div>

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
					$('.msg').html('Enviando dados')
				}
			}).done(function(res) {
				console.log(res);
				if (res.error == 0) {
					$('.msg').html('Enviado com sucesso. Link do boleto: <a target="_blank" href="' + res.code.paymentLink + '">Clique aqui para baixar</a>');
				} else {
					$('.msg').html('Ocorreu um erro: ' + res.error + ' ' + res.message)
				}
			}).fail(function(res) {
				$('.msg').html('Ocorreu um erro: ' + res.error + ' ' + res.message)

			});

		}

		function setSessionIdPagSeguro() {
			$.ajax({
				url: 'pagar/pg_session_id',
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