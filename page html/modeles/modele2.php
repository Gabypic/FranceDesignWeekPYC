<?php
if (!isset($current_article)) {
    echo "<p>Erreur : article non défini.</p>";
    return;
}

$titre = htmlspecialchars($current_article['titre']);
$contenu = nl2br(htmlspecialchars($current_article['article']));
$auteur = htmlspecialchars($current_article['auteur']);
$image1 = $current_article['image1'] ? "../Guillaume/site_vitrine/public/images/" . $current_article['image1'] : null;
$video = $current_article['video'];

$video_id = null;
if ($video && preg_match('/v=([a-zA-Z0-9_-]+)/', $video, $matches)) {
    $video_id = $matches[1];
}
?>

<div class="modele2-root">
    <style>
        .modele2-root body {
            padding: 0;
            font-family: 'Alata', sans-serif;
            background: white;
        }
        .modele2-root .main-title {
            font-family: 'Rubik One', sans-serif;
            text-transform: uppercase;
            text-align: center;
            font-size: clamp(16px, 2vw, 28px);
            margin-top: 0.5rem;
            margin-bottom: 2rem;
        }
        .modele2-root .text-content {
            font-size: clamp(16px, 1.2vw, 20px);
            line-height: 1.6;
            color: black;
            padding-left: 8rem;
            text-align: justify;
        }
        .modele2-root .author {
            font-size: clamp(14px, 1vw, 16px);
            margin-top: 1.5rem;
            text-align: left;
        }
        .modele2-root .image-right {
            width: 80%;
            height: auto;
            border-radius: 1rem;
            background-color: #eee;
            margin-left: 4rem;
        }
        .modele2-root .video-container {
            aspect-ratio: 16 / 9;
            max-width: 70%;
            width: 100%;
            margin: 3rem auto;
            border-radius: 1rem;
            overflow: hidden;
        }
        .modele2-root .video-container iframe {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: none;
        }
        .modele2-root .decorative {
            position: absolute;
            z-index: 0;
            max-width: 100%;
        }
        .modele2-root .decorative-left {
            top:5rem;
            left: -6.3rem;
        }
        .modele2-root .decorative-right-high {
            top: 7rem;
            right: -6.2rem;
        }
        .modele2-root .decorative-right-down {
            top: 48rem;
            right: -6.2rem;
        }
        @media (max-width: 768px) {
            .modele2-root .decorative {
                display: none;
            }
        }
    </style>

    <div class="container py-5 position-relative">

        <!-- Titre -->
        <h1 class="main-title"><?= $titre ?></h1>

        <!-- Contenu en deux colonnes -->
        <div class="row align-items-center">
            <!-- Texte à gauche -->
            <div class="col-md-6 text-content">
                <p><?= $contenu ?></p>
                <p class="author"><?= $auteur ?></p>
            </div>

            <!-- Image à droite (si elle existe) -->
            <?php if ($image1): ?>
                <div class="col-md-6">
                    <img src="<?= $image1 ?>" alt="Illustration" class="image-right">
                </div>
            <?php endif; ?>
        </div>

        <!-- Vidéo YouTube centrée en bas (si présente et valide) -->
        <?php if ($video_id): ?>
            <div class="video-container">
                <iframe
                        src="https://www.youtube.com/embed/<?= $video_id ?>?start=0"
                        title="Vidéo YouTube"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                </iframe>
            </div>
        <?php endif; ?>

        <!-- Décorations -->
        <img src="../page%20html/public/article/suite%20de%20points%20section%203%201.png" class="decorative decorative-right-down" alt="Décoration droite basse">
        <img src="../page%20html/public/article/suite%20de%20points%20-%20article%20(section%202).png" class="decorative decorative-right-high" alt="Décoration droite haute">
        <img src="../page%20html/public/article/suite%20de%20points%20avec%20cercle%20-%20article%20(section%202).png" class="decorative decorative-left" alt="Décoration gauche">
    </div>
</div>
