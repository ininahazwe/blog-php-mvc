<?php

    namespace App\Models;
 
    class CategoriesModel extends Model {

        public function __construct() {
            $this->getConnexion();
            $this->table = 'categories';
        }

    }