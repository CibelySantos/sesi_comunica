<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cssprof/login2.css">
    <link rel="shortcut icon" type="" href="../img/icon.png">
    <title>Login</title>
</head>
<body>
    <div class="login-container">
        <div class="login-image">
            <img src="../img/imgAlunosLogin.jpg" alt="Logo da Instituição">
        </div>
        <div class="login-form">
            <center><img src="../img/icon.png" alt="" width="110" height="100"></center>
            <h2>Bem-vindo!</h2>
            <p>Faça login para continuar</p>
            <label for="CPF">CPF:</label>
            <input type="text" id="CPF" placeholder="Digite seu CPF">
            <label for="password">Senha: </label>
            <input type="password" id="password" placeholder="Digite sua senha">
            <button onclick="login()">Entrar</button>
        </div>
    </div>
    <script>
        function login() {
            // Substitua 'outra_pagina.html' pelo URL da página para a qual você quer redirecionar
            window.location.href = '../professores/inicialprof.php';
        }
    </script>
</body>
</html>

