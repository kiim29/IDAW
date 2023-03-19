<html>
<?php
session_start();
if(isset($_SESSION['login'])) {
    echo "<h1>Bienvenue ".$_SESSION['login']."</h1>";
    echo '<div class="user-widget">
            <a href="logout.php">Se déconnecter</a>';
}else{
    echo "<p>bah oui il faut se connecter</p>";
}
?>
</html>
