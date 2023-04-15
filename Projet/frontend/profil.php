<!doctype html>
<html>
    <?php
        require_once('template_header.php');
    ?>
        <div class="bigcontent">
            <?php
                require_once('template_menu.php');
                renderMenuToHTML('profil');
            ?>
            <div class="content">
                <br>
                <script>
                    let URL_PREFIX = "<?php
                        require_once('config.php');
                        echo _URL_PREFIX; ?>";
                    let login = "<?php
                        echo $_SESSION['login']; ?>";
                </script>

                <h3>Formulaire de modification de vos informations</h3>
                <form id="userForm" action="" onsubmit="onFormSubmit();">
                    <div class="form-group row">
                        <label for="inputNom" class="col-sm-2 col-form-label">Nom</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputNom" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputLogin" class="col-sm-2 col-form-label">Login</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputLogin" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Mot de passe</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputPassword" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputAge" class="col-sm-2 col-form-label">Age (en années)</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputAge" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputSexe" class="col-sm-2 col-form-label">Sexe</label>
                        <div class="col-sm-3">
                            <select id="inputSexe">
                                <option value=1>F</option>
                                <option value=2>H</option>
                                <option value=3>X</option>
                            </select>
                            <!-- <input type="text" class="form-control" id="inputSexe" > -->
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputTaille" class="col-sm-2 col-form-label">Taille (en mètres)</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputTaille" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPoids" class="col-sm-2 col-form-label">Poids (en kilos)</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputPoids" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputProfil" class="col-sm-2 col-form-label">Profil sportif</label>
                        <div class="col-sm-3">
                            <select id="inputProfil">
                                <option value=1>Sédentaire</option>
                                <option value=2>Actif</option>
                                <option value=3>Très actif</option>
                                <option value=3>Athlète</option>
                            </select>
                            <!-- <input type="text" class="form-control" id="inputProfil" > -->
                        </div>
                    </div>
                    <div class="form-group row">
                        <span class="col-sm-2"></span>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-primary form-control">Submit</button>
                        </div>
                    </div>
                </form>

                <script>
                    $(document).ready(function () {
                        //Requête AJAX GET pour récupérer les infos sur l'user de login : login
                        $.ajax({
                            url: URL_PREFIX + "backend/users.php?login="+login,
                            method: "GET",
                            dataType : "json"
                        })
                        //Ce code sera exécuté en cas de succès - La réponse du serveur est passée à done()
                        .done(function(response){
                            document.getElementById('inputNom').value = response['nom'];
                            document.getElementById('inputLogin').value = response['login'];
                            document.getElementById('inputPassword').value = response['password'];
                            document.getElementById('inputAge').value = response['age'];
                            document.getElementById('inputSexe').value = response['id_sexe'];
                            document.getElementById('inputTaille').value = response['taille'];
                            document.getElementById('inputPoids').value = response['poids'];
                            document.getElementById('inputProfil').value = response['id_profil'];
                        })
                        //Ce code sera exécuté en cas d'échec - L'erreur est passée à fail()
                        .fail(function(error){
                            alert("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
                        });
                    });
                    
                    function onFormSubmit() {
                        // prevent the form to be sent to the server
                        event.preventDefault();
                        if(document.getElementById('inputLogin').value != null) { //MODIFICATION D'UN user EXISTANT
                            var nomModif = document.getElementById('inputNom').value;
                            var loginModif = document.getElementById('inputLogin').value;
                            var passwordModif = document.getElementById('inputPassword').value;
                            var ageModif = document.getElementById('inputAge').value;
                            var sexeModif = document.getElementById('inputSexe').value;
                            var tailleModif = document.getElementById('inputTaille').value;
                            var poidsModif = document.getElementById('inputPoids').value;
                            var profilModif = document.getElementById('inputProfil').value;
                            enModif=false;
                            //Requête AJAX PUT pour modifier
                            $.ajax({
                                url: URL_PREFIX + 'backend/users.php',
                                method: "PUT",
                                dataType: "json",
                                data: JSON.stringify({
                                    nom: nomModif, 
                                    login: loginModif, 
                                    password: passwordModif, 
                                    age: ageModif, 
                                    sexe: sexeModif, 
                                    taille: tailleModif, 
                                    poids: poidsModif, 
                                    profil: profilModif
                                })
                            })
                            //Ce code sera exécuté en cas de succès - La réponse du serveur est passée à done()
                            .done(function(response){
                                let res = JSON.stringify(response);
                                alert("Merci, vos informations ont bien été mises à jour.")
                            })
                            //Ce code sera exécuté en cas d'échec - L'erreur est passée à fail()
                            .fail(function(error){
                                alert("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
                            });
                        }
                    }

                </script>
            </div>
        </div>
    </body>