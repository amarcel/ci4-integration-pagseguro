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
    <div id="divp" class="card ">
        <div class=" text-center card-header">
            Sandbox
        </div>

        <div class="card-body">
            <div class="text-center ">
                <h1 class="card-title">Status</h1>
                <p class="card-text mb-1">Ao estar com o PagSeguro todo configurado basta clicar <a href="/listagem"> aqui</a> para acessar a listagem de transações</p>
                <p class="card-text mb-5 text-muted">OBS.: Sempre que alterar algum parâmetro no .env é necessário dar um restart no server PHP</p>
            </div>

            <div class="container col-9 mx-auto">

                <h4><span class="btn btn-success pt-1">active </span> PagSeguro</h4>
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Usabilidade</th>
                            <th scope="col">Configurado</th>
                        </tr>
                    </thead>
                    <tbody class="table-striped">
                        <tr>
                            <td>api.mode</td>
                            <td><?= env('api.mode') ?></td>
                            <td>Modo da aplicação</td>
                            <td><?= env('api.mode') ?  '<p class="font-weight-bold text-success ">SIM</p>' : '<p class="font-weight-bold text-danger">NÃO</p>' ?></td>
                        </tr>
                        <tr>

                            <td>api.email</td>
                            <td><?= env('api.email') ?></td>
                            <td>E-mail do Pagseguro</td>
                            <td><?= env('api.email') == 'email' ? '<p class="font-weight-bold text-danger">NÃO</p>' : '<p class="font-weight-bold text-success">SIM</p>' ?></td>
                        </tr>
                        <tr>
                            <td>api.token</td>
                            <td><?= env('api.token') ?></td>
                            <td>Token do Pagseguro</td>
                            <td><?= env('api.token') == 'token' ? '<p class="font-weight-bold text-danger">NÃO</p>' : '<p class="font-weight-bold text-success">SIM</p>' ?></td>
                        </tr>
                    </tbody>
                </table>

                <h3><?= env('mail.using') != false ? '<span class="btn btn-success  pt-1">active </span>' : '<span class="btn btn-danger  pt-1">inative </span>' ?> E-mail</h3>
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Usabilidade</th>
                            <th scope="col">Configurado</th>
                        </tr>
                    </thead>
                    <tbody class="table-striped">
                        <tr>

                            <td>mail.host</td>
                            <td><?= env('mail.host') ?></td>
                            <td>Host do servidor de e-mail</td>
                            <td><?= env('mail.host') == 'host' ?  '<p class="font-weight-bold text-danger">NÃO</p>' : '<p class="font-weight-bold text-success">SIM</p>' ?></td>
                        </tr>
                        <tr>

                            <td>mail.user</td>
                            <td><?= env('mail.user') ?></td>
                            <td>Usuário cadastrado</td>
                            <td><?= env('mail.user') == 'user' ? '<p class="font-weight-bold text-danger">NÃO</p>' : '<p class="font-weight-bold text-success">SIM</p>' ?></td>
                        </tr>
                        <tr>
                            <td>mail.pass</td>
                            <td><?= env('mail.pass') ?></td>
                            <td>Senha do usuário</td>
                            <td><?= env('mail.pass') == 'pass' ? '<p class="font-weight-bold text-danger">NÃO</p>' : '<p class="font-weight-bold text-success">SIM</p>' ?></td>
                        </tr>
                        <tr>
                            <td>mail.port</td>
                            <td><?= env('mail.port') ?></td>
                            <td>Porta do servidor</td>
                            <td><?= env('mail.port') == 'port' ? '<p class="font-weight-bold text-danger">NÃO</p>' : '<p class="font-weight-bold text-success">SIM</p>' ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

        <div class="card-footer text-muted text-center">
            <a target="_blank" href='https://github.com/matheuscastroweb'>GitHub</a> - Matheus de Castro Pelegrino < matheuscastroweb@gmail.com>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>