<!doctype html>
<html>
    <?php
        require_once('template_header.php');
    ?>
        <div class="bigcontent">
            <?php
                require_once('template_menu.php');
                renderMenuToHTML('dashboard');
            ?>
            <div class="content">
                <br>
                <script>
                    let PREFIX = "<?php
                        require_once('config.php');
                        echo _URL_PREFIX; ?>";
                    let login = "<?php
                        echo $_SESSION['login']; ?>";
                </script>
                <h4 id="messageBesoinsJours"></h4>
                <h4 id="messageCalories"></h4>
                <script>
                    let besoins_jour = 0;
                    console.log("frr")
                    $(document).ready(function () {
                        //Requête AJAX GET pour récupérer les infos sur l'utilisateur
                        $.ajax({
                            url: PREFIX + "backend/users.php?login="+login,
                            method: "GET",
                            dataType : "json"
                        })
                        //Ce code sera exécuté en cas de succès - La réponse du serveur est passée à done()
                        .done(function(res){
                            //Calcul des besoins journaliers théoriques
                            if (res['sexe'] == "1") {
                                var base = 9.74*parseFloat(res['poids']) + 172.9*parseFloat(res['taille']) - 4.737*parseInt(res['age']) +667.051;
                            }else {
                                var base = 13.707*parseFloat(res['poids']) + 492.3*parseFloat(res['taille']) - 6.673*parseInt(res['age']) +77.607;
                            }
                            switch(res['profil']) {
                                case "1":
                                    besoins_jour = base*1.2;
                                break;
                                case "2":
                                    besoins_jour = base*1.375;
                                break;
                                case "3":
                                    besoins_jour = base*1.55;
                                break;
                                case "4":
                                    besoins_jour = base*1.725;
                                break;
                            }
                            $('#messageBesoinsJours').html("Vos besoins journaliers théoriques sont de " + besoins_jour + " kcal.")

                        })
                        //Ce code sera exécuté en cas d'échec - L'erreur est passée à fail()
                        .fail(function(error){
                            alert("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
                        });
                        //TODO : rajouter le calcul des calories du jour : implique des modifs dans l'API
                        // //Requête AJAX GET pour récupérer la liste des repas du jour
                        // $.ajax({
                        //     url: URL_PREFIX + 'backend/aliments.php',
                        //     method: "GET",
                        //     dataType : "json"
                        // })
                        // //Ce code sera exécuté en cas de succès - La réponse du serveur est passée à done()
                        // .done(function(response){
                        // })
                        // //Ce code sera exécuté en cas d'échec - L'erreur est passée à fail()
                        // .fail(function(error){
                        //     alert("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
                        // });
                        // //Calcul des calories du jour
                    })

                </script>
            </div>
        </div>
    </body>
