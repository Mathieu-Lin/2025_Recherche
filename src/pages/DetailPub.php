<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./src/styles/Publications.css">
    <link rel="stylesheet" type="text/css" href="./src/styles/Global.css">
    <title>Détails de la Publication</title>
</head>

<body>
    <?php
    require_once("./src/components/header.php");

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $publication_id = intval($_GET['id']);

        // Requête pour obtenir les détails de la publication
        $stmt = $conn->prepare("SELECT p.id, p.title, p.description, p.type, p.publication_date, p.update_date, e.name AS editor_name 
                                FROM 2025_publications AS p
                                LEFT JOIN 2025_editors AS e ON p.id_editor = e.id
                                WHERE p.id = ?");
        $stmt->bind_param("i", $publication_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<div class='publication-detail'>";
            echo "<h2>" . $row["title"] . "</h2>";
            echo "<p><strong>Description:</strong> " . $row["description"] . "</p>";
            echo "<p><strong>Type:</strong> " . $row["type"] . "</p>";
            echo "<p><strong>Date de Publication:</strong> " . $row["publication_date"] . "</p>";
            echo "<p><strong>Dernière mise à jour:</strong> " . $row["update_date"] . "</p>";
            echo "<p><strong>Éditeur:</strong> " . $row["editor_name"] . "</p>";

            // Requête pour obtenir les auteurs de la publication
            $stmt2 = $conn->prepare("SELECT a.firstname, a.lastname 
                                     FROM 2025_authors AS a 
                                     JOIN 2025_publish AS p ON p.id_author = a.id 
                                     WHERE p.id_publication = ?");
            $stmt2->bind_param("i", $publication_id);
            $stmt2->execute();
            $result2 = $stmt2->get_result();

            if ($result2->num_rows > 0) {
                echo "<p><strong>Auteurs:</strong> ";
                $authors = array();
                while ($row2 = $result2->fetch_assoc()) {
                    $authors[] = $row2["firstname"] . " " . $row2["lastname"];
                }
                echo implode(", ", $authors);
                echo "</p>";
            }

            // Requête pour obtenir les liens des pièces jointes
            $stmt3 = $conn->prepare("SELECT a.pdf_link, a.article_link, a.video_link 
                                     FROM 2025_attachments AS a
                                     JOIN 2025_links AS l ON l.id_attachment = a.id
                                     WHERE l.id_publication = ?");
            $stmt3->bind_param("i", $publication_id);
            $stmt3->execute();
            $result3 = $stmt3->get_result();

            if ($result3->num_rows > 0) {
                echo "<p><strong>Liens:</strong> ";
                while ($row3 = $result3->fetch_assoc()) {
                    if (!empty($row3['pdf_link'])) {
                        echo "<a href='" . $row3['pdf_link'] . "'>PDF</a> ";
                    }
                    if (!empty($row3['article_link'])) {
                        echo "<a href='" . $row3['article_link'] . "'>Article</a> ";
                    }
                    if (!empty($row3['video_link'])) {
                        echo "<a href='" . $row3['video_link'] . "'>Vidéo</a> ";
                    }
                }
                echo "</p>";
                echo "<a href='?page=Publications'><button>Retour</button></a>";
            }

            echo "</div>";
        } else {
            echo "<p>Publication non trouvée.</p>";
        }
    } else {
        echo "<p>ID de publication non valide.</p>";
    }

    require_once("./src/components/footer.php");
    ?>
</body>

</html>