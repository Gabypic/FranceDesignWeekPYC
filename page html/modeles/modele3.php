<?php
if (!isset($current_article)) {
    echo "<p>Erreur : article non défini.</p>";
    return;
}

$titre = htmlspecialchars($current_article['titre']);
$contenu = nl2br(htmlspecialchars($current_article['article']));
$auteur = htmlspecialchars($current_article['auteur']);
?>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Présentation du Kit Étudiant</title>

<!-- Bootstrap + Google Fonts -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Alata&family=Rubik+One&display=swap" rel="stylesheet">

<div class="modele3-root position-relative">
    <style>
        .modele3-root {
            font-family: 'Alata', sans-serif;
            background: white;
            color: black;
            position: relative;
            overflow: hidden;
        }
        .modele3-root .main-title {
            font-family: 'Rubik One', sans-serif;
            text-transform: uppercase;
            text-align: center;
            font-size: clamp(14px, 1.5vw, 24px);
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        .modele3-root .text-content {
            font-size: clamp(16px, 1vw, 18px);
            line-height: 1.6;
            text-align: justify;
            max-width: 69%;
            margin-left: auto;
            margin-right: auto;
        }
        .modele3-root .author {
            padding-top: 1rem;
            font-size: clamp(16px, 0.9vw, 15px);
            margin-top: 1.5rem;
            text-align: center;
        }

        /* Décorations */
        .modele3-root .decorative {
            position: absolute;
            z-index: 0;
            height: auto;
        }
        .modele3-root .decorative-left {
            top: 7.5rem;
            left: 0;
            width: clamp(80px, 15vw, 220px);
            transform: translateX(-30%);
        }
        .modele3-root .decorative-right {
            top: 7rem;
            right: 0;
            width: clamp(80px, 15vw, 220px);
            transform: translateX(30%);
        }

        @media (max-width: 768px) {
            .modele3-root .decorative {
                display: none;
            }
            .modele3-root .text-content {
                max-width: 100%;
                padding: 0 1rem;
            }
        }
    </style>

    <div class="container section-wrapper position-relative">
        <!-- Titre -->
        <h1 class="main-title"><?= $titre ?></h1>

        <!-- Contenu texte -->
        <div class="row">
            <div class="col-12 col-md-10 offset-md-1 text-content">
                <p><?= $contenu ?></p>
                <p class="author"><?= $auteur ?></p>
            </div>
        </div>
    </div>

    <!-- Décorations collées aux bords -->
    <img src="../public/article/vague%20-%20article%20(section%202)%202.png"
         alt="Décor gauche"
         class="decorative decorative-left" />
    <img src="../public/article/vague%20-%20article%20(section%202)%201.png"
         alt="Décor droit"
         class="decorative decorative-right" />
</div>
