<?php 
include 'nav.php'; 
include '../../conexao.php';

// Enviar comunicado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'] ?? '';
    $destinatario = $_POST['destinatario'] ?? '';

    if (isset($_FILES['arquivo_pdf']) && $_FILES['arquivo_pdf']['error'] === UPLOAD_ERR_OK) {
        $conteudo_pdf = file_get_contents($_FILES['arquivo_pdf']['tmp_name']);

        $stmt = $conn->prepare("INSERT INTO comunicados (data_comunicado, nome, destinatario, arquivo_comunicado) VALUES (NOW(), ?, ?, ?)");
        $stmt->bind_param("ssb", $nome, $destinatario, $null);
        $null = NULL;
        $stmt->send_long_data(2, $conteudo_pdf);

        if ($stmt->execute()) {
            echo "<script>alert('Comunicado enviado com sucesso!'); window.location.href = window.location.href;</script>";
            exit();
        } else {
            echo "<p class='error'>Erro ao enviar comunicado: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p class='error'>Erro no envio do arquivo PDF.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cssadm/navadm.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/cssadm/administrativo.css">
    <link rel="shortcut icon" href="../img/icon.png">
    <title>Administrativo - SESI Comunica</title>
</head>
<body>
    <main class="container">
        <h1>Comunicados enviados</h1>

        <div class="comunicados">
            <?php
            $result = $conn->query("SELECT id, nome FROM comunicados ORDER BY data_comunicado DESC");

            if ($result->num_rows > 0) {
                $numero = 1;
                while ($row = $result->fetch_assoc()) {
                    $id = $row['id'];
                    $nome = htmlspecialchars($row['nome']);
                    $numeroFormatado = str_pad($numero++, 3, "0", STR_PAD_LEFT);

                    echo "
                        <a href='#' onclick='abrirComunicado($id)'>
                            <div class='comunicado'>
                                Comunicado $numeroFormatado -<br>$nome
                            </div>
                        </a>
                    ";


                }
            } else {
                echo "<p>Nenhum comunicado encontrado.</p>";
            }

            $conn->close();
            ?>
        </div>

        <div class="modal-comunicados">
            <div id="comunicado-modal" class="modal-overlay" style="display:none;">
                <div class="modal-content">
                    <button class="close-btn" onclick="fecharModal()">x</button> 
                    <h2 id="modal-nome-comunicado"></h2>
                    <iframe id="pdf-frame" style="width:101%; height:300px;" frameborder="0"></iframe>
                </div>
            </div>
        </div>

        <h2>Enviar comunicado</h2>
        <div class="enviar-box">
            <span>+</span>
        </div>

        <div class="modal-overlay" id="modal">
            <div class="modal-content">
                <button class="close-btn" onclick="fecharModal()">x</button>
                <form method="POST" enctype="multipart/form-data">
                    <label for="nome">Nome do comunicado:</label>
                    <input type="text" id="nome" name="nome" required>

                    <label for="arquivo_pdf">Upload comunicado (PDF):</label>
                    <input type="file" id="arquivo_pdf" name="arquivo_pdf" accept=".pdf" required hidden>
                    <label for="arquivo_pdf" class="upload-label">
                        <img src="../img/img-iconArquivo-adm.png" alt="Selecionar arquivo PDF" class="upload-icon">
                    </label>
                    <span id="nome-arquivo" style="margin-top: 8px; display: block;"></span>

                    <label for="destinatario">Destinatário:</label>
                    <select id="destinatario" name="destinatario" required>
                        <option value="aluno">Aluno</option>
                        <option value="professor">Professor</option>
                    </select>

                    <button type="submit" class="publicar-btn">Publicar comunicado</button>
                </form>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script src="../js/nav-adm.js"></script>
    <script>
        const modal = document.getElementById("modal");

        document.querySelector(".enviar-box").addEventListener("click", () => {
            modal.style.display = "flex";
        });

        window.addEventListener("click", function (e) {
            if (e.target === modal) {
                fecharModal();
            }
        });

        document.getElementById('arquivo_pdf').addEventListener('change', function () {
            const nomeArquivo = this.files[0]?.name || 'Nenhum arquivo selecionado';
            document.getElementById('nome-arquivo').textContent = nomeArquivo;
        });

        function abrirComunicado(id) {
    fetch('get_comunicado.php?id=' + id)
        .then(response => response.json())
        .then(data => {
            document.getElementById('modal-nome-comunicado').innerText = data.nome;
            document.getElementById('pdf-frame').src = 'data:application/pdf;base64,' + data.pdf;
            document.getElementById('comunicado-modal').style.display = 'flex';
        })
        .catch(error => {
            alert('Erro ao carregar comunicado.');
            console.error(error);
        });
}

function fecharModal() {
    document.getElementById('comunicado-modal').style.display = 'none';
    document.getElementById('modal').style.display = 'none';
}

    </script>
</body>
</html>
