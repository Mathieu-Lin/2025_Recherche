<?php
$result = false;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ok'])) {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $mail = $_POST["mail"];
    $mdp = $_POST["mdp"];
    $date_inscription = date("Y-m-d");

    // Utilisez une déclaration préparée pour sécuriser la requête SQL
    $stmt = $conn->prepare("INSERT INTO 2025_users (lastname, firstname, email, password, registration_date, update_date) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Erreur lors de la préparation de la requête : " . $conn->error);
    }

    $stmt->bind_param("ssssss", $nom, $prenom, $mail, $mdp, $date_inscription, $date_inscription);
    $result = $stmt->execute();
    if ($result === false) {
        die("Erreur lors de l'exécution de la requête : " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./src/styles/Global.css">
    <link rel="stylesheet" type="text/css" href="./src/styles/Inscription.css">
    <title>PolyRecherche - Inscription</title>
</head>

<body>
    <div class="container">
        <h1>Page d'inscription</h1>
        <div class="logo-container">
            <img src="./assets/poly.png" alt="PolyRecherche Logo" class="logo">
        </div>
        <form method="POST" action="">
            <?php
            if ($result != false) {
                echo "<h2> Votre compte a été crée </h2>";
            }
            ?>
            <label for="NOM"></label>
            <input type="text" id="NOM" name="nom" placeholder="Nom..." required>
            <br />
            <label for="PRENOM"></label>
            <input type="text" id="PRENOM" name="prenom" placeholder="Prenom..." required>
            <br />
            <label for="MAIL"></label>
            <input type="email" id="MAIL" name="mail" placeholder="Email..." required>
            <br />
            <label for="MDP"></label>
            <input type="password" id="MDP" name="mdp" placeholder="Mot de passe..." required>
            <br />
            <input type="submit" Value="Cree mon compte" name="ok" required>
            <br />
            <input type="button" Value="Retour" class="link-button" onclick="window.location.href='?page=Accueil';">
            <br />
        </form>

    </div>
</body>