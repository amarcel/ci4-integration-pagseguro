/**
 * Função responsável abrir o modal com o iframe do boleto passado por parâmetro
 * @param {String} link 
 */
function buscar_boleto(link) {

    //Inicia o loading
    $('.loading').show();
    $('#iframe_boleto').hide();

    //Adiciona o link ao atributo src do iframe
    $("#iframe_boleto").attr("src", "" + link + "");

    $(".aviso").html('Caso não consiga visualizar o boleto <a target="_blank" class="url_bol" href="' + link + '">Clique aqui</a>');
    $('.loading').html('<div class="spinner-border text-center" role="status"><span class="sr-only">Enviando dados...</span></div>');

    //Aguarda o load do iframe
    $('#iframe_boleto').on('load', function () {
        $('.loading').hide();
        $('#iframe_boleto').show();
    });

    //Abre o modal
    $('#acessar').modal('show');
}