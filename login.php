<?php

header('Content-Type: application/json');

include 'db/db.php';

startConnect(); // Start Connection

// Check if Email and password are in the URL.
if (isset($_GET["email"], $_GET["password"])) {
    $email = htmlspecialchars($_GET["email"]); // Get Email
    $password = htmlspecialchars($_GET["password"]); // Get Password

    $hashpass = hash('sha256', $password); // Hash Password (Crypt Password sha256)

    // Check if email exists.
    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows >= 1) {
        $row = $result->fetch_assoc();
        $passw = $row["password"];

        // Check if the hashed password matches the stored password.
        if ($hashpass === $passw) {
            echo json_encode(true);
        } else {
            echo json_encode("password_incorrect");
        }
    } else {
        echo json_encode("account_not_exist");
    }
} else {
    echo json_encode("missing_information");
}

stopConnect(); // Stop Connection

?>
