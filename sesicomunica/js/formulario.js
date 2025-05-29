function criarPergunta() {
    const container = document.getElementById('perguntas-container');
    const index = container.children.length;

    const newQuestion = document.createElement('div');
    newQuestion.className = 'form-group pergunta-item';
    newQuestion.dataset.index = index;

    const perguntaHeader = document.createElement('div');
    perguntaHeader.className = 'pergunta-header';

    const label = document.createElement('label');
    label.textContent = 'Pergunta:';

    const btnRemover = document.createElement('button');
    btnRemover.type = 'button';
    btnRemover.className = 'btn-remover-pergunta';
    btnRemover.textContent = 'Remover';
    btnRemover.onclick = function () { removerPergunta(this); };

    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'perguntas[]';
    input.required = true;
    input.placeholder = 'Digite sua pergunta';

    const tipoHidden = document.createElement('input');
    tipoHidden.type = 'hidden';
    tipoHidden.name = 'tipos_pergunta[]';
    tipoHidden.value = 'dissertativa';

    perguntaHeader.appendChild(label);
    perguntaHeader.appendChild(btnRemover);

    newQuestion.appendChild(perguntaHeader);
    newQuestion.appendChild(input);
    newQuestion.appendChild(tipoHidden);

    container.appendChild(newQuestion);
}

function removerPergunta(button) {
    const container = document.getElementById('perguntas-container');
    if (container.children.length > 1) {
        button.closest('.pergunta-item').remove();
    } else {
        alert('O formulário precisa ter pelo menos uma pergunta.');
    }
}

function abrirModal() {
    const modal = document.getElementById('modalFormulario');
    modal.classList.remove('hidden');
    modal.style.display = 'block';
}

function fecharModal() {
    const modal = document.getElementById('modalFormulario');
    modal.classList.add('hidden');
    modal.style.display = 'none';
}

window.onclick = function (event) {
    const modal = document.getElementById('modalFormulario');
    if (event.target === modal) {
        fecharModal();
    }
}

function confirmarExclusao(id) {
    if (confirm('Tem certeza que deseja excluir este formulário?')) {
        window.location.href = 'deletar_formulario.php?id=' + id;
    }
}

// Edição
let editarModal = null;

document.addEventListener('DOMContentLoaded', function () {
    const editarModalEl = document.getElementById('editarModal');
    if (editarModalEl) {
        editarModal = new bootstrap.Modal(editarModalEl, {
            backdrop: false,
            keyboard: true
        });
    }

    const form = document.querySelector('form[action="criar_formulario.php"]');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const perguntas = form.querySelectorAll('.pergunta-item');
            if (perguntas.length === 0) {
                alert('Adicione pelo menos uma pergunta ao formulário.');
                return;
            }

            let valid = true;
            perguntas.forEach(pergunta => {
                const textoPergunta = pergunta.querySelector('input[name="perguntas[]"]');
                if (!textoPergunta.value.trim()) {
                    valid = false;
                }
            });

            if (!valid) {
                alert('Por favor, preencha todas as perguntas corretamente.');
                return;
            }

            form.submit();
        });
    }
});

function abrirModalEditar(id) {
    fetch('get_formulario.php?id=' + id)
        .then(response => response.json())
        .then(formulario => {
            if (formulario.erro) {
                alert('Erro ao buscar formulário: ' + formulario.erro);
                return;
            }
            preencherModalEditar(formulario);
            editarModal.show();
        })
        .catch(err => alert('Erro ao buscar formulário: ' + err));
}

function preencherModalEditar(formulario) {
    document.getElementById('editar-nome-formulario').value = formulario.nome;
    document.getElementById('editar-publico').value = formulario.publico_alvo;
    document.getElementById('editar-data-criacao').value = formulario.data_criacao;
    document.getElementById('editar-data-limite').value = formulario.data_limite;

    const container = document.getElementById('editar-perguntas-container');
    container.dataset.formularioId = formulario.id;
    carregarPerguntasEditar(formulario.perguntas || []);
}

function carregarPerguntasEditar(perguntas) {
    const container = document.getElementById('editar-perguntas-container');
    container.innerHTML = '';

    perguntas.forEach(pergunta => {
        const div = document.createElement('div');
        div.className = 'form-group pergunta-item';
        if (pergunta.id) div.dataset.perguntaId = pergunta.id;

        div.innerHTML = `
            <div class='pergunta-header'>
                <label>Pergunta:</label>
                <button type='button' class='btn btn-danger btn-sm' onclick='removerPerguntaEditar(this)'>Remover</button>
            </div>
            <input type='text' class='form-control mt-2' value='${pergunta.texto || ''}' required>
            <input type='hidden' value='dissertativa'>
        `;
        container.appendChild(div);
    });
}

function criarPerguntaEditar() {
    const container = document.getElementById('editar-perguntas-container');
    const div = document.createElement('div');
    div.className = 'form-group pergunta-item';

    div.innerHTML = `
        <div class='pergunta-header'>
            <label>Pergunta:</label>
            <button type='button' class='btn btn-danger btn-sm' onclick='removerPerguntaEditar(this)'>Remover</button>
        </div>
        <input type='text' class='form-control mt-2' required>
        <input type='hidden' value='dissertativa'>
    `;

    container.appendChild(div);
}

function removerPerguntaEditar(btn) {
    btn.closest('.pergunta-item').remove();
}

async function salvarAlteracoes() {
    const container = document.getElementById('editar-perguntas-container');
    const formId = container.dataset.formularioId;

    if (!formId) {
        alert('ID do formulário não encontrado');
        return;
    }

    const data = {
        id: formId,
        nome: document.getElementById('editar-nome-formulario').value,
        publico_alvo: document.getElementById('editar-publico').value,
        data_criacao: document.getElementById('editar-data-criacao').value,
        data_limite: document.getElementById('editar-data-limite').value,
        perguntas: []
    };

    const perguntasItems = container.querySelectorAll('.pergunta-item');
    perguntasItems.forEach(item => {
        const pergunta = {
            texto: item.querySelector('input[type="text"]').value,
            tipo: 'dissertativa'
        };
        if (item.dataset.perguntaId) {
            pergunta.id = item.dataset.perguntaId;
        }
        data.perguntas.push(pergunta);
    });

    try {
        const response = await fetch('atualizar_formulario.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.erro) throw new Error(result.erro);
        alert('Formulário atualizado com sucesso!');
        window.location.reload();
    } catch (erro) {
        alert('Erro ao salvar formulário: ' + erro.message);
    }
}
