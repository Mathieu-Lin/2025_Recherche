<?php
require_once('./../bd_app.php');
// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// // Fonction session_start() crée une session ou restaure celle trouvée sur le serveur, via l'identifiant						//
// // de session passé dans une requête GET, POST ou par un cookie.																//															//
// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
session_save_path('/home/' . $mysqlUsername . '/public_html/2025_Recherche/');
session_start();

if ($_SESSION["user"] == null) {
    $_SESSION["user"] = "";
}
if ($_SESSION["id_author"] == null) {
    $_SESSION["id_author"] = "";
}

/*Connexion à la base de données sur le serveur tp-epua*/
$conn = @mysqli_connect($mysqlHost, $mysqlUsername, $mysqlPassword);

/*connexion à la base de donnée depuis la machine virtuelle INFO642*/
/*$conn = @mysqli_connect("localhost", "etu", "bdtw2021");*/

if (mysqli_connect_errno()) {
    $msg = "erreur " . mysqli_connect_error();
} else {
    $msg = "connecté au serveur " . mysqli_get_host_info($conn);
    //////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////
    /* Création d'une base des données */
    //$sql = "CREATE DATABASE IF NOT EXISTS PolyRecherche";
    //$conn->query($sql);

    //////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////
    /*Sélection de la base de données*/
    mysqli_select_db($conn, $mysqlDatabase);
    /*mysqli_select_db($conn, "etu"); */ /*sélection de la base sous la VM info642*/

    /*Encodage UTF8 pour les échanges avecla BD*/
    mysqli_query($conn, "SET NAMES UTF8");
}
