<!doctype html>
<html>
    <?php
        require_once('template_header.php');
    ?>
        <div class="bigcontent">
            <?php
                require_once('template_menu.php');
                renderMenuToHTML('dashboard');
            ?>
            <div class="content">
                <br>
                <script>
                    let PREFIX = "<?php
                        require_once('config.php');
                        echo API_URL_PREFIX; ?>";
                </script>
            </div>
        </div>
    </body>
