<!doctype html>
<html>
    <?php
        require_once('template_header.php');
    ?>
        <div class="bigcontent">
            <?php
                require_once('template_menu.php');
                renderMenuToHTML('index');
            ?>
            <div class="content">
                <p>Voici un petit site pour me présenter !</p>
            </div>
        </div>
    </body>
    <?php
        require_once('template_footer.php');
    ?>
</html>