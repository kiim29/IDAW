<?php

if (isset($_SERVER['REQUEST_METHOD'])) {
    switch($_SERVER['REQUEST_METHOD']) {
        case 'GET' :
            if (isset($_GET['id_aliment'])) {
                //select * from aliments where id_aliment = id
                $request = $pdo->prepare("select * from `aliments` where id_aliment=".$_GET['id_aliment']);
                $request -> execute();
                $resultat = $request->fetch(PDO::FETCH_OBJ);
                $body = json_encode($resultat);
                http_response_code(200);
                header('content-type:application/json');
                echo $body;
            } else {
                //select * from aliments
                $request = $pdo->prepare("select * from aliments");
                $request -> execute();
                $resultat = $request->fetchAll(PDO::FETCH_ASSOC);
                $body = json_encode($resultat);
                http_response_code(200);
                header('content-type:application/json');
                echo $body;
            }
        break;
        
        case 'POST' :
            if (isset($_POST['name']) && isset($_POST['email'])) {
                //insert into aliments (name, email) values (name, email)
                $request = $pdo->prepare("INSERT INTO `aliments` (name,email) VALUES ('".$_POST['name']."','".$_POST['email']."')");
                $request -> execute();
                //select id_aliment from aliments where name=name and email=email --> Nouvelle location
                $request = $pdo->prepare("select * from `aliments` where name='".$_POST['name']."' and email='".$_POST['email']."'");
                $request -> execute();
                $resultat = $request->fetch(PDO::FETCH_ASSOC);
                $final_result = array('Location' => 'aliments.php?id_aliment='.$resultat['id_aliment']);
                $final_result['data'] = $resultat;
                $body = json_encode($final_result);
                http_response_code(201);
                header('content-type:application/json');
                echo $body;
            } else {
                //$erreur
                $resultat = array('reponse' => "La création est impossible. Cause possible : il manque des champs (assurez-vous d'avoir fourni un name et un email.");
                $body = json_encode($resultat);
                http_response_code(400);
                header('content-type:application/json');
            }
        break;

        case 'PUT' :
            parse_str(file_get_contents("php://input"), $output);
            if (isset($output['id_aliment']) && isset($output['name']) && isset($output['email'])) {
                //select * from aliments where id_aliment = id --> Anciennes valeurs
                $request = $pdo->prepare("select * from `aliments` where id_aliment=".$output['id_aliment']);
                $request -> execute();
                $old_values = $request->fetch(PDO::FETCH_ASSOC);
                if (isset($old_values['id_aliment'])) { //si l'aliment d'id=id est bien présent dans la base
                    //update aliments set name = name, email = email where id = id --> Modif et Nouvelles valeurs
                    $request = $pdo->prepare("UPDATE `aliments` SET `name`='".$output['name']."', `email`='".$output['email']."' WHERE `id_aliment`=".$output['id_aliment']);
                    $request -> execute();
                    $request = $pdo->prepare("select * from `aliments` where id_aliment=".$output['id_aliment']);
                    $request -> execute();
                    $resultat = $request->fetch(PDO::FETCH_ASSOC);
                    $final_result['old_data'] = $old_values;
                    $final_result['new_data'] = $resultat;
                    $body = json_encode($final_result);
                    http_response_code(200);
                    header('content-type:application/json');
                    echo $body;
                } else {
                    //$erreur
                    $resultat = array('reponse' => "La modification est impossible. Cause possible : l'identifiant donné n'est pas correct.");
                    $body = json_encode($resultat);
                    http_response_code(400);
                    header('content-type:application/json');
                    echo $body;
                }
            } else {
                //$erreur
                $resultat = array('reponse' => "La modification est impossible. Cause possible : il manque des champs (assurez-vous d'avoir fourni un id, un name et un email.");
                $body = json_encode($response);
                http_response_code(400);
                header('content-type:application/json');
                echo $body;
            }
        break;

        case 'DELETE' :
            parse_str(file_get_contents("php://input"), $output);
            if (isset($output['id_aliment'])) {
                //select * from aliments where id_aliment = id_aliment --> Anciennes valeurs
                $request = $pdo->prepare("select * from `aliments` where id_aliment=".$output['id_aliment']);
                $request -> execute();
                $old_values = $request->fetch(PDO::FETCH_ASSOC);
                if (isset($old_values['id_aliment'])) {
                    //delete from aliments where id_aliment = id_aliment
                    $request = $pdo->prepare("DELETE FROM `aliments` WHERE id_aliment='".$old_values['id_aliment']."'");
                    $request -> execute();
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
