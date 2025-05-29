<?php
include '../../conexao.php';

$formularioSelecionado = null;
$respostaSalva = false;

// Salvar respostas
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['formulario_id'])) {

  $formularioId = intval($_POST['formulario_id']);

  // Insere na tabela submissoes para criar o registro e gerar o ID automático
  $sqlSubmissao = "INSERT INTO submissoes (formulario_id) VALUES ($formularioId)";
  if (!$conn->query($sqlSubmissao)) {
    die("Erro ao salvar submissão: " . $conn->error);
  }
  $submissaoId = $conn->insert_id;

  // Verifica e salva as respostas
  if (isset($_POST['respostas']) && is_array($_POST['respostas'])) {
    foreach ($_POST['respostas'] as $perguntaId => $resposta) {
      $perguntaId = intval($perguntaId);
      $resposta = $conn->real_escape_string($resposta);

      // Valores padrão para os campos obrigatórios da tabela respostas
      $texto_opcao = '';
      $ordem = 0;

      $sqlResposta = "INSERT INTO respostas 
        (submissao_id, pergunta_id, resposta, texto_opcao, ordem, formulario_id) 
        VALUES 
        ($submissaoId, $perguntaId, '$resposta', '$texto_opcao', $ordem, $formularioId)";

      if (!$conn->query($sqlResposta)) {
        die("Erro ao salvar resposta: " . $conn->error);
      }
    }
  }

  $respostaSalva = true; // Para mostrar a mensagem de sucesso no formulário

}



// Buscar dados do formulário selecionado
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $sql = "SELECT * FROM formularios WHERE id = $id";
  $result = $conn->query($sql);

  if ($result && $result->num_rows > 0) {
    $formularioSelecionado = $result->fetch_assoc();
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Formulários - SESI Comunica</title>
  <link rel="stylesheet" href="../css/formulario.css">
  <link rel="stylesheet" href="../css/nav.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="shortcut icon" href="../img/icon.png">
  <style>
    body { background: #f9f9f9; font-family: Arial, sans-serif; }
    .container { max-width: 1200px; margin: 30px auto; padding: 20px; }

    .formulario-container {
      background: white; padding: 30px; border-radius: 12px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); max-width: 900px; margin: 40px auto;
    }

    h1, h2 { text-align: center; color: #d50000; }

    label { font-weight: bold; display: block; margin-top: 15px; }

    input[type="text"], textarea, select {
      width: 100%; padding: 10px; margin-top: 5px;
      border: 1px solid #ccc; border-radius: 5px;
    }

    button {
      background: #d50000; color: white; padding: 10px 20px;
      border: none; border-radius: 5px; margin-top: 20px;
      cursor: pointer; font-size: 16px;
    }

    .comunicado {
      background: white; padding: 20px; border-radius: 10px;
      width: 250px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      text-align: center; transition: box-shadow 0.2s, transform 0.2s;
    }

    .comunicado:hover {
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      transform: scale(1.05);
    }

    .comunicados-container {
      display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;
    }

    .sucesso {
      background: #d4edda; color: #155724; padding: 15px;
      border: 1px solid #c3e6cb; border-radius: 8px; margin-bottom: 20px;
      text-align: center;
    }

    /* NOVO: tornar card inteiro clicável e remover estilo de link */
    a.comunicado-link {
      text-decoration: none;
      color: inherit;
      display: block;
    }

    a.comunicado-link:hover {
      text-decoration: none;
      color: inherit;
    }
  </style>
</head>
<body>

<?php include('navprof.php'); ?>

<div class="container">
  <h1>Formulários</h1>

  <div class="comunicados-container">
    <?php
    $sql = "SELECT id, nome FROM formularios";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo '<a href="?id=' . $row['id'] . '" class="comunicado-link">';
        echo '<div class="comunicado">';
        echo '<p>' . htmlspecialchars($row['nome']) . '</p>';
        echo '</div>';
        echo '</a>';
      }
    } else {
      echo '<p>Nenhum formulário encontrado.</p>';
    }
    ?>
  </div>

  <?php if ($formularioSelecionado): ?>
    <div class="formulario-container">
      <h2><?php echo htmlspecialchars($formularioSelecionado['nome']); ?></h2>

      <?php if ($respostaSalva): ?>
        <div class="sucesso">Respostas enviadas com sucesso!</div>
      <?php endif; ?>

      <form method="POST">
        <input type="hidden" name="formulario_id" value="<?php echo $formularioSelecionado['id']; ?>">

        <?php
        // BUSCAR PERGUNTAS DO FORMULÁRIO
        $formId = intval($formularioSelecionado['id']);
        $sqlPerguntas = "SELECT * FROM perguntas WHERE formulario_id = $formId";
        $resPerguntas = $conn->query($sqlPerguntas);

        if ($resPerguntas && $resPerguntas->num_rows > 0) {
          while ($pergunta = $resPerguntas->fetch_assoc()) {
            $perguntaId = $pergunta['id'];
            $texto = htmlspecialchars($pergunta['pergunta']);
            $tipo = $pergunta['tipo'];

            echo "<label for='pergunta_$perguntaId'>$texto</label>";

            // Renderizar o campo de acordo com o tipo
            switch ($tipo) {
              case 'text':
              case 'dissertativa':
                echo "<input type='text' name='respostas[$perguntaId]' id='pergunta_$perguntaId' required>";
                break;

              case 'textarea':
                echo "<textarea name='respostas[$perguntaId]' id='pergunta_$perguntaId' rows='4' required></textarea>";
                break;

              default:
                echo "<input type='text' name='respostas[$perguntaId]' id='pergunta_$perguntaId' required>";
            }
          }
        } else {
          echo "<p>Esse formulário ainda não possui perguntas.</p>";
        }
        ?>

        <button type="submit">Enviar Respostas</button>
      </form>
    </div>
  <?php endif; ?>

</div>

<?php include('footerprof.php'); ?>

</body>
</html>
