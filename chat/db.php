<?php
$servername = "localhost"; // Change if your MySQL server is different
$username = "root"; // Change to your MySQL username
$password = ""; // Change to your MySQL password
$dbname = "elserag";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
