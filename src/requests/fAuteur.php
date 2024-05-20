<?php
function connectDatabase()
{
    $conn = @mysqli_connect("tp-epua:3308", "login", "mdp");

    if (mysqli_connect_errno()) {
        echo "Erreur de connexion : " . mysqli_connect_error();
        exit();
    } else {
        mysqli_select_db($conn, "login");
        mysqli_query($conn, "SET NAMES UTF8");
    }
    return $conn;
}

function getAuteur($conn, $id)
{
    $query = "SELECT * FROM 2025_authors WHERE id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }
    $stmt->bind_param('i', $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function updateAuteur($conn, $id, $email, $phone_number, $job, $description)
{
    $sql = "UPDATE `2025_authors` SET email=?, phone_number=?, job=?, description=?, update_date=NOW() WHERE id=?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }
    $stmt->bind_param('ssssi', $email, $phone_number, $job, $description, $id);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function getPublications($conn, $author_id)
{
    $query = "
        SELECT p.*, a.pdf_link, a.article_link, a.video_link
        FROM 2025_publications p
        JOIN 2025_publish pub ON p.id = pub.id_publication
        LEFT JOIN 2025_links l ON p.id = l.id_publication
        LEFT JOIN 2025_attachments a ON l.id_attachment = a.id
        WHERE pub.id_author = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }
    $stmt->bind_param('i', $author_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
