/**
 * Função obrigatória para gerar a sessão de pagamento da API do PagSeguro
 * URL = base_url()
 */

var url = 'http://localhost:8080/' + 'sessao/gerarSessao';

function setSessionIdPagSeguro() {
    $.ajax({
        url: url,
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