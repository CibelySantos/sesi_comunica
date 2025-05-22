<?php
include("../../conexao.php");

$stmt = $conn->prepare("SELECT * FROM eventos");
$stmt->execute();

$result = $stmt->get_result(); // Necessário para usar fetch_assoc()
$eventos = [];

while ($row = $result->fetch_assoc()) {
  switch ($row['categoria']) {
    case 'fundamental1':
      $cor = '#f9e88d';
      break;
    case 'fundamental2':
      $cor = '#f9b3b3';
      break;
    case 'medio':
      $cor = '#b3d9ff';
      break;
    default:
      $cor = '#cccccc'; // Cor para quando for categoria adm ou professores
  }

  $eventos[] = array(
  "title" => $row['titulo'],
  "start" => $row['data_inicio'],
  "description" => $row['descricao'],
  "category" => $row['categoria'],
  "color" => $cor
);

}
header('Content-Type: application/json');
echo json_encode($eventos);
$stmt->close();
?>
