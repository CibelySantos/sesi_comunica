<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- Estilos -->
  <link rel="stylesheet" href="../css/cssprof/navprof.css">
  <link rel="stylesheet" href="../css/cssprof/calendarioprof.css">
  <link rel="shortcut icon" href="../img/icon.png">
  
  <!-- FullCalendar CSS -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

  <title>Calendário</title>
</head>

<body>
  <!-- Navbar -->
  <?php include 'navprof.php'; ?>

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
          <span class="highlight">27 / 01 - Volta às aulas</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include 'footerprof.php'; ?>

  <!-- Scripts -->
  <script src="../js/nav-prof.js"></script>

  <!-- FullCalendar JS -->
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

  <!-- Inicializar o calendário -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');

      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth', // Visualização em grade mensal
        locale: 'pt-br', // Deixar em português
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: [
          {
            title: 'Volta às Aulas',
            start: '2025-01-27', // exemplo de evento
            color: '#2196f3'
          }
        ]
      });

      calendar.render();
    });
  </script>

</body>

</html>