<?php
include 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) die('ID do projeto não informado.');

$result = $conn->query("SELECT * FROM projetos WHERE id = $id");
$projeto = $result->fetch_assoc();
if (!$projeto) die('Projeto não encontrado.');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];

    // Atualiza nome e descrição
    $conn->query("UPDATE projetos SET nome='$nome', descricao='$descricao' WHERE id=$id");

    $uploadDir = "imagens/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $camposImagens = ['imagem1', 'imagem2', 'imagem3'];

    foreach ($camposImagens as $campo) {
        if (!empty($_FILES[$campo]['name'])) {
            $ext = pathinfo($_FILES[$campo]['name'], PATHINFO_EXTENSION);
            $nomeUnico = 'img_' . uniqid() . '.' . $ext;
            $caminhoUpload = $uploadDir . $nomeUnico;

            if (move_uploaded_file($_FILES[$campo]['tmp_name'], $caminhoUpload)) {
                // Atualiza caminho da nova imagem
                $conn->query("UPDATE projetos SET $campo = '$caminhoUpload' WHERE id=$id");
            }
        }
    }

    header("Location: galeria.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Editar Projeto</title>
  <link rel="stylesheet" href="./css/editar.css">
</head>
<body>
  <h2>Editar Projeto</h2>
  <form method="POST" enctype="multipart/form-data">
    <label>Nome:</label><br>
    <input type="text" name="nome" value="<?= htmlspecialchars($projeto['nome']) ?>"><br><br>

    <label>Descrição:</label><br>
    <textarea name="descricao"><?= htmlspecialchars($projeto['descricao']) ?></textarea><br><br>

    <?php foreach (['imagem1', 'imagem2', 'imagem3'] as $campo): ?>
      <div>
        <?php if (!empty($projeto[$campo])): ?>
          <img src="<?= htmlspecialchars($projeto[$campo]) ?>" style="max-width:150px;"><br>
        <?php endif; ?>
        Alterar <?= $campo ?>:
        <input type="file" name="<?= $campo ?>"><br><br>
      </div>
    <?php endforeach; ?>

    <button type="submit">Salvar Alterações</button>
  </form>
  <br>
  <a href="galeria.php">← Voltar</a>
</body>
</html>
