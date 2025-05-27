<?php
session_start();
include 'conexao.php';

$erro = '';
$sucesso = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $stmt = $conn->prepare("SELECT id_users, nome_usuario, senha_usuario, tipo_usuario FROM usuarios WHERE email_usuario = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($senha, $user['senha_usuario'])) {
            $_SESSION['usuario'] = $user['nome_usuario'];
            $_SESSION['id_users'] = $user['id_users'];
            $_SESSION['tipo_usuario'] = $user['tipo_usuario'];
            $sucesso = true;
        } else {
            $erro = "Senha incorreta.";
        }
    } else {
        $erro = "Email não encontrado.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - SESI Comunica</title>
    <link rel="stylesheet" href="sesicomunica/css/login.css" />
</head>
<body>
<?php if ($erro): ?>
    <script>alert("<?= htmlspecialchars($erro) ?>");</script>
<?php elseif ($sucesso): ?>
    <script>
        <?php if ($_SESSION['tipo_usuario'] === 'administrador'): ?>
            window.location.href = "sesicomunica/adm/inicialadm.php";
        <?php elseif ($_SESSION['tipo_usuario'] === 'professor'): ?>
            window.location.href = "sesicomunica/professores/inicialprof.php";
        <?php else: ?>
            window.location.href = "sesicomunica/usuario/inicialcomum.php";
        <?php endif; ?>
    </script>
<?php endif; ?>

<div class="login-container">
    <div class="login-image">
        <img src="sesicomunica/img/imgAlunosLogin.jpg" alt="Logo da Instituição" />
    </div>
    <div class="login-form">
        <center><img src="sesicomunica/img/icon.png" alt="Icone" width="110" height="100" /></center>
        <h2>Bem-vindo!</h2>
        <p>Faça login para continuar</p>

        <form method="POST" action="">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Digite seu email" required autofocus />

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required />

            <button type="submit">Entrar</button>
        </form>
    </div>
</div>
</body>
</html>
