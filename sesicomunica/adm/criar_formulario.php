<?php
    include_once 'nav.php';
    include_once '../../conexao.php';

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Salvar novo formulário via POST
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nome_formulario"])) {
        $nome = $conn->real_escape_string($_POST["nome_formulario"]);
        $publico = isset($_POST["publico"]) ? $conn->real_escape_string($_POST["publico"]) : '';
        $data_criacao = isset($_POST["data_criacao"]) ? $conn->real_escape_string($_POST["data_criacao"]) : date("Y-m-d");
        $data_limite = isset($_POST["data_limite"]) ? $conn->real_escape_string($_POST["data_limite"]) : null;

        $perguntas = $_POST["perguntas"];
        $tipos_pergunta = $_POST["tipos_pergunta"];
        $opcoes = isset($_POST["opcoes"]) ? $_POST["opcoes"] : array();
        $classificacao_min = isset($_POST["classificacao_min"]) ? $_POST["classificacao_min"] : array();
        $classificacao_max = isset($_POST["classificacao_max"]) ? $_POST["classificacao_max"] : array();

        $conn->begin_transaction();

        try {
            // Inserir na tabela de formulários
            $sql_formulario = "INSERT INTO formularios (nome) VALUES (?)";
            $stmt = $conn->prepare($sql_formulario);
            $stmt->bind_param("s", $nome);
            $stmt->execute();
            $formulario_id = $conn->insert_id;

            // Inserir perguntas e suas configurações
            $sql_pergunta = "INSERT INTO perguntas (formulario_id, pergunta, tipo_pergunta) VALUES (?, ?, ?)";
            $stmt_pergunta = $conn->prepare($sql_pergunta);

            // Inserir opções para perguntas objetivas
            $sql_opcao = "INSERT INTO respostas (pergunta_id, texto_opcao, ordem) VALUES (?, ?, ?)";
            $stmt_opcao = $conn->prepare($sql_opcao);

            foreach ($perguntas as $index => $pergunta) {
                $tipo = $tipos_pergunta[$index];
                
                // Inserir pergunta
                $stmt_pergunta->bind_param("iss", $formulario_id, $pergunta, $tipo);
                $stmt_pergunta->execute();
                $pergunta_id = $conn->insert_id;

                // Inserir opções se for pergunta objetiva
                if ($tipo === 'objetiva' && isset($opcoes[$index])) {
                    $ordem = 1;
                    foreach ($opcoes[$index] as $opcao) {
                        $stmt_opcao->bind_param("isi", $pergunta_id, $opcao, $ordem);
                        $stmt_opcao->execute();
                        $ordem++;
                    }
                }
                // Inserir configuração de classificação
                elseif ($tipo === 'classificacao' && isset($classificacao_min[$index]) && isset($classificacao_max[$index])) {
                    $min = intval($classificacao_min[$index]);
                    $max = intval($classificacao_max[$index]);
                    $sql_classificacao = "UPDATE perguntas SET classificacao_min = ?, classificacao_max = ? WHERE id = ?";
                    $stmt_class = $conn->prepare($sql_classificacao);
                    $stmt_class->bind_param("iii", $min, $max, $pergunta_id);
                    $stmt_class->execute();
                }
            }

            // Inserir público
            $sql_publico = "INSERT INTO publico (formulario_id, publico_alvo) VALUES (?, ?)";
            $stmt_publico = $conn->prepare($sql_publico);
            $stmt_publico->bind_param("is", $formulario_id, $publico);
            $stmt_publico->execute();

            // Inserir datas
            $sql_datas = "INSERT INTO data_formularios (formulario_id, data_envio, data_limite) VALUES (?, ?, ?)";
            $stmt_datas = $conn->prepare($sql_datas);
            $stmt_datas->bind_param("iss", $formulario_id, $data_criacao, $data_limite);
            $stmt_datas->execute();

            $conn->commit();
            echo "<script>
                alert('Formulário criado com sucesso!');
                window.location.reload();
            </script>";
        } catch (Exception $e) {
            $conn->rollback();
            echo "<script>alert('Erro ao criar formulário: " . $e->getMessage() . "');</script>";
        }
    }
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Formulário</title>
    <link rel="stylesheet" href="../css/cssadm/navadm.css">
    <link rel="stylesheet" href="../css/cssadm/formularioadm.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../img/icon.png">
    <link href="https://fonts.googleapis.com/css2?family=Gabarito:wght@400..900&display=swap" rel="stylesheet">
</head>
    <body>

    <div class="flex-container">
        <!-- Formulários existentes -->
        <div class="coluna coluna-scroll">
            <div class="titulo-coluna">
                <h2>📋 Formulários já criados</h2>
            </div>
            <div id="espacamento"></div>
            <?php
                $sql = "SELECT f.id, f.nome,pub.publico_alvo, d.data_envio, d.data_limite
                        FROM formularios f
                        LEFT JOIN publico pub ON f.id = pub.formulario_id
                        LEFT JOIN data_formularios d ON f.id = d.formulario_id
                        ORDER BY d.data_envio DESC";

                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='card'>";
                        echo "<strong>" . htmlspecialchars($row['nome']) . "</strong><br>";
                        echo "Público: " . htmlspecialchars($row['publico_alvo']) . "<br>";
                        echo "Criado em: " . htmlspecialchars($row['data_envio']) . "<br>";
                        echo "Limite: " . htmlspecialchars($row['data_limite']) . "<br>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Nenhum formulário encontrado.</p>";
                }
            ?>
        </div>
        <!-- Criação de formulário -->
        <div class="card-criacao-formulario">
            
            <div class="card-criacao-formulario-content">
                <div class="titulo-card-criacao-formulario">
                        <h2>Criar novo formulário</h2>
                </div>
                <button class="botao-criar" onclick="abrirModal()">Novo Formulário</button>
            </div>

            <!-- Modal -->
            <div id="modalFormulario" class="modal hidden">
                <div class="modal-content">
                    <span class="close" onclick="fecharModal()">&times;</span>
                    <form method="POST" action="">
                    <div class="form-group">
                        <label for="nome_formulario">Nome do formulário:</label>
                        <input type="text" name="nome_formulario" id="nome_formulario" required>
                    </div>

                    <div id="perguntas-container">
                        <div class="form-group pergunta-item">
                            <div class="pergunta-header">
                                <label>Pergunta:</label>
                                <select class="tipo-pergunta" onchange="handleTipoPergunta(this)">
                                    <option value="dissertativa">Dissertativa</option>
                                    <option value="objetiva">Objetiva</option>
                                    <option value="classificacao">Classificação</option>
                                </select>
                                <button type="button" class="btn-remover-pergunta" onclick="removerPergunta(this)">Remover</button>
                            </div>
                            <input type="text" name="perguntas[]" required>
                            <input type="hidden" name="tipos_pergunta[]" value="dissertativa">
                            <div class="opcoes-container"></div>
                            <div class="classificacao-container">
                                <label for="classificacao_min">Mínimo:</label>
                                <input type="number" name="classificacao_min[]" id="classificacao_min">
                                <label for="classificacao_max">Máximo:</label>
                                <input type="number" name="classificacao_max[]" id="classificacao_max">
                            </div>
                        </div>
                    </div>
                    <button type="button" class="add-pergunta" onclick="criarPergunta()">+ Adicionar pergunta</button>

                    <div class="form-group">
                        <label for="publico">Público alvo:</label>
                        <select name="publico" id="publico" required>
                        <option value="">Selecione</option>
                        <option value="alunos">Alunos</option>
                        <option value="professores">Professores</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="data_criacao">Data de criação:</label>
                        <input type="date" name="data_criacao" required>
                    </div>

                    <div class="form-group">
                        <label for="data_limite">Data limite:</label>
                        <input type="date" name="data_limite" required>
                    </div>

                    <button type="submit" class="botao-criar">Criar formulário</button>
                    </form>
                </div>
            </div>


        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="../js/formulario.js" defer></script>
    <script src="../js/nav-adm.js"></script>
    </body>
</html>
