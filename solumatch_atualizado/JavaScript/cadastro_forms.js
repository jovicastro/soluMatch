document.addEventListener('DOMContentLoaded', function() {
    // Verifica se há mensagem de erro (indica que o formulário falhou)
    const erroGeral = document.querySelector('.erro-geral');
    
    if (erroGeral) {
        // Limpa todos os campos do formulário
        document.querySelectorAll('input').forEach(input => {
            input.value = '';
        });
        
        // Foca no primeiro campo
        document.querySelector('input').focus();
    }
});