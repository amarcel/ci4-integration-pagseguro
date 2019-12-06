/**
 * Função obrigatória para gerar a sessão de pagamento da API do PagSeguro
 * URL = base_url()
 */

var url = 'http://localhost:8080/' + 'sessao/gerarSessao';

function setSessionIdPagSeguro() {
    $('#btn_pagar').attr("disabled", true);

    $.ajax({
        url: url,
        dataType: 'json',
        success: function (res) {
            console.log(res);
            if (res.error == 0) {
                var id_sessao = res.id_sessao;
                //Setar id_sessao
                PagSeguroDirectPayment.setSessionId(id_sessao);
                if (!$('#btn_pagar').hasClass('btn-danger')) {
                    $('#btn_pagar').attr("disabled", false);
                }

            } else {
                alert('Erro ao setar a sessão' + res.error + ' ' + res.message);
            }
        },
        error: function () {
            alert('Erro ao gerar sessão' + res.error + ' ' + res.message);
        }
    });
}

//Iniciando a sessão ao abrir a página
setSessionIdPagSeguro();