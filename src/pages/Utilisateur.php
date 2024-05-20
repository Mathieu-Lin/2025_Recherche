<?php
require_once("./src/requests/fUtilisateur.php");
$user = getUtilisateur($conn, $_SESSION["user"]);  // Retrieve a specific user

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];  // Consider hashing this before storing
    $description = $_POST['description'];
    $id = $_POST['id'];  // Ensure this ID is passed securely

    // Call the update function
    if (updateUtilisateur($conn, $id, $email, $phone_number, $password, $description)) {
        echo "<p>Update successful.</p>";
    } else {
        echo "<p>Error during update.</p>";
    }

    // Refresh user data
    $user = getUtilisateur($conn);
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./src/styles/Global.css">
    <link rel="stylesheet" type="text/css" href="./src/styles/Utilisateur.css">
    <title>PolyRecherche - Profil Utilisateur</title>
</head>

<body>
    <?php require_once("./src/components/header.php"); ?>
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-image">
                <img src="athy.jpg" alt="Image de profil">
            </div>
            <button class="btn">Changer la photo</button>
        </div>
        <div class="profile-form">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <label for="lastname">Nom de famille</label>
                <div id="lastname"><?php echo htmlspecialchars($user['lastname']); ?></div>

                <label for="firstname">Prénom</label>
                <div id="firstname"><?php echo htmlspecialchars($user['firstname']); ?></div>

                <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">

                <label for="phone_number">Numéro de téléphone</label>
                <input type="tel" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>">

                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($user['password']); ?>">

                <label for="description">Description</label>
                <textarea id="description" name="description"><?php echo htmlspecialchars($user['description']); ?></textarea>

                <button type="submit" class="btn">Sauvegarder</button>
            </form>
        </div>
    </div>
    <?php
    require_once("./src/components/footer.php");
    ?>
</body>