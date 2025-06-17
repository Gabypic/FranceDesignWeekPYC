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


if (isset($_POST['new_cat']) && !empty($_POST['cat_nom'])) {
    $stmt = $conn->prepare("INSERT INTO categorie (nom) VALUES (?)");
    $stmt->bind_param("s", $_POST['cat_nom']);
    $stmt->execute();
}

if (isset($_POST['submit_article'])) {
    $titre = $_POST['titre'];
    $sous_titre = $_POST['sous_titre'];
    $contenu = $_POST['contenu'];
    $id_cat = $_POST['categorie'];
    $id_art = $_POST['id_article'] ?? null;
    $image = null;
    if (!empty($_FILES['image']['name'])) {
        $image = uniqid() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../images/$image");
    }

    if ($id_art) {
        if ($image) {
            $stmt = $conn->prepare("UPDATE article SET titre=?, sous_titre=?, image=?, contenu=?, id_categorie=? WHERE id=?");
            $stmt->bind_param("ssssii", $titre, $sous_titre, $image, $contenu, $id_cat, $id_art);
        } else {
            $stmt = $conn->prepare("UPDATE article SET titre=?, sous_titre=?, contenu=?, id_categorie=? WHERE id=?");
            $stmt->bind_param("sssii", $titre, $sous_titre, $contenu, $id_cat, $id_art);
        }
    } else {
        $stmt = $conn->prepare("INSERT INTO article (titre, sous_titre, image, contenu, id_categorie) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $titre, $sous_titre, $image, $contenu, $id_cat);
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

$cats = $conn->query("SELECT * FROM categorie");
$arts = $conn->query("SELECT a.*, c.nom as cat FROM article a LEFT JOIN categorie c ON a.id_categorie = c.id $where ORDER BY a.date_publication DESC LIMIT $offset, $par_page");
$total_res = $conn->query("SELECT COUNT(*) as t FROM article a $where")->fetch_assoc();
$pages = ceil($total_res['t'] / $par_page);
?>
<h1>Tableau de bord</h1>

<form method="post">
    <h3>Nouvelle catégorie</h3>
    <input type="text" name="cat_nom" placeholder="Nom catégorie" required>
    <button name="new_cat">Ajouter</button>
</form>

<form method="post" enctype="multipart/form-data">
    <h3><?= $edit ? 'Modifier' : 'Nouvel' ?> article</h3>
    <input type="hidden" name="id_article" value="<?= $edit['id'] ?? '' ?>">
    <input type="text" name="titre" placeholder="Titre" value="<?= $edit['titre'] ?? '' ?>" required><br>
    <input type="text" name="sous_titre" placeholder="Sous-titre" value="<?= $edit['sous_titre'] ?? '' ?>"><br>
    <select name="categorie" required>
        <option value="">-- Catégorie --</option>
        <?php
        $rescat = $conn->query("SELECT * FROM categorie");
        while($c = $rescat->fetch_assoc()): ?>
            <option value="<?= $c['id'] ?>" <?= ($edit && $edit['id_categorie'] == $c['id']) ? 'selected' : '' ?>><?= $c['nom'] ?></option>
        <?php endwhile; ?>
    </select><br>
    <textarea name="contenu" placeholder="Contenu de l'article" required><?= $edit['contenu'] ?? '' ?></textarea><br>
    <input type="file" name="image"><br>
    <button name="submit_article"><?= $edit ? 'Modifier' : 'Publier' ?></button>
</form>

<form method="get">
    <input type="text" name="q" placeholder="Recherche par titre" value="<?= htmlspecialchars($search) ?>">
    <button>Rechercher</button>
</form>

<h3>Articles existants</h3>
<table border="1" cellpadding="5">
    <tr><th>ID</th><th>Titre</th><th>Catégorie</th><th>Action</th></tr>
    <?php while($a = $arts->fetch_assoc()): ?>
        <tr>
            <td><?= $a['id'] ?></td>
            <td><?= $a['titre'] ?></td>
            <td><?= $a['cat'] ?></td>
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
