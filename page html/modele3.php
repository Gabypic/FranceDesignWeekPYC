<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Présentation du Kit Étudiant</title>

<!-- Bootstrap + Google Fonts -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Alata&family=Rubik+One&display=swap" rel="stylesheet">

<div class="modele3-root">
    <style>
        .modele3-root body {
            padding: 0;
            margin: 0;
            font-family: 'Alata', sans-serif;
            background: white;
            color: black;
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
        .modele3-root .decorative {
            position: absolute;
            z-index: 0;
            max-width: 100%;
        }
        .modele3-root .decorative-left {
            top: 7.5rem;
            left: -6.5rem;
        }
        .modele3-root .decorative-right {
            width: 20%;
            top: 7rem;
            right: -6.25rem;
        }

        @media (max-width: 768px) {
            .modele3-root .decorative {
                display: none;
            }
        }
    </style>


    <div class="container section-wrapper" style="position: relative;">

    <!-- Titre -->
    <h1 class="main-title">PRÉSENTATION</h1>

    <!-- Contenu texte -->
    <div class="row">
      <div class="col-12 col-md-10 offset-md-1 text-content">
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
    </div>

    <!-- Images décoratives -->
    <img src="images_test/article/vague%20-%20article%20(section%202)%202.png" alt="Decor 1" class="decorative decorative-left" />
    <img src="images_test/article/vague%20-%20article%20(section%202)%201.png" alt="Decor 2" class="decorative decorative-right" />

  </div>
</div>
