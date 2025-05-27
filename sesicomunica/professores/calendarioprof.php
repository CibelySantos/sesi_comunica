<?php

session_start();

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <link rel="shortcut icon" href="../img/icon.png">
  <title>Calendário - SESI Comunica</title>
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/cssadm/navadm.css">
  <link rel="stylesheet" href="../css/calendario.css">
  <link rel="stylesheet" href="../css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
</head>

<body>
  <?php include('navprof.php'); ?>

  <div class="container">
    <div class="calendar-container">
      <div id="calendar"></div>
    </div>

    <div class="activities-container">
      <div class="activity-box" style="border: 2px solid #2196f3;">
        <div class="label fundamental1">Ensino Fundamental I</div>
        <div class="activity-text">
          
        </div>
      </div>

      <div class="activity-box">
        <div class="label fundamental2">Ensino Fundamental II</div>
        <div class="activity-text">
          
        </div>
      </div>

      <div class="activity-box">
        <div class="label medio">Ensino Médio</div>
        <div class="activity-text">
          
        </div>
      </div>
    </div>
  </div>

  <?php include('../adm/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
  <script src="../js/calendario-adm.js"></script>
</body>

</html>