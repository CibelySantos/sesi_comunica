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

    const tipoSelect = document.createElement('select');
    tipoSelect.className = 'tipo-pergunta';
    tipoSelect.innerHTML = `
        <option value="dissertativa">Dissertativa</option>
        <option value="objetiva">Objetiva</option>
        <option value="classificacao">Classificação</option>
    `;
    tipoSelect.onchange = function() { handleTipoPergunta(this); };

    const btnRemover = document.createElement('button');
    btnRemover.type = 'button';
    btnRemover.className = 'btn-remover-pergunta';
    btnRemover.textContent = 'Remover';
    btnRemover.onclick = function() { removerPergunta(this); };

    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'perguntas[]';
    input.required = true;
    input.placeholder = 'Digite sua pergunta';

    const tipoHidden = document.createElement('input');
    tipoHidden.type = 'hidden';
    tipoHidden.name = 'tipos_pergunta[]';
    tipoHidden.value = 'dissertativa';

    const opcoesContainer = document.createElement('div');
    opcoesContainer.className = 'opcoes-container';

    perguntaHeader.appendChild(label);
    perguntaHeader.appendChild(tipoSelect);
    perguntaHeader.appendChild(btnRemover);
    
    newQuestion.appendChild(perguntaHeader);
    newQuestion.appendChild(input);
    newQuestion.appendChild(tipoHidden);
    newQuestion.appendChild(opcoesContainer);
    
    container.appendChild(newQuestion);
}

function handleTipoPergunta(select) {
    const perguntaItem = select.closest('.pergunta-item');
    const opcoesContainer = perguntaItem.querySelector('.opcoes-container');
    const tipoHidden = perguntaItem.querySelector('input[name="tipos_pergunta[]"]');
    
    tipoHidden.value = select.value;
    opcoesContainer.innerHTML = '';

    if (select.value === 'objetiva') {
        const btnAddOpcao = document.createElement('button');
        btnAddOpcao.type = 'button';
        btnAddOpcao.className = 'btn-add-opcao';
        btnAddOpcao.textContent = '+ Adicionar alternativa';
        btnAddOpcao.onclick = function() { adicionarOpcao(opcoesContainer); };
        
        opcoesContainer.appendChild(btnAddOpcao);
        adicionarOpcao(opcoesContainer); // Adiciona primeira opção automaticamente
        adicionarOpcao(opcoesContainer); // Adiciona segunda opção automaticamente
    } else if (select.value === 'classificacao') {
        const classificacaoDiv = document.createElement('div');
        classificacaoDiv.className = 'classificacao-container';
        classificacaoDiv.innerHTML = `
            <div class="classificacao-range">
                <label>Escala de classificação:</label>
                <div class="range-inputs">
                    <input type="number" name="classificacao_min[]" value="1" min="0" max="10" 
                        onchange="validarClassificacao(this)" required>
                    <span>até</span>
                    <input type="number" name="classificacao_max[]" value="5" min="1" max="10" 
                        onchange="validarClassificacao(this)" required>
                </div>
            </div>
        `;
        opcoesContainer.appendChild(classificacaoDiv);
    }
}

function adicionarOpcao(container) {
    const perguntaItem = container.closest('.pergunta-item');
    const index = perguntaItem.dataset.index;
    const opcaoDiv = document.createElement('div');
    opcaoDiv.className = 'opcao-item';
    
    const input = document.createElement('input');
    input.type = 'text';
    input.name = `opcoes[${index}][]`;
    input.placeholder = 'Digite a alternativa';
    input.required = true;
    
    const btnRemover = document.createElement('button');
    btnRemover.type = 'button';
    btnRemover.className = 'btn-remover-opcao';
    btnRemover.textContent = 'Remover';
    btnRemover.onclick = function() {
        const totalOpcoes = container.querySelectorAll('.opcao-item').length;
        if (totalOpcoes > 2) { // Mantém pelo menos 2 opções
            opcaoDiv.remove();
        } else {
            alert('Uma questão objetiva precisa ter pelo menos 2 alternativas.');
        }
    };
    
    opcaoDiv.appendChild(input);
    opcaoDiv.appendChild(btnRemover);
    
    // Insere antes do botão de adicionar
    const btnAdd = container.querySelector('.btn-add-opcao');
    if (btnAdd) {
        container.insertBefore(opcaoDiv, btnAdd);
    } else {
        container.appendChild(opcaoDiv);
    }
}

function validarClassificacao(input) {
    const rangeInputs = input.closest('.range-inputs');
    const minInput = rangeInputs.querySelector('input[name="classificacao_min[]"]');
    const maxInput = rangeInputs.querySelector('input[name="classificacao_max[]"]');
    
    // Garante que os valores estão entre 0 e 10
    let minVal = Math.max(0, Math.min(10, parseInt(minInput.value) || 0));
    let maxVal = Math.max(1, Math.min(10, parseInt(maxInput.value) || 1));
    
    // Garante que o mínimo é sempre menor que o máximo
    if (minVal >= maxVal) {
        if (input === minInput) {
            minVal = maxVal - 1;
        } else {
            maxVal = Math.min(10, minVal + 1);
        }
    }
    
    minInput.value = minVal;
    maxInput.value = maxVal;
}

function removerPergunta(button) {
    const container = document.getElementById('perguntas-container');
    if (container.children.length > 1) {
        const perguntaItem = button.closest('.pergunta-item');
        perguntaItem.remove();
        // Atualiza os índices das perguntas restantes
        Array.from(container.children).forEach((item, index) => {
            item.dataset.index = index;
            const opcoes = item.querySelectorAll('input[name^="opcoes["]');
            opcoes.forEach(opcao => {
                opcao.name = `opcoes[${index}][]`;
            });
        });
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

window.onclick = function(event) {
    const modal = document.getElementById('modalFormulario');
    if (event.target === modal) {
        fecharModal();
    }
}
// Funções para manipulação de formulários
function confirmarExclusao(id) {
    if (confirm('Tem certeza que deseja excluir este formulário?')) {
        window.location.href = 'deletar_formulario.php?id=' + id;
    }
}

// Funções para modal de edição
let editarModal = null;

document.addEventListener('DOMContentLoaded', function() {
    const editarModalEl = document.getElementById('editarModal');
    if (editarModalEl) {
        editarModal = new bootstrap.Modal(editarModalEl, {
            backdrop: false,
            keyboard: true
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
            if (!editarModal) {
                editarModal = new bootstrap.Modal(document.getElementById('editarModal'), {
                    backdrop: false,
                    keyboard: true
                });
            }
            editarModal.show();
        })
        .catch(err => {
            alert('Erro ao buscar formulário: ' + err);
        });
}

function fecharModalEditar() {
    if (editarModal) {
        editarModal.hide();
    }
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
        if (pergunta.id) {
            div.dataset.perguntaId = pergunta.id;
        }
        
        let inner = `<div class='pergunta-header'><label>Pergunta:</label>`;
        inner += `<select class='form-control tipo-pergunta' onchange='handleTipoPerguntaEditar(this)'>`;
        inner += `<option value='dissertativa' ${pergunta.tipo === 'dissertativa' ? 'selected' : ''}>Dissertativa</option>`;
        inner += `<option value='objetiva' ${pergunta.tipo === 'objetiva' ? 'selected' : ''}>Objetiva</option>`;
        inner += `<option value='classificacao' ${pergunta.tipo === 'classificacao' ? 'selected' : ''}>Classificação</option>`;
        inner += `</select>`;
        inner += `<button type='button' class='btn btn-danger btn-sm' onclick='removerPerguntaEditar(this)'>Remover</button></div>`;
        inner += `<input type='text' class='form-control mt-2' value='${pergunta.texto || ''}' required>`;
        inner += `<input type='hidden' value='${pergunta.tipo}'>`;
        inner += `<div class='opcoes-container mt-2'>`;
        
        if (pergunta.tipo === 'objetiva' && pergunta.opcoes) {
            pergunta.opcoes.forEach(opcao => {
                inner += `<div class='opcao-item input-group mb-2'>
                    <input type='text' class='form-control' value='${opcao}' required>
                    <div class='input-group-append'>
                        <button type='button' class='btn btn-danger' onclick='this.closest(".opcao-item").remove()'>Remover</button>
                    </div>
                </div>`;
            });
            inner += `<button type='button' class='btn btn-secondary btn-sm' onclick='adicionarOpcaoEditar(this)'>+ Adicionar alternativa</button>`;
        }
        if (pergunta.tipo === 'classificacao') {
            inner += `<div class='classificacao-container'>
                <div class='classificacao-range'>
                    <label>Escala de classificação (max 10):</label>
                    <div class='range-inputs input-group'>
                        <input type='number' class='form-control' value='${pergunta.min || 1}' min='0' max='10' required>
                        <div class='input-group-prepend input-group-append'>
                            <span class='input-group-text'>até</span>
                        </div>
                        <input type='number' class='form-control' value='${pergunta.max || 5}' min='1' max='10' required>
                    </div>
                </div>
            </div>`;
        }
        inner += `</div>`;
        div.innerHTML = inner;
        container.appendChild(div);
    });
}

function criarPerguntaEditar() {
    const container = document.getElementById('editar-perguntas-container');
    const div = document.createElement('div');
    div.className = 'form-group pergunta-item';
    
    let inner = `<div class='pergunta-header'><label>Pergunta:</label>`;
    inner += `<select class='form-control tipo-pergunta' onchange='handleTipoPerguntaEditar(this)'>`;
    inner += `<option value='dissertativa'>Dissertativa</option>`;
    inner += `<option value='objetiva'>Objetiva</option>`;
    inner += `<option value='classificacao'>Classificação</option>`;
    inner += `</select>`;
    inner += `<button type='button' class='btn btn-danger btn-sm' onclick='removerPerguntaEditar(this)'>Remover</button></div>`;
    inner += `<input type='text' class='form-control mt-2' required>`;
    inner += `<input type='hidden' value='dissertativa'>`;
    inner += `<div class='opcoes-container mt-2'></div>`;
    div.innerHTML = inner;
    container.appendChild(div);
}

function handleTipoPerguntaEditar(select) {
    const perguntaItem = select.closest('.pergunta-item');
    const opcoesContainer = perguntaItem.querySelector('.opcoes-container');
    const tipoHidden = perguntaItem.querySelector('input[type="hidden"]');
    tipoHidden.value = select.value;
    opcoesContainer.innerHTML = '';
    
    if (select.value === 'objetiva') {
        const btnAddOpcao = document.createElement('button');
        btnAddOpcao.type = 'button';
        btnAddOpcao.className = 'btn btn-secondary btn-sm';
        btnAddOpcao.textContent = '+ Adicionar alternativa';
        btnAddOpcao.onclick = function() { adicionarOpcaoEditar(btnAddOpcao); };
        opcoesContainer.appendChild(btnAddOpcao);
        adicionarOpcaoEditar(btnAddOpcao);
        adicionarOpcaoEditar(btnAddOpcao);
    } else if (select.value === 'classificacao') {
        const classificacaoDiv = document.createElement('div');
        classificacaoDiv.className = 'classificacao-container';
        classificacaoDiv.innerHTML = `<div class='classificacao-range'>
            <label>Escala de classificação:</label>
            <div class='range-inputs input-group'>
                <input type='number' class='form-control' value='1' min='0' max='10' required>
                <div class='input-group-prepend input-group-append'>
                    <span class='input-group-text'>até</span>
                </div>
                <input type='number' class='form-control' value='5' min='1' max='10' required>
            </div>
        </div>`;
        opcoesContainer.appendChild(classificacaoDiv);
    }
}

function adicionarOpcaoEditar(btnAdd) {
    const container = btnAdd.parentNode;
    const opcaoDiv = document.createElement('div');
    opcaoDiv.className = 'opcao-item input-group mb-2';
    opcaoDiv.innerHTML = `
        <input type='text' class='form-control' required>
        <div class='input-group-append'>
            <button type='button' class='btn btn-danger' onclick='this.closest(".opcao-item").remove()'>Remover</button>
        </div>
    `;
    container.insertBefore(opcaoDiv, btnAdd);
}

function removerPerguntaEditar(btn) {
    const perguntaItem = btn.closest('.pergunta-item');
    perguntaItem.remove();
}

async function salvarAlteracoes() {
    const container = document.getElementById('editar-perguntas-container');
    const formId = container.dataset.formularioId;
    
    if (!formId) {
        alert('ID do formulário não encontrado');
        return;
    }
    
    try {
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
                tipo: item.querySelector('select.tipo-pergunta').value
            };
            
            if (item.dataset.perguntaId) {
                pergunta.id = item.dataset.perguntaId;
            }
            
            if (pergunta.tipo === 'objetiva') {
                pergunta.opcoes = Array.from(item.querySelectorAll('.opcao-item input[type="text"]')).map(input => input.value);
            }
            
            if (pergunta.tipo === 'classificacao') {
                const [min, max] = item.querySelectorAll('.range-inputs input[type="number"]');
                pergunta.min = parseInt(min.value);
                pergunta.max = parseInt(max.value);
            }
            
            data.perguntas.push(pergunta);
        });
        
        const response = await fetch('atualizar_formulario.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        if (result.erro) {
            throw new Error(result.erro);
        }
        
        alert('Formulário atualizado com sucesso!');
        window.location.reload();
    } catch (erro) {
        alert('Erro ao salvar formulário: ' + erro.message);
    }
}

// Event listener para o formulário de criação
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="criar_formulario.php"]');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validar se há pelo menos uma pergunta
            const perguntas = form.querySelectorAll('.pergunta-item');
            if (perguntas.length === 0) {
                alert('Adicione pelo menos uma pergunta ao formulário.');
                return;
            }

            // Validar campos obrigatórios das perguntas
            let valid = true;
            perguntas.forEach(pergunta => {
                const textoPergunta = pergunta.querySelector('input[name="perguntas[]"]');
                if (!textoPergunta.value.trim()) {
                    valid = false;
                }

                const tipo = pergunta.querySelector('input[name="tipos_pergunta[]"]').value;
                if (tipo === 'objetiva') {
                    const opcoes = pergunta.querySelectorAll('input[name^="opcoes"]');
                    opcoes.forEach(opcao => {
                        if (!opcao.value.trim()) {
                            valid = false;
                        }
                    });
                    if (opcoes.length < 2) {
                        valid = false;
                    }
                }
            });

            if (!valid) {
                alert('Por favor, preencha todas as perguntas e opções corretamente.');
                return;
            }

            // Se tudo estiver válido, enviar o formulário
            form.submit();
        });
    }
});

