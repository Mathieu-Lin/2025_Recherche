<?php
include 'fct.php';
$conn = connectDatabase();  // Establish the connection
$user = getUtilisateur($conn);  // Retrieve a specific user

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user form data
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

    // Retrieve publication form data
    $title = $_POST['title'];
    $description_pub = $_POST['description_pub']; // Changed the name to avoid conflict with user description
    $type = $_POST['type'];
    $publication_date = $_POST['publication_date'];
    $update_date = $_POST['update_date'];
    $title_type = $_POST['title_type'];
    $pages = $_POST['pages'];

    // Call the function to add the publication
    if (addPublication($conn, $title, $description_pub, $type, $publication_date, $update_date, $title_type, $pages)) {
        echo "<p>Publication added successfully.</p>";
    } else {
        echo "<p>Error during publication addition.</p>";
    }

    // Refresh user data
    $user = getUtilisateur($conn);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil Utilisateur</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-image">
                <img src="Pdp.png" alt="Image de profil">
            </div>
        </div>
        <div class="profile-form">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">

                <label for="lastname">Nom de famille</label>
                <input type="text" id="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" disabled>

                <label for="firstname">Prénom</label>
                <input type="text" id="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" disabled>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">

                <label for="phone_number">Numéro de téléphone</label>
                <input type="tel" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>">

                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($user['password']); ?>">

                <label for="description">Description</label>
                <textarea id="description" name="description"><?php echo htmlspecialchars($user['description']); ?></textarea>

                <div class="publication-section">
                    <h2>Ajouter une publication</h2>

                    <label for="title">Titre</label>
                    <input type="text" id="title" name="title">

                    <label for="description_pub">Description</label>
                    <textarea id="description_pub" name="description_pub"></textarea>

                    <label for="type">Type</label>
                    <input type="text" id="type" name="type">

                    <label for="publication_date">Date de publication</label>
                    <input type="date" id="publication_date" name="publication_date">

                    <label for="update_date">Date de mise à jour</label>
                    <input type="date" id="update_date" name="update_date">

                    <label for="title_type">Type de titre</label>
                    <input type="text" id="title_type" name="title_type">

                    <label for="pages">Pages</label>
                    <input type="number" id="pages" name="pages">
                </div>

                <button type="submit" class="btn">Sauvegarder</button>
            </form>
        </div>
    </div>
</body>
</html>
