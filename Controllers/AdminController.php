<?php

namespace App\Controllers;

use App\Models\AnnoncesModel;
use App\Models\ArticlesModel;
use App\Models\UsersModel;
use App\Core\Form;

class AdminController extends Controller {

  public function index() {
    $this->render( 'admin/index' );
  }

  // public static function isAdmin() {
  //   if( isset( $_SESSION['user'] ) && 'admin' == $_SESSION['user']['role'] ) {
  //     return true;
  //   } else {
  //     return false;
  //   }
  // }

  public function annonces() {
    if( $this->isAdmin() ) {
      $annoncesModel = new AnnoncesModel();
      $annonces = $annoncesModel->getAll();
      $this->render( 'admin/annonces', ['annonces' => $annonces ] );
    } else {
      $_SESSION['error'] = 'Vous n\'avez pas accès à cette zone';
      header( 'Location: ' . BASEURL );
      exit;
    }
  }

  public function articles() {
    if( $this->isAdmin() ) {
      $articlesModel = new ArticlesModel();
      $articles = $articlesModel->getAll();
      $this->render( 'admin/articles', ['articles' => $articles ] );
    } else {
      $_SESSION['error'] = 'Vous n\'avez pas accès à cette zone';
      header( 'Location: ' . BASEURL );
      exit;
    }
  }

  public function deleteAnnonce( int $id) {
    if( $this->isAdmin() ) {
      $annoncesModel = new AnnoncesModel();
      $annonces = $annoncesModel->delete( $id );
      header( 'Location: ' . $_SERVER['HTTP_REFERER'] );
      exit;
    } else {
      $_SESSION['error'] = 'Vous n\'avez pas accès à cette zone';
      header( 'Location: ' . BASEURL );
      exit;
    }
  }

  public function deleteArticle( int $id) {
    if( $this->isAdmin() ) {
      $articlesModel = new ArticlesModel();
      $articles = $articlesModel->delete( $id );
      header( 'Location: ' . $_SERVER['HTTP_REFERER'] );
      exit;
    } else {
      $_SESSION['error'] = 'Vous n\'avez pas accès à cette zone';
      header( 'Location: ' . BASEURL );
      exit;
    }
  }

  public function users() {
    $usersModel = new UsersModel();
    $users = $usersModel->getAll();
    $this->render( 'admin/users', ['users' => $users] );
  }

  public function user( int $id ) {
    $usersModel = new UsersModel();
    $user = $usersModel->getOne( $id );
    $this->render( 'admin/user', [ 'user'=>$user ] );
  }

  public function createUser() {
    
    if( $this->isAdmin() ) {
    
      if( Form::validate( $_POST, [ 'pseudo', 'email', 'password', 'password2' ] ) ) {

        $pseudo     =   strip_tags( $_POST['pseudo'] );
        $email      =   strip_tags( $_POST['email'] );  
        $password   =   strip_tags( $_POST['password'] );  
        $password2  =   strip_tags( $_POST['password2'] ); 
        
        if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
            $_SESSION['error'] = "Format d'adresse email incorect";
            header('Location: ' . BASEURL . 'users/register');
            exit;
        }

        if( $password != $password2 ){
            $_SESSION['error'] = "Les mots de passe ne correspondent pas";
            header('Location: ' . BASEURL . 'users/register');
            exit;
        }

        $user = new UsersModel(); 
        $user->setPseudo( $pseudo )
        ->setEmail( $email )
        ->setPassword( password_hash( $password, PASSWORD_DEFAULT ) )
        ->setRole( $_POST['role'] )
        ;

        $user->create();

        $_SESSION['success'] = "Le compte a été créé";
        header( 'Location: ' . BASEURL . 'admin/users');
        exit;
        
      }


      $form = new Form();

      $form->startForm()
      ->addLabelFor( "pseudo", "Pseudonyme")
      ->addInput( "text", "pseudo", array("id"=>"pseudo", "class"=>"form-control"))
      ->addLabelFor( "email", "Adresse Mail")
      ->addInput( "text", "email", array("id"=>"email", "class"=>"form-control") )
      ->addLabelFor( "password", "Mot de passe")
      ->addInput( "password", "password", array("id"=>"password", "class"=>"form-control") )
      ->addLabelFor( "password2", "Confirmation mot de passe")
      ->addInput( "password", "password2", array("id"=>"password2", "class"=>"form-control") )

      ->addString('<div class="custom-control custom-radio">')
      ->addInput( "radio", "role", array("id"=>"membre", "class"=>"custom-control-input"))
      ->addLabelFor( "membre", "Membre", array("class"=>"custom-control-label" ))
      ->addString( '</div>')
      ->addString('<div class="custom-control custom-radio">')
      ->addInput( "radio", "role", array("id"=>"admin", "class"=>"custom-control-input"))
      ->addLabelFor( "admin", "Administrateur", array("class"=>"custom-control-label" ))
      ->addString( '</div>')
      
      ->addButton( 'Connexion', array( "class"=>"btn btn-primary") )
      ->endForm()
      ;

      $registerForm = $form->create();

      $this->render( 'admin/updateUser', [
          'registerForm' => $registerForm,
          'titre' =>  'Ajouter un utilisateur'
        ] 
      );

    } else {
      $_SESSION['error'] = 'Vous n\'avez pas accès à cette zone';
      header( 'Location: ' . BASEURL );
      exit;
    }

  }


  public function updateUser( int $id ) {
    if( $this->isAdmin() ) {
    
      if( Form::validate( $_POST, [ 'pseudo', 'email' ] ) ) {

        $pseudo     =   strip_tags( $_POST['pseudo'] );
        $email      =   strip_tags( $_POST['email'] );  
        $password   =   strip_tags( $_POST['password'] );  
        $password2  =   strip_tags( $_POST['password2'] ); 
        
        if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
            $_SESSION['error'] = "Format d'adresse email incorect";
            header('Location: ' . BASEURL . 'users/register');
            exit;
        }

        if( $password != $password2 ){
            $_SESSION['error'] = "Les mots de passe ne correspondent pas";
            header('Location: ' . BASEURL . 'users/register');
            exit;
        }

        $user = new UsersModel(); 
        $user->setPseudo( $pseudo )
        ->setEmail( $email );
        if( !empty( $password ) ) {
          $user->setPassword( password_hash( $password, PASSWORD_DEFAULT ) );
        }
        // ->setRole( 'membre' )
        ;

        $user->update( $id );

        $_SESSION['success'] = "Le compte a été modifié";
        header( 'Location: ' . BASEURL . 'admin/users');
        exit;
        
      }

      $usersModel = new UsersModel();
      $userArray = $usersModel->getOne( $id );
      $user = $usersModel->hydrate($userArray);

      $form = new Form();

      $form->startForm()
      ->addLabelFor( "pseudo", "Pseudonyme")
      ->addInput( "text", "pseudo", array("id"=>"pseudo", "class"=>"form-control", "value" => $user->getPseudo() ))
      ->addLabelFor( "email", "Adresse Mail")
      ->addInput( "text", "email", array("id"=>"email", "class"=>"form-control", "value" => $user->getEmail()) )
      ->addLabelFor( "password", "Mot de passe")
      ->addInput( "password", "password", array("id"=>"password", "class"=>"form-control") )
      ->addLabelFor( "password2", "Confirmation mot de passe")
      ->addInput( "password", "password2", array("id"=>"password2", "class"=>"form-control") )
      ->addButton( 'Valider', array( "class"=>"btn btn-primary") )
      ->endForm()
      ;

      $registerForm = $form->create();

      $this->render( 'admin/updateUser', [
          'registerForm' => $registerForm,
          'titre' =>  'Modifier un utilisateur'
        ] 
      );

    } else {
      $_SESSION['error'] = 'Vous n\'avez pas accès à cette zone';
      header( 'Location: ' . BASEURL );
      exit;
    }
  }
  public function deleteUser( int $id ) {
    if( $this->isAdmin() ) {

      $usersModel = new UsersModel();
      $usersModel->delete( $id );
      $_SESSION['success'] = 'Utilisateur supprimé';
      header( 'Location: ' . $_SERVER['HTTP_REFERER'] );
      exit;

    } else {
      $_SESSION['error'] = 'Vous n\'avez pas accès à cette zone';
      header( 'Location: ' . BASEURL );
      exit;
    }
  }

  public function activeArticle( int $id ) {

      $articlesModel = new ArticlesModel();
      $articlesArray = $articlesModel->getOne( $id );
      $article = $articlesModel->hydrate( $articlesArray );

      if( $article->getActif() ) {
        $article->setActif("0");
      } else {
        $article->setActif("1");
      }
      $article->update( $id );
    
  }

}