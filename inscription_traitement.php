<?php
/*Connexion à la base de données sur le serveur tp-epua*/
$conn = @mysqli_connect("tp-epua:3308", "sbaisa", "3h4pqAgf");        
/*connexion à la base de donnée depuis la machine virtuelle INFO642*/
/*$conn = @mysqli_connect("localhost", "etu", "bdtw2021");*/  
if (mysqli_connect_errno()) {
    $msg = "erreur ". mysqli_connect_error();
} else {  
    $msg = "connecté au serveur " . mysqli_get_host_info($conn);
    /*Sélection de la base de données*/
    mysqli_select_db($conn, "sbaisa"); 
    /*mysqli_select_db($conn, "etu"); */ /*sélection de la base sous la VM info642*/

    /*Encodage UTF8 pour les échanges avecla BD*/
    mysqli_query($conn, "SET NAMES UTF8");
}    


if(isset($_POST['ok'])){
    $nom=$_POST["nom"];
    $prenom=$_POST["prenom"];
    $mail=$_POST["mail"];
    $mdp=$_POST["mdp"];
    $date_inscription = date("Y-m-d");
    $sql = "INSERT INTO 2025_users (lastname,firstname,email,password,registration_date,update_date)  VALUES ('".$nom."', '".$prenom."', '".$mail."', '".$mdp."', '".$date_inscription."','".$date_inscription."');";
    $result =  mysqli_query($conn, $sql) or die("Requête invalide : ". mysqli_error($conn)."</br>".$sql);
    // Vérifiez si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        header("Location: connexion.php");
        exit();
    }      
}   

?>
