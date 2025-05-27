<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Criar Projeto</title>
  <link rel="stylesheet" href="./css/criar.css">
  
</head>
<body>
  <div class="container">
    <h2>Criar Novo Projeto</h2>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
      <input type="text" name="nome" placeholder="Seu nome" required>

      <textarea name="descricao" placeholder="Descrição do projeto" required></textarea>

      <label>Imagem 1:</label>
      <input type="file" name="imagem1" required>

      <label>Imagem 2:</label>
      <input type="file" name="imagem2" required>

      <label>Imagem 3:</label>
      <input type="file" name="imagem3" required>

      <button type="submit">Enviar</button>
    </form>

    <a href="galeria.php">← Voltar para Galeria</a>
  </div>

</body>
</html>
