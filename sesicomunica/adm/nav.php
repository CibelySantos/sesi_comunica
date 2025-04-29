<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Gabarito:wght@400..900&display=swap" rel="stylesheet">

<div class="nav-wrapper">
    <div class="alinhamento-nav">
        <a href="inicialadm.php" class="logo-link">
            <img class="logo-comunica" src="../img/PROJETOGG.png" alt="Logo">
        </a>
        <div class="perfil-user">
            <img class="icone-user" src="../img/icone-usuario.png" alt="Perfil">
        </div>
    </div>

    <div class="menu">
        <button class="hamburger" onclick="toggleMenu()">☰ Menu</button>
        <div class="menu-container" id="menu">
            <a href="inicialadm.php">Página Inicial</a>
            <a href="administrativo.php">Administrativo</a>
            <a href="calendarioadm.php">Calendário</a>
            <a href="cardapioadm.php">Cardápio</a>
            <a href="criar_formulario.php">Formulário</a>
            <button class="close-btn" onclick="toggleMenu()">✖</button>
        </div>
    </div>
</div>
<script src="../js/nav-adm.js"></script>