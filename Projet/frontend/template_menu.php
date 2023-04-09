<!doctype html>
    <html>
    <?php
    function renderMenuToHTML($currentPageId) {
        // un tableau qui définit la structure du site
        $mymenu = array(
            // idPage => titre
            'dashboard' => 'Tableau de Bord' ,
            'repas' => 'Repas',
            'aliments' => 'Aliments',
            'profil' => 'Profil',
            'logout' => 'Se déconnecter'
        );
        // echo le HTML exact du menu
        echo "
        <div id='menu_dynamique'>
            <nav>
                <ul>";
        foreach($mymenu as $pageId => $pageName) {
            if($pageId==$currentPageId){
                echo "<li><a id='currentpage' href='".$pageId.".php'>".$pageName."</a></li>";
            }
            else {
                echo "<li><a href='".$pageId.".php'>".$pageName."</a></li>";
            }
        }
        echo "  </ul>
            </nav>
        </div>";
    }
    ?>