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
    document.getElementById("modalFormulario").classList.remove("hidden");
}
  
function fecharModal() {
    document.getElementById("modalFormulario").classList.add("hidden");
}