<h1>Liste des articles</h1>

<ul id="categories">
  <?php foreach( $listeCategories as $categorie ) : ?>
    <li><a href="<?= BASEURL . 'articles/categorie/' . $categorie['id'] ?>"><?= $categorie['categorie'] ?></a></li>
  <?php endforeach; ?>

<?php foreach( $listeArticles as $article ) : ?>

  <article class="row">
    <div class="col4">
      <img src="<?= BASEURL ?>uploads/<?= $article['image'] ?>" alt="">
    </div>
    <div class="col-8">
      <h2><a href="<?= BASEURL ?>articles/read/<?= $article['id'] ?>"><?= $article['titre'] ?></a></h2>
      <p><?= $article['description'] ?></p>
    </div>
  </article>

<?php endforeach; ?>