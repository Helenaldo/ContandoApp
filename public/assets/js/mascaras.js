$(document).ready(function() {
    var $selectTipoIdentificacao = $('#tipo_identificacao');
    var $inputCnpjCpf = $('#cnpj_cpf');
    var $labelCnpjCpf = $('#cnpjCpfLabel');
    var $inputCep = $('#cep'); // Selecionando o campo de CEP
    var $inputTelefone = $('#telefone'); // Selecionando o campo de telefone

    function applyMask(tipo) {
        if (tipo === 'CNPJ') {
            $inputCnpjCpf.mask('00.000.000/0000-00', {clearIfNotMatch: true});
        } else if (tipo === 'CPF') {
            $inputCnpjCpf.mask('000.000.000-00', {clearIfNotMatch: true});
        } else {
            // Se não for CNPJ ou CPF, limpa qualquer máscara aplicada
            $inputCnpjCpf.unmask();
        }
    }

    function updateLabelAndMask() {
        var tipo = $selectTipoIdentificacao.val();
        if (tipo) {
            $labelCnpjCpf.text(tipo === 'CNPJ' ? 'CNPJ*' : 'CPF*');
            applyMask(tipo);
        } else {
            $labelCnpjCpf.text('CNPJ ou CPF*'); // Define texto padrão quando nenhuma opção está selecionada
            $inputCnpjCpf.unmask(); // Garante que nenhuma máscara é aplicada
        }
    }

    $selectTipoIdentificacao.change(updateLabelAndMask);

    // Aplica a máscara inicial baseada na seleção atual ao carregar a página
    updateLabelAndMask();

    // Aplicando a máscara de CEP
    $inputCep.mask('00.000-000', {reverse: true});

        // Máscara dinâmica para telefone
        $inputTelefone.mask('(00) 0000-00009').on('focus keyup', function(event) {
        var target = $(event.target);
        var phone = target.val().replace(/\D/g, '');
        var newMask = '(00) 0000-00009';
        if (phone.length >= 11) {
            newMask = '(00) 0 0000-0000';
        }
        target.mask(newMask, {clearIfNotMatch: true});
    });


});
