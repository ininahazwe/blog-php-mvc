<h1>Liste des catégories</h1>

<?php foreach( $donnees as $categorie ) : ?>

    <article>
        <h3><?= $categorie['categorie'] ?></h3>
    </article>

<?php endforeach; ?>