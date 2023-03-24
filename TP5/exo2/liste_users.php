<!doctype html>
<html lang="fr">
<head>
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script>import DataTable from 'datatables.net-dt';</script>
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
                <th scope="col">Actions possibles</th>
            </tr>
        </thead>
        <tbody id="usersTableBody">
            
        </tbody>
    </table>

    <form id="addStudentForm" action="" onsubmit="onFormSubmit();">
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
        
        $('#usersTable').DataTable( {
            ajax: { 
                url: PREFIX + '/IDAW/TP4/exo5/users.php',
                dataSrc: ''
            },
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'email' }
            ],
            buttons: [{
                extend: 'edit',
                editor: myEditor,
                formButtons: [
                    {
                        label: 'Cancel',
                        fn: function () { this.close(); }
                    },
                    'Save row'
                ]
            }]
        }  );

        // $('#usersTable').button().add( 0, {
        //     action: function ( e, dt, button, config ) {
        //         dt.ajax.reload();
        //     },
        //     text: 'Reload table'
        // } );

        
        function onFormSubmit() {

        }
    </script>
</body>
</html>