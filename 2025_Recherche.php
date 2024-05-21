<?php
require_once("./lib/Database.php");

?>
<!DOCTYPE html>
<html lang="en">

<body>

    <?php
    // Vérifiez si le paramètre 'page' est défini dans l'URL
    if (isset($_GET['page'])) {
        if ($_SESSION["user"] == null) {
            $_SESSION["user"] = "";
        }
        if ($_SESSION["id_author"] == null) {
            $_SESSION["id_author"] = "";
        }
        // Récupérez la valeur du paramètre 'page' depuis l'URL
        $page = $_GET['page'];

        // Incluez le fichier correspondant à la valeur de 'page'
        if ($page == "Accueil") {
            require_once('./src/pages/Accueil.php');
        } elseif ($page == "Publications") {
            require_once('./src/pages/Publications.php');
        } elseif ($page == "DetailPub") {
            require_once('./src/pages/DetailPub.php');
        } elseif ($page == "Graphe") {
            require_once('./src/pages/Graphe.php');
        } elseif ($page == "ProfilAuteur" && $_SESSION["id_author"] != "") {
            require_once('./src/pages/Auteur.php');
        } elseif ($page == "Profil" && $_SESSION["user"] != "") {
            require_once('./src/pages/Utilisateur.php');
        } elseif ($page == "Deconnexion" && $_SESSION["user"] != "") {
            $_SESSION["user"] = "";
            $_SESSION["id_author"] = "";
            require_once('./src/pages/Accueil.php');
        } elseif ($page == "Connexion" && $_SESSION["user"] == "") {
            require_once('./src/pages/Connexion.php');
        } elseif ($page == "Inscription" && $_SESSION["user"] == "") {
            require_once('./src/pages/Inscription.php');
        } else {
            $_SESSION["user"] = "";
            $_SESSION["id_author"] = "";
            require_once('./src/pages/Accueil.php');
        }
    } else {
        // Si 'page' n'est pas défini dans l'URL, incluez la page d'accueil par défaut
        $_SESSION["user"] = "";
        $_SESSION["id_author"] = "";
        require_once('./src/pages/Accueil.php');
    }
    ?>



</body>

</html>