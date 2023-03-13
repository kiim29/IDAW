<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="css/style.css">
        <meta charset="utf-8">
            <title>Kim Luxembourger</title>
    </head>
    <body>
        <header>
            <h1 id="titleheader">Kim Luxembourger</h1>
            <div class="imgbox" id="imgboxheader">
                <img src="images\kim.jpg" alt="Kim" />
            </div>
        </header>
        <div class="bigcontent">
            <div id="menu_dynamique">
                <nav>
                    <ul>
                        <li><a id="currentpage" href="index.php">Accueil</a></li>
                        <li><a href="projets.php">Projets et expériences</a></li>
                        <li><a href="cv.php">CV</a></li>
                        <li><a href="hobbies.php">Hobbies</a></li>
                    </ul>
                </nav>
            </div>
            <div class="content">
                <p>Voici un petit site pour me présenter !</p>
            </div>
        </div>
    </body>
    <?php
        require_once('template_footer.php');
    ?>
</html>