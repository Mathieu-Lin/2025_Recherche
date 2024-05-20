<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./src/styles/Publications.css">
    <link rel="stylesheet" type="text/css" href="./src/styles/Global.css">
    <title>PolyRecherche - Publications</title>
</head>

<body>
    <?php require_once("./src/components/header.php"); ?>
    <div class="container">
        <!-- Formulaire de recherche -->
        <div class="search-form">
            <form action="index.php" method="GET">
                <input type="text" name="search" placeholder="Rechercher...">
                <button type="submit">Rechercher</button>
            </form>
        </div>

        <!-- Affichage des publications -->
        <?php
        // Nombre d'articles à afficher par page
        $articlesParPage = 5;

        // Page actuelle
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = intval($_GET['page']);
        } else {
            $page = 1;
        }

        // Calcul du point de départ de la requête SQL
        $offset = ($page - 1) * $articlesParPage;

        // Requête SQL pour récupérer les publications de la page actuelle
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $_GET['search'];
            $sql = "SELECT p.id, p.title, p.publication_date , p.update_date FROM 2025_publications AS p WHERE p.title LIKE '%$search%' LIMIT $offset, $articlesParPage";
        } else {
            $sql = "SELECT p.id, p.title, p.publication_date, p.update_date FROM 2025_publications AS p LIMIT $offset, $articlesParPage";
        }
        $result = $conn->query($sql);

        // Affichage des publications
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $publication_id = $row['id'];
                echo "<div class='publication'>";
                echo "<h2>" . $row["title"] . "</h2>"; // Titre

                // Requête pour récupérer les auteurs de la publication actuelle
                $sql2 = "SELECT a.firstname, a.lastname FROM 2025_authors AS a JOIN 2025_publish AS p ON p.id_author = a.id WHERE p.id_publication = $publication_id";
                $result2 = $conn->query($sql2);

                // Affichage des auteurs
                if ($result2->num_rows > 0) {
                    echo "<p><strong>Auteurs:</strong> ";
                    $authors = array();
                    while ($row2 = $result2->fetch_assoc()) {
                        $authors[] = $row2["firstname"] . " " . $row2["lastname"];
                    }
                    echo implode(", ", $authors);
                    echo "</p>";
                }
                echo "<p>Date de Publication: " . $row["publication_date"] . "</p>";
                echo "<p>Dernière mise à jour: " . $row["update_date"] . "</p>";

                // Ajoutez la logique pour afficher le contenu et la date de publication si nécessaire

                echo "</div>";
                // Ajout du bouton pour voir la publication
                echo "<a href='publication.php?id=$publication_id'><button>Voir la publication</button></a>";
            }
        } else {
            echo "<p>Aucune publication trouvée.</p>";
        }

        // Calcul du nombre total de pages
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $_GET['search'];
            $sql = "SELECT COUNT(*) AS total FROM 2025_publications WHERE title LIKE '%$search%'";
        } else {
            $sql = "SELECT COUNT(*) AS total FROM 2025_publications";
        }
        $result = $conn->query($sql);
        $donnees = $result->fetch_assoc();
        $totalArticles = $donnees['total'];
        $totalPages = ceil($totalArticles / $articlesParPage);
        ?>

        <!-- Pagination -->
        <div class="pagination">
            <?php
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($i === $page) {
                    echo "<a href='index.php?page=$i' class='current'>$i</a>";
                } else {
                    echo "<a href='index.php?page=$i'>$i</a>";
                }
            }
            ?>
        </div>
    </div>

    <?php require_once("./src/components/footer.php"); ?>

</body>

</html>