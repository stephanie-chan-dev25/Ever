<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ever";

// Connexion
$conn = new mysqli($host, $user, $pass, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("❌ Connexion échouée : " . $conn->connect_error);
}
?>