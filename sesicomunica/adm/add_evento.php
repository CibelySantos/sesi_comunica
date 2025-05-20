<?php
include("../../conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $titulo = $_POST["title"] ?? '';
  $descricao = $_POST["description"] ?? '';
  $categoria = $_POST["category"] ?? '';
  $data_evento = $_POST["date"] ?? '';

  if (!$titulo || !$descricao || !$categoria || !$data_evento) {
    echo "Campos obrigatórios não preenchidos.";
    exit;
  }

  $sql = "INSERT INTO eventos (titulo, descricao, categoria, data_inicio)
          VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssss", $titulo, $descricao, $categoria, $data_evento);

  if ($stmt->execute()) {
    echo "ok";
  } else {
    echo "Erro ao salvar no banco: " . $conn->error;
  }

  $stmt->close();
  $conn->close();
}
?>
