/**
 * Função obrigatória para gerar a sessão de pagamento da API do PagSeguro
 * URL = base_url()
 */

var url = 'http://localhost:8080/' + 'sessao/gerarSessao';

function setSessionIdPagSeguro() {
    $('#btn_pagar').attr("disabled", true);

    $.ajax({
        url,
        dataType: 'json',
        success(res) {
            if (res.error === 0) {
                //Setar id_sessao
                PagSeguroDirectPayment.setSessionId(res.id_sessao);
                /**
                 * Verifica se o botão está como danger no caso do Pagamento de cartão ele seta danger até colocar o valor da parcela
                 */
                if (!$('#btn_pagar').hasClass('btn-danger')) {
                    $('#btn_pagar').attr("disabled", false);
                }

            } else {
                alert('Erro - Código: ' + res.error + '. Mensagem: ' + res.message);
            }
        },
        error(res) {
            alert('Erro - Código: ' + res.error + '. Mensagem: ' + res.message);
        }
    });
}

//Iniciando a sessão ao abrir a página
setSessionIdPagSeguro();