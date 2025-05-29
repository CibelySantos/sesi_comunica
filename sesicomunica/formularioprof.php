<?php
include_once '../../conexao.php';
include ('navprof.php');

// Pega o ID do formulário, se tiver na URL
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$formularioSelecionado = null;

// Se tiver ID, busca os dados do formulário
if ($id) {
    $sql = "SELECT id, nome FROM formularios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $formularioSelecionado = $result->fetch_assoc();

    // Se quiser, pode buscar perguntas desse formulário aqui também
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulários - SESI Comunica</title>
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/comunicados.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../img/icon.png">
    <style>
      .pesquisa-container {
        margin-bottom: 30px;
        text-align: center;
      }
      #barra-pesquisa {
        width: 80%;
        max-width: 600px;
        padding: 15px;
        font-size: 18px;
        border: 2px solid #d50000;
        border-radius: 8px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        transition: border-color 0.3s, box-shadow 0.3s;
      }
      #barra-pesquisa:focus {
        border-color: #a00000;
        box-shadow: 0 0 8px rgba(213, 0, 0, 0.5);
      }
    </style>
</head>
<body>

<main class="container">
    <h1>Formulários</h1>

    <!-- Barra de pesquisa -->
    <div class="pesquisa-container">
      <input type="text" id="barra-pesquisa" placeholder="Pesquisar formulários...">
    </div>

    <!-- Lista de Formulários -->
    <div class="comunicados-container">
      <?php
        $sql = "SELECT id, nome FROM formularios";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo '<div class="comunicado">';
            echo '<a href="?id=' . $row['id'] . '">';
            echo '<p>' . htmlspecialchars($row['nome']) . '</p>';
            echo '</a>';
            echo '</div>';
          }
        } else {
          echo '<p>Nenhum formulário encontrado.</p>';
        }
      ?>
    </div>

    <!-- Conteúdo do Formulário Selecionado -->
    <?php if ($formularioSelecionado): ?>
      <div class="formulario-container">
        <h2><?php echo htmlspecialchars($formularioSelecionado['nome']); ?></h2>
        <div class="conteudo">
          <p>Aqui você pode exibir as perguntas do formulário ou um link para responder.</p>
          <!-- Exemplo de botão -->
          <a href="responderform.php?id=<?php echo $formularioSelecionado['id']; ?>" class="botao-responder">Responder Formulário</a>
        </div>
      </div>
    <?php endif; ?>

</main>

<?php include ('footerprof.php'); ?>

<script>
function removerAcentos(texto) {
  return texto.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
}

document.getElementById('barra-pesquisa').addEventListener('input', function () {
  const filtro = removerAcentos(this.value);
  const comunicados = document.querySelectorAll('.comunicado');

  comunicados.forEach(function (comunicado) {
    const texto = removerAcentos(comunicado.textContent);
    comunicado.style.display = texto.includes(filtro) ? '' : 'none';
  });
});
</script>

</body>
</html>
