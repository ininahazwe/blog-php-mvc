<?php

    namespace App\Controllers;

    use App\Models\AnnoncesModel;
    use App\Core\Form;

    class AnnoncesController extends Controller {

        public function index() {

            $annoncesModel = new AnnoncesModel();
            $annonces = $annoncesModel->getAll();
            $this->render( 'annonces/index', ['annonces' => $annonces ] );

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
    
                    $annonce = new AnnoncesModel();
    
                    $annonce->setTitre( $titre )
                    ->setDescription( $description )
                    ->setActif(1)
                    ->setImage( $name );
    
                    $annonce->create();
    
                    $_SESSION['success'] = 'Annonce créée';
                    header('Location: ' . BASEURL . 'admin/annonces');
                    exit;
                }
                
                $form = new Form();
    
                $form->startForm( 'post', '', [ 'enctype' => 'multipart/form-data'])
                ->addLabelFor( 'image', 'Image')
                ->addInput( 'file', 'image', ['id'=>'image'])
                ->addLabelFor( 'titre', 'Titre de l\'annonce' )
                ->addInput( 'text', 'titre', ['id'=>'tittre', 'class'=>'form-control'] )
                ->addLabelFor( 'description', 'Texte de l\'annonce' )
                ->addTextarea( 'description', '', ['id'=>'description','class'=>'form-control'] )
                ->addButton( 'Valider', [ 'class'=>'btn btn-primary'] )
                ;
    
                $annonceForm = $form->create();
    
                $this->render( 'annonces/create', [ 
                        'annonceForm'   => $annonceForm,
                        'titre'         =>  "Nouvelle annonce",
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

                $annoncesModel = new AnnoncesModel();
                $annonce = $annoncesModel->getOne( $id );

                if( !$annonce ) {
                    $_SESSION['error'] = 'Annonce non trouvée';
                    header( 'Location: ' . BASEURL . 'annonces');
                    exit;
                }

                if( Form::validate( $_POST, ['titre', 'description'] ) ) {
                    $titre = strip_tags( $_POST['titre']);
                    $description = strip_tags( $_POST['description']);

                    $annonce = new AnnoncesModel();

                    $annonce->setTitre( $titre )
                    ->setDescription( $description )
                    ->setActif(1);
                    $annonce->update( $id );

                    $_SESSION['success'] = 'Annonce modifiée';
                    header('Location: ' . BASEURL . 'admin/annonces');
                    exit;
                }
                
                $form = new Form();

                $form->startForm()
                ->addLabelFor( 'titre', 'Titre de l\'annonce' )
                ->addInput( 'text', 'titre', [
                    'id'=>'titre', 
                    'class'=>'form-control',
                    'value'=>$annonce['titre']
                ])
                ->addLabelFor( 'description', 'Texte de l\'annonce' )
                ->addTextarea( 'description', $annonce['description'], ['id'=>'description','class'=>'form-control'] )
                ->addButton( 'Valider', [ 'class'=>'btn btn-primary'] )
                ;

                $annonceForm = $form->create();

                $this->render( 'annonces/create', [ 
                        'annonceForm'   => $annonceForm,
                        'titre'         =>  "Modifier l'annonce",
                    ] 
                );
            
            } else {
                $_SESSION['error'] = 'Vous n\'avez pas accès à cette zone';
                header( 'Location: ' . BASEURL );
                exit;
            }

        }

        public function read( int $id ) {
            $annoncesModel = new AnnoncesModel();
            $annonce = $annoncesModel->getOne( $id );
            $this->render( 'annonces/read', ['annonce'=>$annonce] );
        }

        
    }