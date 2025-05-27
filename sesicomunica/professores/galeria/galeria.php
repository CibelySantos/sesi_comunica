<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Galeria de Projetos</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="./css/galeria.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

  <h1>Galeria de Projetos</h1>

  <div class="galeria">
<?php
$result = $conn->query("SELECT * FROM projetos ORDER BY criado_em DESC");
while ($row = $result->fetch_assoc()) {
    echo "<div class='card'>";

    // Início do cabeçalho do card
    echo "<div class='conteudo'>";
    echo "<div class='topo-card'>";

    echo "<div class='autor'>";
    echo "<span class='nome'><strong style='color: red;'>Feito por:</strong> <strong style='color: black;'>" . htmlspecialchars($row['nome']) . "</strong></span>";
    echo "</div>";

    echo "<div class='icones'>";
   echo "<a href='#' class='btn-excluir' data-id='" . $row['id'] . "' title='Excluir'><i class='fas fa-trash'></i></a>";
    echo "<a href='editar.php?id=" . $row['id'] . "' title='Editar'><i class='fas fa-edit'></i></a>";
    echo "</div>";

    echo "</div>"; // fecha topo-card

    echo "<p>Descrição: " . nl2br(htmlspecialchars($row['descricao'])) . "</p>";
    echo "</div>"; // fecha conteudo

    // Imagens (corrige se nome tem ou não 'imagens/')
    echo "<div class='imagens'>";
    $imagens = [$row['imagem1'], $row['imagem2'], $row['imagem3']];
    foreach ($imagens as $img) {
        if (!empty($img)) {
            $src = (strpos($img, 'imagens/') === 0) ? $img : 'imagens/' . $img;
            echo "<img class='imagem' src='" . htmlspecialchars($src) . "'>";
        }
    }
    echo "</div>";

    echo "</div>"; // fecha card
}
?>
  </div>

  <a href="criargaleria.php" class="botao-criar"> + Criar Postagem</a>

  <!-- Modal para exibição da imagem ampliada -->
  <div id="modal" class="modal">
    <span class="fechar" onclick="fecharModal()">&times;</span>
    <img class="modal-conteudo" id="imagemModal">
  </div>

  <script>
    document.querySelectorAll('.imagem').forEach(img => {
      img.addEventListener('click', function () {
        const modal = document.getElementById("modal");
        const modalImg = document.getElementById("imagemModal");
        modal.style.display = "block";
        modalImg.src = this.src;
      });
    });

    function fecharModal() {
      document.getElementById("modal").style.display = "none";
    }

    window.onclick = function(event) {
      const modal = document.getElementById("modal");
      if (event.target === modal) {
        modal.style.display = "none";
      }
    }
  </script>

  <script>
  document.querySelectorAll('.btn-excluir').forEach(botao => {
    botao.addEventListener('click', function (e) {
      e.preventDefault();
      const id = this.getAttribute('data-id');

      Swal.fire({
        title: 'Tem certeza que deseja excluir?',
        text: "Você não poderá reverter isso!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#aaa',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = `excluir.php?id=${id}`;
        }
      });
    });
  });
</script>


</body>
</html>
