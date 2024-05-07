<?php
require_once('./../bd_app.php');
// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// // Fonction session_start() crée une session ou restaure celle trouvée sur le serveur, via l'identifiant						//
// // de session passé dans une requête GET, POST ou par un cookie.																//															//
// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
session_save_path('/home/' . $mysqlUsername . '/public_html/2025_Recherche/');
session_start();


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


    // SQL statements to create tables
    $tables = [
        "CREATE TABLE IF NOT EXISTS 2025_Recherche_chercheur(
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(100) NOT NULL,
        prenom VARCHAR(100) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        numero_tel VARCHAR(20) NOT NULL UNIQUE,
        mot_de_passe VARCHAR(255) NOT NULL,
        date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )",
        "CREATE TABLE IF NOT EXISTS 2025_Recherche_publication (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        titre VARCHAR(255) NOT NULL,
        lien_pdf VARCHAR(255),
        lien_article VARCHAR(255),
        description TEXT,
        type VARCHAR(50),
        date_publication DATE NOT NULL
    )",
        "CREATE TABLE IF NOT EXISTS 2025_Recherche_chercheur_publication (
        id_chercheur INT UNSIGNED NOT NULL,
        id_publication INT UNSIGNED NOT NULL,
        PRIMARY KEY (id_chercheur, id_publication),
        FOREIGN KEY (id_chercheur) REFERENCES 2025_Recherche_chercheur(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_publication) REFERENCES 2025_Recherche_publication(id) ON DELETE CASCADE ON UPDATE CASCADE
    )",
        "CREATE TABLE IF NOT EXISTS 2025_Recherche_citation_publication (
        id_publication INT UNSIGNED NOT NULL,
        id_citation INT UNSIGNED NOT NULL,
        PRIMARY KEY (id_publication, id_citation),
        FOREIGN KEY (id_citation) REFERENCES 2025_Recherche_publication(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_publication) REFERENCES 2025_Recherche_publication(id) ON DELETE CASCADE ON UPDATE CASCADE
    )"
        /** ,
        "CREATE TABLE IF NOT EXISTS 2025_Recherche_entreprise (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        titre VARCHAR(255) NOT NULL,
        lien VARCHAR(255),
        description TEXT
    )",
        "CREATE TABLE IF NOT EXISTS 2025_Recherche_pays (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        id_entreprise INT UNSIGNED NOT NULL,
        nom_pays VARCHAR(50) NOT NULL,
        FOREIGN KEY (id_entreprise) REFERENCES 2025_Recherche_entreprise(id) ON DELETE CASCADE ON UPDATE CASCADE
    )",
        "CREATE TABLE IF NOT EXISTS 2025_Recherche_domaine (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        id_entreprise INT UNSIGNED NOT NULL,
        nom_domaine VARCHAR(50) NOT NULL,
        FOREIGN KEY (id_entreprise) REFERENCES 2025_Recherche_entreprise(id) ON DELETE CASCADE ON UPDATE CASCADE
    )",
        "CREATE TABLE IF NOT EXISTS 2025_Recherche_chercheur_entreprise (
        id_chercheur INT UNSIGNED NOT NULL,
        id_entreprise INT UNSIGNED NOT NULL,
        PRIMARY KEY (id_chercheur, id_entreprise),
        FOREIGN KEY (id_chercheur) REFERENCES 2025_Recherche_chercheur(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_entreprise) REFERENCES 2025_Recherche_entreprise(id) ON DELETE CASCADE ON UPDATE CASCADE
    )"*/
    ];

    // Execute each SQL statement to create tables
    foreach ($tables as $sql) {
        if (!mysqli_query($conn, $sql)) {
            echo "Error creating table: " . mysqli_error($conn) . "\n";
        } else {
        }
    }
}
