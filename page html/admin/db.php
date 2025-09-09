<?php
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit;
}

$host = 'localhost'; // ou "sqlXXX.hostingprovider.com"
$dbname = 'u336831863_site_vitrine';
$user = 'u336831863_user';
$pass = 'G9h@;1+hM3t';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Erreur DB: " . $e->getMessage());
    http_response_code(500);
    die("Impossible de se connecter à la base de données.");
}
