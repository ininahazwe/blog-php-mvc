<?php
namespace App\Controllers;

use App\Models\ArticlesModel;
use App\Models\CategoriesModel;
use App\Core\Form;

class ArticlesController extends Controller {

  public function index() {

    $articlesModel = new ArticlesModel(); 
    $articles = $articlesModel->getAll();

    $categoriesModel = new CategoriesModel();
    $categories = $categoriesModel->getAll();

    $this->render( 'articles/index', [ 
      'listeArticles' => $articles,
      'listeCategories' => $categories,
    ] );

  }

  public function create() {
    
    if( self::isAdmin() ) {

      if( Form::validate( $_POST, ['titre', 'description'] ) ) {
                  
        $titre = strip_tags( $_POST['titre']);
        $description = strip_tags( $_POST['description']);

        $name ='';

        if( !empty( $_FILES['image'] ) ) {
            
            $tmp_file   = $_FILES['image']['tmp_name'];
            $type       = $_FILES['image']['type'];
            $name       = $_FILES['image']['name'];

            $upload_file = ROOT . 'uploads/' . $name;

            move_uploaded_file( $tmp_file, $upload_file );

        }

        $article = new ArticlesModel();

        $article->setTitre( $titre )
        ->setDescription( $description )
        ->setCategorie_id( $_POST['categorie'] )
        ->setActif(1)
        ->setImage( $name );

        $article->create();

        $_SESSION['success'] = 'Article créée';
        header('Location: ' . BASEURL . '/articles');
        exit;
      }

      $categoriesModel = new CategoriesModel();
      $categories = $categoriesModel->getAll();

      $liste_categories = [ ''=>''];
      
      foreach( $categories as $categorie) {
        $liste_categories[ $categorie['id'] ] = $categorie['categorie'];
      }
  
      $form = new Form();
      
      $form->startForm( 'post', '', [ 'enctype' => 'multipart/form-data'])
      ->addLabelFor( 'titre', 'Titre de l\'article' )
      ->addInput( 'text', 'titre', ['id'=>'titre', 'class'=>'form-control'] )
      ->addLabelFor( 'description', 'Texte de l\'article' )
      ->addTextarea( 'description', '', ['id'=>'description','class'=>'form-control'] )
      ->addLabelFor( 'categorie', "Catégorie")
      ->addSelect( 'categorie', $liste_categories, '' , ['id'=>'categorie', 'class'=>'form-control' ] )

      ->addLabelFor( 'image', 'Image')
      ->addInput( 'file', 'image', ['id'=>'image'])
      ->addButton( 'Valider', [ 'class'=>'btn btn-primary'] )
      ;

      $articleForm = $form->create();

      $this->render( 'articles/create', [ 
              'articleForm'   => $articleForm,
              'titre'         =>  "Ajouter un article",
          ] 
      );
    } else {
      $_SESSION['error'] = 'Vous n\'avez pas accès à cette zone';
      header( 'Location: ' . BASEURL );
      exit;
    }
  }

  public function update( int $id ) {
    
    if( self::isAdmin() ) {

      if( Form::validate( $_POST, ['titre', 'description'] ) ) {
                  
        $titre = strip_tags( $_POST['titre']);
        $description = strip_tags( $_POST['description']);

        $name ='';

        if( !empty( $_FILES['image'] ) ) {
            
            $tmp_file   = $_FILES['image']['tmp_name'];
            $type       = $_FILES['image']['type'];
            $name       = $_FILES['image']['name'];

            $upload_file = ROOT . 'uploads/' . $name;

            move_uploaded_file( $tmp_file, $upload_file );

        }

        $article = new ArticlesModel();

        $article->setTitre( $titre )
        ->setDescription( $description )
        ->setCategorie_id( $_POST['categorie'])
        ->setActif(1)
        ->setImage( $name );

        $article->update( $id );

        $_SESSION['success'] = 'Article créée';
        header('Location: ' . BASEURL . '/articles');
        exit;
      }
  
      $articlesModel = new ArticlesModel();
      $article = $articlesModel->getOne( $id );

      $categoriesModel = new CategoriesModel();
      $categories = $categoriesModel->getAll();

      $liste_categories = [ ''=>''];
      
      foreach( $categories as $categorie) {
        $liste_categories[ $categorie['id'] ] = $categorie['categorie'];
      }

      $form = new Form();
      
      $form->startForm( 'post', '', [ 'enctype' => 'multipart/form-data'])
      ->addLabelFor( 'titre', 'Titre de l\'article' )
      ->addInput( 'text', 'titre', ['id'=>'titre', 'class'=>'form-control', "value"=>$article['titre'] ] )
      ->addLabelFor( 'description', 'Texte de l\'article' )
      ->addTextarea( 'description', $article['description'], ['id'=>'description','class'=>'form-control'] )
      
      ->addString('<img src=' . BASEURL . 'uploads/' . $article['image'] .'>' )

      ->addLabelFor( 'categorie', "Catégorie")
      ->addSelect( 'categorie', $liste_categories, $article['categorie_id'] , ['id'=>'categorie', 'class'=>'form-control' ] )

      ->addLabelFor( 'image', 'Image')
      ->addInput( 'file', 'image', ['id'=>'image'])
      
      ->addButton( 'Valider', [ 'class'=>'btn btn-primary'] )
      ;

      $articleForm = $form->create();

      $this->render( 'articles/create', [ 
              'articleForm'   => $articleForm,
              'titre'         =>  "Modifier un article",
          ] 
      );
    } else {
      $_SESSION['error'] = 'Vous n\'avez pas accès à cette zone';
      header( 'Location: ' . BASEURL );
      exit;
    }

  }

  public function read( int $id ) {
    $articlesModel = new ArticlesModel();
    $article = $articlesModel->getOne( $id );
    $this->render( 'articles/read', ['contenuArticle'=>$article] );
  }

  public function delete() {}

  public function categorie( int $id ) {

    $articlesModel = new ArticlesModel();
    $articles = $articlesModel->getBy( [ 'categorie_id' => $id ] );

    $categoriesModel = new CategoriesModel();
    $categories = $categoriesModel->getAll();


    $this->render( 'articles/index', [ 
      'listeArticles'   =>  $articles,
      'listeCategories' =>  $categories,
    ]);
  
  }


}