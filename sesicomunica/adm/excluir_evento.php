<?php
include('../../conexao.php'); 

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'adm') {
    http_response_code(403);
    echo json_encode(['erro' => 'Acesso negado']);
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM eventos WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "ok";
    } else {
        echo "erro";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "id_invalido";
}
