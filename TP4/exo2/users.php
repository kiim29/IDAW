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

$request = $pdo->prepare("select * from users");

$request -> execute();

echo "<!doctype html>
<html>
<head></head>
<body>
<h1>Liste des utilisateurs</h1>
<table>
";

function generateHTMLRow($id, $name, $email) {
    echo "<tr>";
    echo "<td>".$id."</td><td>".$name."</td><td>".$email."</td>";
    echo "</tr>";
}

generateHTMLRow('id','name','email');

$resultat = $request->fetchAll(PDO::FETCH_ASSOC);

foreach ($resultat as $row) {
    generateHTMLRow($row['id'],$row['name'],$row['email']);
}
echo "</table>";





// /*print_r permet un affichage lisible des résultats,
//  *<pre> rend le tout un peu plus lisible*/
// echo '<pre>';
// print_r($resultat);
// echo '</pre>';

/*** close the database connection ***/
$pdo = null;

?>
</table>
</body>
</html>