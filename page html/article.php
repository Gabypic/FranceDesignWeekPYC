<?php
include 'db.php';
include 'includes/header.html';

$stmt = $db->query("SELECT * FROM article ORDER BY id DESC");
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

$allowed_models = [1, 2, 3, 4];

foreach ($articles as $article) {
    $modele = intval($article['modele']);
    $id = $article['id'];

    if (in_array($modele, $allowed_models)) {
        $filename = "modeles/modele{$modele}.php";
        $current_article = $article;
        include $filename;
    } else {
        echo "<p>Modèle non reconnu pour l'article ID $id</p>";
    }
}

include 'includes/footer.html';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Articles</title>
</head>
</html>
