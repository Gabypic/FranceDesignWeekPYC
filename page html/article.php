<?php
include 'db.php';
include 'includes/header.html';
?>

<!-- Bannière avec titre superposé -->
<section class="banner">
    <img src="public/article/Rectangle_182.png" alt="Bannière" class="banniere-img">
    <h1 class="banner-title">ARTICLES</h1>
</section>




<?php
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
    <style>
        html, body {
            overflow-x: hidden; /* supprime le scroll horizontal */
        }

        .banner {
            width: 100%;
            height: 400px;
            position: relative; /* pour que le texte soit positionné par rapport à l'image */
            overflow: hidden;
        }

        .banniere-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .banner-title {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #ffffff;
            font-weight: 900;
            font-size: 64px;
            text-align: center;
        }




    </style>
</head>
</html>
