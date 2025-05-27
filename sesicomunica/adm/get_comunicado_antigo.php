<?php
include '../../conexao.php';

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["erro" => "ID não fornecido"]);
    exit;
}

$id = intval($_GET['id']);

// Verifica se o comunicado tem mais de 1 mês
$sql = "SELECT nome, arquivo_comunicado 
        FROM comunicados 
        WHERE id = ? AND data_comunicado < DATE_SUB(NOW(), INTERVAL 1 MONTH)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    http_response_code(404);
    echo json_encode(["erro" => "Comunicado não encontrado ou não é antigo"]);
    exit;
}

$stmt->bind_result($nome, $arquivo);
$stmt->fetch();

echo json_encode([
    "nome" => $nome,
    "pdf" => base64_encode($arquivo)
]);
?>
