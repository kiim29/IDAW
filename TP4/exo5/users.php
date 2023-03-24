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
                $body = json_encode($response);
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
                    $body = json_encode($response);
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


// $request = $pdo->prepare("select * from users");
// $request -> execute();
// $resultat = $request->fetchAll(PDO::FETCH_ASSOC);


// echo "<!doctype html>
// <html>
// <head>
// </head>
// <body>
// <h1>Liste des utilisateurs</h1>
// <table>
// ";
// function generateHTMLRow($id, $name, $email, $actionButtons=true) {
//     echo "<tr>";
//     echo "
//         <td>".$id."</td>
//         <td>".$name."</td>
//         <td>".$email."</td>
//     ";
//     if ($actionButtons) {
//         echo"<td><a href=users.php?action=supprimer&id=".$id.">Supprimer</a></td>
//             <td><a href=users.php?action=modifier&id=".$id."&name=".$name."&email=".$email.">Modifier</a></td>
//         ";
//     }
//     echo "</tr>";
// }
// generateHTMLRow('id','name','email',false);
// foreach ($resultat as $row) {
//     generateHTMLRow($row['id'],$row['name'],$row['email']);
// }
// echo "</table></br>";

// echo '<form id="user_add_form" action="users.php" method="GET">';
// echo '
//     <div class="form-example">
//         <input type="hidden" name="id" id="id">
//     </div>
//     <div class="form-example">
//         <input type="hidden" name="action" id="action" value="ajouter" required>
//     </div>
//     <div class="form-example">
//         <label for="name">Nom :</label>
//         <input type="text" name="name" id="name" required>
//     </div>
//     <div class="form-example">
//         <label for="email">Email :</label>
//         <input type="email" name="email" id="email" required>
//     </div>
//         <div class="form-example">
//         <input type="submit" value="Ajouter!">
//     </div>
// ';
// echo "</form></br>";

// if (isset($_GET['action']) && $_GET['action']=='modifier') {
//     echo '<form id="user_modify_form" action="users.php" method="GET">';
//     echo '
//         <div class="form-example">
//             <input type="hidden" name="id" id="id" value="'.$_GET['id'].'" required>
//         </div>
//         <div class="form-example">
//             <input type="hidden" name="action" id="action" value="modifier" required>
//         </div>
//         <div class="form-example">
//             <input type="hidden" name="okPourModif" id="okPourModif" value=true required>
//         </div>
//         <div class="form-example">
//             <label for="name">Name :</label>
//             <input type="text" name="name" id="name" value="'.$_GET['name'].'" required>
//         </div>
//         <div class="form-example">
//             <label for="email">Email :</label>
//             <input type="email" name="email" id="email" value="'.$_GET['email'].'" required>
//         </div>
//             <div class="form-example">
//             <input type="submit" value="Modifier!">
//         </div>
//     ';
//     echo "</form>";
// }




/*** close the database connection ***/
$pdo = null;

?>