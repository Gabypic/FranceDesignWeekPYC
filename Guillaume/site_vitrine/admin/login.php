<?php
session_start();
$u = 'admin';
$p = 'adminpass';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['user'] === $u && $_POST['pass'] === $p) {
        $_SESSION['auth'] = true;
        header('Location: dashboard.php');
        exit;
    }
    $err = 'Identifiants invalides';
}
?>
<form method="post">
    <input type="text" name="user" placeholder="Utilisateur" required>
    <input type="password" name="pass" placeholder="Mot de passe" required>
    <button>Connexion</button>
    <?php if (!empty($err)) echo "<p>$err</p>"; ?>
</form>
