        const modal = document.getElementById("modal");

        document.querySelector(".enviar-box").addEventListener("click", () => {
            modal.style.display = "flex";
        });

        window.addEventListener("click", function (e) {
            if (e.target === modal) {
                fecharModal();
            }
        });

        document.getElementById('arquivo_pdf').addEventListener('change', function () {
            const nomeArquivo = this.files[0]?.name || 'Nenhum arquivo selecionado';
            document.getElementById('nome-arquivo').textContent = nomeArquivo;
        });

        function abrirComunicado(id) {
    fetch('get_comunicado.php?id=' + id)
        .then(response => response.json())
        .then(data => {
            document.getElementById('modal-nome-comunicado').innerText = data.nome;
            document.getElementById('pdf-frame').src = 'data:application/pdf;base64,' + data.pdf;
            document.getElementById('comunicado-modal').style.display = 'flex';
        })
        .catch(error => {
            alert('Erro ao carregar comunicado.');
            console.error(error);
        });
}

function fecharModal() {
    document.getElementById('comunicado-modal').style.display = 'none';
    document.getElementById('modal').style.display = 'none';
}
