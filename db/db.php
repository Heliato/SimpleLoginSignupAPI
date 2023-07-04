<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "example";

$conn;

function startConnect() {
    global $servername, $username, $password, $dbname, $conn;
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Error connect: " . mysqli_connect_error());
    }
}
function stopConnect() {
    global $conn;
    $conn = mysqli_close($conn);
}

?>