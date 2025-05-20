<?php
session_start();
include '../../conexao.php';
include 'nav.php';

// Protege a página: só admins podem acessar
if (!isset($_SESSION['usuario']) || $_SESSION['tipo_usuario'] !== 'administrador') {
    header('Location: ../../login.php');
    exit();
}

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome_usuario'] ?? '';
    $email = $_POST['email_usuario'] ?? '';
    $tipo = $_POST['tipo_usuario'] ?? 'professor';
    $senha = $_POST['senha_usuario'] ?? '';

    if ($nome && $email && $tipo && $senha) {
        // Verifica se email já existe
        $stmt = $conn->prepare("SELECT id_users FROM usuarios WHERE email_usuario = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $mensagem = "Erro: Email já cadastrado.";
        } else {
            // Insere novo usuário com senha hash
            $hashSenha = password_hash($senha, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO usuarios (nome_usuario, email_usuario, tipo_usuario, senha_usuario) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nome, $email, $tipo, $hashSenha);

            if ($stmt->execute()) {
                $mensagem = "Usuário cadastrado com sucesso!";
            } else {
                $mensagem = "Erro ao cadastrar usuário: " . $stmt->error;
            }
        }

        $stmt->close();
    } else {
        $mensagem = "Preencha todos os campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <head>
    <link rel="shortcut icon" href="../img/icon.png">
    <title>Calendário - SESI Comunica</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/cssadm/navadm.css">
    <link rel="stylesheet" href="../css/cssadm/calendarioadm.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/cssadm/cadastro_usuarios.css"> <!-- Novo CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

</head>
<body>
<div class="container">
    <h1>Cadastro de Usuários</h1>

    <?php if ($mensagem): ?>
        <div class="mensagem <?= strpos($mensagem, 'sucesso') !== false ? 'success' : '' ?>">
            <?= htmlspecialchars($mensagem) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="nome_usuario">Nome do usuário:</label>
        <input type="text" id="nome_usuario" name="nome_usuario" required>

        <label for="email_usuario">Email do usuário:</label>
        <input type="email" id="email_usuario" name="email_usuario" required>

        <label for="tipo_usuario">Tipo do usuário:</label>
        <select id="tipo_usuario" name="tipo_usuario" required>
            <option value="professor">Professor</option>
            <option value="administrador">Administrador</option>
        </select>

        <label for="senha_usuario">Senha:</label>
        <input type="password" id="senha_usuario" name="senha_usuario" required>

        <button type="submit">Cadastrar usuário</button>
    </form>

    <p style="text-align:center; margin-top: 20px;">
        <a href="logout.php">Sair</a>
    </p>
   
</div>
 <?php include 'footer.php'; ?>
</body>
</html>
