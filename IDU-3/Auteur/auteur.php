<?php
include 'fonctions.php';
$conn = connectDatabase();  // Établir la connexion à la base de données
$author = getAuteur($conn, 'Monnet');  // Récupérer l'auteur par son nom de famille

// Vérifier si l'auteur existe
if ($author) {
    // Récupérer les publications et les citations de l'auteur
    $publications = getPublications($conn, $author['id']);
}

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $job = $_POST['job'];
    $description = $_POST['description'];
    $id = $_POST['id'];  // Ensure this ID is passed securely

    // Call the update function
    if (updateAuteur($conn, $id, $email, $phone_number, $job, $description)) {
        echo "<p>Update successful.</p>";
    } else {
        echo "<p>Error during update.</p>";
    }

    // Refresh author data
    $author = getAuteur($conn, 'Monnet');
    $publications = getPublications($conn, $author['id']);
    $citations = getCitations($conn, $author['id']);
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Profil Auteur</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="profile-container">
        <h2>Profil de l'Auteur</h2>
        <!-- Inclure l'image -->
        <div class="profile-image">
            <img src="victor.jpg" alt="Image de l'auteur">
        </div>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($author['id']); ?>">

            <label for="lastname">Nom de famille</label>
            <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($author['lastname']); ?>" readonly>

            <label for="firstname">Prénom</label>
            <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($author['firstname']); ?>" readonly>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($author['email']); ?>" readonly>

            <label for="phone_number">Numéro de téléphone</label>
            <input type="tel" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($author['phone_number']); ?>" readonly>

            <label for="job">Profession</label>
            <input type="text" id="job" name="job" value="<?php echo htmlspecialchars($author['job']); ?>" readonly>

            <label for="description">Description</label>
            <textarea id="description" name="description" readonly><?php echo htmlspecialchars($author['description']); ?></textarea>
        </form>

        <!-- Afficher les publications de l'auteur -->
        <div class="publications">
            <h3>Publications de l'Auteur</h3>
            <ol>
                <?php if (!empty($publications)) {
                    foreach ($publications as $publication) {
                        echo "<li>";
                        echo "<a href=\"" . (!empty($publication['article_link']) ? $publication['article_link'] : '#') . "\">{$publication['title']}</a>";
                        if (!empty($publication['pdf_link'])) {
                            echo " | <a href=\"{$publication['pdf_link']}\">Lien du PDF</a>";
                        }
                        if (!empty($publication['video_link'])) {
                            echo " | <a href=\"{$publication['video_link']}\">Lien de la Vidéo</a>";
                        }
                        echo "</li>";
                    }
                } else {
                    echo "<li>Aucune donnée trouvée</li>";
                } ?>
            </ol>
        </div>


    </div>
</body>

</html>