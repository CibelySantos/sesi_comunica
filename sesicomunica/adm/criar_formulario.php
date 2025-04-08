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

        $conn->begin_transaction();

        try {
            // Inserir na tabela de formulários (apenas nome)
            $conn->query("INSERT INTO formularios (nome) VALUES ('$nome')");
            $formulario_id = $conn->insert_id;

            // Inserir perguntas
            foreach ($perguntas as $pergunta) {
                $pergunta = $conn->real_escape_string($pergunta);
                $conn->query("INSERT INTO perguntas (formulario_id, pergunta) VALUES ('$formulario_id', '$pergunta')");
            }

            // Inserir público (caso tenha tabela 'publico')
            $conn->query("INSERT INTO publico (formulario_id, publico_alvo) VALUES ('$formulario_id', '$publico')");

            // Inserir datas
            $conn->query("INSERT INTO data_formularios (formulario_id, data_envio, data_limite) VALUES ('$formulario_id', '$data_criacao', '$data_limite')");

            $conn->commit();
            echo "<script>alert('Formulário criado com sucesso!');</script>";
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
            <div id="modalFormulario" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="fecharModal()">&times;</span>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="nome_formulario">Nome do formulário:</label>
                            <input type="text" name="nome_formulario" id="nome_formulario" required>
                        </div>

                        <div id="perguntasContainer">
                            <div class="form-group">
                                <label>Pergunta:</label>
                                <input type="text" name="perguntas[]" required>
                            </div>
                        </div>
                        <button type="button" class="add-pergunta" onclick="adicionarPergunta()">+ Adicionar pergunta</button>

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
