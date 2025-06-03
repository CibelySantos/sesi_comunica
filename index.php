<?php
    include 'nav-index.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="sesicomunica/css/style.css">
        <link rel="shortcut icon" type="" href="../sesicomunica/img/icon.png">
  <title>Página inicial - SESI Comunica</title>
  <style>
    .menu-container {
    display: flex;
    gap: 30px;
    list-style: none;
    margin: -50;
    padding: 0 20px;
    position: static !important;
    margin-top: 1px;
    transition: left 0.3s ease-in-out;
    margin-left: 0 !important;
    }
    .logo-comunica {
    max-height: 100px;
    } 
  </style>
</head>

<body>

  <div class="banner">
    <div class="banner-content">
      <div class="infor-banner">
        <h1>Bem-vindo</h1>
        <p>Fique por dentro de todos os recados e cronogramas da nossa escola!</p>
      </div>
    </div>
  </div>

  <?php include 'footer-index.php'; ?>



</body>
</html>