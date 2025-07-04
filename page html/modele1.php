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
      text-align: justify;
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
    <h1 class="main-title">UN SEUL KIT POUR TOUS LES ÉTUDIANTS : MISSION IMPOSSIBLE ?</h1>

    <div class="row">
      <!-- Texte -->
      <div class="col-md-6 article-text">
        <p>
          Peut-on vraiment créer un kit unique capable de répondre aux besoins de filières aussi différentes que le graphisme, l'architecture, le marketing ou l'informatique ? C'est le défi que relève ce kit étudiant modulable, pensé comme une base commune, mais adaptable à chaque profil.
        </p>
        <p>
          À la rentrée, chaque étudiant fait face aux mêmes petits défis : organiser son espace de travail, ne rien oublier, rester productif sans s'encombrer. C'est là que le kit prend tout son sens. Il propose une base composée d'objets essentiels – un carnet, un crayon/stylo/gomme combiné, une gourde anti-stress, des post-it et une boîte bento – qui sont utiles à toutes les filières. Le design a été étudié pour favoriser l'usage polyvalent, que vous soyez en salle de classe, en bibliothèque ou en déplacement.
        </p>
        <p>
          Mais ce qui fait sa force, c'est sa modularité : les étudiants peuvent ajouter des boîtes complémentaires, empilables, avec des outils spécifiques à leur formation (comme des feutres de couleur, un compas, une clé USB, etc.). C'est donc un système évolutif, où chacun construit son propre kit, adapté à ses besoins, son budget et son mode de travail.
        </p>
        <p>
          Un kit unique ? Non. Un système intelligent et personnalisable ? Oui. C'est cette flexibilité qui en fait un vrai compagnon pour toute la durée des études.
        </p>

        <p class="signature">Damien Coutard</p>
      </div>

      <!-- Images -->
      <div class="col-md-6 img-grid">
        <img src="images_test/article/imageTestArticle1.jpg" alt="Illustration 1">
        <img src="images_test/article/imageTestArticle2.jpg" alt="Illustration 2">
      </div>
    </div>

    <!-- Décorations -->
    <img src="images_test/article/suite de points avec carré, cercle - article (section 2).png" class="decorative-img img-right" alt="Décoration droite">
    <img src="images_test/article/suite de points article (section 2).png" class="decorative-img img-left" alt="Décoration gauche">
  </div>
</div>
