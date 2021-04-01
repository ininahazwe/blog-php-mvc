<?php

    namespace App\Controllers;

    use App\Models\CategoriesModel;
    use PDO;

    class CategoriesController extends Controller {

        public function index() {

            $categoriesModel = new CategoriesModel();
            $categories = $categoriesModel->getAll( PDO::FETCH_ASSOC );
            $this->render( 'categories/index', $categories);

        }

    }