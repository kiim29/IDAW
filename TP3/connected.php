<?php
$servername = 'localhost';
$username = 'root';
$password = '';

//On essaie de se connecter
try{
    $conn = new PDO("mysql:host=$servername;dbname=base_tp3", $username, $password);
    //On définit le mode d'erreur de PDO sur Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo 'Connexion réussie';

    /*Sélectionne les valeurs dans les colonnes prenom et mail de la table
        *users pour chaque entrée de la table*/
    $sth = $conn->prepare("SELECT * FROM users");
    $sth->execute();
    
    /*Retourne un tableau associatif pour chaque entrée de notre table
        *avec le nom des colonnes sélectionnées en clefs*/
    $resultat = $sth->fetchAll(PDO::FETCH_ASSOC);
}

/*On capture les exceptions si une exception est lancée et on affiche
    *les informations relatives à celle-ci*/
catch(PDOException $e){
    echo "Erreur : " . $e->getMessage();
}
// on simule une base de données
$users = array(
    // login => password
);
foreach ($resultat as $row) {
    $users[$row['login']] = $row['password'];
}

$login = "anonymous";
$errorText = "";
$successfullyLogged = false;
if(isset($_POST['login']) && isset($_POST['password'])) {
    $tryLogin=$_POST['login'];
    $tryPwd=$_POST['password'];
    // si login existe et password correspond
    if( array_key_exists($tryLogin,$users) && $users[$tryLogin]==$tryPwd ) {
        $successfullyLogged = true;
        $login = $tryLogin;
        session_start();
        $_SESSION['login'] = $tryLogin;
        echo "<a href='nouvelle_page.php'>Aller à la nouvelle page</a>";
    } else {
        $errorText = "Erreur de login/password";
    }
} else {
    $errorText = "Merci d'utiliser le formulaire de login";
}
if(!$successfullyLogged) {
    echo $errorText;
} else {
    echo "<h1>Bienvenue ".$login."</h1>";
}
?>