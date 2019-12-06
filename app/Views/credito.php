<!doctype html>
<html>

<head>
	<title>API de Pagamento PagSeguro</title>
	<link rel="shortcut icon" type="image/png" href="/favicon.ico" />

	<!-- CSS referente à página  -->
	<link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>">
	<!-- CSS referente à página  -->

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
				<h5 class="card-title">Pagamento Cartão Crédito - API PagSeguro</h5>
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
					<input type="text" class="my-1 form-control" readonly name="email" placeholder="Digite seu e-mail" value="c24122153051718861428@sandbox.pagseguro.com.br">
				</div>
				<div class="form-group">
					<label class="text-left">Número cartão</label>
					<input id="ncartao" type="text" class="my-1 form-control" readonly name="ncartao" placeholder="Digite o número do seu cartão" value="4111111111111111">
				</div>
				<div class="form-group">
					<label class="text-left">Validade</label>
					<input id="validade" type="text" class="my-1 form-control" readonly name="validade" placeholder="Digite a validade do cartão" value="12/2030">
				</div>
				<div class="form-group">
					<label class="text-left">CVV</label>
					<input id="cvv" type="text" class="my-1 form-control" readonly name="cvv" placeholder="Digite o código de segurança" value="123">
				</div>
				<div class="form-group">
					<label class="text-left">Quantidade de Parcelas *</label>
					<select class="form-control" id="parcelas" name="parcelas">
						<option value="0">Selecione o número de parcelas</option>
						<option value="1">1 vez</option>
						<option value="2">2 vezes</option>
						<option value="3">3 vezes</option>
						<option value="4">4 vezes</option>
						<option value="5">5 vezes</option>
						<option value="6">6 vezes</option>
						<option value="7">7 vezes</option>
						<option value="8">8 vezes</option>
						<option value="9">9 vezes</option>
						<option value="10">10 vezes</option>
						<option value="11">11 vezes</option>
						<option value="12">12 vezes</option>
					</select>
				</div>
				<div class="form-group">
					<label class="my-1">Valor da Parcela</label>
					<input type="text" class="my-1 form-control" readonly id="vparcela" name="valor_parcela" placeholder="O valor da parcela será gerado aguarde">
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
						<input id="valor" type="text" class="form-control" readonly name="valor" value="<?= rand(50, 200) . '.' . rand(10, 99) ?>">
					</div>

				</div>
				<input id="pagar_cartao" type="submit" class="btn btn-danger btn-pagar-credito btn-block" disabled="true" onclick="gerarToken(event)" value="Pagar com cartão de crédito"></input>
			</form>

		</div>
		<div class="card-footer text-muted text-center">
			<span class="msg"></span>
		</div>
		<div>

		</div>

	</div>

	<!-- JavaScript referente à página  -->
	<script src="<?= base_url('assets/js/credito.js') ?>"></script>
	<script src="<?= base_url('assets/js/sessao.js') ?>"></script>
	<!-- Fim -->

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>