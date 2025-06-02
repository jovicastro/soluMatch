document.querySelector('input[name="cpf"]').addEventListener('input', function(e) {
    const target = e.target;
    const position = target.selectionStart;
    let value = target.value.replace(/\D/g, '');
    
    if (value.length > 11) {
        value = value.substring(0, 11);
    }
    
    // Aplica a formatação
    let formattedValue = value;
    if (value.length > 3) formattedValue = formattedValue.replace(/^(\d{3})/, '$1.');
    if (value.length > 6) formattedValue = formattedValue.replace(/^(\d{3}\.\d{3})/, '$1.');
    if (value.length > 9) formattedValue = formattedValue.replace(/^(\d{3}\.\d{3}\.\d{3})/, '$1-');
    
    // Atualiza o valor mantendo a posição do cursor
    target.value = formattedValue;
    
    // Ajusta a posição do cursor
    if (position === 4 || position === 8) {
        target.setSelectionRange(position + 1, position + 1);
    } else if (position === 12) {
        target.setSelectionRange(position + 1, position + 1);
    } else {
        target.setSelectionRange(position, position);
    }
});