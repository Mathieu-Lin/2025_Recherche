<?php
require_once("./lib/Database.php");

if (!isset($_SESSION["page"])) {
    require_once('./src/pages/Accueil.php');
} else {
    // blabla
    if ($_SESSION["page"] == 1) {
        require_once('./src/pages/Accueil.php');
    } else {
        require_once('./2025_Recherche.php');
    }
}
