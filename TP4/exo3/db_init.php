<?php
require_once('config.php');

$connectionString = "mysql:host=". _MYSQL_HOST;

if(defined('_MYSQL_PORT'))
    $connectionString .= ";port=". _MYSQL_PORT;

if(defined('_MYSQL_DBNAME'))
    $connectionString .= ";dbname=" . _MYSQL_DBNAME;

$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' );

$pdo = NULL;
try {
    $pdo = new PDO($connectionString,_MYSQL_USER,_MYSQL_PASSWORD,$options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch (PDOException $erreur) {
    echo ('Erreur : '.$erreur->getMessage());
}

$sql = file_get_contents("sql/dbtest.sql");

$pdo -> exec($sql);


/*** close the database connection ***/
$pdo = null;

?>
<html>
<h3> La base de données a été ré-initialisée </h3>
</html>