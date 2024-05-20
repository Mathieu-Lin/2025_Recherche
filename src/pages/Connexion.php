<?php
$check = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = $_POST["mail"];
    $mdp = $_POST["mdp"];
    $sql = "SELECT * FROM 2025_users WHERE email='$mail' AND password='$mdp'";
    $result =  mysqli_query($conn, $sql) or die("Requête invalide : " . mysqli_error($conn) . "</br>" . $sql);
    $user = mysqli_fetch_assoc($result);
    if ($user && $user['id']) {
        $_SESSION["user"] = $user['id'];
        $_SESSION["id_author"] = $user['id_author'];
        $check = true;
    } else {
        $error_msg = "Votre email ou mot de passe est incorrecte";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./src/styles/Global.css">
    <link rel="stylesheet" type="text/css" href="./src/styles/Connexion.css">
    <title>PolyRecherche - Connexion</title>
</head>


<body>
    <div class="container">
        <?php
        if ($check == false) {
        ?>
            <h1>Page de connexion</h1>
            <div class="logo-container">
                <img src="./assets/poly.png" alt="PolyRecherche Logo" class="logo">
            </div>
            <form method="POST" action="">
                <label for="MAIL"></label>
                <input type="email" id="MAIL" name="mail" placeholder="Email..." required>
                <br />
                <label for="MDP"></label>
                <input type="password" id="MDP" name="mdp" placeholder="Mot de passe..." required>
                <br />
                <input type="submit" Value="Se connecter" name="ok" required>
                <br />
                <input type="button" Value="Retour" class="link-button" onclick="window.location.href='?page=Accueil';">
                <br />
            </form>
        <?php
        } else {

        ?>
            <h1>Vous êtes connecté</h1>
            <div class="logo-container">
                <img src="./assets/poly.png" alt="PolyRecherche Logo" class="logo">
            </div>
            <form method="POST" action="">
                <input type="button" Value="Retour" class="link-button" onclick="window.location.href='?page=Accueil';">
                <br />
            </form>
        <?php
        } ?>
    </div>


</body>

</html>