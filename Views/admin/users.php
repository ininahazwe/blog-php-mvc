<h1>Index des utilisateurs</h1>

<table class="table table-striped">

    <thead>
        <th>ID</th>
        <th>Pseudo</th>
        <th>Email</th>
        <th>Rôle</th>
        <th>Actions</th>
    </thead>

    <tbody>

        <?php foreach( $users as $user ) : ?>

            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= $user['pseudo'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['role'] ?></td>
                <td>
                    <a href="<?= BASEURL ?>admin/updateUser/<?= $user['id'] ?>" class="btn btn-warning">Modifier</a> 
                    <a href="<?= BASEURL ?>admin/deleteUser/<?= $user['id'] ?>" class="btn btn-danger">Supprimer</a> 
                </td>
            </tr>

        <?php endforeach; ?>

    </tbody>

</table>

<p><a href="<?= BASEURL ?>admin/createUser" class="btn btn-primary">Ajouter</a></p>
