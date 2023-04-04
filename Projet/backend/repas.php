<?php

require_once('init_pdo.php');

if (isset($_SERVER['REQUEST_METHOD'])) {
    switch($_SERVER['REQUEST_METHOD']) {

        /*********************************SELECTION*****************************************/
        case 'GET' :
            if (isset($_GET['id_repas'])) {
                //select * from repas where id_repas = id_repas
                $request = $pdo->prepare("select * from repas 
                join aliments on id_aliment_mange=id_aliment
                join utilisateurs on id_mangeur=login
                where id_repas=".$_GET['id_repas']);
                $request -> execute();
                $resultat = $request->fetch(PDO::FETCH_OBJ);
                $body = json_encode($resultat);
                http_response_code(200);
                header('content-type:application/json');
                echo $body;
            } else if (isset($_GET['id_mangeur'])) {
                //select * from repas where id_mangeur = id_mangeur
                $request = $pdo->prepare("select * from repas 
                join aliments on id_aliment_mange=id_aliment
                join utilisateurs on id_mangeur=login
                where id_mangeur=".$_GET['id_mangeur']);
                $request -> execute();
                $resultat = $request->fetch(PDO::FETCH_OBJ);
                $body = json_encode($resultat);
                http_response_code(200);
                header('content-type:application/json');
                echo $body;
            } else {
                //select * from repas
                $request = $pdo->prepare("select * from repas 
                join aliments on id_aliment_mange=id_aliment
                join utilisateurs on id_mangeur=login");
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
            if (isset($_POST['id_mangeur']) && isset($_POST['id_aliment_mange']) && isset($_POST['qte'])) {
                //insert into repas (...) values (...)
                $request = $pdo->prepare("INSERT INTO `repas` (id_mangeur,id_aliment_mange,qte,date) 
                VALUES ('".$_POST['id_mangeur']."','".$_POST['id_aliment_mange']."','".$_POST['qte']."','".$_POST['date']."')");
                $request -> execute();
                //select id_repas from repas where ... --> Nouvelle location
                $request = $pdo->prepare("select * from `repas` where id_mangeur='".$_POST['id_mangeur']."' and id_aliment_mange='".$_POST['id_aliment_mange']."' and date='".$_POST['date']."' and qte='".$_POST['qte']."'");
                $request -> execute();
                $resultat = $request->fetch(PDO::FETCH_ASSOC);
                $final_result = array('Location' => 'repas.php?id_repas='.$resultat['id_repas']);
                $final_result['data'] = $resultat;
                $body = json_encode($final_result);
                http_response_code(201);
                header('content-type:application/json');
                echo $body;
            } else {
                //$erreur
                $resultat = array('reponse' => "La création est impossible. Cause possible : il manque des champs (assurez-vous d'avoir fourni un mangeur, un aliment, et une qté.");
                $body = json_encode($resultat);
                http_response_code(400);
                header('content-type:application/json');
            }
        break;

        /*********************************MODIFICATION*****************************************/
        case 'PUT' :
            parse_str(file_get_contents("php://input"), $output);
            if (isset($output['id_repas']) && isset($output['id_mangeur']) && isset($output['id_aliment_mange']) && isset($output['qte'])) {
                //select * from repas where id_repas = id_repas --> Anciennes valeurs
                $request = $pdo->prepare("select * from `repas` where id_repas=".$output['id_repas']);
                $request -> execute();
                $old_values = $request->fetch(PDO::FETCH_ASSOC);
                if (isset($old_values['id_repas'])) { //si le repas d'id_repas=id_repas est bien présent dans la base
                    //update repas set ... where id_repas = id_repas --> Modif et Nouvelles valeurs
                    $request = $pdo->prepare("UPDATE `repas` 
                    SET `id_mangeur`='".$output['id_mangeur']."', `id_aliment_mange`='".$output['id_aliment_mange']."', `qte`='".$output['qte']."', `date`='".$output['date']."' 
                    WHERE `id_repas`=".$output['id_repas']);
                    $request -> execute();
                    $request = $pdo->prepare("select * from `repas` where id_repas=".$output['id_repas']);
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
                $resultat = array('reponse' => "La modification est impossible. Cause possible : il manque des champs (assurez-vous d'avoir fourni un id_repas, un mangeur, un aliment et une qté.");
                $body = json_encode($resultat);
                http_response_code(400);
                header('content-type:application/json');
                echo $body;
            }
        break;

        /*********************************SUPPRESSION*****************************************/
        case 'DELETE' :
            parse_str(file_get_contents("php://input"), $output);
            if (isset($output['id_repas'])) {
                //select * from repas where id_repas = id_repas --> Anciennes valeurs
                $request = $pdo->prepare("select * from `repas` where id_repas=".$output['id_repas']);
                $request -> execute();
                $old_values = $request->fetch(PDO::FETCH_ASSOC);
                if (isset($old_values['id_repas'])) {
                    //delete from repas where id_repas = id_repas
                    $request = $pdo->prepare("DELETE FROM `repas` WHERE id_repas='".$old_values['id_repas']."'");
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
