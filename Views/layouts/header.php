<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= BASEURL ?>Public/style.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
     
        <a class="navbar-brand" href="<?= BASEURL ?>">Test MVC</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="collapse navbar-collapse" id="navbarNav">
            
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASEURL ?>">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASEURL ?>annonces/">Annonces</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASEURL ?>articles/">Articles</a>
                </li>
            </ul>
        
            <ul class="navbar-nav ml-auto">
          
                <?php if(!empty( $_SESSION['user'] )) { ?>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASEURL ?>admin/">Administration</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASEURL ?>users/profil">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASEURL ?>users/logout/">Deconnexion</a>
                    </li>

                <?php } else { ?>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASEURL ?>users/register/">Inscription</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASEURL ?>users/login">Connexion</a>
                    </li>

                <?php } ?>
            
            </ul>
        
        </div>
    </nav>

    <?php if( !empty( $_SESSION['success'] ) ) : ?>
        <div class="alert alert-success" role="alert">
            <?php
                echo $_SESSION['success'];
                unset( $_SESSION['success'] );
            ?>
        </div>
    <?php endif; ?>

    <?php if( !empty( $_SESSION['error'] ) ) : ?>
        <div class="alert alert-danger" role="alert">
            <?php
                echo $_SESSION['error'];
                unset( $_SESSION['error'] );
            ?>
        </div>
    <?php endif; ?>