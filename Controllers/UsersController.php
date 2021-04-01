<?php

    namespace App\Controllers;

    use App\Models\UsersModel;
    use App\Core\Form;

    class UsersController extends Controller {

        public function index() {

            // $usersModel = new UsersModel();
            // $users = $usersModel->getAll();
            // $this->render( 'users/index', ['users' => $users] );
            header('Location: ' .BASEURL );
        
        }

        // public function read( int $id ) {
        //     $usersModel = new UsersModel();
        //     $user = $usersModel->getOne( $id );
        //     $this->render( 'users/read', [ 'user'=>$user ] );
        // }

        public function login() {

            if( Form::validate( $_POST , [ 'email', 'password' ] ) ) {

                $usersModel = new UsersModel;
                $userArray = $usersModel->getUserByEmail( $_POST['email'] );
                $user = $usersModel->hydrate( $userArray );

                if( $userArray ) {
                    if( password_verify( $_POST['password'], $user->getPassword() ) ) {

                        $user->setSession();
                        
                        $_SESSION['success'] = "Vous êtes connecté";
                        header( 'Location: ' . BASEURL . 'admin');
                        exit;
                    } else {
                        $_SESSION['error'] = "L'email et le mot de passe ne correspondent pas";
                        header('Location: ' . BASEURL . 'users/login');
                        exit;
                    }
                };

            } 

            $form = new Form();

            $form->startForm()
            ->addLabelFor( "email", "Adresse Mail")
            ->addInput( "text", "email", array("id"=>"email", "class"=>"form-control") )
            ->addLabelFor( "password", "Mot de passe")
            ->addInput( "password", "password", array("id"=>"password", "class"=>"form-control") )
            ->addButton( 'Connexion', array( "class"=>"btn btn-primary") )
            ->endForm()
            ;

            $loginForm = $form->create();

            $this->render( 'users/login', ['loginForm' => $loginForm] );
        
        }


        public function register() {

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
                ->setRole( 'membre' );

                $user->create();

                $_SESSION['success'] = "Le compte a été créé";
                header( 'Location: ' . BASEURL . 'users/login');
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
            ->addButton( 'Connexion', array( "class"=>"btn btn-primary") )
            ->endForm()
            ;

            $registerForm = $form->create();

            $this->render( 'users/register', ['registerForm' => $registerForm] );
        }

        public function logout() {
            unset( $_SESSION['user'] );
            $_SESSION['success'] = 'Vous êtes déconnecté';
            header( 'Location: ' . BASEURL );
            exit;
        }

        public function profil() {
            
            if( self::isConnected() ) {
                
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
    
                    $user->update( $_SESSION['user']['id'] );
    
                    $_SESSION['success'] = "Le compte a été modifié";
                    header( 'Location: ' . BASEURL . 'admin');
                    exit;
                    
                }
    
                $usersModel = new UsersModel();
                $user = $usersModel->getOne( $_SESSION['user']['id'] );


                $form = new Form();
    
                $form->startForm()
                ->addLabelFor( "pseudo", "Pseudonyme")
                ->addInput( "text", "pseudo", array("id"=>"pseudo", "class"=>"form-control", "value" => $user['pseudo'] ))
                ->addLabelFor( "email", "Adresse Mail")
                ->addInput( "text", "email", array("id"=>"email", "class"=>"form-control", "value" => $user['email']) )
                ->addLabelFor( "password", "Mot de passe")
                ->addInput( "password", "password", array("id"=>"password", "class"=>"form-control") )
                ->addLabelFor( "password2", "Confirmation mot de passe")
                ->addInput( "password", "password2", array("id"=>"password2", "class"=>"form-control") )
                ->addButton( 'Valider', array( "class"=>"btn btn-primary") )
                ->endForm()
                ;
    
                $registerForm = $form->create();
    
                $this->render( 'users/profil', ['registerForm' => $registerForm] );

            }
        
        }

    }