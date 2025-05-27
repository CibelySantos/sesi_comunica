<?php
include '../../conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT arquivo_pdf, data_pdf FROM pdf WHERE id = $id";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);

        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment; filename=cardapio_" . date('d-m-Y', strtotime($row['data_pdf'])) . ".pdf");
        echo $row['arquivo_pdf'];
    } else {
        echo "Arquivo não encontrado.";
    }
} else {
    echo "ID não informado.";
}
?>
