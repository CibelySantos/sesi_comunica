<?php
include_once 'navaluno.php';
include('../../conexao.php');

// Buscar o PDF mais recente
$stmt = $conn->prepare("SELECT data_pdf, arquivo_pdf FROM pdf WHERE data_pdf = (SELECT MAX(data_pdf) FROM pdf)");
$stmt->execute();
$stmt->store_result();

$pdfBase64 = "";
$data_mais_recente = "Nenhuma data encontrada";

if ($stmt->num_rows > 0) {
    $stmt->bind_result($data_pdf, $arquivo_pdf);
    $stmt->fetch();

    $data_mais_recente = date("d/m/Y", strtotime($data_pdf));
    $pdfBase64 = base64_encode($arquivo_pdf);
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cssaluno/navaluno.css">
    <link rel="stylesheet" href="../css/cssadm/cardapioadm.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../img/icon.png">
    <title>Cardápio - SESI Comunica</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Gabarito:wght@400..900&display=swap" rel="stylesheet">
</head>

<body>
    <h1 id="text-princ-caradapio-adm">CARDÁPIO SEMANAL</h1>
    <p style="text-align: center; font-weight: bold; margin-bottom: 20px;">
        Última atualização: <?php echo $data_mais_recente; ?>
    </p>

    <div class="container-adm">
        <?php if (!empty($pdfBase64)): ?>
            <embed src="data:application/pdf;base64,<?php echo $pdfBase64; ?>" type="application/pdf" />
        <?php else: ?>
            <div style="text-align: center; color: red;">Nenhum PDF encontrado.</div>
        <?php endif; ?>

    </div>

    <?php include_once 'footeraluno.php' ?>
</body>

</html>