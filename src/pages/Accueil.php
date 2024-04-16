<!DOCTYPE html>
<html lang="en">

<?php
// Session 
$_SESSION['page'] = 1;
// Les fonctions importés : 
require_once("./src/requests/F_BDD_Accueil.php");
?>

<head>
    <meta charset="UTF-8">
    <?php  //css a ajouter apres 
    ?>
    <link rel="stylesheet" type="text/css" href="./src/styles/Global.css">
    <link rel="stylesheet" type="text/css" href="./src/styles/Accueil.css">
    <title>PolyRecherche - Accueil</title>
</head>

<body>
    <?php
    echo "<h5> Coucou </h5>";
    var_dump($conn); // Connection SQL

    ?>
</body>