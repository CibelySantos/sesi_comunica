<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Gabarito:wght@400..900&display=swap" rel="stylesheet">

<div class="nav-wrapper">
    <div class="alinhamento-nav">
        <a href="inicialadm.php" class="logo-link">
            <img class="logo-comunica" src="../img/PROJETOGG.png" alt="Logo">
        </a>
        <div class="perfil-user">
            <a href="../../logout.php"><img class="icone-user" src="../img/sair.png" alt="Perfil"></a>
        </div>
    </div>

    <div class="menu">
        <div class="menu-container" id="menu">
            <a href="inicialprof.php">Página Inicial</a>
            <a href="agendamentoprof.php">Agendamentos</a>
            <a href="calendarioprof.php">Calendário</a>
            <a href="comunicadosprof.php">Comunicados</a>
            <a href="formularioprof.php">Formulário</a>
        </div>
    </div>
</div>
<script src="../js/nav-adm.js"></script>

  </div>
</nav>


<button class="hamburger" id="hamburger" aria-expanded="false" aria-controls="menu" aria-label="Abrir menu">☰</button>

<!-- O Menu/Modal -->
<ul class="menu-container" id="menu" role="menu" aria-labelledby="hamburger">
    <li role="none"><a role="menuitem" href="inicialprof.php">Página Inicial</a></li>
    <li role="none"><a role="menuitem" href="calendarioprof.php">Calendário</a></li>
    <li role="none"><a role="menuitem" href="formularioprof.php">Formulário</a></li>
    <li role="none"><a role="menuitem" href="agendamentoprof.php">Agendamentos</a></li>
    <li role="none"><a role="menuitem" href="./galeria/galeria.php">Galeria</a></li>
</ul>

<script src="../js/nav-prof.js"></script>

