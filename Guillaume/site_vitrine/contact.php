<?php include 'includes/db.php'; include 'includes/header.php'; ?>
<h2>Contactez-nous</h2>
<form method="post">
    <input type="text" name="nom" placeholder="Nom" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="text" name="sujet" placeholder="Sujet"><br>
    <textarea name="message" placeholder="Votre message" required></textarea><br>
    <button>Envoyer</button>
</form>
<?php include 'includes/footer.php'; ?>