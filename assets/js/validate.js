// envia o formulário via ajax
(function($) {
    $.fn.enviaFormulario = function(url) {
        $.ajax({
            type: 'POST',
            typeData: 'json',
            data: $(this).serialize(),
            url: url,
            success: function(request) {
                limpaModal();
                msgSucesso(request);
            },
            error: function() {
                limpaModal();
                msgErro();
            }
        });
    };
})(jQuery);

// é chamada quando o ajax dá certo
function msgSucesso(request) {
    if (request.resultado === 'success') {
        exibeModal("Sucesso", "<span class='glyphicon glyphicon-ok-sign'></span>&nbsp" + request.mensagem);
    } else if (request.resultado === 'error') {
        var mensagem = "";
        $.each(request.mensagem, function(index, valor) {
            mensagem += '<strong>Atenção: </strong>' + valor + '<br\>';
        });
        exibeAlertDanger(mensagem);
        window.scrollTo(0, 0);
    }
}

// é chamada quando o ajax da errado
function msgErro() {
    exibeModal('Erro', "<span class='glyphicon glyphicon-warning-sign'></span>&nbsp" + '&nbsp;Atenção: Ocorreu um erro no servidor.<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tente novamente mais tarde.');
}

//limpa as mesangens do modal
function limpaModal(){
    $('#modal-info .modal-title').empty();
    $('#modal-info .modal-body').empty();
}

// exibe o modal de informações
function exibeModal(titulo, mensagem) {
    $('.modal-scrollable').hide();
    $('#modal-info .modal-title').text(titulo);
    $('#modal-info .modal-body').append(mensagem);
    $('#modal-info').modal('show');
}

// exibe o alert com mensagens de erro de validação
function exibeAlertDanger(mensagem) {
    $('.bg-danger').empty();
    $('.bg-danger').append(mensagem);
    $('.bg-danger').show();
}

//limpa o formulário

$('#limpar').click(function(evento) {
    evento.preventDefault();
    $('input').val('');
    $('input[type="checkbox"]').attr('checked', false);
});