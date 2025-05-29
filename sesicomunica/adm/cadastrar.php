<?php
session_start();
include '../../conexao.php';
include 'nav.php';

// Protege a página: só admins podem acessar
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['id_users'])) {
    header('Location: ../../index.php');
    exit();
}

$mensagem = '';

// Excluir usuário
if (isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id_users = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Usuário Deletado com sucesso!',
                        confirmButtonText: 'Ok'
                    }).then(() => {
                        window.location.href = '../../index.php';
                    });
                </script>";

    } else {
        $mensagem = "Erro ao excluir usuário.";
    }
    $stmt->close();
}

if (isset($_POST['atualizar'])) {
    $id = $_POST['edit_id'];
    $nome = $_POST['edit_nome'];
    $email = $_POST['edit_email'];
    $tipo = $_POST['edit_tipo'];

    $stmt = $conn->prepare("UPDATE usuarios SET nome_usuario = ?, email_usuario = ?, tipo_usuario = ? WHERE id_users = ?");
    $stmt->bind_param("sssi", $nome, $email, $tipo, $id);

    if ($stmt->execute()) {
        $mensagem = "Usuário atualizado com sucesso!";
    } else {
        $mensagem = "Erro ao atualizar usuário: " . $stmt->error;
    }
    $stmt->close();
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['delete_id']) && !isset($_POST['edit_id'])) {
    $id = $_POST['id_usuario'] ?? '';
    $nome = $_POST['nome_usuario'] ?? '';
    $email = $_POST['email_usuario'] ?? '';
    $tipo = $_POST['tipo_usuario'] ?? 'professor';
    $senha = $_POST['senha_usuario'] ?? '';

    if ($nome && $email && $tipo) {
        if ($id) {
            // Atualizar
            if ($senha) {
                $hashSenha = password_hash($senha, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE usuarios SET nome_usuario=?, email_usuario=?, tipo_usuario=?, senha_usuario=? WHERE id_users=?");
                $stmt->bind_param("ssssi", $nome, $email, $tipo, $hashSenha, $id);
            } else {
                $stmt = $conn->prepare("UPDATE usuarios SET nome_usuario=?, email_usuario=?, tipo_usuario=? WHERE id_users=?");
                $stmt->bind_param("sssi", $nome, $email, $tipo, $id);
            }

            if ($stmt->execute()) {
                $mensagem = "Usuário atualizado com sucesso!";
            } else {
                $mensagem = "Erro ao atualizar usuário.";
            }
            $stmt->close();
        } else {
            // Cadastrar novo
            $stmt = $conn->prepare("SELECT id_users FROM usuarios WHERE email_usuario = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $mensagem = "Erro: Email já cadastrado.";
            } else {
                $hashSenha = password_hash($senha, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO usuarios (nome_usuario, email_usuario, tipo_usuario, senha_usuario) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $nome, $email, $tipo, $hashSenha);

                if ($stmt->execute()) {
                    $mensagem = "Usuário cadastrado com sucesso!";
                } else {
                    $mensagem = "Erro ao cadastrar usuário.";
                }
            }
            $stmt->close();
        }
    } else {
        $mensagem = "Preencha todos os campos.";
    }
}


// Busca todos os usuários para listagem
$result_usuarios = $conn->query("SELECT id_users, nome_usuario, email_usuario, tipo_usuario FROM usuarios ORDER BY nome_usuario ASC");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../img/icon.png">
    <title>Cadastro e Listagem de Usuários - SESI Comunica</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/cssadm/cadastrar.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/cssadm/cadastrar.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <form method="POST" action="">
            <h1><?= isset($editar_usuario) ? 'Editar Usuário' : 'Cadastro de Usuários' ?></h1>

            <?php if ($mensagem): ?>
                <div class="mensagem <?= strpos($mensagem, 'sucesso') !== false ? 'success' : 'error' ?>">
                    <?= htmlspecialchars($mensagem) ?>
                </div>
            <?php endif; ?>

            <input type="hidden" name="id_usuario" value="<?= $editar_usuario['id_users'] ?? '' ?>">

            <label for="nome_usuario">Nome do usuário:</label>
            <input type="text" id="nome_usuario" name="nome_usuario" required
                value="<?= $editar_usuario['nome_usuario'] ?? '' ?>">

            <label for="email_usuario">Email do usuário:</label>
            <input type="email" id="email_usuario" name="email_usuario" required
                value="<?= $editar_usuario['email_usuario'] ?? '' ?>">

            <label for="tipo_usuario">Tipo do usuário:</label>
            <select id="tipo_usuario" name="tipo_usuario" required>
                <option value="professor" <?= (isset($editar_usuario) && $editar_usuario['tipo_usuario'] == 'professor') ? 'selected' : '' ?>>Professor</option>
                <option value="administrador" <?= (isset($editar_usuario) && $editar_usuario['tipo_usuario'] == 'administrador') ? 'selected' : '' ?>>Administrador</option>
            </select>

            <label for="senha_usuario">Senha
                <?= isset($editar_usuario) ? '(deixe em branco para não alterar)' : '' ?>:</label>
            <input type="password" id="senha_usuario" name="senha_usuario" <?= isset($editar_usuario) ? '' : 'required' ?>>

            <button id="button-cadastro" type="submit"><?= isset($editar_usuario) ? 'Salvar alterações' : 'Cadastrar usuário' ?></button>
        </form>

        <div id="editModal" class="modal" style="display:none;">
            <div class="modal-content">
                <span class="fechar-btn" onclick="fecharModal()">&times;</span>
                <h2>Editar Usuário</h2>
                <form method="POST" action="">
                    <input type="hidden" id="edit_id" name="edit_id">

                    <label for="edit_nome">Nome:</label>
                    <input type="text" id="edit_nome" name="edit_nome" required>

                    <label for="edit_email">Email:</label>
                    <input type="email" id="edit_email" name="edit_email" required>

                    <label for="edit_tipo">Tipo:</label>
                    <select id="edit_tipo" name="edit_tipo" required>
                        <option value="professor">Professor</option>
                        <option value="administrador">Administrador</option>
                    </select>

                    <button type="submit" name="atualizar">Salvar alterações</button>
                </form>
            </div>
        </div>


        <div class="listagem-usuarios">
            <h2>Usuários cadastrados</h2>
            <?php if ($result_usuarios && $result_usuarios->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Tipo</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody>
                        <?php while ($user = $result_usuarios->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['nome_usuario']) ?></td>
                                <td><?= htmlspecialchars($user['email_usuario']) ?></td>
                                <td><?= htmlspecialchars(ucfirst($user['tipo_usuario'])) ?></td>
                                <td class="alinhamento-editar-excluir">
                                    <button onclick="abrirModal()" class="editar-excluir-btn" data-id="<?= $user['id_users'] ?>"
                                        data-nome="<?= htmlspecialchars($user['nome_usuario']) ?>"
                                        data-email="<?= htmlspecialchars($user['email_usuario']) ?>"
                                        data-tipo="<?= $user['tipo_usuario'] ?>">Editar</button>
                                    <form method="POST" action="" style="display:inline;">
                                        <input type="hidden" name="delete_id" value="<?= $user['id_users'] ?>">
                                        <button type="submit" class="editar-excluir-btn"
                                            onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>


                    </tbody>
                </table>
            <?php else: ?>
                <p>Nenhum usuário cadastrado.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>

<script src="../js/cadastrar.js"></script>

</html>