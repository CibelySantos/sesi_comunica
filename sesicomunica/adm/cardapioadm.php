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
    <?php include_once 'nav.php' ?>
    <h1 id="text-princ-caradapio-adm">CARDÁPIO SEMANAL</h1>
    <p style="text-align: center; font-weight: bold; margin-bottom: 20px;">
        Última atualização: [Data da última atualização]
    </p>

    <div class="container-adm">
        <div style="text-align: center; color: red;">Nenhum PDF encontrado.</div>

        <div class="alinha-button-pdf">
            <a class="sublinhado" href="#" id="openModal">
                <!-- <img id="icone-pdf-adm" src="../img/icone-pdf.png" alt="PDF"> -->
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