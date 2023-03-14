<!doctype html>
<html>
    <?php
        require_once('template_header.php');
    ?>
    <body>
        <header>
            <h1 id="titleheader">Kim Luxembourger</h1>
            <div class="imgbox" id="imgboxheader">
                <img src="images\kim.jpg" alt="Kim" />
            </div>
        </header>
        <div class="bigcontent">
            <?php
                require_once('template_menu.php');
            ?>
            <div class="content">
                <h2>Mes hobbies</h2>
                <h3>Associatif</h3>
                <p>
                    Présidente du comité Egal'IMT
                    <div class="imgbox">
                        <img src="images\egalimt.png" alt="Logo du comité Egal'IMT" />
                    </div>
                    <br>
                    Membre du Caméléon Déchaîné - Journal de l'école (rédactrice, correctirce, maquettiste)
                    <div class="imgbox">
                        <img src="images\cameleon.jpg" alt="Logo du Caméleon Déchaîné" />
                    </div>
                    <br>
                    Chorale
                    <br>
                    Théatre...
                </p>
                <br>
                <h3>Sport</h3>
                <p>
                    Surf
                    <div class="imgbox">
                        <img src="images\surf.jpeg" alt="Kim qui surfe en Bretagne" />
                    </div>
                    <br>
                    Escrime
                </p>
                <br>
                <h3>Intérêts</h3>
                <p>
                    Voyage
                    <br>
                    Littérature
                    <br>
                    Cinéma...
                </p>
                <br>
            </div>
        </div>
    </body>
    <?php
        require_once('template_footer.php');
    ?>
</html>