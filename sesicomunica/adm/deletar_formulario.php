<?php
include_once '../../conexao.php';
session_start();

if (!isset($_GET['id'])) {
    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            window.onload = function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'ID do formulário não fornecido.',
                    confirmButtonText: 'Ok'
                }).then(() => {
                    window.location.href = 'criar_formulario.php';
                });
            };
        </script>
    </body>
    </html>";
    exit();
}

$formulario_id = intval($_GET['id']);

try {
    $conn->begin_transaction();

    // Excluir respostas
    $sql = "DELETE r FROM respostas r 
            INNER JOIN perguntas p ON r.pergunta_id = p.id 
            WHERE p.formulario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $formulario_id);
    $stmt->execute();

    // Excluir opções de resposta (ANTES de excluir perguntas!)
    $sql = "DELETE o FROM opcoes o 
            INNER JOIN perguntas p ON o.pergunta_id = p.id 
            WHERE p.formulario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $formulario_id);
    $stmt->execute();

    // Excluir perguntas
    $sql = "DELETE FROM perguntas WHERE formulario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $formulario_id);
    $stmt->execute();

    // Excluir datas
    $sql = "DELETE FROM data_formularios WHERE formulario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $formulario_id);
    $stmt->execute();

    // Excluir público alvo
    $sql = "DELETE FROM publico WHERE formulario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $formulario_id);
    $stmt->execute();

    // Excluir submissões
    $sql = "DELETE FROM submissoes WHERE formulario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $formulario_id);
    $stmt->execute();

    // Excluir formulário
    $sql = "DELETE FROM formularios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $formulario_id);
    $stmt->execute();

    $stmt->close();
    $conn->commit();

    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            window.onload = function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Formulário excluído com sucesso.',
                    confirmButtonText: 'Ok'
                }).then(() => {
                    window.location.href = 'criar_formulario.php';
                });
            };
        </script>
    </body>
    </html>";

} catch (Exception $e) {
    $conn->rollback();

    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            window.onload = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro ao excluir formulário',
                    text: '" . addslashes($e->getMessage()) . "',
                    confirmButtonText: 'Ok'
                }).then(() => {
                    window.location.href = 'criar_formulario.php';
                });
            };
        </script>
    </body>
    </html>";
}
?>
