<?php
require_once("./lib/Database.php");
?>
<!DOCTYPE html>
<html lang="en">

<body>

    <?php require_once("./src/components/header.php"); ?>
    <?php
    // Vérifiez si le paramètre 'page' est défini dans l'URL
    if (isset($_GET['page'])) {
        // Récupérez la valeur du paramètre 'page' depuis l'URL
        $page = $_GET['page'];

        // Incluez le fichier correspondant à la valeur de 'page'
        if ($page == "Accueil") {
            require_once('./src/pages/Accueil.php');
        } elseif ($page == "Inscription") {
            require_once('./src/pages/Inscription.php');
        } elseif ($page == "Graphe") {
            require_once('./src/pages/Graphe.php');
        } else {
            require_once('./src/pages/Accueil.php');
        }
    } else {
        // Si 'page' n'est pas défini dans l'URL, incluez la page d'accueil par défaut
        require_once('./src/pages/Accueil.php');
    }
    ?>

    <?php require_once("./src/components/footer.php"); ?>

</body>

</html>