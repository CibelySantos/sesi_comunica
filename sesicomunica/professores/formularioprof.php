<?php
include '../../conexao.php';

// Verifica se recebeu um ID via GET (clique no card)
$formularioSelecionado = null;

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $sql = "SELECT * FROM formularios WHERE id = $id";
  $result = $conn->query($sql);

  if ($result && $result->num_rows > 0) {
    $formularioSelecionado = $result->fetch_assoc();
  } else {
    $formularioSelecionado = null;
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulários - SESI Comunica</title>
  <link rel="stylesheet" href="../css/formulario.css">
  <link rel="stylesheet" href="../css/nav.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="shortcut icon" href="../img/icon.png">
  <style>
    body {
      background: #f9f9f9;
      font-family: Arial, sans-serif;
    }

    .container {
      max-width: 1200px;
      margin: 30px auto;
      padding: 20px;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
      color: #d50000;
    }

    .comunicados-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }

    .comunicado {
      background: white;
      padding: 20px;
      border-radius: 10px;
      width: 250px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      cursor: pointer;
      transition: transform 0.2s, box-shadow 0.2s;
      text-align: center;
    }

    .comunicado:hover {
      transform: scale(1.05);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .formulario-container {
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      max-width: 800px;
      margin: 40px auto;
    }

    .formulario-container h2 {
      color: #d50000;
      margin-bottom: 20px;
    }

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

    .comunicado a {
      text-decoration: none;
      color: inherit;
      display: block;
      width: 100%;
      height: 100%;
    }
  </style>
</head>

<body>
  <?php include('navprof.php'); ?>

  <div class="container">
    <h1>Formulários</h1>

    <!-- Barra de pesquisa -->
    <div class="pesquisa-container">
      <input type="text" id="barra-pesquisa" placeholder="Pesquisar formulários...">
    </div>

    <!-- Lista de Formulários -->
    <div class="comunicados-container" id="lista-formularios">
      <?php
      $sql = "SELECT id, nome FROM formularios";
      $result = $conn->query($sql);

      if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '<div class="comunicado">';
          echo '<a href="?id=' . $row['id'] . '">';
          echo '<p>' . htmlspecialchars($row['nome']) . '</p>';
          echo '</a>';
          echo '</div>';
        }
      } else {
        echo '<p>Nenhum formulário encontrado.</p>';
      }
      ?>
    </div>

    <!-- Conteúdo do Formulário Selecionado -->
    <?php if ($formularioSelecionado): ?>
      <div class="formulario-container">
        <h2><?php echo htmlspecialchars($formularioSelecionado['nome']); ?></h2>
        <div class="conteudo">
          <?php
          $formularioSelecionado = "SELECT * FROM formularios";
          $resultado = $conn->query($formularioSelecionado);

          if ($resultado->num_rows > 0) {
            // Loop pra mostrar os dados
            while ($linha = $resultado->fetch_assoc()) {
              echo $linha["nome"] . "<br>";
            }
          } else {
            echo "Nenhum resultado encontrado.";
          } ?>
        </div>
      </div>
    <?php endif; ?>

  </div>

  <?php include('footerprof.php'); ?>

  <script>
    function removerAcentos(texto) {
      return texto.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
    }

    const barraPesquisa = document.getElementById('barra-pesquisa');
    const comunicados = document.querySelectorAll('.comunicado');

    barraPesquisa.addEventListener('input', function () {
      const filtro = removerAcentos(this.value);

      comunicados.forEach(function (comunicado) {
        const texto = removerAcentos(comunicado.textContent);
        comunicado.style.display = texto.includes(filtro) ? '' : 'none';
      });
    });
  </script>

</body>

</html>