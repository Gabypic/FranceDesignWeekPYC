<?php
session_start();
require_once 'db.php';

// Seul "editor" peut créer des comptes
if (!isset($_SESSION['auth']) || $_SESSION['auth']['login'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$success = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($login === '' || $password === '') {
        $error = "Veuillez remplir tous les champs.";
    } else {
        // Vérifie si le login existe déjà
        $stmt = $db->prepare("SELECT id FROM utilisateurs WHERE login = ?");
        $stmt->execute([$login]);
        if ($stmt->fetch()) {
            $error = "Ce login existe déjà.";
        } else {
            // Hash en SHA-256
            $hash = hash('sha256', $password);
            $stmt = $db->prepare("INSERT INTO utilisateurs (login, password) VALUES (?, ?)");
            if ($stmt->execute([$login, $hash])) {
                $success = "Utilisateur créé avec succès.";
            } else {
                $error = "Erreur lors de la création.";
            }
        }
    }
}

function e($str) { return htmlspecialchars($str, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un compte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4">Créer un compte éditeur</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" class="bg-white p-4 rounded shadow-sm" style="max-width:400px">
        <div class="mb-3">
            <label>Login</label>
            <input type="text" name="login" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Mot de passe</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary">Créer le compte</button>
    </form>
    <form method="post" action="admin.php" class="mt-3">
        <button class="btn btn-secondary">Retour admin</button>
    </form>
</div>
</body>
</html>
