<h1>Page d'accueil</h1>

<?php foreach( $listeArticles as $article ) : ?>

<article class="row">
  <div class="col4">
    <img src="<?= BASEURL ?>uploads/<?= $article['image'] ?>" alt="">
  </div>
  <div class="col-8">
    <h2><a href="<?= BASEURL ?>articles/read/<?= $article['id'] ?>"><?= $article['titre'] ?></a></h2>
    <p><?= $article['description'] ?></p>
    <p><?= $article['created_at'] ?></p>
  </div>
</article>

<?php endforeach; ?>