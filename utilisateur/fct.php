<?php
function connectDatabase() {
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

function getUtilisateur($conn) {
    $query = "SELECT * FROM 2025_users WHERE id = 1"; // Example with a fixed ID for demonstration
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

function updateUtilisateur($conn, $id, $email, $phone_number, $password, $description) {
    // Update query without updating the lastname and firstname
    $sql = "UPDATE `2025_users` SET email=?, phone_number=?, password=?, description=?, update_date=NOW() WHERE id=?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    // Bind parameters: email, phone_number, password, description, and id
    $stmt->bind_param('ssssi', $email, $phone_number, $password, $description, $id);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

?>
