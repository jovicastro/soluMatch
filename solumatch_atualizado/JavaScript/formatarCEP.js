function formatarCEP(campo) {
    // Pega a posição atual do cursor
    const posicaoCursor = campo.selectionStart;
    
    // Remove tudo que não é dígito
    let valor = campo.value.replace(/\D/g, "");
    
    // Aplica a formatação
    if (valor.length > 5) {
        valor = valor.substring(0, 5) + "-" + valor.substring(5, 8);
    }
    
    // Atualiza o valor no campo
    campo.value = valor;
    
    // Ajusta a posição do cursor
    if (posicaoCursor === 6 && valor.length > 5) {
        // Se estava na posição onde será inserido o hífen
        campo.setSelectionRange(posicaoCursor + 1, posicaoCursor + 1);
    } else {
        campo.setSelectionRange(posicaoCursor, posicaoCursor);
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const campoCEP = document.querySelector('input[name="cep"]');
    if (campoCEP) {
        campoCEP.addEventListener("input", function() {
            formatarCEP(this);
        });
        
        // Opcional: busca automática ao perder o foco
        campoCEP.addEventListener("blur", function() {
            const cep = this.value.replace(/\D/g, "");
            if (cep.length === 8) {
                buscarEnderecoPorCEP(cep);
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const cepInput = document.querySelector('input[name="cep"]');
    const enderecoInput = document.querySelector('input[name="endereco"]');
    
    cepInput.addEventListener('blur', buscarEndereco);

    function buscarEndereco() {
        // Remove tudo que não é dígito
        const cep = this.value.replace(/\D/g, '');
        
        // Verifica se o CEP tem 8 dígitos
        if (cep.length !== 8) {
            mostrarErroCEP("CEP deve conter 8 dígitos");
            return;
        }
        
        // Configuração do loading
        iniciarLoading();
        
        // Faz a requisição para a API ViaCEP
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => {
                if (!response.ok) {
                    throw new Error("Erro na requisição");
                }
                return response.json();
            })
            .then(data => {
                if (data.erro) {
                    throw new Error("CEP não encontrado");
                }
                preencherEndereco(data);
            })
            .catch(error => {
                mostrarErroCEP(error.message);
            })
            .finally(() => {
                finalizarLoading();
            });
    }

    function iniciarLoading() {
        enderecoInput.value = "";
        enderecoInput.placeholder = "Buscando endereço...";
        enderecoInput.disabled = true;
        cepInput.classList.add('loading');
    }

    function finalizarLoading() {
        enderecoInput.disabled = false;
        enderecoInput.placeholder = "Endereço";
        cepInput.classList.remove('loading');
    }

    function mostrarErroCEP(mensagem) {
        enderecoInput.placeholder = mensagem;
        enderecoInput.value = "";
        // Adiciona classe de erro ao campo CEP
        cepInput.classList.add('erro');
        // Remove a classe de erro após 3 segundos
        setTimeout(() => {
            cepInput.classList.remove('erro');
        }, 3000);
    }

    function preencherEndereco(data) {
        // Formata o endereço com os dados retornados
        const endereco = formatarEndereco(data);
        enderecoInput.value = endereco;
        
        // Foca no próximo campo (se necessário)
        enderecoInput.focus();
    }

    function formatarEndereco(data) {
        let endereco = "";
        if (data.logradouro) endereco += data.logradouro;
        if (data.bairro && data.bairro !== data.logradouro) {
            endereco += endereco ? ", " + data.bairro : data.bairro;
        }
        if (data.localidade) {
            endereco += endereco ? " - " + data.localidade : data.localidade;
        }
        if (data.uf) {
            endereco += endereco ? "/" + data.uf : data.uf;
        }
        return endereco;
    }
});