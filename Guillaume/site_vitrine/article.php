<?php
include 'includes/db.php';
$id = intval($_GET['id']);
$res = $conn->query("SELECT a.*, c.nom as cat FROM article a LEFT JOIN categorie c ON a.id_categorie = c.id WHERE a.id=$id LIMIT 1");
$a = $res->fetch_assoc();
if (!$a) die('Article introuvable');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($a['titre']) ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($a['titre']) ?></h1>
    <h3><?= htmlspecialchars($a['sous_titre']) ?></h3>
    <p><strong>Catégorie :</strong> <?= $a['cat'] ?></p>
    <?php if ($a['image']): ?>
        <img src="images/<?= $a['image'] ?>" width="300">
    <?php endif; ?>
    <p><?= nl2br(htmlspecialchars($a['contenu'])) ?></p>
    <p><a href="index.php">← Retour</a></p>
</body>
</html>