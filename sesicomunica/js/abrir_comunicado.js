
function abrirComunicado(id) {
    // Define o nome dinamicamente no título (pode ser modificado para buscar do banco)
    document.getElementById('modal-nome-comunicado').innerText = 'Visualizando Comunicado #' + id;

    // Define o PDF no iframe
    const iframe = document.getElementById('pdf-frame');
    iframe.src = 'visualizar_comunicado.php?id=' + id;

    // Abre o modal
    document.getElementById('comunicado-modal').style.display = 'block';
}

function fecharModal() {
    document.getElementById('comunicado-modal').style.display = 'none';
    document.getElementById('pdf-frame').src = ''; // Limpa o iframe
}
