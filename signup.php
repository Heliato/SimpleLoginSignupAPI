<?php

header('Content-Type: application/json');

include 'db/db.php';
include 'function/func-auth.php';

startConnect(); // Start Connection

// Check if Username, email and password is in URL.
if (isset($_GET["username"], $_GET["email"], $_GET["password"])) {
    $username = htmlspecialchars($_GET["username"]); // Get Username
    $email = htmlspecialchars($_GET["email"]); // Get Email
    $password = htmlspecialchars($_GET["password"]); // Get Password

    $hashpass = hash('sha256', $password); // Hash Password (Crypt Password sha256)

    // Check if Username is already taken.
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $verifUsername = verifUsernamePass($username); // Verif is correct Username.

        if ($verifUsername === "ok") {
            $verifEmail = verifEmailPass($email); // Verif is correct Email.

            if ($verifEmail) {
                // Insert in DB the information.
                $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $username, $email, $hashpass);
                $execute = $stmt->execute();

                echo json_encode($execute);
            } else {
                echo json_encode("email_has_incorrect");
            }
        } else {
            echo json_encode($verifUsername);
        }
    } else {
        echo json_encode("username_already_exist");
    }
} else {
    echo json_encode("missing_information");
}

stopConnect(); // Stop Connection

?>
