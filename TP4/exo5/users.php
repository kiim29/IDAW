<?php
require_once('config.php');
$connectionString = "mysql:host=". _MYSQL_HOST;
if(defined('_MYSQL_PORT')) {$connectionString .= ";port=". _MYSQL_PORT;}
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


if (isset($_SERVER['REQUEST_METHOD'])) {
    switch($_SERVER['REQUEST_METHOD']) {
        case 'GET' :
            if (isset($_GET['id'])) {
                //select * from users where id = id
                $request = $pdo->prepare("select * from `users` where id=".$_GET['id']);
                $request -> execute();
                $resultat = $request->fetch(PDO::FETCH_OBJ);
                $body = json_encode($resultat);
                http_response_code(200);
                header('content-type:application/json');
                echo $body;
                //réponse : OK, valeurs
            } else {
                //select * from users
                $request = $pdo->prepare("select * from users");
                $request -> execute();
                $resultat = $request->fetchAll(PDO::FETCH_ASSOC);
                $body = json_encode($resultat);
                http_response_code(200);
                header('content-type:application/json');
                echo $body;
                //réponse : OK, valeurs
            }
        break;
        
        case 'POST' :
            if (isset($_POST['name']) && isset($_POST['email'])) {
                //insert into users (name, email) values (name, email)
                $request = $pdo->prepare("INSERT INTO `users` (name,email) VALUES ('".$_POST['name']."','".$_POST['email']."')");
                $request -> execute();
                //select id from users where name=name and email=email --> Nouvelle location
                $request = $pdo->prepare("select * from `users` where name='".$_POST['name']."' and email='".$_POST['email']."'");
                $request -> execute();
                $resultat = $request->fetch(PDO::FETCH_ASSOC);
                $final_result = array('Location' => 'users.php?id='.$resultat['id']);
                $final_result['data'] = $resultat;
                $body = json_encode($final_result);
                http_response_code(201);
                header('content-type:application/json');
                echo $body;
                //réponse : Created, Location, valeurs
            } else {
                //$erreur ?
                $resultat = array('reponse' => "La création est impossible. Cause possible : il manque des champs (assurez-vous d'avoir fourni un name et un email.");
                $body = json_encode($resultat);
                http_response_code(400);
                header('content-type:application/json');
            }
        break;

        case 'PUT' :
            parse_str(file_get_contents("php://input"), $output);
            if (isset($output['id']) && isset($output['name']) && isset($output['email'])) {
                //select * from users where id = id --> Anciennes valeurs
                $request = $pdo->prepare("select * from `users` where id=".$output['id']);
                $request -> execute();
                $old_values = $request->fetch(PDO::FETCH_ASSOC);
                if (isset($old_values['id'])) { //si l'utilisateur d'id=id est bien présent dans la base
                    //update users set name = name, email = email where id = id --> Modif et Nouvelles valeurs
                    $request = $pdo->prepare("UPDATE `users` SET `name`='".$output['name']."', `email`='".$output['email']."' WHERE `id`=".$output['id']);
                    $request -> execute();
                    //réponse : OK, anciennes valeurs, nouvelles valeurs
                    $request = $pdo->prepare("select * from `users` where id=".$output['id']);
                    $request -> execute();
                    $resultat = $request->fetch(PDO::FETCH_ASSOC);
                    $final_result['old_data'] = $old_values;
                    $final_result['new_data'] = $resultat;
                    $body = json_encode($final_result);
                    http_response_code(200);
                    header('content-type:application/json');
                    echo $body;
                } else {
                    $resultat = array('reponse' => "La modification est impossible. Cause possible : l'identifiant donné n'est pas correct.");
                    $body = json_encode($resultat);
                    http_response_code(400);
                    header('content-type:application/json');
                    echo $body;
                }
            } else {
                //$erreur ?
                $resultat = array('reponse' => "La modification est impossible. Cause possible : il manque des champs (assurez-vous d'avoir fourni un id, un name et un email.");
                $body = json_encode($response);
                http_response_code(400);
                header('content-type:application/json');
            }
        break;

        case 'DELETE' :
            parse_str(file_get_contents("php://input"), $output);
            if (isset($output['id'])) {
                //select * from users where id = id --> Anciennes valeurs
                $request = $pdo->prepare("select * from `users` where id=".$output['id']);
                $request -> execute();
                $old_values = $request->fetch(PDO::FETCH_ASSOC);
                if (isset($old_values['id'])) {
                    //delete from users where id = id
                    $request = $pdo->prepare("DELETE FROM `users` WHERE id='".$old_values['id']."'");
                    $request -> execute();
                    //réponse : OK, suppression faite, valeurs
                    $final_result['reponse'] = "La suppression est effectuée";
                    $final_result['old_data'] = $old_values;
                    $body = json_encode($final_result);
                    http_response_code(200);
                    header('content-type:application/json');
                    echo $body;
                }
                else {
                    $resultat = array('reponse' => "La modification est impossible. Cause possible : l'identifiant donné n'est pas correct.");
                    $body = json_encode($response);
                    http_response_code(400);
                    header('content-type:application/json');
                    echo $body;
                }
            } else {
                $resultat = array('reponse' => "La modification est impossible. Cause possible : vous n'avez pas fourni d'identifiant.");
                $body = json_encode($response);
                http_response_code(400);
                header('content-type:application/json');
                echo $body;
            }
        break;

        default :
            http_response_code(400);
    }
} else {
    http_response_code(400);
}

/*** close the database connection ***/
$pdo = null;
