document.querySelectorAll('.editar-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('edit_id').value = btn.dataset.id;
        document.getElementById('edit_nome').value = btn.dataset.nome;
        document.getElementById('edit_email').value = btn.dataset.email;
        document.getElementById('edit_tipo').value = btn.dataset.tipo;
        document.getElementById('editModal').style.display = 'block';
    });
});

function fecharModal() {
    document.getElementById('editModal').style.display = 'none';
}

function abrirModal(){
    document.getElementById('editModal').style.display = 'block';
}