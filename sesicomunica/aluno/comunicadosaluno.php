
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/nav.css">
  <link rel="stylesheet" href="../css/comunicados.css">
  <link rel="shortcut icon" href="../img/icon.png">
  <link rel="stylesheet" href="../css/style.css">
  <title>Comunicados - SESI Comunica</title>
  <style>
    .pesquisa-container {
  margin-bottom: 30px;
  text-align: center;
 
}

#barra-pesquisa {
  width: 80%;
  max-width: 600px; /* barra maior */
  padding: 15px;
  font-size: 18px;
  border: 2px solid #d50000; /* borda vermelha */
  border-radius: 8px;
  outline: none;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  transition: border-color 0.3s, box-shadow 0.3s;
}

#barra-pesquisa:focus {
  border-color: #a00000;
  box-shadow: 0 0 8px rgba(213, 0, 0, 0.5);
}

</style>
</head>

<body>
  <?php include 'navaluno.php'; ?>
  <main class="container">
    <h1>Comunicados</h1>

    <!-- Barra de pesquisa -->
    <div class="pesquisa-container">
      <input type="text" id="barra-pesquisa" placeholder="Pesquisar comunicados...">
    </div>

    <div class="comunicados-container">
      <div class="comunicado">
        <p>Comunicado 029 - Conselho de classe</p>
      </div>
      <div class="comunicado">
        <p>Comunicado 030 - Formação acadêmica</p>
      </div>
      <div class="comunicado">
        <p>Comunicado 031 - Momento cívico</p>
      </div>
      <div class="comunicado">
        <p>Comunicado 032 - Festa de São João</p>
      </div>
      <div class="comunicado">
        <p>Comunicado 033 - Reunião de Pais</p>
      </div>
    </div>
  </main>

  <?php include 'footeraluno.php'; ?>

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
