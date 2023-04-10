<!doctype html>
<html>
    <?php
        require_once('template_header.php');
    ?>
        <div class="bigcontent">
            <?php
                require_once('template_menu.php');
                renderMenuToHTML('repas');
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
                <table class="table" id="repasTable">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Aliment mangé</th>
                            <th scope="col">Type d'aliment</th>
                            <th scope="col">Quantité</th>
                            <th scope="col">Date</th>
                            <th scope="col">Modification</th>
                            <th scope="col">Suppression</th>
                        </tr>
                    </thead>
                    <tbody id="repasTableBody">
                        
                    </tbody>
                </table>

                <form id="repasForm" action="" onsubmit="onFormSubmit();">
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputID" hidden>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputAliment" class="col-sm-2 col-form-label">Aliment</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputAliment" >
                        </div>
                    </div>
                    <div class="form-group row"> <!--TODO : liste déroulante -->
                        <label for="inputType" class="col-sm-2 col-form-label">Type</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputType" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputQte" class="col-sm-2 col-form-label">Quantité (en grammes)</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputCalories" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputGlucides" class="col-sm-2 col-form-label">inputQte</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputGlucides" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputDate" class="col-sm-2 col-form-label">Date</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputDate" >
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
                    let enModif = false;
                    let table;
                    $(document).ready(function () {
                        table = $('#repasTable').DataTable( {
                            ajax: { 
                                url: URL_PREFIX + "backend/repas.php?id_mangeur='" + login + "'",
                                dataSrc: ''
                            },
                            columns: [
                                { data: 'id_repas' },
                                { data: 'nom' },
                                { data: 'nom_type' },
                                { data: 'qte' },
                                { data: 'date' },
                                { data: null },
                                { data: null }
                            ],
                            columnDefs: [ 
                                {orderable: false,
                                targets: 5,
                                data: null,
                                defaultContent: '<button id=edit>Edit</button>'},
                                {orderable: false,
                                targets: 6,
                                data: null,
                                defaultContent: '<button id=delete>Delete</button>'}
                            ]
                        });
                    });

                    $('#repasTable tbody').on('click', 'button', function () { // TODO 
                        switch ($(this).attr('id_aliment')) {
                            case 'edit' :
                                enModif = true;
                                var data = table.row($(this).parents('tr')).data();
                                document.getElementById('inputID').value = data['id_aliment'];
                                document.getElementById('inputNom').value = data['nom'];
                                document.getElementById('inputType').value = data['nom_type'];
                                document.getElementById('inputCalories').value = data['calories'];
                                document.getElementById('inputGlucides').value = data['glucides'];
                                document.getElementById('inputSucres').value = data['sucres'];
                                document.getElementById('inputLipides').value = data['lipides'];
                                document.getElementById('inputAcidesGras').value = data['acides_gras'];
                                document.getElementById('inputProteines').value = data['proteines'];
                                document.getElementById('inputSel').value = data['sel'];
                            break;

                            case 'delete' :
                                var tr = $(this).parents('tr');
                                var dataDel = table.row(tr).data();
                                var idDel = dataDel['id_aliment'];
                                //Requête AJAX DELETE pour supprimer
                                $.ajax({
                                    url: URL_PREFIX + 'backend/repas.php',
                                    method: "DELETE",
                                    dataType : "json",
                                    data: JSON.stringify({id_aliment: idDel})
                                })
                                //Ce code sera exécuté en cas de succès - La réponse du serveur est passée à done()
                                .done(function(response){
                                    let res = JSON.stringify(response);
                                    $('#repasTable').DataTable().ajax.reload();
                                })
                                //Ce code sera exécuté en cas d'échec - L'erreur est passée à fail()
                                .fail(function(error){
                                    alert("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
                                });
                            break;
                        }
                    });
                    
                    function onFormSubmit() {
                        // prevent the form to be sent to the server
                        event.preventDefault();
                        if(enModif && document.getElementById('inputID').value != null) { //MODIFICATION D'UN aliment EXISTANT
                            var idModif = document.getElementById('inputID').value;
                            var nomModif = document.getElementById('inputNom').value;
                            var typeModif = document.getElementById('inputType').value;
                            var caloriesModif = document.getElementById('inputCalories').value;
                            var glucidesModif = document.getElementById('inputGlucides').value;
                            var sucresModif = document.getElementById('inputSucres').value;
                            var lipidesModif = document.getElementById('inputLipides').value;
                            var acidesGrasModif = document.getElementById('inputAcidesGras').value;
                            var proteinesModif = document.getElementById('inputProteines').value;
                            var selModif = document.getElementById('inputSel').value;
                            enModif=false;
                            //Requête AJAX PUT pour modifier
                            $.ajax({
                                url: URL_PREFIX + 'backend/repas.php',
                                method: "PUT",
                                dataType: "json",
                                data: JSON.stringify({
                                    id_aliment: idModif, 
                                    nom: nomModif, 
                                    id_type_aliment: typeModif, 
                                    calories: caloriesModif, 
                                    glucides: glucidesModif, 
                                    sucres: sucresModif, 
                                    lipides: lipidesModif, 
                                    acides_gras: acidesGrasModif, 
                                    proteines: proteinesModif, 
                                    sel: selModif
                                })
                            })
                            //Ce code sera exécuté en cas de succès - La réponse du serveur est passée à done()
                            .done(function(response){
                                let res = JSON.stringify(response);
                                document.getElementById("repasForm").reset();
                                $('#repasTable').DataTable().ajax.reload();
                            })
                            //Ce code sera exécuté en cas d'échec - L'erreur est passée à fail()
                            .fail(function(error){
                                alert("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
                            });
                        }else if(!(enModif)) { //AJOUT D'UN NOUVEL aliment
                            var nomNouv = document.getElementById('inputNom').value;
                            var typeNouv = document.getElementById('inputType').value;
                            var caloriesNouv = document.getElementById('inputCalories').value;
                            var glucidesNouv = document.getElementById('inputGlucides').value;
                            var sucresNouv = document.getElementById('inputSucres').value;
                            var lipidesNouv = document.getElementById('inputLipides').value;
                            var acidesGrasNouv = document.getElementById('inputAcidesGras').value;
                            var proteinesNouv = document.getElementById('inputProteines').value;
                            var selNouv = document.getElementById('inputSel').value;
                            //Requête AJAX POST pour ajouter
                            $.ajax({
                                url:  URL_PREFIX + 'backend/repas.php',
                                method: "POST",
                                dataType : "json",
                                data: JSON.stringify({
                                    nom: nomNouv, 
                                    id_type_aliment: typeNouv, 
                                    calories: caloriesNouv, 
                                    glucides: glucidesNouv, 
                                    sucres: sucresNouv, 
                                    lipides: lipidesNouv, 
                                    acides_gras: acidesGrasNouv, 
                                    proteines: proteinesNouv, 
                                    sel: selNouv
                                })
                            })
                            //Ce code sera exécuté en cas de succès - La réponse du serveur est passée à done()
                            .done(function(response){
                                let res = JSON.stringify(response);
                                var idNouv = response['data']['id_aliment'];
                                document.getElementById("repasForm").reset();
                                $('#repasTable').DataTable().ajax.reload();
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