<?php 
    include 'nav-index.php'; 
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="sesicomunica/css/style.css">
        <link rel="shortcut icon" type="" href="sesicomunica/img/icon.png">
<<<<<<< HEAD
        <style>

            @media screen and (max-width: 768px) {
                nav {
                    flex-direction: column;
                    height: auto;
                    text-align: center;
                }

                .logo-comunica {
                    height: 60px;
                }

                .icone-user {
                    height: 40px;
                }

                ul {
                    flex-direction: column;
                }

                ul a {
                    font-size: 16px;
                    padding: 10px;
                }

                footer {
                    flex-direction: column;
                }

                .info h1 {
                    font-size: 28px;
                }

                .info p {
                    font-size: 16px;
                }
            }

            @media screen and (max-width: 480px) {
                .info h1 {
                    font-size: 24px;
                }

                .info p {
                    font-size: 14px;
                }

                .imagem-extra img {
                    border-radius: 10px;
                }
            }

            /* Estilos Globais */
            * {
                margin: 0;
                padding: 0;
            }
=======
>>>>>>> 3fbb9cf20897f6e59120a02701f460869b506710

        <title>Página inicial</title>
    </head>
    <body>
        <div class="content">

            <section class="info">
                <div class="overlay">
                    <h1>Bem-vindo(a)!</h1>
                    <p>Fique por dentro de todos os recados e cronogramas da nossa escola.</p>
                </div>
            </section>

            <section class="imagem-extra" style="margin-top: 40px; text-align: center;">
                <img src="./sesicomunica/img/bannerCarrossel.png" alt="Banner adicional" style="max-width: 100%; height: auto; border-radius: 20px;">
            </section>
        </div>
        <?php include 'footer-index.php'?>
    </body>
    <script src="sesicomunica/js/nav-aluno.js"></script>
</html>
