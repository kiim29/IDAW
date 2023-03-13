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
            <div id="menu_dynamique">
                <nav>
                    <ul>
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="projets.php">Projets et expériences</a></li>
                        <li><a id="currentpage" href="cv.php">CV</a></li>
                        <li><a href="hobbies.php">Hobbies</a></li>
                    </ul>
                </nav>
            </div>
            <div class="content">
                <h2>Mon Curriculum Vitae</h2>
                <p>
                    Vous pouvez le visualiser <a href="https://drive.google.com/file/d/1RTlNESrHEk3TpjsmJLlfse_jWtJX_fp0/view?usp=share_link">ici</a> !
                </p>
            </div>
        </div>
    </body>
    <?php
        require_once('template_footer.php');
    ?>
</html>