function limpa_formulário_cep() {
    // Limpa valores do formulário de cep.
    document.getElementById('logradouro').value = "";
    document.getElementById('bairro').value = "";
    document.getElementById('cidade').value = "";
    document.getElementById('uf').value = "";
}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        // Atualiza os campos com os valores.
        document.getElementById('logradouro').value = conteudo.logradouro;
        document.getElementById('bairro').value = conteudo.bairro;
        document.getElementById('cidade').value = conteudo.localidade;
        document.getElementById('uf').value = conteudo.uf;

        // Agora chama a função para selecionar a cidade baseada nos valores atualizados
        selecionaCidade();
    } else {
        // CEP não Encontrado.
        limpa_formulário_cep();
        alert("CEP não encontrado.");
    }
}

function pesquisacep(valor) {
    // Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');

    // Verifica se campo cep possui valor informado.
    if (cep != "") {
        // Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        // Valida o formato do CEP.
        if (validacep.test(cep)) {
            // Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('logradouro').value = "...";
            document.getElementById('bairro').value = "...";
            document.getElementById('cidade').value = "...";
            document.getElementById('uf').value = "...";

            // Cria um elemento javascript.
            var script = document.createElement('script');

            // Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

            // Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } else {
            // CEP é inválido.
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
        }
    } else {
        // CEP sem valor, limpa formulário.
        limpa_formulário_cep();
    }
};

function selecionaCidade() {
    // Obtenha os valores dos campos hidden
    var cidade = document.getElementById('cidade').value;
    var uf = document.getElementById('uf').value;

    // Selecione o elemento select pelo seu ID
    var select = document.getElementById('cidade_id');
    var options = select.options;

    // Itere pelas opções para encontrar e selecionar a correta
    for (var i = 0; i < options.length; i++) {
        // Assuma que as opções estão no formato "Cidade - UF"
        if (options[i].text === cidade + ' - ' + uf) {
            select.selectedIndex = i;
            break;
        }
    }

    // Atualiza o Select2
    $(select).select2('destroy');  // Destrói a instância atual do Select2
    $(select).select2();          // Recria o Select2 para aplicar o estilo
    // $(select).select2().trigger('change');  // Opcionalmente dispara o evento change
}
