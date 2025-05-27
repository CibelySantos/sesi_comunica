// Abrir modal de envio
const modal = document.getElementById("modal");
document.querySelector(".enviar-box").addEventListener("click", () => {
    modal.style.display = "flex";
});

// Fechar modal de envio ao clicar fora
window.addEventListener("click", function (e) {
    if (e.target === modal) {
        fecharModal();
    }
});

// Mostrar nome do arquivo selecionado
document.getElementById('arquivo_pdf').addEventListener('change', function () {
    const nomeArquivo = this.files[0]?.name || 'Nenhum arquivo selecionado';
    document.getElementById('nome-arquivo').textContent = nomeArquivo;
});

// ✅ Abrir comunicado individual (iframe direto)
function abrirComunicado(id) {
    document.getElementById('modal-nome-comunicado').innerText = 'Comunicado #' + id;
    document.getElementById('pdf-frame').src = 'visualizar_comunicado.php?id=' + id;
    document.getElementById('comunicado-modal').style.display = 'flex';
}

// ✅ Fechar qualquer modal
function fecharModal() {
    const modais = ['comunicado-modal', 'modal', 'modal-antigos'];
    modais.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.style.display = 'none';
    });
    document.getElementById('pdf-frame').src = ''; // limpa o iframe
}

// Abrir modal de comunicados antigos
function abrirModalAntigos() {
    document.getElementById("modal-antigos").style.display = "flex";
}

// Fechar modal de comunicados antigos
function fecharModalAntigos() {
    document.getElementById("modal-antigos").style.display = "none";
}
