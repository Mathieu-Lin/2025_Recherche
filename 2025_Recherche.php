<?php
require_once("./lib/Database.php");
?>
<!DOCTYPE html>
<html lang="en">
<body>

<?php
require_once("./src/components/header.php");
if (!isset($_SESSION["page"])) {
    require_once('./src/pages/Accueil.php');
} else {
    if ($_SESSION["page"] == 1) {
        require_once('./src/pages/Accueil.php');
    } elseif ($_SESSION["page"] == 2) {
        require_once('./src/pages/Inscription.php');
    } elseif ($_SESSION["page"] == 3) {
        require_once('./src/pages/Connexion.php');
    } else {
        require_once('./src/pages/Accueil.php'); 
    }
}

?>
</body>
<?php
require_once("./src/components/footer.php");
?>