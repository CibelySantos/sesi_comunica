<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id_users'])) {
    http_response_code(403); // Código HTTP "Forbidden"
    echo "Acesso negado.";
    exit;
}

if (isset($_GET['id'])) {
    include '../../conexao.php';
    $id = intval($_GET['id']);
    
    $stmt = $conn->prepare("SELECT nome, arquivo_comunicado FROM comunicados WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($nome, $arquivo);
        $stmt->fetch();

        // Garante que nenhum output foi enviado antes do header
        if (!headers_sent()) {
            header("Content-Type: application/pdf");
            header("Content-Disposition: inline; filename=\"" . urlencode($nome) . ".pdf\"");
            header("Content-Length: " . strlen($arquivo));
            echo $arquivo;
        } else {
            echo "Erro: cabeçalhos já enviados.";
        }
    } else {
        echo "Comunicado não encontrado.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID inválido.";
}
