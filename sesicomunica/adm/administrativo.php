<?php 
    include 'nav.php'; 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/cssadm/navadm.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/cssadm/administrativo.css">
        <link rel="shortcut icon" type="" href="../img/icon.png">
        <title>Página inicial</title>
    </head>
    <body>
        <main class="container">
            <h1>Comunicados enviados</h1>
            <div class="comunicados">
            <div class="comunicado">Comunicado 028 -<br>Imposto de renda</div>
            <div class="comunicado">Comunicado 027 -<br>Papo Supremo</div>
            <div class="comunicado">Comunicado 026 -<br>Compensação da<br>Quarta-feira de Cinzas</div>
            <div class="comunicado">Comunicado 025 -<br>Orientações sobre o<br>Uso de Bicicletas</div>
            <div class="comunicado">Comunicado 023 -<br>Papo SUPREMO FIESP</div>
            <div class="comunicado">Comunicado 018 -<br>Código de Conduta</div>
            </div>

            <h2>Enviar comunicado</h2>
            <div class="enviar-box">
            <span>+</span>
            </div>

            <div class="modal-overlay" id="modal">
                <div class="modal-content">
                    <button class="close-btn" onclick="fecharModal()">x</button>

                    <form>
                    <label for="nome">Nome do comunicado :</label>
                    <input type="text" id="nome" name="nome" required>

                    <label>Upload comunicados:</label>
                    <div class="upload-box">
                        <span>⬆️</span>
                    </div>

                    <label for="destinatario">Destinatário:</label>
                    <select id="destinatario" name="destinatario">
                        <option value="aluno">aluno</option>
                        <option value="professor">professor</option>
                    </select>

                    <button type="submit" class="publicar-btn">Publicar comunicado</button>
                    </form>
                </div>
            </div>
        </main>
        <?php include 'footer.php'?>
    </body>
    <script src="../js/nav-adm.js"></script>
    <script>
        const modal = document.getElementById("modal");

        document.querySelector(".enviar-box").addEventListener("click", () => {
            modal.style.display = "flex";
        });

        function fecharModal() {
            modal.style.display = "none";
        }

        // Fecha o modal ao clicar fora dele
        window.addEventListener("click", function (e) {
            if (e.target === modal) {
            fecharModal();
            }
        });
    </script>

</html>