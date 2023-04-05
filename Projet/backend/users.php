<?php

require_once('init_pdo.php');

if (isset($_SERVER['REQUEST_METHOD'])) {
    switch($_SERVER['REQUEST_METHOD']) {
        
        /*********************************SELECTION*****************************************/
        case 'GET' :
            if (isset($_GET['login'])) {
                //select * from utilisateurs where login = login
                $request = $pdo->prepare("select * from `utilisateurs` 
                join profils_sportifs on profil=id_profil 
                join sexe on sexe=id_sexe
                where login=".$_GET['login']);
                $request -> execute();
                $resultat = $request->fetch(PDO::FETCH_OBJ);
                $body = json_encode($resultat);
                http_response_code(200);
                header('content-type:application/json');
                echo $body;
            } else {
                //select * from utilisateurs
                $request = $pdo->prepare("select * from `utilisateurs` 
                join profils_sportifs on profil=id_profil 
                join sexe on sexe=id_sexe");
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
            if (isset($_POST['login']) &&isset($_POST['nom']) && isset($_POST['age']) && isset($_POST['taille']) && isset($_POST['poids'])) {
                //insert into utilisateurs (login, nom, age, taille, poids) values (login, nom, age, taille, poids)
                $request = $pdo->prepare("INSERT INTO `utilisateurs` (login,nom,age,sexe,taille,poids,profil) 
                VALUES ('".$_POST['login']."','".$_POST['nom']."','".$_POST['age']."','".$_POST['sexe']."','".$_POST['taille']."','".$_POST['poids']."','".$_POST['profil']."')");
                $request -> execute();
                //select login from utilisateurs where nom=nom and age=age and taille=taille and poids=poids --> Nouvelle location
                $request = $pdo->prepare("select * from `utilisateurs` where login='".$_POST['login']."' and age='".$_POST['age']."' and taille='".$_POST['taille']."' and poids='".$_POST['poids']."'");
                $request -> execute();
                $resultat = $request->fetch(PDO::FETCH_ASSOC);
                $final_result = array('Location' => 'users.php?login='.$resultat['login']);
                $final_result['data'] = $resultat;
                $body = json_encode($final_result);
                http_response_code(201);
                header('content-type:application/json');
                echo $body;
            } else {
                //$erreur ?
                $resultat = array('reponse' => "La création est impossible. Cause possible : il manque des champs (assurez-vous d'avoir fourni un nom et un age.");
                $body = json_encode($resultat);
                http_response_code(400);
                header('content-type:application/json');
            }
        break;

        /*********************************MODIFICATION*****************************************/
        case 'PUT' :
            parse_str(file_get_contents("php://input"), $output);
            if (isset($output['login']) && isset($output['nom']) && isset($output['age']) && isset($output['taille']) && isset($output['poids'])) {
                //select * from utilisateurs where login = login --> Anciennes valeurs
                $request = $pdo->prepare("select * from `utilisateurs` where login=".$output['login']);
                $request -> execute();
                $old_values = $request->fetch(PDO::FETCH_ASSOC);
                if (isset($old_values['login'])) { //si l'utilisateur de login=login est bien présent dans la base
                    //update utilisateurs set nom = nom, age = age,... where login = login --> Modif et Nouvelles valeurs
                    $request = $pdo->prepare("UPDATE `utilisateurs` 
                    SET `nom`='".$output['nom']."', `age`='".$output['age']."', `sexe`='".$output['sexe']."', `taille`='".$output['taille']."', `poids`='".$output['poids']."', `profil`='".$output['profil']."' 
                    WHERE `login`=".$output['login']);
                    $request -> execute();
                    $request = $pdo->prepare("select * from `utilisateurs` where login=".$output['login']);
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
                $resultat = array('reponse' => "La modification est impossible. Cause possible : il manque des champs (assurez-vous d'avoir fourni un login, un nom et un age.");
                $body = json_encode($resultat);
                http_response_code(400);
                header('content-type:application/json');
            }
        break;

        /*********************************SUPPRESSION*****************************************/
        case 'DELETE' :
            parse_str(file_get_contents("php://input"), $output);
            if (isset($output['login'])) {
                //select * from utilisateurs where login = login --> Anciennes valeurs
                $request = $pdo->prepare("select * from `utilisateurs` where login=".$output['login']);
                $request -> execute();
                $old_values = $request->fetch(PDO::FETCH_ASSOC);
                if (isset($old_values['login'])) {
                    //delete from utilisateurs where login = login
                    $request = $pdo->prepare("DELETE FROM `utilisateurs` WHERE login='".$old_values['login']."'");
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
                $resultat = array('reponse' => "La modification est impossible. Cause possible : vous n'avez pas fourni d'identifiant. Login reçu : ".$output['login']);
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
