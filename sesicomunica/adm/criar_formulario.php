<?php
include_once 'nav.php';
include_once '../../conexao.php';

session_start();

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

if (!isset($_SESSION['id_users'])) {
    header('Location: ../../index.php');
    exit();
}

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $perguntas = $_POST['perguntas'] ?? [];
    $tipos = $_POST['tipos_pergunta'] ?? [];
    $opcoes = $_POST['opcoes'] ?? [];

    if (isset($_POST["nome_formulario"])) {
        try {
            $conn->begin_transaction();

            // Inserir na tabela de formulários
            $sql_formulario = "INSERT INTO formularios (nome) VALUES (?)";
            $stmt = $conn->prepare($sql_formulario);
            $stmt->bind_param("s", $_POST["nome_formulario"]);
            $stmt->execute();
            $formulario_id = $conn->insert_id;

            // Inserir público alvo
            if (isset($_POST["publico"])) {
                $sql_publico = "INSERT INTO publico (formulario_id, publico_alvo) VALUES (?, ?)";
                $stmt_publico = $conn->prepare($sql_publico);
                $stmt_publico->bind_param("is", $formulario_id, $_POST["publico"]);
                $stmt_publico->execute();
            }

            // Inserir datas
            if (isset($_POST["data_criacao"]) && isset($_POST["data_limite"])) {
                $sql_datas = "INSERT INTO data_formularios (formulario_id, data_limite) VALUES (?, ?)";
                $stmt_datas = $conn->prepare($sql_datas);
                $stmt_datas->bind_param("is", $formulario_id, $_POST["data_limite"]);
                $stmt_datas->execute();
            }

            // Inserir perguntas
            if (isset($_POST["perguntas"]) && isset($_POST["tipos_pergunta"])) {
                $perguntas = $_POST["perguntas"];
                $tipos = $_POST["tipos_pergunta"];
                $opcoes = $_POST['opcoes'] ?? [];

                for ($i = 0; $i < count($perguntas); $i++) {
                    // Inserir pergunta
                    $sql_pergunta = "INSERT INTO perguntas (formulario_id, pergunta, tipo_pergunta) VALUES (?, ?, ?)";
                    $stmt_pergunta = $conn->prepare($sql_pergunta);
                    $stmt_pergunta->bind_param("iss", $formulario_id, $perguntas[$i], $tipos[$i]);
                    $stmt_pergunta->execute();
                    $pergunta_id = $conn->insert_id;

                    // Removida inserção de opções objetivas

                    // Se for pergunta de classificação, inserir min e max
                    if ($tipos[$i] === 'classificacao' && isset($_POST["classificacao_min"][$i]) && isset($_POST["classificacao_max"][$i])) {
                        $sql_class = "UPDATE perguntas SET min_classificacao = ?, max_classificacao = ? WHERE id = ?";
                        $stmt_class = $conn->prepare($sql_class);
                        $min = $_POST["classificacao_min"][$i];
                        $max = $_POST["classificacao_max"][$i];
                        $stmt_class->bind_param("iii", $min, $max, $pergunta_id);
                        $stmt_class->execute();
                    }

                    if ($tipos[$i] === 'objetiva' && isset($opcoes[$i])) {
                        foreach ($opcoes[$i] as $opcao) {
                            $sql_opcao = "INSERT INTO opcoes (pergunta_id, texto) VALUES (?, ?)";
                            $stmt_opcao = $conn->prepare($sql_opcao);
                            $stmt_opcao->bind_param("is", $pergunta_id, $opcao);
                            $stmt_opcao->execute();
                        }
                    }
                }
            }

            $conn->commit();
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Formulário criado com sucesso!',
                    confirmButtonText: 'Ok'
                }).then(() => {
                    window.location.href = '../adm/criar_formulario.php';
                });
            </script>";

            exit;
        } catch (Exception $e) {
            $conn->rollback();
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Erro ao criar formulário',
                    text: '" . addslashes($e->getMessage()) . "',
                    confirmButtonText: 'Ok'
                });
            </script>";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Formulário</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/cssadm/formularioadm.css">
    <link rel="stylesheet" href="../css/cssadm/navadm.css">
    <link rel="shortcut icon" href="../img/icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Gabarito:wght@400..900&display=swap" rel="stylesheet">
    <title>Criar Formulário - SESI Comunica</title>
</head>

<body>

    <div class="flex-container">
        <!-- Formulários existentes -->
        <div class="coluna coluna-scroll">
            <div class="titulo-coluna">
                <h2>Formulários já criados</h2>
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
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='card-formulario'>";
                    echo "<div class='card-header'>";
                    echo "<h3>" . htmlspecialchars($row['nome']) . "</h3>";
                    echo "<div class='card-icons'>";
                    echo "<a href='exportar_formularios.php?id=" . $row['id'] . "' class='icon-link' title='Exportar formulário'><i class='fas fa-file-csv'></i></a>";
                    echo "<a href='#' onclick='abrirModalEditar(" . $row['id'] . ")' class='icon-link'><i class='fas fa-edit'></i></a>";
                    echo "<a href='#' onclick='confirmarExclusao(" . $row['id'] . ")' class='icon-link'><i class='fas fa-trash-alt'></i></a>";
                    echo "</div>";
                    echo "</div>";
                    echo "<div class='card-content'>";
                    echo "Público: " . htmlspecialchars($row['publico_alvo']) . "<br>";
                    echo "Criado em: " . htmlspecialchars($row['data_envio']) . "<br>";
                    echo "Limite: " . htmlspecialchars($row['data_limite']) . "<br>";
                    echo "</div>";
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
                <div class="modal-alinhamento">
                    <div class="modal-content">
                        <span class="close" onclick="fecharModal()">&times;</span>
                        <form method="POST" action="criar_formulario.php">
                            <div class="form-group">
                                <label for="nome_formulario">Nome do formulário:</label>
                                <input type="text" name="nome_formulario" id="nome_formulario" required>
                            </div>

                            <div id="perguntas-container">
                            </div>

                            <button type="button" class="add-pergunta mt-2" onclick="criarPergunta()">+ Adicionar
                                pergunta</button>

                            <div class="form-group">
                                <label for="publico">Público alvo:</label>
                                <select name="publico" id="publico" required>
                                    <option value="">Selecione</option>
                                    <option value="alunos">Alunos</option>
                                    <option value="professores">Professores</option>
                                    <option value="ambos">Ambos</option>
                                </select>
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

            <!-- Modal de Edição -->
            <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editarModalLabel">Editar Formulário</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Fechar"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editar-form">
                                <div class="form-group mb-3">
                                    <label for="editar-nome-formulario" class="form-label">Nome do Formulário:</label>
                                    <input type="text" class="form-control" id="editar-nome-formulario" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="editar-publico" class="form-label">Público Alvo:</label>
                                    <select class="form-control" id="editar-publico" required>
                                        <option value="">Selecione</option>
                                        <option value="alunos">Alunos</option>
                                        <option value="professores">Professores</option>
                                    </select>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="editar-data-criacao" class="form-label">Data de Criação:</label>
                                        <input type="date" class="form-control" id="editar-data-criacao" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="editar-data-limite" class="form-label">Data Limite:</label>
                                        <input type="date" class="form-control" id="editar-data-limite">
                                    </div>
                                </div>
                                <div id="editar-perguntas-container">
                                    <!-- Perguntas serão carregadas aqui -->
                                </div>
                                <button type="button" class="btn btn-secondary mt-3" onclick="criarPerguntaEditar()">+
                                    Adicionar Pergunta</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="button" class="btn btn-primary" onclick="salvarAlteracoes()">Salvar
                                Alterações</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php include 'footer.php'; ?>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/formulario.js" defer></script>

</body>

</html>