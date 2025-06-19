<?php
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit;
}

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'site_vitrine_test';

$conn = @new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_errno) {
    error_log("Erreur DB: " . $conn->connect_error);
    http_response_code(500);
    die("Impossible de se connecter à la base de données.");
}

$conn->set_charset("utf8mb4");
