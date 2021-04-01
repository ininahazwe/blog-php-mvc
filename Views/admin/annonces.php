<h1>Liste des annonces</h1>
<table class="table table-striped">

  <thead>
    <th>ID</th>
    <th>Titre</th>
    <th>Contenu</th>
    <th>Active</th>
    <th>Actions</th>
  </thead>

  <tbody>
  
  <?php foreach( $annonces as $annonce ) : ?>
    <tr>
      <td><?= $annonce['id']; ?></td>
      <td><?= $annonce['titre']; ?></td>
      <td><?= $annonce['description']; ?></td>
      <td>
        <div class="custom-control custom-switch">
          <input 
            type="checkbox" 
            class="custom-control-input" 
            id="switch<?= $annonce['id'] ?>" 
            <?= $annonce['actif'] ? 'checked':''; ?> data-id="<?= $annonce['id'] ?>">
          <label class="custom-control-label" for="switch<?= $annonce['id'] ?>"></label>
        </div>
      </td>
      <td>
        <a href="<?= BASEURL ?>annonces/update/<?= $annonce['id'] ?>" class="btn btn-warning">Modifier</a> 
        <a href="<?= BASEURL ?>admin/deleteAnnonce/<?= $annonce['id'] ?>" class="btn btn-danger">Supprimer</a> 
      </td>
    </tr>
  <?php endforeach; ?>
  
  </tbody>

</table>

<p><a href="<?= BASEURL ?>annonces/create" class="btn btn-primary">Ajouter</a></p>