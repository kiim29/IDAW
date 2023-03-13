<!DOCTYPE html>
<html>
    <head>
        <title>Essai PHP</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="cours.css">
    </head>
    
    <body>
        <h1>PHP</h1>
        <p>L'heure courante est : </p>

        <?php
            $d = date( "d/m/Y H:i:s");
            echo $d;
            function bonjour(){
                echo '<br>Bonjour à tous <br>';
            }
            for($i=0;$i<5;$i++) {
                bonjour();
            }
        ?>

    </body>
</html>