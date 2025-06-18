<?php
include 'includes/db.php';

$id = intval($_GET['id']);
$res = $conn->query("SELECT * FROM article WHERE id=$id LIMIT 1");
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

<p><strong>Auteur :</strong> <?= htmlspecialchars($a['auteur']) ?></p>
<p><strong>Date de publication :</strong> <?= htmlspecialchars($a['date_publication']) ?></p>

<?php if (!empty($a['image1'])): ?>
    <img src="<?= htmlspecialchars($a['image1']) ?>" width="300" alt="Image 1">
<?php endif; ?>

<?php if (!empty($a['image2'])): ?>
    <img src="<?= htmlspecialchars($a['image2']) ?>" width="300" alt="Image 2">
<?php endif; ?>

<?php if (!empty($a['video'])): ?>
    <div>
        <video width="480" controls>
            <source src="<?= htmlspecialchars($a['video']) ?>" type="video/mp4">
            Votre navigateur ne supporte pas la lecture de vidéos.
        </video>
    </div>
<?php endif; ?>

<p><?= nl2br(htmlspecialchars($a['article'])) ?></p>

<p><a href="index.php">← Retour</a></p>
</body>
</html>
