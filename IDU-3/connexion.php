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




    $error_msg = "";

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $mail=$_POST["mail"];
        $mdp=$_POST["mdp"];
        $sql = "SELECT * FROM 2025_users WHERE email='$mail' AND password='$mdp'" ;
        $result =  mysqli_query($conn, $sql) or die("Requête invalide : ". mysqli_error($conn)."</br>".$sql);
        $user = mysqli_fetch_assoc($result);
        if($user && $user['id']){ 
            header("Location: accueil.php");
            exit;
        }
    
        else{
            $error_msg="Votre email ou mot de passe est incorrecte";
        }
    }
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RechercheApp</title>
    <link rel="stylesheet" href="connexion.css">
</head>
<h1>Page de connexion</h1>
<body>

    <div class="logo-container">
        <img src="logo.png" alt="PolyRecherche Logo" class="logo">
    </div>
    <form method="POST" action="">
        <label for="MAIL"></label>
        <input type="email" id="MAIL" name="mail" placeholder="Email..." required>
        <br/>
        <label for="MDP"></label>
        <input type="password" id="MDP" name="mdp" placeholder="Mot de passe..." required>
        <br/>
        <input type="submit" Value="Se connecter" name="ok" required>
        <br/>
    </form>
    <?php
    if($error_msg){
        ?>
        <p><?php echo $error_msg; ?></p>
    <?php 

}
?>

</body>
</html>


