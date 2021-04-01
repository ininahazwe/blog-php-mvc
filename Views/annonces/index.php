<h1>Index des annonces</h1>

<?php foreach( $annonces as $annonce ) : ?>

    <article class="row">
        <div class="col-4">
            <img src="<?= BASEURL ?>uploads/<?= $annonce['image'] ?>" 
            style="width: auto; max-height: 200px; object-fit:cover;">
        </div>
        <div class="col-8">
            <h2><a href="<?= BASEURL ?>annonces/read/<?= $annonce['id'] ?>">
            <?= $annonce['titre'] ?></a></h2>
            <p><?= $annonce['created_at'] ?></p>
            <p><?= $annonce['description'] ?></p>
        </div>
    </article>

<?php endforeach; ?>