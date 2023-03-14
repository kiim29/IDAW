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