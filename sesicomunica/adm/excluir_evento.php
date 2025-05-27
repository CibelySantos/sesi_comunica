<?php
include('../../conexao.php'); // ajuste para o caminho correto do seu banco

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
