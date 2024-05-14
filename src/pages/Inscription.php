<?php
$_SESSION['page'] = 2;
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
<form action="" method="post">
    <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Mot de passe:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>
</body>