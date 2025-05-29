<?php
include '../../../conexao.php';

$nome = $_POST['nome'];
$descricao = $_POST['descricao'];

$imagens = [];
for ($i = 1; $i <= 3; $i++) {
    $file = $_FILES["imagem$i"];
    if ($file['error'] === 0) {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = uniqid("img_", true) . ".$ext";
        move_uploaded_file($file['tmp_name'], "imagens/$newName");
        $imagens[] = $newName;
    } else {
        $imagens[] = null;
    }
}

$stmt = $conn->prepare("INSERT INTO projetos (nome, descricao, imagem1, imagem2, imagem3) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nome, $descricao, $imagens[0], $imagens[1], $imagens[2]);
$stmt->execute();

header("Location: galeria.php");
exit;
