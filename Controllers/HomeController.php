<?php

    namespace App\Controllers;

    use App\Models\ArticlesModel;

    class HomeController extends Controller {

        public function index() {

            $articlesModel = new ArticlesModel();
            $articles = $articlesModel->getByOrder( 'created_at', 'DESC', 0, 5 );

            $this->render('home/index', [ 'listeArticles' => $articles] );

        }

    }