<!doctype html>
<html>
    <?php
        require_once('template_header.php');
    ?>
        <div class="bigcontent">
            <?php
                require_once('template_menu.php');
                renderMenuToHTML('aliments');
            ?>
            <div class="content">
                <br>
                <script>
                    let URL_PREFIX = "<?php
                        require_once('config.php');
                        echo _URL_PREFIX; ?>";
                </script>
                <table class="table" id="alimentsTable">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Type</th>
                            <th scope="col">Calories</th>
                            <th scope="col">Glucides</th>
                            <th scope="col">Dont sucres</th>
                            <th scope="col">Lipides</th>
                            <th scope="col">Dont acides gras saturés</th>
                            <th scope="col">Protéines</th>
                            <th scope="col">Sel</th>
                            <th scope="col">Modification</th>
                            <th scope="col">Suppression</th>
                        </tr>
                    </thead>
                    <tbody id="alimentsTableBody">
                        
                    </tbody>
                </table>

                <form id="alimentsForm" action="" onsubmit="onFormSubmit();">
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputID" hidden>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputNom" class="col-sm-2 col-form-label">Nom</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputNom" >
                        </div>
                    </div>
                    <div class="form-group row"> <!--TODO : liste déroulante -->
                        <label for="inputType" class="col-sm-2 col-form-label">Type</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputType" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputCalories" class="col-sm-2 col-form-label">Calories</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputCalories" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputGlucides" class="col-sm-2 col-form-label">Glucides</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputGlucides" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputSucres" class="col-sm-2 col-form-label">Dont sucres</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputSucres" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputLipides" class="col-sm-2 col-form-label">Lipides</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputLipides" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputAcidesGras" class="col-sm-2 col-form-label">Dont acides gras saturés</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputAcidesGras" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputProteines" class="col-sm-2 col-form-label">Protéines</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputProteines" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputSel" class="col-sm-2 col-form-label">Sel</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputSel" >
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
                        table = $('#alimentsTable').DataTable( {
                            ajax: { 
                                url: URL_PREFIX + 'backend/aliments.php',
                                dataSrc: ''
                            },
                            columns: [
                                { data: 'id_aliment' },
                                { data: 'nom' },
                                { data: 'nom_type' },
                                { data: 'calories' },
                                { data: 'glucides' },
                                { data: 'sucres' },
                                { data: 'lipides' },
                                { data: 'acides_gras' },
                                { data: 'proteines' },
                                { data: 'sel' },
                                { data: null },
                                { data: null }
                            ],
                            columnDefs: [ {
                                orderable: false,
                                targets: 10,
                                data: null,
                                defaultContent: '<button id=edit>Edit</button>'},
                                {orderable: false,
                                targets: 11,
                                data: null,
                                defaultContent: '<button id=delete>Delete</button>'}
                            ]
                        });
                    });

                    $('#alimentsTable tbody').on('click', 'button', function () {
                        switch ($(this).attr('id')) {
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
                                    url: URL_PREFIX + 'backend/aliments.php',
                                    method: "DELETE",
                                    dataType : "json",
                                    data: JSON.stringify({id_aliment: idDel})
                                })
                                //Ce code sera exécuté en cas de succès - La réponse du serveur est passée à done()
                                .done(function(response){
                                    let res = JSON.stringify(response);
                                    $('#alimentsTable').DataTable().ajax.reload();
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
                                url: URL_PREFIX + 'backend/aliments.php',
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
                                document.getElementById("alimentsForm").reset();
                                $('#alimentsTable').DataTable().ajax.reload();
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
                                url:  URL_PREFIX + 'backend/aliments.php',
                                method: "POST",
                                dataType : "json",
                                data: {
                                    nom: nomNouv, 
                                    id_type_aliment: typeNouv, 
                                    calories: caloriesNouv, 
                                    glucides: glucidesNouv, 
                                    sucres: sucresNouv, 
                                    lipides: lipidesNouv, 
                                    acides_gras: acidesGrasNouv, 
                                    proteines: proteinesNouv, 
                                    sel: selNouv
                                }
                            })
                            //Ce code sera exécuté en cas de succès - La réponse du serveur est passée à done()
                            .done(function(response){
                                let res = JSON.stringify(response);
                                var idNouv = response['data']['id_aliment'];
                                document.getElementById("alimentsForm").reset();
                                $('#alimentsTable').DataTable().ajax.reload();
                            })
                            //Ce code sera exécuté en cas d'échec - L'erreur est passée à fail()
                            .fail(function(error){
                                alert("La requête d'ajout s'est terminée en échec. Infos : " + JSON.stringify(error));
                            });
                        }
                    }

                </script>
            </div>
        </div>
    </body>