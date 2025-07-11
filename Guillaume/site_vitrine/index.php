<?php
include 'refonte/db.php';
$stmt = $db->prepare("SELECT * FROM article ORDER BY date_publication DESC LIMIT 5");
$stmt->execute();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
</head>
<body>
<h1>Articles récents</h1>
<?php while ($a = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
    <div>
        <h2><?= htmlspecialchars($a['titre']) ?></h2>
        <?php if (!empty($a['image1'])): ?>
            <img src="public/images/<?= htmlspecialchars($a['image1']) ?>" width="200">
        <?php endif; ?>
        <p><?= substr(strip_tags($a['article']), 0, 150) ?>...</p>
        <a href="article.php?id=<?= $a['id'] ?>">Lire plus</a>
    </div>
    <hr>
<?php endwhile; ?>
</body>
</html>
