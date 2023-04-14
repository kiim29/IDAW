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
                <table id="repasTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Aliment mangé</th>
                            <th scope="col">Type d'aliment</th>
                            <th scope="col">Quantité</th>
                            <th scope="col">Date</th>
                            <th scope="col">Modification</th>
                            <th scope="col">Suppression</th>
                            <th scope="col">ID de l'aliment mangé</th>
                        </tr>
                    </thead>
                    <tbody id="repasTableBody">
                        
                    </tbody>
                </table>

                <form id="repasForm" action="" onsubmit="onFormSubmit();">
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputIDRepas" hidden>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputAliment" class="col-sm-2 col-form-label">Aliment mangé</label>
                        <div class="col-sm-3">
                            <select class="form-control" id="inputAliment" required>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputQte" class="col-sm-2 col-form-label">Quantité (en grammes)</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="inputQte" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputDate" class="col-sm-2 col-form-label">Date (AAAA-MM-JJ)</label>
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
                                { data: 'nom_aliment' },
                                { data: 'nom_type' },
                                { data: 'qte' },
                                { data: 'date' },
                                { data: null },
                                { data: null },
                                { data: 'id_aliment' }
                            ],
                            columnDefs: [ 
                                {orderable: false,
                                targets: 5,
                                data: null,
                                defaultContent: '<button id=edit>Edit</button>'},
                                {orderable: false,
                                targets: 6,
                                data: null,
                                defaultContent: '<button id=delete>Delete</button>'},
                                {targets: 7,
                                visible: false}
                            ]
                        });
                        //Requête AJAX GET pour récupérer la liste des aliments possibles
                        $.ajax({
                            url: URL_PREFIX + 'backend/aliments.php',
                            method: "GET",
                            dataType : "json"
                        })
                        //Ce code sera exécuté en cas de succès - La réponse du serveur est passée à done()
                        .done(function(response){
                            let html = '<option value="-1">Sélectionnez un aliment</option>';
                            for (var i = 0; i < response.length; i++) {  
                                html += '<option value="' + response[i].id_aliment + '">' + response[i].nom_aliment + '</option>';  
                            }  
                            $("#inputAliment").html(html);
                        })
                        //Ce code sera exécuté en cas d'échec - L'erreur est passée à fail()
                        .fail(function(error){
                            alert("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
                        });
                    });

                    $('#repasTable tbody').on('click', 'button', function () { // TODO 
                        switch ($(this).attr('id')) {
                            case 'edit' :
                                console.log("bvk111111fjk");
                                enModif = true;
                                var data = table.row($(this).parents('tr')).data();
                                document.getElementById('inputIDRepas').value = data['id_repas'];
                                document.getElementById('inputAliment').value = data['id_aliment'];
                                document.getElementById('inputQte').value = data['qte'];
                                document.getElementById('inûtDate').value = data['date'];
                            break;

                            case 'delete' :
                                console.log("bvkfjk");
                                var tr = $(this).parents('tr');
                                var dataDel = table.row(tr).data();
                                var idDel = dataDel['id_repas'];
                                console.log("dataDel");
                                //Requête AJAX DELETE pour supprimer
                                $.ajax({
                                    url: URL_PREFIX + 'backend/repas.php',
                                    method: "DELETE",
                                    dataType : "json",
                                    data: JSON.stringify({id_repas: idDel})
                                })
                                //Ce code sera exécuté en cas de succès - La réponse du serveur est passée à done()
                                .done(function(response){
                                    let res = JSON.stringify(response);
                                    $('#repasTable').DataTable().ajax.reload();
                                    console.log("ouiii");
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
                        if(enModif && document.getElementById('inputIDRepas').value != null) { //MODIFICATION D'UN aliment EXISTANT
                            var idRepasModif = document.getElementById('inputIDRepas').value;
                            var idMangeurModif = login;
                            var idAlimentModif = document.getElementById('inputAliment').value;
                            var qteModif = document.getElementById('inputQte').value;
                            var dateModif = document.getElementById('inputDate').value;
                            enModif=false;
                            //Requête AJAX PUT pour modifier
                            $.ajax({
                                url: URL_PREFIX + 'backend/repas.php',
                                method: "PUT",
                                dataType: "json",
                                data: JSON.stringify({
                                    id_repas: idRepasModif,
                                    id_mangeur: idMangeurModif, 
                                    id_aliment_mange: idAlimentModif, 
                                    qte: qteModif, 
                                    date: dateModif
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
                        }else if(!(enModif)) { //AJOUT D'UN NOUVEAU REPAS
                            var idMangeurNouv = login;
                            var idAlimentNouv = document.getElementById('inputAliment').value;
                            var qteNouv = document.getElementById('inputQte').value;
                            var dateNouv = document.getElementById('inputDate').value;
                            //Requête AJAX POST pour ajouter
                            $.ajax({
                                url:  URL_PREFIX + 'backend/repas.php',
                                method: "POST",
                                dataType : "json",
                                data: {
                                    id_mangeur: idMangeurNouv, 
                                    id_aliment_mange: idAlimentNouv, 
                                    qte: qteNouv, 
                                    date: dateNouv
                                }
                            })
                            //Ce code sera exécuté en cas de succès - La réponse du serveur est passée à done()
                            .done(function(response){
                                let res = JSON.stringify(response);
                                var idNouv = response['data']['id_repas'];
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