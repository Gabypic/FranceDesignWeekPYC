<?php
session_start();
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");

// Forcer HTTPS
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit;
}

// Gestion des tentatives
$_SESSION['tries'] = $_SESSION['tries'] ?? 0;
$_SESSION['last_try'] = $_SESSION['last_try'] ?? 0;
if ($_SESSION['tries'] >= 5 && time() - $_SESSION['last_try'] < 900) {
    die("Trop de tentatives. Réessayez plus tard.");
}

require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($login && $password) {
        $stmt = $db->prepare("SELECT * FROM utilisateurs WHERE login = ?");
        $stmt->execute([$login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $hash_entry = hash('sha256', $password);

            if ($hash_entry === $user['password']) {
                $_SESSION['tries'] = 0;
                $_SESSION['auth'] = [
                    'id'    => $user['id'],
                    'login' => $user['login']
                ];
                $_SESSION['last_activity'] = time();
                header("location: admin.php");
                exit;
            }
        }

        $_SESSION['tries']++;
        $_SESSION['last_try'] = time();
        $error = "Identifiant ou mot de passe incorrect";
    } else {
        $error = "Champs requis.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4">Connexion admin</h2>
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
        <button class="btn btn-primary">Se connecter</button>
    </form>
    <form method="post" action="../index.html" class="mt-3">
        <button class="btn btn-secondary">Retour au site</button>
    </form>
</div>
</body>
</html>
