<?php
session_start();
require_once 'db.php';
require_once 'content_manager.php';

if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 1800) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}
$_SESSION['last_activity'] = time();

if (!isset($_SESSION['auth'])) {
    header("Location: login.php");
    exit;
}

$contentManager = new ContentManager($db);
$success = null;
$error = null;

if (isset($_POST['delete']) && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    if ($contentManager->deleteContent($id)) {
        $success = "L'article supprimé.";
    } else {
        $error = "Impossible de supprimer.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitbtn'])) {
    $model  = intval($_POST['model'] ?? 0);
    $isEdit = !empty($_POST['id']);

    $uploadDirImages = __DIR__ . '/../public/images/';
    if (!is_dir($uploadDirImages)) { @mkdir($uploadDirImages, 0775, true); }

    $image1Name = $isEdit ? trim($_POST['existing_image1'] ?? '') : '';
    $image2Name = $isEdit ? trim($_POST['existing_image2'] ?? '') : '';
    $videoLink  = trim($_POST['video'] ?? '');

    if (!empty($_POST['delete_image1'])) $image1Name = '';
    if (!empty($_POST['delete_image2'])) $image2Name = '';

    if (!empty($_FILES['image1']['tmp_name'])) {
        $mime = mime_content_type($_FILES['image1']['tmp_name']);
        $size = $_FILES['image1']['size'];
        if (in_array($mime, ['image/jpeg', 'image/png']) && $size <= 8 * 1024 * 1024) {
            $ext = strtolower(pathinfo($_FILES['image1']['name'], PATHINFO_EXTENSION));
            $image1Name = uniqid('img1_') . '.' . $ext;
            move_uploaded_file($_FILES['image1']['tmp_name'], $uploadDirImages . $image1Name);
        } else { $error = "Image 1 : format non valide ou trop grande."; }
    }

    if (!empty($_FILES['image2']['tmp_name'])) {
        $mime = mime_content_type($_FILES['image2']['tmp_name']);
        $size = $_FILES['image2']['size'];
        if (in_array($mime, ['image/jpeg', 'image/png']) && $size <= 8 * 1024 * 1024) {
            $ext = strtolower(pathinfo($_FILES['image2']['name'], PATHINFO_EXTENSION));
            $image2Name = uniqid('img2_') . '.' . $ext;
            move_uploaded_file($_FILES['image2']['tmp_name'], $uploadDirImages . $image2Name);
        } else { $error = "Image 2 : format non valide ou trop grande."; }
    }

    if (!$error) {
        $data = [
            'titre'   => $_POST['titre'] ?? '',
            'article' => $_POST['article'] ?? '',
            'auteur'  => $_POST['auteur'] ?? '',
            'image1'  => $image1Name,
            'image2'  => $image2Name,
            'video'   => $videoLink,
        ];

        if ($model === 1 && empty($data['image1'])) {
            $error = "Modèle 1 : nécessite au moins l'image 1.";
        } elseif ($model === 2 && (empty($data['image1']) || empty($data['video']))) {
            $error = "Modèle 2 : nécessite une image ET une vidéo.";
        } elseif ($model === 4 && empty($data['video'])) {
            $error = "Modèle 4 : nécessite une vidéo.";
        }

        if (!$error) {
            if (!empty($_POST['id'])) { $contentManager->deleteContent(intval($_POST['id'])); }
            if ($contentManager->addContent($model, $data)) {
                $success = !empty($_POST['id']) ? "L'article a été mis à jour." : "Article publié !";
            } else { var_dump($db->errorInfo()); exit; }
        }
    }
}

$editData = isset($_GET['edit']) ? $contentManager->getContent(intval($_GET['edit'])) : null;
$articles = $contentManager->getAllContents();

function e($str) { return htmlspecialchars($str, ENT_QUOTES, 'UTF-8'); }
function yt_embed($url) {
    if (preg_match('#(?:youtube\.com/watch\?v=|youtu\.be/)([a-zA-Z0-9_-]{11})#', $url, $m)) return $m[1];
    return '';
}

/**
 * IMPORTANT : Certaines BDD renvoient le champ "modele" au lieu de "model".
 * On harmonise ici pour la sélection du <select>.
 */
$currentModel   = isset($editData) ? intval($editData['modele'] ?? $editData['model'] ?? 0) : 0;
$prefilledModel = $currentModel;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f9f9f9; font-family: sans-serif; }
        h1, h2 { font-weight: 600; }
        .card { border: none; border-radius: 10px; }
        .btn { border-radius: 5px; }
        label { font-weight: 500; }
        img.thumb { height: 50px; margin-right: 5px; }
        .hidden { display: none !important; }
        .preview { background:#fff;border:1px dashed #ddd;border-radius:8px;padding:10px;margin-bottom:8px; }
        .preview img { max-height:120px; }
        .small-muted { font-size:.875rem;color:#6c757d; }
    </style>
</head>
<body>
<div class="container py-5">
    <h1 class="mb-4">Admin</h1>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= e($success) ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= e($error) ?></div>
    <?php endif; ?>

    <div class="card p-4 mb-4 shadow-sm">
        <h2 class="h5 mb-3"><?= $editData ? "Modifier l'article" : "Nouvel article" ?></h2>
        <form method="post" enctype="multipart/form-data" id="content-form">
            <input type="hidden" name="id" value="<?= e($editData['id'] ?? '') ?>">

            <div class="mb-3">
                <label>Type de contenu</label>
                <select name="model" id="model" class="form-select" required>
                    <option value="">-- Choisir un type --</option>
                    <?php for ($i = 1; $i <= 4; $i++): ?>
                        <option value="<?= $i ?>" <?= ($currentModel === $i) ? 'selected' : '' ?>>Modèle <?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="<?= $prefilledModel ? '' : 'hidden' ?>" id="core-fields">
                <div class="mb-3">
                    <label>Titre</label>
                    <input type="text" name="titre" class="form-control" value="<?= e($editData['titre'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label>Auteur</label>
                    <input type="text" name="auteur" class="form-control" value="<?= e($editData['auteur'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label>Contenu</label>
                    <textarea name="article" class="form-control" rows="5" required><?= e($editData['article'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="<?= $prefilledModel ? '' : 'hidden' ?>" id="media-section">
                <div class="mb-3 media-field <?= ($prefilledModel === 1 || $prefilledModel === 2) ? '' : 'hidden' ?>" id="field-image1">
                    <label>Image 1 (max 8 Mo)</label>
                    <?php if (!empty($editData['image1'])): ?>
                        <div class="preview">
                            <div class="small-muted mb-2">Image actuelle :</div>
                            <img src="../public/images/<?= e($editData['image1']) ?>" alt="image1 actuelle">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="delete_image1" name="delete_image1" value="1">
                                <label class="form-check-label" for="delete_image1">Supprimer l'image</label>
                            </div>
                        </div>
                        <input type="hidden" name="existing_image1" value="<?= e($editData['image1']) ?>">
                    <?php endif; ?>
                    <input type="file" name="image1" class="form-control">
                    <div class="form-text">Laisser vide pour conserver l'image actuelle.</div>
                </div>

                <div class="mb-3 media-field <?= ($prefilledModel === 1) ? '' : 'hidden' ?>" id="field-image2">
                    <label>Image 2 (optionnelle)</label>
                    <?php if (!empty($editData['image2'])): ?>
                        <div class="preview">
                            <div class="small-muted mb-2">Image actuelle :</div>
                            <img src="../public/images/<?= e($editData['image2']) ?>" alt="image2 actuelle">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="delete_image2" name="delete_image2" value="1">
                                <label class="form-check-label" for="delete_image2">Supprimer l'image</label>
                            </div>
                        </div>
                        <input type="hidden" name="existing_image2" value="<?= e($editData['image2']) ?>">
                    <?php endif; ?>
                    <input type="file" name="image2" class="form-control">
                    <div class="form-text">Laisser vide pour conserver l'image actuelle.</div>
                </div>

                <div class="mb-3 media-field <?= ($prefilledModel === 2 || $prefilledModel === 4) ? '' : 'hidden' ?>" id="field-video">
                    <label>Lien vidéo YouTube</label>
                    <input type="url" name="video" class="form-control" value="<?= e($editData['video'] ?? '') ?>">
                </div>
            </div>

            <div class="<?= $prefilledModel ? '' : 'hidden' ?>" id="submit-row">
                <button name="submitbtn" class="btn btn-success">
                    <?= $editData ? 'Enregistrer les modifications' : 'Publier l’article' ?>
                </button>
                <?php if ($editData): ?>
                    <a href="admin.php" class="btn btn-secondary ms-2">Annuler</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <h2 class="h5 mb-3">Articles publiés</h2>
    <div class="table-responsive bg-white shadow-sm rounded">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Type</th>
                <th>Médias</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($articles as $a): ?>
                <tr>
                    <td><?= e($a['id']) ?></td>
                    <td><?= e($a['titre']) ?></td>
                    <td><?= e($a['auteur']) ?></td>
                    <td>Modèle <?= e($a['modele']) ?></td>
                    <td>
                        <?php if (!empty($a['image1'])): ?>
                            <img src="../public/images/<?= e($a['image1']) ?>" class="thumb" alt="img1">
                        <?php endif; ?>
                        <?php if (!empty($a['image2'])): ?>
                            <img src="../public/images/<?= e($a['image2']) ?>" class="thumb" alt="img2">
                        <?php endif; ?>
                        <?php if (!empty($a['video'])): ?>
                            <?php $yt = yt_embed($a['video']); ?>
                            <?php if ($yt): ?>
                                <iframe width="144" height="81" src="https://www.youtube.com/embed/<?= $yt ?>" frameborder="0" allowfullscreen></iframe>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="?edit=<?= $a['id'] ?>" class="btn btn-sm btn-outline-primary">Modifier</a>
                        <form method="post" class="d-inline" onsubmit="return confirm('Supprimer cet article ?')">
                            <input type="hidden" name="id" value="<?= $a['id'] ?>">
                            <button name="delete" class="btn btn-sm btn-outline-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div>
        <form method="post" action="logout.php" class="d-inline" onsubmit="return confirm('Voulez-vous vous déconnecter ?')">
            <button name="disconnection" class="btn btn-sm btn-outline-danger">Déconnexion</button>
        </form>
    </div>
</div>

<script>
    (function () {
        const modelSelect  = document.getElementById('model');
        const coreFields   = document.getElementById('core-fields');
        const mediaSection = document.getElementById('media-section');
        const submitRow    = document.getElementById('submit-row');

        const fieldImage1 = document.getElementById('field-image1');
        const fieldImage2 = document.getElementById('field-image2');
        const fieldVideo  = document.getElementById('field-video');

        function toggle(el, show) {
            if (!el) return;
            el.classList.toggle('hidden', !show);
            const inputs = el.querySelectorAll('input, textarea, select, button');
            inputs.forEach(i => i.disabled = !show);
        }

        function updateVisibility() {
            const val = parseInt(modelSelect.value, 10) || 0;

            const showCommon = val > 0;
            toggle(coreFields, showCommon);
            toggle(mediaSection, showCommon);
            toggle(submitRow, showCommon);

            if (!showCommon) return;

            toggle(fieldImage1, val === 1 || val === 2);
            toggle(fieldImage2, val === 1);
            toggle(fieldVideo,  val === 2 || val === 4);
        }

        // Forcer la valeur présélectionnée côté JS si le <option selected> ne s'applique pas
        <?php if ($currentModel > 0): ?>
        modelSelect.value = "<?= $currentModel ?>";
        <?php endif; ?>

        modelSelect.addEventListener('change', updateVisibility);
        updateVisibility();
    })();
</script>
</body>
</html>
