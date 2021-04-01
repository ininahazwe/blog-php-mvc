<h1>Liste des articles</h1>
<table class="table table-striped">

  <thead>
    <th>ID</th>
    <th>Titre</th>
    <th>Contenu</th>
    <th>Catégorie</th>
    <th>Active</th>
    <th>Actions</th>
  </thead>

  <tbody>
  
  <?php foreach( $articles as $article ) : ?>
    <tr>
      <td><?= $article['id']; ?></td>
      <td><?= $article['titre']; ?></td>
      <td><?= $article['description']; ?></td>
      <td><?= $article['categorie_id'] ?></td>
      <td>
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input" 
          id="switch<?= $article['id'] ?>" 
          <?= $article['actif'] ? 'checked':''; ?> data-id="<?= $article['id']; ?>">
          <label class="custom-control-label" for="switch<?= $article['id'] ?>"></label>
        </div>
      </td>
      <td>
        <a href="<?= BASEURL ?>articles/update/<?= $article['id'] ?>" class="btn btn-warning">Modifier</a> 
        <a href="<?= BASEURL ?>admin/deleteArticle/<?= $article['id'] ?>" class="btn btn-danger">Supprimer</a> 
      </td>
    </tr>
  <?php endforeach; ?>
  
  </tbody>

</table>

<p><a href="<?= BASEURL ?>articles/create" class="btn btn-primary">Ajouter</a></p>