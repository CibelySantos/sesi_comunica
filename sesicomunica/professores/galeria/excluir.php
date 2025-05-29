<?php
include '../../../conexao.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $conn->query("DELETE FROM projetos WHERE id = $id");
}
header("Location: galeria.php");
exit;
