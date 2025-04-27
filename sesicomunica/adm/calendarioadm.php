<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Calendário de Atividades</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/cssadm/navadm.css">
    <link rel="stylesheet" href="../css/cssadm/calendarioadm.css">
    <link rel="stylesheet" href="../css/style.css">
    
</head>
<body>
<?php include ('nav.php'); ?>
<div class="container">
    <div class="calendar-container">
        <div id="calendar"></div>
    </div>
    
    <div class="activities-container">
        <div class="activity-box" style="border: 2px solid #2196f3;">
            <div class="label fundamental1">Ensino Fundamental I</div>
            <div class="activity-text">Não há nenhuma atividade para esse período</div>
        </div>

        <div class="activity-box">
            <div class="label fundamental2">Ensino Fundamental II</div>
            <div class="activity-text">Não há nenhuma atividade para esse período</div>
        </div>

        <div class="activity-box">
            <div class="label medio">Ensino Médio</div>
            <div class="activity-text">
                <span class="highlight">27 / 01 - Volta as aulas</span>
            </div>
        </div>
    </div>
</div>
<?php include ('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      initialDate: '2025-01-01',
      locale: 'pt-br',
      height: 'auto',
      headerToolbar: {
        left: 'prev,next',
        center: 'title',
        right: 'today'
      }
    });
    calendar.render();
  });
</script>

</body>
</html>
