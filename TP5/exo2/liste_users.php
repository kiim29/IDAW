<!doctype html>
<html lang="fr">
<head>
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script>
        let PREFIX = "<?php
            require_once('config.php');
            echo API_URL_PREFIX; ?>";
    </script>
    <title>liste users with datatables</title>
    <style></style>
</head>
<body>
    <table class="table" id="usersTable">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nom</th>
                <th scope="col">Email</th>
                <th scope="col">Modification</th>
                <th scope="col">Suppression</th>
            </tr>
        </thead>
        <tbody id="usersTableBody">
            
        </tbody>
    </table>

    <form id="usersForm" action="" onsubmit="onFormSubmit();">
        <div class="form-group row">
            <div class="col-sm-3">
                <input type="text" class="form-control" id="inputID" hidden>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputName" class="col-sm-2 col-form-label">Nom</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="inputName" >
            </div>
        </div>
        <div class="form-group row">
            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="inputEmail" >
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
            table = $('#usersTable').DataTable( {
                ajax: { 
                    url: PREFIX + '/IDAW/TP4/exo5/users.php',
                    dataSrc: ''
                },
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'email' },
                    { data: null },
                    { data: null }
                ],
                columnDefs: [ {
                    targets: 3,
                    data: null,
                    defaultContent: '<button id=edit>Edit</button>'},
                    {targets: 4,
                    data: null,
                    defaultContent: '<button id=delete>Delete</button>'}
                ]
            });
        });

        $('#usersTable tbody').on('click', 'button', function () {
            switch ($(this).attr('id')) {
                case 'edit' :
                    enModif = true;
                    var data = table.row($(this).parents('tr')).data();
                    document.getElementById('inputID').value = data['id'];
                    document.getElementById('inputName').value = data['name'];
                    document.getElementById('inputEmail').value = data['email'];
                break;

                case 'delete' :
                    var tr = $(this).parents('tr');
                    var dataDel = table.row(tr).data();
                    var idDel = dataDel['id'];
                    //Requête AJAX DELETE pour supprimer
                    $.ajax({
                        url:  PREFIX + '/IDAW/TP4/exo5/users.php',
                        method: "DELETE",
                        dataType : "json",
                        data: "id="+idDel
                    })
                    //Ce code sera exécuté en cas de succès - La réponse du serveur est passée à done()
                    .done(function(response){
                        let res = JSON.stringify(response);
                        $('#usersTable').DataTable().ajax.reload();
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
            if(enModif && document.getElementById('inputID').value != null) { //MODIFICATION D'UN USER EXISTANT
                var idModif = document.getElementById('inputID').value;
                var nomModif = document.getElementById('inputName').value;
                var emailModif = document.getElementById('inputEmail').value;
                enModif=false;
                //Requête AJAX PUT pour modifier
                $.ajax({
                    url:  PREFIX + '/IDAW/TP4/exo5/users.php',
                    method: "PUT",
                    dataType : "json",
                    data: {id: idModif, name: nomModif, email: emailModif}
                })
                //Ce code sera exécuté en cas de succès - La réponse du serveur est passée à done()
                .done(function(response){
                    let res = JSON.stringify(response);
                    document.getElementById("usersForm").reset();
                    $('#usersTable').DataTable().ajax.reload();
                })
                //Ce code sera exécuté en cas d'échec - L'erreur est passée à fail()
                .fail(function(error){
                    alert("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
                });
            }else if(!(enModif)) { //AJOUT D'UN NOUVEL USER
                var nomNouv = document.getElementById('inputName').value;
                var emailNouv = document.getElementById('inputEmail').value;
                //Requête AJAX POST pour ajouter
                $.ajax({
                    url:  PREFIX + '/IDAW/TP4/exo5/users.php',
                    method: "POST",
                    dataType : "json",
                    data: {name: nomNouv, email: emailNouv}
                })
                //Ce code sera exécuté en cas de succès - La réponse du serveur est passée à done()
                .done(function(response){
                    let res = JSON.stringify(response);
                    var idNouv = response['data']['id'];
                    document.getElementById("usersForm").reset();
                    $('#usersTable').DataTable().ajax.reload();
                })
                //Ce code sera exécuté en cas d'échec - L'erreur est passée à fail()
                .fail(function(error){
                    alert("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
                });
            }
        }

    </script>
</body>
</html>