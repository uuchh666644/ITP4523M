<?php
$hostname = "127.0.0.1";
$database = "projectDB";
$username = "root";
$password = "";
$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_errno) {
    die("Failed to connect: " . $conn->connect_error);
}
?>