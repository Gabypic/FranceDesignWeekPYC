<?php
$h = 'localhost';
$u = 'root';
$p = '';
$db = 'site_vitrine_test';
$conn = new mysqli($h, $u, $p, $db);
if ($conn->connect_error) die('Erreur connexion DB');
?>