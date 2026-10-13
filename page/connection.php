<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ever";

function formatNumber($value): string {
    if ($value === null || $value === '') {
        return '0';
    }

    return number_format((float) $value, 0, ',', ' ');
}

// Database connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}
?>