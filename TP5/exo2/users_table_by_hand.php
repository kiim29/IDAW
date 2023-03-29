<!doctype html>
<html lang="fr">
<head>
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script>
        let PREFIX = "<?php
            require_once('config.php');
            echo API_URL_PREFIX; ?>";
    </script>
    <title></title>
    <style>
        body{
            margin-top: 5em;
        }
        .table {
            margin-top: 50px;
            margin-bottom: 50px;
        }
    </style>
</head>
<body>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nom</th>
                <th scope="col">Email</th>
                <th scope="col">CRUD</th>
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
            <label for="inputNom" class="col-sm-2 col-form-label">Nom *</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="inputNom" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputEmail" class="col-sm-2 col-form-label">Email *</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="inputEmail" required>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function(){
            $.ajax({
                url:  PREFIX + '/IDAW/TP4/exo5/users.php',

                method: "GET",

                dataType : "json",
            })
            //Ce code sera exécuté en cas de succès - La réponse du serveur est passée à done()
            .done(function(response){
                let data = JSON.stringify(response);
                $("div#usersTableBody").append(data);
            })
            //Ce code sera exécuté en cas d'échec - L'erreur est passée à fail()
            //On peut afficher les informations relatives à la requête et à l'erreur
            .fail(function(error){
                alert("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
            })
            //Ce code sera exécuté que la requête soit un succès ou un échec
            .always(function(){
                alert("Requête effectuée");
            });
        });




        let idEnModif = -1;
        let id=0;
        function onFormSubmit() {
            // prevent the form to be sent to the server
            event.preventDefault();
            let idPut = $("inputID").val();
            let nom = $("#inputNom").val();
            let prenom = $("#inputEmail").val();
            let date = $("#inputDate").val();
            let aimeCours = $("#inputAimeCours").val();
            let remarques = $("#inputRemarques").val();
            if (idEnModif!=-1) {
                document.getElementById(`cellNom${idEnModif}`).textContent = nom;
                document.getElementById(`cellPrenom${idEnModif}`).textContent = prenom;
                document.getElementById(`cellDate${idEnModif}`).textContent = date;
                document.getElementById(`cellAimeCours${idEnModif}`).textContent = aimeCours;
                document.getElementById(`cellRemarques${idEnModif}`).textContent = remarques;
                idEnModif=-1;
            } else {
                let crud = `<a href='#' onclick='editLine(${id});return false;' id=edit>Modifier</a>  <a href='#' onclick='deleteLine(${id});return false;' id=delete>Supprimer</a>`;
                $("#usersTableBody").append(`<tr><td id=cellNom${id}>${nom}</td><td id=cellPrenom${id}>${prenom}</td><td id=cellDate${id}>${date}</td><td id=cellAimeCours${id}>${aimeCours}</td><td id=cellRemarques${id}>${remarques}</td><td>${crud}</td></tr>`);
                id++;
            }
        }
        function deleteLine(id) {
            document.getElementById('usersTableBody').deleteRow(id);
        }
        function editLine(id) {
            idEnModif=id;
            document.getElementById('inputNom').value = document.getElementById(`cellNom${id}`).textContent;
            document.getElementById('inputPrenom').value = document.getElementById(`cellPrenom${id}`).textContent;
            document.getElementById('inputDate').value = document.getElementById(`cellDate${id}`).textContent;
            document.getElementById('inputAimeCours').value = document.getElementById(`cellAimeCours${id}`).textContent;
            document.getElementById('inputRemarques').value = document.getElementById(`cellRemarques${id}`).textContent;
        }
    </script>
</body>
</html>