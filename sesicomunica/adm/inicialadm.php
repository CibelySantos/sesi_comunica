<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

if (!isset($_SESSION['id_users'])) {
    header('Location: ../../index.php');
    exit();
}

include 'nav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/cssadm/navadm.css">

  <link rel="stylesheet" href="../css/cssadm/inicialadm.css">
  <link rel="shortcut icon" href="../img/icon.png">
  <link href="https://fonts.googleapis.com/css2?family=Gabarito:wght@400;900&display=swap" rel="stylesheet">
  <title>Página inicial - SESI Comunica</title>
</head>

<body>

  <div class="banner">
    <div class="banner-content">
      <div class="infor-banner">
        <h1>Bem-vindo administrador!</h1>
        <p>Fique por dentro de todos os recados e cronogramas da nossa escola!</p>
      </div>
    </div>
  </div>

  <?php include 'footer.php'; ?>



</body>
</html>
