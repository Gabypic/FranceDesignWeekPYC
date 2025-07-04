<?php
if (!isset($current_article)) {
    echo "<p>Erreur : article non défini.</p>";
    return;
}

$titre = htmlspecialchars($current_article['titre']);
$contenu = nl2br(htmlspecialchars($current_article['article']));
$auteur = htmlspecialchars($current_article['auteur']);
$image1 = $current_article['image1'] ? "../Guillaume/site_vitrine/public/images/" . $current_article['image1'] : null;
$image2 = $current_article['image2'] ? "../Guillaume/site_vitrine/public/images/" . $current_article['image2'] : null;
?>

<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<!-- Bootstrap + Fonts -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Alata&family=Rubik+One&display=swap" rel="stylesheet">

<div class="modele1-root">
  <style>
    .modele1-root * {
      outline: 1px solid rgba(0, 0, 0, 0.2);
    }
    .modele1-root body {
      font-family: 'Alata', sans-serif;
      margin: 0;
      padding: 0;
      background: white;
    }
    .modele1-root .main-title {
      font-family: 'Rubik One', sans-serif;
      text-transform: uppercase;
      font-size: clamp(16px, 2vw, 28px);
      text-align: center;
      margin-top: 2rem;
      margin-bottom: 2rem;
    }
    .modele1-root .content-wrapper {
      position: relative;
      z-index: 1;
    }
    .modele1-root .article-text {
      font-size: clamp(14px, 1.2vw, 20px);
      line-height: 1.6;
      color: black;
      text-align: center;
    }
    .modele1-root .signature {
      text-align: left;
      margin-top: 2rem;
      font-size: clamp(14px, 1vw, 16px);
    }
    .modele1-root .img-grid {
      display: flex;
      flex-direction: column;
      gap: 2rem;
    }
    .modele1-root .img-grid img {
      width: 80%;
      height: auto;
      border-radius: 1rem;
      background-color: #eee;
    }
    .modele1-root .decorative-img {
      position: absolute;
      z-index: 0;
      max-width: 100%;
      height: auto;
    }
    .modele1-root .img-right {
      top: 2rem;
      right: -6.2rem;
      width: clamp(60px, 10vw, 150px);
    }
    .modele1-root .img-left {
      top: 11rem;
      left: -6rem;
    }

    @media (max-width: 768px) {
        .modele1-root .decorative-img {
            display: none;
        }
    }
  </style>

  <div class="container py-5 content-wrapper">
    <h1 class="main-title"><?= $titre?></h1>

    <div class="row align-items-center">
      <!-- Texte -->
      <div class="col-md-6 article-text">
        <p><?=$contenu?></p>

        <p class="signature"><?= $auteur?></p>
      </div>

      <!-- Images -->
      <?php if ($image1): ?>
          <div class="col-md-6 img-grid">
              <img src="<?= $image1 ?>" alt="Illustration 1">
              <img src="<?= $image2 ?>" alt="Illustration 2">
          </div>
      <?php endif; ?>
    </div>

    <!-- Décorations -->
    <img src="images_test/article/suite de points avec carré, cercle - article (section 2).png" class="decorative-img img-right" alt="Décoration droite">
    <img src="images_test/article/suite de points article (section 2).png" class="decorative-img img-left" alt="Décoration gauche">
  </div>
</div>
