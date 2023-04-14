<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <meta charset="utf-8">
    <title>Suivi de vos repas</title>
    <script>
    </script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
</head>
    <body>
        <header style="display:flex;">
            <div style="display:flex; width:80%;">
                <h2 id="secondtitle"> Bonjour <?php session_start(); //echo $_SESSION['nom'] ?> ! </h2>
                <h1 id="titleheader">Suivi de vos repas</h1>
            </div>
            <div class="imgbox" id="imgboxheader">
                <img style="" src="imgs/repas.jpeg" alt="repas" />
            </div>
        </header>