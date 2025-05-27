<?php
$conn = mysqli_connect("localhost", "root", "", "sesicomunica_db");

if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT nome, arquivo_comunicado FROM comunicados WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $row['nome'] . '.pdf"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        echo $row['arquivo_comunicado'];
        exit;
    } else {
        echo "Arquivo não encontrado.";
    }
} else {
    echo "ID não fornecido.";
}
?>
