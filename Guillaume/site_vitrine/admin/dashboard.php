<?php
session_start();
if (!isset($_SESSION['auth'])) die('Accès refusé');
include '../includes/db.php';
echo '<p><a href="logout.php">Déconnexion</a></p>';

$timeout = 30;
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}
$_SESSION['last_activity'] = time();

if (isset($_POST['submit_article'])) {
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $contenu = $_POST['article'];
    $modele = intval($_POST['modele']);
    if ($modele < 1 || $modele > 4) die("Modèle invalide.");

    $id_art = $_POST['id_article'] ?? null;

    $image1 = null;
    $image2 = null;
    $video = null;

    if (!empty($_FILES['image1']['name'])) {
        $image1 = uniqid() . '_' . basename($_FILES['image1']['name']);
        move_uploaded_file($_FILES['image1']['tmp_name'], "../images/$image1");
    }
    if (!empty($_FILES['image2']['name'])) {
        $image2 = uniqid() . '_' . basename($_FILES['image2']['name']);
        move_uploaded_file($_FILES['image2']['tmp_name'], "../images/$image2");
    }
    if (!empty($_FILES['video']['name'])) {
        $video = uniqid() . '_' . basename($_FILES['video']['name']);
        move_uploaded_file($_FILES['video']['tmp_name'], "../videos/$video");
    }

    if ($id_art) {
        $sql = "UPDATE article SET titre=?, article=?, auteur=?, modele=?";
        $types = "sssi";
        $params = [$titre, $contenu, $auteur, $modele];

        if ($image1 !== null) {
            $sql .= ", image1=?";
            $types .= "s";
            $params[] = $image1;
        }
        if ($image2 !== null) {
            $sql .= ", image2=?";
            $types .= "s";
            $params[] = $image2;
        }
        if ($video !== null) {
            $sql .= ", video=?";
            $types .= "s";
            $params[] = $video;
        }

        $sql .= " WHERE id=?";
        $types .= "i";
        $params[] = $id_art;

        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
    } else {
        $stmt = $conn->prepare("INSERT INTO article (titre, article, image1, image2, video, auteur, modele) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssi", $titre, $contenu, $image1, $image2, $video, $auteur, $modele);
    }
    $stmt->execute();
}

if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    $conn->query("DELETE FROM article WHERE id=$id");
}

$edit = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $edit = $conn->query("SELECT * FROM article WHERE id=$id")->fetch_assoc();
}

$search = $_GET['q'] ?? '';
$where = $search ? "WHERE titre LIKE '%$search%'" : '';
$par_page = 5;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $par_page;

$arts = $conn->query("SELECT * FROM article $where ORDER BY date_publication DESC LIMIT $offset, $par_page");
$total_res = $conn->query("SELECT COUNT(*) as t FROM article $where")->fetch_assoc();
$pages = ceil($total_res['t'] / $par_page);
?>

<h1>Tableau de bord</h1>

<form method="post" enctype="multipart/form-data">
    <h3><?= $edit ? 'Modifier' : 'Nouvel' ?> article</h3>
    <input type="hidden" name="id_article" value="<?= $edit['id'] ?? '' ?>">
    <input type="text" name="titre" placeholder="Titre" value="<?= $edit['titre'] ?? '' ?>" required><br>
    <input type="text" name="auteur" placeholder="Auteur" value="<?= $edit['auteur'] ?? '' ?>" required><br>

    <label for="modele">Modèle (1 à 4) :</label>
    <input type="number" name="modele" id="modele" min="1" max="4" value="<?= $edit['modele'] ?? 1 ?>" required><br>

    <textarea name="article" placeholder="Contenu de l'article" required><?= $edit['article'] ?? '' ?></textarea><br>

    <div id="image1_field">
        <label>Image 1 : <input type="file" name="image1"></label><br>
    </div>
    <div id="image2_field">
        <label>Image 2 : <input type="file" name="image2"></label><br>
    </div>
    <div id="video_field">
        <label>Vidéo : <input type="file" name="video" accept="video/*"></label><br>
    </div>

    <button name="submit_article"><?= $edit ? 'Modifier' : 'Publier' ?></button>
</form>

<form method="get">
    <input type="text" name="q" placeholder="Recherche par titre" value="<?= htmlspecialchars($search) ?>">
    <button>Rechercher</button>
</form>

<h3>Articles existants</h3>
<table border="1" cellpadding="5">
    <tr><th>ID</th><th>Titre</th><th>Auteur</th><th>Modèle</th><th>Action</th></tr>
    <?php while($a = $arts->fetch_assoc()): ?>
        <tr>
            <td><?= $a['id'] ?></td>
            <td><?= htmlspecialchars($a['titre']) ?></td>
            <td><?= htmlspecialchars($a['auteur']) ?></td>
            <td><?= $a['modele'] ?></td>
            <td>
                <a href="?edit=<?= $a['id'] ?>">✏️</a>
                <a href="?del=<?= $a['id'] ?>" onclick="return confirm('Supprimer ?')">🗑️</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<?php if ($pages > 1): ?>
    <p>Pages :
        <?php for ($i = 1; $i <= $pages; $i++): ?>
            <a href="?page=<?= $i ?>&q=<?= urlencode($search) ?>" <?= $i == $page ? 'style="font-weight:bold"' : '' ?>><?= $i ?></a>
        <?php endfor; ?>
    </p>
<?php endif; ?>

<script>
    function updateFields() {
        const modele = parseInt(document.getElementById('modele').value);
        const img1 = document.getElementById('image1_field');
        const img2 = document.getElementById('image2_field');
        const video = document.getElementById('video_field');

        img1.style.display = 'none';
        img2.style.display = 'none';
        video.style.display = 'none';

        if (modele === 1) {
            img1.style.display = 'block';
            img2.style.display = 'block';
        } else if (modele === 2) {
            img1.style.display = 'block';
            video.style.display = 'block';
        } else if (modele === 4) {
            video.style.display = 'block';
        }
    }
    document.getElementById('modele').addEventListener('input', updateFields);
    window.addEventListener('DOMContentLoaded', updateFields);
</script>
