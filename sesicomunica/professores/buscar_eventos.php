<?php
header('Content-Type: application/json');

// Conexão com o banco de dados
$host = "localhost";
$user = "root";
$password = "";
$db = "sesicomunica_db";

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro na conexão com o banco de dados.']);
    exit();
}

$sql = "SELECT titulo, data_inicio, categoria FROM eventos ORDER BY data_inicio ASC";
$result = $conn->query($sql);

$eventos = [];

while ($row = $result->fetch_assoc()) {
    $categoria = $row['categoria']; // deve ser 'fundamental1', 'fundamental2' ou 'medio'

    $eventos[] = [
        'title' => $row['titulo'],
        'start' => $row['data_inicio'],
        'display' => 'list-item',           // Mostra com bolinha
        'classNames' => [$categoria],       // Define classe CSS para cor da bolinha
    ];
}

echo json_encode($eventos);
$conn->close();
?>
