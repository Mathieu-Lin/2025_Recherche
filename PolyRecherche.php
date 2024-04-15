<?php


require_once("./lib/Database.php");


if (!isset($_GET["url"])) {
    require_once('./src/pages/Accueil.php');
} else {
    require_once('./PolyRecherche.php');
}
