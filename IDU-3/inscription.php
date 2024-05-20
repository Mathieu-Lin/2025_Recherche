<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RechercheApp</title>
    <link rel="stylesheet" href="inscription.css">
</head>
<h1>Page d'inscription</h1>

<body>
    <div class="logo-container">
        <img src="./assets/poly.png" alt="PolyRecherche Logo" class="logo">
    </div>
    <form method="POST" action="traitement.php">

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

    </form>

</body>