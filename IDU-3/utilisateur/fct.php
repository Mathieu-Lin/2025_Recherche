<?php
function connectDatabase() {
    $conn = @mysqli_connect("tp-epua:3308", "dahmanei", "bMck3DRY");    

    if (mysqli_connect_errno()) {
        echo "Erreur de connexion : " . mysqli_connect_error();
        exit();
    } else {
        mysqli_select_db($conn, "dahmanei");
        mysqli_query($conn, "SET NAMES UTF8");
    }
    return $conn;
}

function getUtilisateur($conn) {
    $query = "SELECT * FROM 2025_users WHERE id = 1"; 
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

function updateUtilisateur($conn, $id, $email, $phone_number, $password, $description) {
    $sql = "UPDATE `2025_users` SET email=?, phone_number=?, password=?, description=?, update_date=NOW() WHERE id=?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    $stmt->bind_param('ssssi', $email, $phone_number, $password, $description, $id);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function addPublication($conn, $title, $description, $type, $publication_date, $update_date, $title_type, $pages) {
    $sql = "INSERT INTO `2025_publications` (title, description, type, publication_date, update_date, title_type, pages) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    $stmt->bind_param('ssssssi', $title, $description, $type, $publication_date, $update_date, $title_type, $pages);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
?>

