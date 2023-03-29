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
        console.log('debut');
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
                    console.log('bla');
                    enModif = true;
                    var data = table.row($(this).parents('tr')).data();
                    console.log(data['name']);
                    $('#inputID').value = data['id'];
                    $('#inputName').value = data['name'];
                    $('#inputEmail').value = data['email'];
                break;

                case 'delete' :
                    console.log('bladel');
                    var dataDel = table.row($(this).parents('tr')).data();
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
                        console.log('delDone');
                        // console.log(table.row($(this).parents('tr')));
                        // table.row($(this).parents('tr')).remove().draw();
                    })
                    //Ce code sera exécuté en cas d'échec - L'erreur est passée à fail()
                    .fail(function(error){
                        alert("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
                    });
                break;
            }
        });
        
        function onFormSubmit() {
            if(enModif && $('#inputID').value != null) {
                var idModif = $("inputID").value;
                var nomModif = $("inputName").value;
                var emailModif = $("inputEmail").value;
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
                    table.draw();
                })
                //Ce code sera exécuté en cas d'échec - L'erreur est passée à fail()
                .fail(function(error){
                    alert("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
                });
            }else{

            }
        }
    </script>
</body>
</html>