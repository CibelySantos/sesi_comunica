<?php
include 'nav.php';
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

if (!isset($_SESSION['id_users'])) {
    header('Location: ../../index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cssadm/navadm.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/cssadm/enviocomunicadoadm.css">
    <link rel="shortcut icon" type="" href="../img/icon.png">
    <title>Página inicial</title>
</head>

<body>
    <?php include 'footer.php' ?>
</body>
<script src="../js/nav-adm.js"></script>

</html>