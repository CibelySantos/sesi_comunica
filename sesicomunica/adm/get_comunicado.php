<?php
include '../../conexao.php';

header('Content-Type: application/json');

// Verifica se o parâmetro 'id' foi enviado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['error' => 'ID do comunicado não fornecido']);
    exit;
}

$id = intval($_GET['id']);

// Prepara a consulta para evitar SQL Injection
$stmt = $conn->prepare("SELECT nome, arquivo_comunicado FROM comunicados WHERE id = ?");
$stmt->bind_param("i", $id);

if (!$stmt->execute()) {
    echo json_encode(['error' => 'Erro ao executar a consulta']);
    exit;
}

$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo json_encode(['error' => 'Comunicado não encontrado']);
    exit;
}

$stmt->bind_result($nome, $arquivo_comunicado);
$stmt->fetch();

// Converte o conteúdo do PDF (binário) para base64
$pdfBase64 = base64_encode($arquivo_comunicado);

echo json_encode([
    'nome' => $nome,
    'pdf' => $pdfBase64
]);

$stmt->close();
$conn->close();
