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
            Sandbox
        </div>
        <div class="card-body">
            <div class="text-center ">
                <h5 class="card-title">Listagens de transações</h5>
                <p class="card-text mb-3">Esta funcionalidade está em modo <?= env('api.mode') ?>.</p>
            </div>
            <table class="mx-auto col-9 table">
                <tr>
                    <td><strong>REF</strong></td>
                    <td>Pedido</td>
                    <td>Cliente</td>
                    <td>Código</td>
                    <td>Tipo</td>
                    <td>Status</td>
                    <td>Valor</td>

                </tr>
                <?php if (!empty($transacoes) && is_array($transacoes)) :  ?>
                    <?php foreach ($transacoes as $transacoes_item) :  ?>
                        <tr>
                            <td class="text-uppercase"><?= substr($transacoes_item['referencia_transacao'], 1, 5) ?></td>
                            <td><?= $transacoes_item['id_pedido'] ?></td>
                            <td><?= $transacoes_item['id_cliente'] ?></td>
                            <td><?= $transacoes_item['codigo_transacao'] ?></td>
                            <td><?= getStatusTypePag($transacoes_item['tipo_transacao'], $transacoes_item['url_boleto']) ?></td>
                            <td><?= getStatusCodePag($transacoes_item['status_transacao']) ?></td>
                            <td>R$ <?= $transacoes_item['valor_transacao'] ?></td>

                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td class="text-center" colspan="7">Nenhuma notícia encontrada</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
        <div class="card-footer text-muted text-center">
            <a href="/pagar">Criar novo pagamento</a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>