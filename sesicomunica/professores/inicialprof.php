<?php
session_start();
include 'navprof.php';
include '../../conexao.php';

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['id_users'])) {
    header('Location: ../../index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/cssprof/inicialprof.css">
  <link rel="stylesheet" href="../css/nav.css">
  <link rel="stylesheet" href="../css/cssadm/administrativo.css"> <!-- Importa estilos da seção de comunicados -->
  <link rel="shortcut icon" href="../img/icon.png">
  <title>Página Inicial - SESI Comunica</title>
</head>

<body>

  <div class="content">
    <section class="banner">
      <img src="../img/fundo-tela-inicial.jpg" alt="Imagem principal" class="main-image">

      <div class="overlay"></div>

      <div class="info">
        <h1>Bem-vindo Professor</h1>
        <p>Fique por dentro de todos os recados e cronogramas da nossa escola.</p>
      </div>
    </section>

    <section class="imagem-extra">
      <img src="../img/bannerCarrossel.png" alt="Banner adicional">
    </section>

    <section class="cards">
      <div class="card" onclick="window.location.href='./agendamentoprof.php';">
        <img src="../img/agendamento.png" alt="Card 1">
        <div class="card-content">
          <h3>Agendamentos</h3>
        </div>
      </div>
      <div class="card" onclick="window.location.href='./formularioprof.php';">
        <img src="../img/formulario.png" alt="Card 2">
        <div class="card-content">
          <h3>Formulários</h3>
        </div>
      </div>
      <div class="card" onclick="window.location.href='./calendarioprof.php';">
        <img src="../img/calendario.png" alt="Card 3">
        <div class="card-content">
          <h3>Calendário</h3>
        </div>
      </div>
    </section>


    </main>
    <!-- Fim da seção de comunicados -->
  </div>

  <!-- Footer -->
  <?php include 'footerprof.php'; ?>
  <script src="../js/comunicados.js"></script>
</body>
</html>