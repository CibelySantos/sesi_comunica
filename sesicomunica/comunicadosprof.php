<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/nav.css">
  <link rel="stylesheet" href="../css/comunicados.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="shortcut icon" href="../img/icon.png">
  <title>Comunicados - SESI Comunica</title>
  <style>
    .pesquisa-container {
      margin-bottom: 30px;
      text-align: center;
    }

    #barra-pesquisa {
      width: 80%;
      max-width: 600px;
      padding: 15px;
      font-size: 18px;
      border: 2px solid #d50000;
      border-radius: 8px;
      outline: none;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      transition: border-color 0.3s, box-shadow 0.3s;
    }

    #barra-pesquisa:focus {
      border-color: #a00000;
      box-shadow: 0 0 8px rgba(213, 0, 0, 0.5);
    }

    .comunicado {
      background: #fff;
      border: 1px solid #ddd;
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 15px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .comunicado p {
      margin: 0;
      font-weight: bold;
      color: #333;
    }

    .comunicado a {
      display: inline-block;
      margin-top: 10px;
      background-color: #d50000;
      color: white;
      padding: 8px 16px;
      border-radius: 6px;
      text-decoration: none;
      transition: background-color 0.3s;
    }

    .comunicado a:hover {
      background-color: #a00000;
    }
  </style>
</head>

<body>

<?php include('navprof.php'); ?>

<main class="container">
  <h1>Comunicados</h1>

  <!-- Barra de pesquisa -->
  <div class="pesquisa-container">
    <input type="text" id="barra-pesquisa" placeholder="Pesquisar comunicados...">
  </div>

  <?php
  // Conexão com o banco
  $conn = mysqli_connect("localhost", "root", "", "sesicomunica_db");

  if (!$conn) {
      die("Conexão falhou: " . mysqli_connect_error());
  }

  $sql = "SELECT * FROM comunicados ORDER BY data_comunicado DESC";
  $result = mysqli_query($conn, $sql);
  ?>

  <div class="comunicados-container">
    <?php 
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo '<div class="comunicado">';
            echo '<p>' . htmlspecialchars($row['nome']) . ' - ' . date('d/m/Y', strtotime($row['data_comunicado'])) . '</p>';
            echo '<a href="baixar.php?id=' . $row['id'] . '" target="_blank">Abrir / Download</a>';
            echo '</div>';
        }
    } else {
        echo '<p>Não há comunicados cadastrados.</p>';
    }
    ?>
  </div>

</main>

<?php include('footerprof.php'); ?>

<script>
  function removerAcentos(texto) {
    return texto.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
  }

  document.getElementById('barra-pesquisa').addEventListener('input', function () {
    const filtro = removerAcentos(this.value);
    const comunicados = document.querySelectorAll('.comunicado');

    comunicados.forEach(function (comunicado) {
      const texto = removerAcentos(comunicado.textContent);
      comunicado.style.display = texto.includes(filtro) ? '' : 'none';
    });
  });
</script>

</body>
</html>
