<h1>Index des utilisateurs</h1>

<?php

var_dump($users); ?>

<?php foreach( $users as $user ) : ?>

    <article>
        <h2><a href="<?= BASEURL ?>users/read/<?= $user['id'] ?>"><?= $user['email'] ?></a></h2>
        <p><?= $user['role'] ?></p>
    </article>

<?php endforeach; ?>