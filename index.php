<?php 
    include 'nav-index.php'; 
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="" href="sesicomunica/img/icon.png">
        <style>
            /* Estilos Globais */
            * {
                margin: 0;
                padding: 0;
            }

            body {
                margin: 0;
                padding: 0;
            }

            /* Estilos da Navbar */
            nav {
                height: 120px;
                width: 65%;
                display: flex;
                align-items: center;
            }

            .logo-comunica {
                height: 120px;
            }

            .icone-user {
                height: 74px;
            }

            .perfil-user {
                display: flex;
                align-items: center;
            }

            .alinhamento-nav {
                display: flex;
                justify-content: space-between;
                background-color: #d90c0c;
            }

            ul {
                list-style-type: none;
                display: flex;
                width: 100%;
                justify-content: space-between;
            }

            ul a {
                text-decoration: none;
                color: white;
                font-size: 24px;
                font-weight: bolder;
                font-family: "Gabarito";
            }

            /* Footer */
            footer {
                display: flex;
                justify-content: space-between;
                padding: 10px;
                margin-top: 70px;
                height: 130px !important;
                background-color: #d90c0c;
            }

            .localizacao h5 {
                font-family: "Gabarito";
                color: white;
                font-weight: 800;
            }

            .localizacao p {
                font-family: "Gabarito";
                color: white;
                margin-top: 15px;
                width: 290px;
                font-size: 16px;
                font-weight: lighter;
            }

            .direitos_reservados {
                font-family: "Gabarito";
                color: white;
                display: flex;
                align-items: end;
                font-size: 10px;
                font-weight: lighter;
            }

            .tamanho-icones {
                height: 20px;
                width: 20px;
            }

            .redes_sociais {
                display: flex;
                justify-content: space-between;
                align-items: end;
            }

            /* Menu Hamburguer */
            .menu-container {
                position: static !important;
                display: flex;
                transition: left 0.3s ease-in-out;
                margin-left: 0px !important;
            }

            .menu {
                position: absolute;
                width: 100%; 
                z-index: 10; 
                padding: 10px 20px;
                box-sizing: border-box;
                gap: 0px !important;
                margin-bottom: 100px;
                display: flex !important;
                border-bottom: none !important;
            }

            .menu-container a {
                display: flex;
                padding: 15px;
                font-size: 24px;
                justify-content: center;
                align-items: center;
                height: 20px;
                font-family: "Gabarito";
                color: red;
                text-decoration: none;
                transition: background 0.3s;
            }

            .close-btn {
                position: static !important;
                display: flex;
                align-items: center;
                top: 14px;
                cursor: pointer;
                right: -10;
                color: red;
            }

            .close-btn:hover {
                font-weight: bolder;
            }

            .hamburger {
                top: 15px;
                width: 10%;
                left: 15px;
                padding: 5px;
                font-size: 24px;
                font-family: "Gabarito";
                font-weight: bolder;
                cursor: pointer;
                color: red;
            }

            /* Configurar imagem de fundo com opacidade */
            .info {
                position: relative;
                background: url('./sesicomunica/img/imgFundoSesi.png') no-repeat center center;
                background-size: cover;
                padding: 50px 0;
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                margin-top: 70px; /* Espaçamento para criar a parte branca abaixo da navbar */
            }

            .info .overlay {
                position: relative;
                background: rgba(0, 0, 0, 0.5); /* Escurece o fundo */
                padding: 20px;
                text-align: center;
                border-radius: 8px;
            }

            .info h1 {
                font-size: 48px;
                font-family: 'Gabarito', sans-serif;
                text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.8); /* Efeito de sombra */
                margin-bottom: 20px;
            }

            .info p {
                font-size: 20px;
                font-family: 'Gabarito', sans-serif;
                text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8); /* Sombra no parágrafo */
            }
        </style>
        <title>Página inicial</title>
    </head>
    <body>
        <div class="content">

            <section class="info">
                <div class="overlay">
                    <h1>Bem-vindo Alunos</h1>
                    <p>Fiquem por dentro de todos os recados e cronogramas da nossa escola.</p>
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
