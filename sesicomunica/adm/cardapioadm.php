<?php 
    include_once 'nav.php'; 
    include('./conexaoPdf.php');

    // Buscar o PDF mais recente
    $stmt = $conn->prepare("SELECT data_pdf, arquivo_pdf FROM pdf WHERE data_pdf = (SELECT MAX(data_pdf) FROM pdf)");
    $stmt->execute();
    $stmt->store_result();

    $pdfBase64 = "";
    $data_mais_recente = "Nenhuma data encontrada";

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($data_pdf, $arquivo_pdf);
        $stmt->fetch();

        $data_mais_recente = date("d/m/Y", strtotime($data_pdf));
        $pdfBase64 = base64_encode($arquivo_pdf);
    }

    $stmt->close();
    $conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cssadm/navadm.css">
    <link rel="stylesheet" href="../css/cssadm/cardapioadm.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../img/icon.png">
    <title>Cardápio - SESI Comunica</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Gabarito:wght@400..900&display=swap" rel="stylesheet">
</head>
<body>
    <h1 id="text-princ-caradapio-adm">CARDÁPIO SEMANAL</h1>
    <p style="text-align: center; font-weight: bold; margin-bottom: 20px;">
        Última atualização: <?php echo $data_mais_recente; ?>
    </p>

    <div class="container-adm">
        <?php if (!empty($pdfBase64)): ?>
            <embed src="data:application/pdf;base64,<?php echo $pdfBase64; ?>" type="application/pdf" />
        <?php else: ?>
            <div style="text-align: center; color: red;">Nenhum PDF encontrado.</div>
        <?php endif; ?>

        
        <div class="alinha-button-pdf">
            <a class="sublinhado" href="#" id="openModal">
                <img id="icone-pdf-adm" src="../img/icone-pdf.png" alt="PDF">
                <span id="text-subirPdf">Clique aqui para subir PDF</span>
            </a>
        </div>
    </div>

    <div id="pdfModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h1 id="text-princp-pdf">Subir PDF</h1>

            <div class="form-container">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="date" name="data_pdf" required>
                    <input type="file" name="arquivo_pdf" accept=".pdf" required>
                    <input type="submit" value="Enviar PDF" class="btn-enviar">
                </form>
            </div>
        </div>
    </div>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            include('./conexaoPdf.php');
            $data_pdf = $_POST['data_pdf'];

            $stmt_check = $conn->prepare("SELECT COUNT(*) FROM pdf WHERE data_pdf = ?");
            $stmt_check->bind_param("s", $data_pdf);
            $stmt_check->execute();
            $stmt_check->bind_result($count);
            $stmt_check->fetch();
            $stmt_check->close();

            if ($count > 0) {
                echo "<script>console.log('Já existe um PDF com essa data.')</script>";
            } else {
                if (isset($_FILES['arquivo_pdf']) && $_FILES['arquivo_pdf']['error'] === UPLOAD_ERR_OK) {
                    $conteudo_pdf = file_get_contents($_FILES['arquivo_pdf']['tmp_name']);

                    $stmt = $conn->prepare("INSERT INTO pdf (data_pdf, arquivo_pdf) VALUES (?, ?)");
                    $stmt->bind_param("sb", $data_pdf, $null);
                    $stmt->send_long_data(1, $conteudo_pdf);

                    if ($stmt->execute()) {
                        echo "<script>alert('PDF enviado com sucesso'); window.location.href = window.location.href;</script>";
                        exit(); 
                    } else {
                        echo "<p class='error'>Erro ao enviar PDF: " . $stmt->error . "</p>";
                    }

                    $stmt->close();
                } else {
                    echo "<p class='error'>Erro no envio do arquivo PDF.</p>";
                }
            }

            $conn->close();
        }
    ?>

    <?php include_once 'footer.php' ?>
</body>

<script src="../js/nav-adm.js"></script>
<script>
    const modal = document.getElementById("pdfModal");
    const btn = document.getElementById("openModal");
    const span = document.getElementsByClassName("close")[0];
    const form = document.querySelector("form");
    const submitButton = form.querySelector('input[type="submit"]');

    btn.onclick = function(e) {
        e.preventDefault();
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    form.addEventListener('submit', function() {
        submitButton.disabled = true;
        submitButton.value = "Enviando...";
    });
</script>
</html>
