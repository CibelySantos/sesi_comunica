<?php
    include 'navaluno.php';
    include '../../conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="shortcut icon" href="../img/icon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio - SESI Comunica</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/cssaluno/cardapioaluno.css">
</head>
<body>

    <h1 style="display: flex; align-items: center; justify-content: center; margin-top: 80px; font-family: 'Gabarito';">
        Cardápio Semanal:
    </h1>

    <div style="display: flex; flex-direction: column; align-items: center; margin-top: 40px;">
        <?php
            $sql = "SELECT * FROM pdf ORDER BY data_pdf DESC LIMIT 1"; // pega o cardápio mais recente
            $res = mysqli_query($conn, $sql);

            if (mysqli_num_rows($res) > 0) {
                $row = mysqli_fetch_assoc($res);
                $id = $row['id'];
                $data = date('d/m/Y', strtotime($row['data_pdf']));

                echo "<p><strong>Data do Cardápio:</strong> $data</p>";

                // Exibir PDF embed na página (como visualização direta)
                echo "<iframe src='exibir_pdf.php?id=$id#toolbar=0' width='80%' height='600px' style='border: none;'></iframe>";

                // Botão para baixar o PDF
                echo "<br><a href='baixar_pdf.php?id=$id' download style='padding: 10px 20px; background-color:rgb(225, 0, 0); color: white; text-decoration: none; border-radius: 8px;'>
                        Baixar PDF
                      </a><br>" ;
            } else {
                echo "<p>⚠️ Nenhum cardápio encontrado.</p>";
            }
        ?>
    </div>

    <?php include 'footeraluno.php' ?>

</body>

</html>