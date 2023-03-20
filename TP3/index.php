<?php
session_start();


echo "<html>";

function generateHTMLHeadWithCSS($styl) {
    echo ('<head>
            <link rel="stylesheet" href="css/'.$styl.'.css">
        </head>');
}

$currentStyle = "style1";

if (isset($_COOKIE['css'])) {
    if ($_COOKIE['css']=='style2') {
        $currentStyle = 'style2';
    }
    else {
        $currentStyle = 'style1';
    }
}

if (isset($_GET['css'])) {
    setcookie('css',$_GET['css']);
    $currentStyle = $_GET['css'];
} 

generateHTMLHeadWithCSS($currentStyle);

?>
<form id="style_form" action="index.php" method="GET">
    <select name="css">
        <option value="style1">style1</option>
        <option value="style2">style2</option>
    </select>
    <input type="submit" value="Appliquer" />
</form>
<p>Ceci est un paragraphe</p>
<div class="user-widget">
  <?php if( isset($_SESSION['user_id']) && $_SESSION['user_id'] !== null ) : ?>
    <a href="logout.php">Se déconnecter</a>
  <?php else : ?>
    <a href="login.php">Se connecter</a>
  <?php endif; ?>
</div>
</html>