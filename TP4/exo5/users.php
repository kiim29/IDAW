<?php
require_once('config.php');

$connectionString = "mysql:host=". _MYSQL_HOST;

if(defined('_MYSQL_PORT'))
    $connectionString .= ";port=". _MYSQL_PORT;

$connectionString .= ";dbname=" . _MYSQL_DBNAME;
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' );

$pdo = NULL;
try {
    $pdo = new PDO($connectionString,_MYSQL_USER,_MYSQL_PASSWORD,$options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $erreur) {
    echo('Erreur : '.$erreur->getMessage());
}

if (! isset($_GET['action'])) {
    $_GET['action']='init';
}

switch ($_GET['action']) {
    case 'modifier' :
        if (isset($_GET['id']) && isset($_GET['name']) && isset($_GET['email']) && isset($_GET['okPourModif'])) {
            if ($_GET['okPourModif']==true) {
                // echo "UPDATE `users` SET `name`='".$_GET['name']."', `email`='".$_GET['email']."' WHERE `id`=".$_GET['id'];
                $request = $pdo->prepare("UPDATE `users` SET `name`='".$_GET['name']."', `email`='".$_GET['email']."' WHERE `id`=".$_GET['id']);
                $request -> execute();
            }
        } elseif (isset($_GET['id'])) {
        } else {
            $erreur = 'modifier sans information ?';
        }
        break;
    case 'ajouter' :
        if (isset($_GET['id']) && isset($_GET['name']) && isset($_GET['email'])) {
            // echo "INSERT INTO `users` (name,email) VALUES ('".$_GET['name']."','".$_GET['email']."')";
            $request = $pdo->prepare("INSERT INTO `users` (name,email) VALUES ('".$_GET['name']."','".$_GET['email']."')");
            $request -> execute();
        } else {
            $erreur = 'ajouter sans information ?';
        }
        break;

    case 'supprimer' :
        if (isset($_GET['id'])) {
            $request = $pdo->prepare("DELETE FROM `users` WHERE id='".$_GET['id']."'");
            $request -> execute();
        } else {
            $erreur = 'supprimer sans information ?';
        }
        break;

    default :
        $request = $pdo->prepare("select * from users");
        $request -> execute();
        $resultat = $request->fetchAll(PDO::FETCH_ASSOC);
}


$request = $pdo->prepare("select * from users");
$request -> execute();
$resultat = $request->fetchAll(PDO::FETCH_ASSOC);


echo "<!doctype html>
<html>
<head>
</head>
<body>
<h1>Liste des utilisateurs</h1>
<table>
";
function generateHTMLRow($id, $name, $email, $actionButtons=true) {
    echo "<tr>";
    echo "
        <td>".$id."</td>
        <td>".$name."</td>
        <td>".$email."</td>
    ";
    if ($actionButtons) {
        echo"<td><a href=users.php?action=supprimer&id=".$id.">Supprimer</a></td>
            <td><a href=users.php?action=modifier&id=".$id."&name=".$name."&email=".$email.">Modifier</a></td>
        ";
    }
    echo "</tr>";
}
generateHTMLRow('id','name','email',false);
foreach ($resultat as $row) {
    generateHTMLRow($row['id'],$row['name'],$row['email']);
}
echo "</table></br>";

echo '<form id="user_add_form" action="users.php" method="GET">';
echo '
    <div class="form-example">
        <input type="hidden" name="id" id="id">
    </div>
    <div class="form-example">
        <input type="hidden" name="action" id="action" value="ajouter" required>
    </div>
    <div class="form-example">
        <label for="name">Nom :</label>
        <input type="text" name="name" id="name" required>
    </div>
    <div class="form-example">
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required>
    </div>
        <div class="form-example">
        <input type="submit" value="Ajouter!">
    </div>
';
echo "</form></br>";

if (isset($_GET['action']) && $_GET['action']=='modifier') {
    echo '<form id="user_modify_form" action="users.php" method="GET">';
    echo '
        <div class="form-example">
            <input type="hidden" name="id" id="id" value="'.$_GET['id'].'" required>
        </div>
        <div class="form-example">
            <input type="hidden" name="action" id="action" value="modifier" required>
        </div>
        <div class="form-example">
            <input type="hidden" name="okPourModif" id="okPourModif" value=true required>
        </div>
        <div class="form-example">
            <label for="name">Name :</label>
            <input type="text" name="name" id="name" value="'.$_GET['name'].'" required>
        </div>
        <div class="form-example">
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" value="'.$_GET['email'].'" required>
        </div>
            <div class="form-example">
            <input type="submit" value="Modifier!">
        </div>
    ';
    echo "</form>";
}

/*** close the database connection ***/
$pdo = null;

?>
</body>
</html>