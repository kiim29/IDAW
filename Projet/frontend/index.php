<!doctype html>
<head>
    <script>
        let URL_PREFIX = "<?php
            session_start();
            require_once('config.php');
            echo _URL_PREFIX;?>";
        let loginSent = "<?php 
            if(isset($_POST['login'])){
                echo $_POST['login'];
            }
        ?>";
        console.log(loginSent);
        let passwordSent = "<?php 
            if(isset($_POST['password'])){
                echo $_POST['password'];
            }
        ?>";
        console.log(passwordSent);
        let successfullyLogged = false;
        console.log(successfullyLogged);
    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
</head>
<body id=body>
<form id="login_form" action="index.php" method="POST">
    <table>
        <tr>
            <th>Login :</th>
            <td><input type="text" name="login"></td>
        </tr>
        <tr>
            <th>Mot de passe :</th>
            <td><input type="password" name="password"></td>
        </tr>
        <tr>
            <th></th>
            <td><input type="submit" value="Se connecter..." /></td>
        </tr>
    </table>
</form>
</body>


<script>
// // if successfullyLogged redirect
// if successfullyLogged {
//     window.location.href = URL_PREFIX+"frontend.php/dashboard.php";
// }
//questions : comment passer contenus du form $_POST['login'] et $_POST['password'] en script JS ?
// pour tester le login : ajax get vers API backend/users.php?login=loginSent&password=passwordSent
// si api retourne vrai :successfullyLogged = true et session['login']=login et redirect
// si api retourne  false  : rien dans le session et previent que faux
//Requête AJAX GET pour tester les logins

console.log(successfullyLogged);
$.ajax({
    url:  URL_PREFIX + 'backend/users.php',
    method: "GET",
    dataType : "json",
    data: {login: loginSent, password: passwordSent}
})
//Ce code sera exécuté en cas de succès - La réponse du serveur est passée à done()
.done(function(response){
    successfullyLogged = response['response'];
    console.log(successfullyLogged);
    if(successfullyLogged){
        let variableInutile = "<?php 
            if(isset($_POST['login'])) {
                $_SESSION['login'] = $_POST['login'];
            }
        ?>";
        window.location.href = URL_PREFIX+"frontend/dashboard.php";
    } else if(loginSent){
        <?php echo 'document.getElementById("body").innerHTML += "<h4>Les login et mot de passe ne sont pas reconnus. S\'il vous plaît réessayez ou vérifiez que vous avez un compte.</h4>"'?>
    }
})
//Ce code sera exécuté en cas d'échec - L'erreur est passée à fail()
.fail(function(error){
    alert("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
});
</script>