function criarPergunta() {
    const container = document.getElementById('perguntas-container');

    const newQuestion = document.createElement('div');
    newQuestion.className = 'form-criar-formulario-container espacamento';

    const label = document.createElement('label');
    label.textContent = 'Pergunta:';

    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'pergunta[]';
    input.required = true;

    newQuestion.appendChild(label);
    newQuestion.appendChild(input);
    container.appendChild(newQuestion);
}

function abrirModal() {
    document.getElementById('modalFormulario').style.display = 'block';
}

function fecharModal() {
    document.getElementById('modalFormulario').style.display = 'none';
}
