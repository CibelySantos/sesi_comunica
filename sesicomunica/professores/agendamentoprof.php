<?php 
    include 'navprof.php'; 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>SESI Comunica - Agendamento</title>
    <link rel="stylesheet" href="../css/cssprof/agendamentoprof.css">
    <link rel="stylesheet" href="../css/cssprof/navprof.css">
    <link rel="shortcut icon" href="../img/icon.png" type="image/png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        .main {
            text-align: center;
            margin-top: 7%;
        }

        h1 {
            margin-bottom: 2rem;
            font-size: 2rem;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            padding: 0 2rem;
            max-width: 1000px;
            margin: auto;
        }

        @media (max-width: 768px) {
            .cards {
                grid-template-columns: repeat(2, 1fr); /* 2 cards por linha em tablet */
            }
        }

        @media (max-width: 480px) {
            .cards {
                grid-template-columns: 1fr; /* 1 por linha no celular */
            }
        }

        .card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: transform 0.2s;
            background-color: #d90000;
        }

        .card:hover {
            transform: scale(1.02);
        }

        .card img {
            width: 100%;
            height: 140px;
            object-fit: cover;
        }

        .card .label {
            background-color: #d90000;
            color: white;
            padding: 1rem;
            font-weight: bold;
        }

        .agendar-btn {
            margin-top: 2rem;
            padding: 1rem 5rem;
            background-color: #d90000;
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
        }

        .social {
            display: flex;
            gap: 1rem;
        }
    </style>
</head>
<body>
    <section class="main">
        <h1>Faça um agendamento</h1>
        <div class="cards">
            <div class="card">
                <img src="../img/maker.jpg" alt="MAKER">
                <div class="label">MAKER</div>
            </div>
            <div class="card">
                <img src="../img/lct.jpg" alt="LCT">
                <div class="label">LCT - Laboratório de Ciências e Tecnologia</div>
            </div>
            <div class="card">
                <img src="../img/lmt.jpg" alt="LMT">
                <div class="label">LMT - Laboratório de Mídias e Tecnologia</div>
            </div>
            <div class="card">
                <img src="../img/biblioteca.png" alt="Biblioteca">
                <div class="label">Biblioteca</div>
            </div>
            <div class="card">
                <img src="../img/laboratorio.jpg" alt="Laboratório">
                <div class="label">Laboratório</div>
            </div>
            <div class="card">
                <img src="../img/computadores.jpg" alt="Computadores">
                <div class="label">Computadores</div>
            </div>
        </div>
        <button class="agendar-btn">Agendar</button>
    </section>

    <?php include 'footerprof.php'; ?>
    <script src="../js/nav-prof.js"></script>
</body>
</html>
