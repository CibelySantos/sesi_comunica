<style>@import url('https://fonts.googleapis.com/css2?family=Gabarito:wght@400..900&display=swap');
        </style>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?              family=Gabarito:wght@400900display=swap" rel="stylesheet">

<div class="alinhamento-nav">
    <div>
        <img class="logo-comunica" src="../img/PROJETOGG.png" alt="">
    </div>

    <div class="perfil-user">
        <a href="../adm/inicialadm.php"><img class="icone-user" src="../img/sair.png" alt="" ></a>
    </div>

    
</div>

<div class="nav-wrapper">
    <div class="menu">
        <div class="hamburger" onclick="toggleMenu()">☰ Menu</div>
        <div class="overlay" id="overlay" onclick="closeMenu()"></div>
        <div class="menu-container" id="menu">
            <a href="inicialprof.php">Página Inicial</a>
            <a href="calendarioprof.php">Calendário</a>
            <a href="formularioprof.php">Formulários</a>
            <a href="agendamentoprof.php">Agendamentos</a>
            <a href="comunicadosprof.php">Comunicados</a>
            <span class="close-btn" onclick="closeMenu()">✖</span>
        </div>
    </div>
</div>