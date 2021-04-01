<?php 

    namespace App\Controllers;

    abstract class Controller {

        public function render( string $fichier, array $donnees = [], string $template ="default"  ) {
           
            extract( $donnees );
          
            ob_start();
            require_once ROOT . '/views/' . $fichier . '.php';  
            $content = ob_get_clean();
            require_once ROOT . '/views/layouts/' . $template . '.php'; 
        }

        public static function isAdmin() {
          if( isset( $_SESSION['user'] ) && 'admin' == $_SESSION['user']['role'] ) {
            return true;
          } else {
            return false;
          }
        }

        public static function isMembre() {
          if( isset( $_SESSION['user'] ) && 'membre' == $_SESSION['user']['role'] ) {
            return true;
          } else {
            return false;
          }
        }

        public static function isConnected() {
          if( isset( $_SESSION['user'] ) ) {
            return true;
          } else {
            return false;
          }
        }

    }