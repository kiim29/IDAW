<!doctype html>
<html>
    <?php
        require_once('template_header.php');
    ?>
        <div class="bigcontent">
            <?php
                require_once('template_menu.php');
                renderMenuToHTML('cv');
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