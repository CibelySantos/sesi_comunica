<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cssprof/inicialprof.css">
    <link rel="stylesheet" href="../css/cssprof/navprof.css">
    <link rel="shortcut icon" href="../img/icon.png">
    <title>Página inicial</title>
</head>

<body>
    <!-- Navbar inclusa -->
    <?php include 'navprof.php'; ?>

    <div class="content">
        <section class="banner">
            <img src="../img/imgFundoSesi.png" alt="Imagem principal" class="main-image">
        </section>

        <section class="info">
            <h1>Bem-vindo Professor</h1>
            <p>Fique por dentro de todos os recados e cronogramas da nossa escola.</p>
        </section>

        <!-- Imagem extra ao descer a página -->
        <section class="imagem-extra" style="margin-top: 40px; text-align: center;">
            <img src="../img/bannerCarrossel.png" alt="Banner adicional" style="max-width: 100%; height: auto;">
        </section>

        <!-- Três cards fixos com imagens -->
        <section class="cards" style="display: flex; justify-content: space-around; margin: 40px 0;">
            <div class="card" style="width: 30%; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden;">
                <img src="../img/card1.jpg" alt="Card 1" style="width: 100%; height: auto;">
                <div style="padding: 15px; text-align: center;">
                    <h3>Card 1</h3>
                    <p>Descrição do card 1.</p>
                </div>
            </div>
            <div class="card" style="width: 30%; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden;">
                <img src="../img/card2.jpg" alt="Card 2" style="width: 100%; height: auto;">
                <div style="padding: 15px; text-align: center;">
                    <h3>Card 2</h3>
                    <p>Descrição do card 2.</p>
                </div>
            </div>
            <div class="card" style="width: 30%; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden;">
                <img src="../img/card3.jpg" alt="Card 3" style="width: 100%; height: auto;">
                <div style="padding: 15px; text-align: center;">
                    <h3>Card 3</h3>
                    <p>Descrição do card 3.</p>
                </div>
            </div>
        </section>


    </div>

    <!-- Rodapé -->
    <?php include 'footerprof.php'; ?>

    <script src="../js/nav-prof.js"></script>
</body>

</html>