<?php

require_once('init_pdo.php');

if (isset($_SERVER['REQUEST_METHOD'])) {
    switch($_SERVER['REQUEST_METHOD']) {

        /*********************************SELECTION*****************************************/
        case 'GET' :
            if (isset($_GET['id_aliment'])) {
                //select * from aliments where id_aliment = id_aliment
                $request = $pdo->prepare("select * from aliments 
                join types_aliments on id_type_aliment=id_type 
                where id_aliment=".$_GET['id_aliment']);
                $request -> execute();
                $resultat = $request->fetch(PDO::FETCH_OBJ);
                $body = json_encode($resultat);
                http_response_code(200);
                header('content-type:application/json');
                echo $body;
            } else if (isset($_GET['id_type_aliment'])) {
                //select * from aliments where id_type_aliment = id_type_aliment
                $request = $pdo->prepare("select * from aliments 
                join types_aliments on id_type_aliment=id_type 
                where id_type_aliment=".$_GET['id_type_aliment']);
                $request -> execute();
                $resultat = $request->fetch(PDO::FETCH_OBJ);
                $body = json_encode($resultat);
                http_response_code(200);
                header('content-type:application/json');
                echo $body;
            } else {
                //select * from aliments
                $request = $pdo->prepare("select * from aliments
                join types_aliments on id_type_aliment=id_type");
                $request -> execute();
                $resultat = $request->fetchAll(PDO::FETCH_ASSOC);
                $body = json_encode($resultat);
                http_response_code(200);
                header('content-type:application/json');
                echo $body;
            }
        break;
        
        /*********************************AJOUT*****************************************/
        case 'POST' :
            if (isset($_POST['nom']) && isset($_POST['id_type_aliment'])) {
                //insert into aliments (nom, id_type_aliment,...) values (nom, id_type_aliment,...)
                $request = $pdo->prepare("INSERT INTO `aliments` (nom,id_type_aliment,calories,glucides,sucres,lipides,acides_gras,proteines,sel) 
                VALUES ('".$_POST['nom']."','".$_POST['id_type_aliment']."','".$_POST['calories']."','".$_POST['glucides']."','".$_POST['sucres']."','".$_POST['lipides']."','".$_POST['acides_gras']."','".$_POST['proteines']."','".$_POST['sel']."')");
                $request -> execute();
                //select id_aliment from aliments where nom=nom and id_type_aliment=id_type_aliment --> Nouvelle location
                $request = $pdo->prepare("select * from `aliments` where nom='".$_POST['nom']."' and id_type_aliment='".$_POST['id_type_aliment']."'");
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
                $resultat = array('reponse' => "La création est impossible. Cause possible : il manque des champs (assurez-vous d'avoir fourni un nom et un type.");
                $body = json_encode($resultat);
                http_response_code(400);
                header('content-type:application/json');
            }
        break;

        /*********************************MODIFICATION*****************************************/
        case 'PUT' :
            parse_str(file_get_contents("php://input"), $output);
            if (isset($output['id_aliment']) && isset($output['nom']) && isset($output['id_type_aliment'])) {
                //select * from aliments where id_aliment = id_aliment --> Anciennes valeurs
                $request = $pdo->prepare("select * from `aliments` where id_aliment=".$output['id_aliment']);
                $request -> execute();
                $old_values = $request->fetch(PDO::FETCH_ASSOC);
                if (isset($old_values['id_aliment'])) { //si l'aliment d'id_aliment=id_aliment est bien présent dans la base
                    //update aliments set nom = nom, type = type... where id_aliment = id_aliment --> Modif et Nouvelles valeurs
                    $request = $pdo->prepare("UPDATE `aliments` 
                    SET `nom`='".$output['nom']."', `id_type_aliment`='".$output['id_type_aliment']."', `calories`='".$output['calories']."', `glucides`='".$output['glucides']."', `sucres`='".$output['sucres']."' `lipides`='".$output['lipides']."' `acides_gras`='".$output['acides_gras']."' `proteines`='".$output['proteines']."' `sel`='".$output['sel']."' 
                    WHERE `id_aliment`=".$output['id_aliment']);
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
                $resultat = array('reponse' => "La modification est impossible. Cause possible : il manque des champs (assurez-vous d'avoir fourni un id_aliment, un nom et un type.");
                $body = json_encode($resultat);
                http_response_code(400);
                header('content-type:application/json');
                echo $body;
            }
        break;

        /*********************************SUPPRESSION*****************************************/
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
                    $body = json_encode($resultat);
                    http_response_code(400);
                    header('content-type:application/json');
                    echo $body;
                }
            } else {
                $resultat = array('reponse' => "La modification est impossible. Cause possible : vous n'avez pas fourni d'identifiant.");
                $body = json_encode($resultat);
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
