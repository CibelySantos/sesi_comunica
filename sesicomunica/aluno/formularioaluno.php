  <?php include 'navaluno.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulários - SESI Comunica</title>
  <link rel="stylesheet" href="../css/nav.css">
  <link rel="shortcut icon" href="../img/icon.png">
  <link rel="stylesheet" href="../css/formulario.css">
  
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
    
  <main class="container">
    <h1>Formulários</h1>

    <div class="pesquisa-container">
      <input type="text" id="barra-pesquisa" placeholder="Pesquisar comunicados...">
    </div>

    <div class="comunicados-container">
      <div class="comunicado">
        <p>Formulário de satisfação</p>
      </div>
      <div class="comunicado">
        <p>Autorização</p>
      </div>
      <div class="comunicado">
        <p>Súde e bem-estar</p>
      </div>
    </div>
  </main>
  <?php include 'footeraluno.php'; ?>
</body>
</html>
