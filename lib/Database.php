<?php

// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// // Fonction session_start() crée une session ou restaure celle trouvée sur le serveur, via l'identifiant						//
// // de session passé dans une requête GET, POST ou par un cookie.																//
// // Fonction ob_start() permet d'utiliser les fonctions header.																	//
// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
session_save_path('/home/linm/public_html/Techno_web/PolyRecherche/'); /*à changer*/
ob_start();
session_start();

/*Connexion à la base de données sur le serveur tp-epua*/
$conn = @mysqli_connect("tp-epua:3308", "linm", "2dMy6nL4"); /*à changer*/

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
    mysqli_select_db($conn, "linm"); /*à changer*/
    /*mysqli_select_db($conn, "etu"); */ /*sélection de la base sous la VM info642*/

    /*Encodage UTF8 pour les échanges avecla BD*/
    mysqli_query($conn, "SET NAMES UTF8");


    /* Création d'une table */
    $sql = "CREATE TABLE IF NOT EXISTS PolyRecherche_Chercheur (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(30) NOT NULL,
        prenom VARCHAR(30) NOT NULL,
        email VARCHAR(50) NOT NULL,
        mot_de_passe VARCHAR(1000) NOT NULL,
        groupe VARCHAR(50),
        date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    mysqli_query($conn, $sql);
}
