<?php
include '../../conexao.php';

if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] == 0) {
    $arquivo = $_FILES['pdf']['tmp_name'];
    $conteudo = addslashes(file_get_contents($arquivo));

    $data = date('Y-m-d'); // 👈 PEGA A DATA ATUAL

    $sql = "INSERT INTO pdf (arquivo_pdf, data_pdf) VALUES ('$conteudo', '$data')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('PDF enviado com sucesso!'); window.location.href='pagina_de_upload.php';</script>";
    } else {
        echo "Erro ao enviar: " . mysqli_error($conn);
    }
} else {
    echo "Nenhum arquivo enviado ou erro no upload.";
}
?>
