<?php
if (!isset($current_article)) {
    echo "<p>Erreur : article non défini.</p>";
    return;
}

$titre = htmlspecialchars($current_article['titre']);
$contenu = nl2br(htmlspecialchars($current_article['article']));
$auteur = htmlspecialchars($current_article['auteur']);
$image1 = $current_article['image1'] ? "../public/images/" . $current_article['image1'] : null;
$image2 = $current_article['image2'] ? "../public/images/" . $current_article['image2'] : null;
?>

<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<!-- Bootstrap + Fonts -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Alata&family=Rubik+One&display=swap" rel="stylesheet">

<div class="modele1-root position-relative">
    <style>
        .modele1-root {
            font-family: 'Alata', sans-serif;
            background: white;
            position: relative;
            overflow: hidden;
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

        /* Décorations */
        .modele1-root .decorative-img {
            position: absolute;
            z-index: 0;
            height: auto;
        }
        .modele1-root .img-right {
            top: 2rem;
            right: 0;
            width: clamp(60px, 10vw, 150px);
            transform: translateX(30%);
        }
        .modele1-root .img-left {
            top: 11rem;
            left: 0;
            width: clamp(60px, 10vw, 150px);
            transform: translateX(-30%);
        }

        @media (max-width: 768px) {
            .modele1-root .decorative-img {
                display: none;
            }
            .modele1-root .img-grid img {
                width: 100%;
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
                    <?php if ($image2): ?>
                        <img src="<?= $image2 ?>" alt="Illustration 2">
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Décorations collées aux bords -->
    <img src="../public/article/suite%20de%20points%20avec%20carré,%20cercle%20-%20article%20(section%202).png"
         class="decorative-img img-right"
         alt="Décoration droite">
    <img src="../public/article/suite%20de%20points%20article%20(section%202).png"
         class="decorative-img img-left"
         alt="Décoration gauche">
</div>
