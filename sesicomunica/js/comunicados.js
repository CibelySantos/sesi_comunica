const modal = document.getElementById("modal");

document.querySelector(".enviar-box").addEventListener("click", () => {
    modal.style.display = "flex";
});

function fecharModal() {
    modal.style.display = "none";
}

window.addEventListener("click", function (e) {
    if (e.target === modal) {
        fecharModal();
    }
});

document.getElementById("arquivo_pdf").addEventListener("change", function () {
    const nomeArquivo = this.files[0]?.name || "Nenhum arquivo selecionado";
    document.getElementById("nome-arquivo").textContent = nomeArquivo;
});
