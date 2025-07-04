<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />

<!-- Bootstrap + Fonts -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Alata&family=Rubik+One&display=swap" rel="stylesheet">

<div class="modele2-root">
  <style>
    .modele2-root * {
      outline: 1px solid rgba(0, 0, 0, 0.2);
    }
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
    <h1 class="main-title">UN SEUL KIT POUR TOUS LES ÉTUDIANTS : MISSION IMPOSSIBLE ?</h1>

    <!-- Contenu en deux colonnes -->
    <div class="row align-items-center">
      <!-- Texte à gauche -->
      <div class="col-md-6 text-content">
        <p>
          Chaque élément de ce pack a été choisi avec soin, en pensant aux étudiants qui aiment allier
          fonctionnalité, style et organisation. L'ensemble adopte un univers graphique Memphis, aux couleurs
          franches, aux formes géométriques ludiques, pour insuffler une touche d'énergie à ton espace de
          travail.
        </p>
        <p>
          Entre les premiers cours, les travaux de groupe, les idées qui fusent à toute heure et les trajets entre
          deux bâtiments, le quotidien d'un étudiant est un vrai marathon créatif. C'est pour répondre à cette
          effervescence que nous avons conçu le kit.
        </p>
        <p class="author">Damien Coutard</p>
      </div>

      <!-- Image à droite -->
      <div class="col-md-6">
        <img src="images_test/article/imageTestArticle1.jpg" alt="Illustration" class="image-right">
      </div>
    </div>

    <!-- Vidéo YouTube centrée en bas -->
    <div class="video-container">
      <iframe
              src="https://www.youtube.com/embed/zhB82qjtoBs?start=0"
              title="Vidéo YouTube"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen>
      </iframe>
    </div>

    <!-- Décorations -->
    <img src="images_test/article/suite de points section 3 1.png" class="decorative decorative-right-down" alt="Décoration droite basse">
    <img src="images_test/article/suite de points - article (section 2).png" class="decorative decorative-right-high" alt="Décoration droite haute">
    <img src="images_test/article/suite de points avec cercle - article (section 2).png" class="decorative decorative-left" alt="Décoration gauche">
  </div>
</div>
