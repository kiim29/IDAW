<!doctype html>
<html>
    <?php
        require_once('template_header.php');
    ?>
        <div class="bigcontent">
            <?php
                require_once('template_menu.php');
                renderMenuToHTML('projets');
            ?>
            <div class="content">
                <h2>Projets et expériences</h2>
                <h3><i>Où est Charlie ?</i> - Bras robotique intelligent</h3>
                <p>
                    Projet de prise en main d'un bras robotique DOFBOT de YAHBOOM pour le faire jouer à <i>Où est Charlie ?</i>.  
                    <br>
                    Développement du code de pointage du bras et transfer learning pour créer un modèle qui reconnaisse Charlie.
                </p>
                <br>
                <h3>Stage en Dev Web dans la Marine Nationale</h3>
                <p>
                    Dans le cadre de ma première année (CI1) d'école d'ingénieur, j'ai développé une application de gestion des ressources humaines pour une équipe de RH de CECLANT.
                    Intégrée à l'équipe du Laboratoire Numérique de CECLANT, j'ai recueilli les besoins de mes clientes et réalisé plusieurs versions de l'application, avec des démonstartions régulières.
                    Au bout de 3 mois, l'application était fonctionnelle et correspondait aux attentes des clientes. Il manquait seulement quelques fonctionnalités à rajouter par un futur stagiaire ou mes responsables.
                    Ce stage m'a permis de monter en compétences en développement full-stack et en gestion de projets agiles.
                </p>
                <br>
                <h3><i>The Light Map</i></h3>
                <p>
                    Durant ma première année en école d'ingénieur, j'ai été cheffe de projet pour The Light Map, un projet d'étude des nuisances lumineuses sur la commune de Lambres-lez-Douai.
                    Avec quatre autres étudiants, nous avons géré les relations avec la mairie, créé des protocoles d'étude, réalisé des mesures, et présenté nos conclusions finales (avec des suggestions et des estimations de coût) au Maire et à ses adjoints.
                </p>
                <br>
            </div>
        </div>
    </body>
    <?php
        require_once('template_footer.php');
    ?>
</html>