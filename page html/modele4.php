<?php
if (!isset($current_article)) {
    echo "<p>Erreur : article non défini.</p>";
    return;
}

$titre = htmlspecialchars($current_article['titre']);
$contenu = nl2br(htmlspecialchars($current_article['article']));
$auteur = htmlspecialchars($current_article['auteur']);
$video = $current_article['video'];

$video_id = null;
if ($video && preg_match('/v=([a-zA-Z0-9_-]+)/', $video, $matches)) {
    $video_id = $matches[1];
}
?>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Alata&family=Rubik+One&display=swap" rel="stylesheet">
<div class="modele4-root">
    <style>
        .modele4-root body {
            font-family: 'Alata', sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }
        .modele4-root .section-title {
            font-family: 'Rubik One', sans-serif;
            text-transform: uppercase;
            text-align: center;
            font-size: clamp(18px, 2vw, 30px);
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        .modele4-root .text-content {
            font-size: clamp(16px, 1vw, 18px);
            line-height: 1.6;
            text-align: justify;
        }
        .modele4-root .author {
            font-size: clamp(14px, 1vw, 16px);
            text-align: center;
            margin-top: 1rem;
        }
        .modele4-root .decorative {
            position: absolute;
            z-index: 0;
            max-width: 100%;
        }
        .modele4-root .decorative-left {
            top: 13.5rem;
            left: -7.3rem;
            width: auto;
        }
        .modele4-root .decorative-right {
            top: 33rem;
            right: -7rem;
        }
        .modele4-root .content-box {
            border-radius: 1rem;
            padding: 2rem;
            margin: 0 auto;
            position: relative;
        }
        .modele4-root .video-container {
            aspect-ratio: 16 / 9;
            max-width: 70%;
            width: 100%;
            margin: 3rem auto;
            border-radius: 1rem;
            overflow: hidden;
            margin-bottom: -1rem;
            margin-top: 2rem;
        }
        .modele4-root .video-container iframe {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: none;
        }
        @media (max-width: 768px) {
            .modele4-root .decorative {
                display: none;
            }
        }
    </style>

  <div class="container py-5">
    <h1 class="section-title"><?= $titre ?></h1>

    <div class="content-box">
      <div class="text-content">
        <p><?= $contenu ?></p>
      </div>

      <div class="author"><?= $auteur ?></div>

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

      <img src="images_test/article/vague.png" alt="Décor vague" class="decorative decorative-left" />
      <img src="images_test/article/vague%203%20-%20article%20(section%202).png" alt="Décor vague bas" class="decorative decorative-right" />
    </div>
  </div>
</div>
