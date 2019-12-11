<!doctype html>
<html lang="pt-br">

<head>
    <title>Listagem - API de Pagamento PagSeguro</title>
    <link rel="shortcut icon" type="image/png" href="/favicon.ico" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
</head>

<body>
    <div class="card">
        <div class=" text-center card-header">
            <a rel="noopener noreferrer" target="_blank" href="https://github.com/matheuscastroweb/ci4-integration-pagseguro">CodeIgniter 4 Integration PagSeguro API</a>
        </div>

        <div class="card-body">
            <div class="text-center ">
                <h5 class="card-title">Listagens de transações</h5>
                <p class="card-text mb-3">Criar novo pagamento com: <a href="/pagar/boleto">Boleto</a> ou <a href="/pagar/credito">Cartão de crédito</a></p>
            </div>
            <table class="mx-auto col-9 table table-striped" aria-describedby="Listagem transações">
                <th class="font-weight-bold">
                <td>Referência</td>
                <td>Código</td>
                <td>Tipo</td>
                <td>Status</td>
                <td>Valor</td>
                <td>Link</td>
                </th>
                <?php if (!empty($transacoes) && is_array($transacoes)) :  ?>
                    <?php foreach ($transacoes as $transacoes_item) :  ?>
                        <tr>
                            <td class=" text-uppercase"><?= substr($transacoes_item['referencia_transacao'], 1, 5) ?></td>
                            <td><?= $transacoes_item['codigo_transacao'] ?></td>
                            <td><?= getStatusTypePag($transacoes_item['tipo_transacao']) ?></td>
                            <td><?= getStatusCodePag($transacoes_item['status_transacao']) ?></td>
                            <td>R$ <?= $transacoes_item['valor_transacao'] ?></td>
                            <td>
                                <?php if ($transacoes_item['tipo_transacao'] == 1) : ?>
                                    Sem link
                                <?php else : ?>
                                    <a href="javascript:;" onclick="buscarBoleto('<?= $transacoes_item['url_boleto'] ?> ');">Acessar </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td class="text-center" colspan="6">Nenhuma transação encontrada</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
        <div class="modal fade" id="acessar" tabindex="-1" role="dialog" aria-labelledby="acessar-link" aria-hidden="true">
            <div style="height: 100%;  width: 100%" class="modal-dialog modal-xl" role="document">
                <div style="height: 100%;  width: 100%" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Boleto cobrança</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <p class="aviso"></p>
                        <p class="loading"></p>
                        <iframe title="Boleto de pagamento" id="iframe_boleto" src="" width="100%" height="90%" style="border: none;"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-muted text-center">
            <a rel="noopener noreferrer" target="_blank" href='https://github.com/matheuscastroweb'>GitHub</a> - Matheus de Castro Pelegrino < matheuscastroweb@gmail.com>
        </div>
    </div>

    <!-- JavaScript referente à página  -->
    <script src="<?= base_url('assets/js/listagem.js') ?>"></script>
    <!-- Fim  -->

    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>