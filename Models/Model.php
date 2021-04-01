<?php

    namespace App\Models;

    use PDO;
    use PDOException;

    abstract class Model {

        private const DBHOST     =   'localhost';
        private const DBNAME     =   'mvc0';
        private const DBUSER     =   'root';
        private const DBPASS     =   '';

        protected $connexion;

        public $table;

        protected function getConnexion() { 
            try {
                $this->connexion = new PDO('mysql:host='.self::DBHOST.';dbname='.self::DBNAME, self::DBUSER, self::DBPASS );
            } catch( PDOException $e ) {
                echo 'Erreur : ' . $e->getMessage();
            }
        
        }

        public function getAll() {
            $sql = "SELECT * FROM $this->table";
            return $this->connexion->query( $sql )->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getOne( int $id ) {
            $sql = "SELECT * FROM $this->table WHERE id = $id";
            return $this->connexion->query( $sql )->fetch();
        }

        public function getByOrder( string $orderby = 'id', string $order = "ASC", int $offset = 0, $limit = null ) {
            $sql = "SELECT * FROM $this->table ORDER BY $orderby $order";
            if( $limit ) {
                $sql .= " LIMIT $offset, $limit";
            }
            return $this->connexion->query( $sql )->fetchAll(PDO::FETCH_ASSOC);
        }


        public function getBy( array $criteres ) {
            $liste_champs = [];
            $liste_valeurs = [];
            foreach( $criteres as $champ=>$valeur ) {
                $liste_champs[] = $champ . " = ? ";
                $liste_valeurs[] = $valeur;
            }
            $champs = implode( ' AND ', $liste_champs );
            $sql = "SELECT * FROM $this->table WHERE $champs";
            $query = $this->connexion->prepare( $sql );
            $query->execute( $liste_valeurs );
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function create() {

            $liste_champs = [];
            $liste_valeurs = [];
            $liste_params = [];

            foreach( $this as $champ => $valeur ) {
                if( $champ != 'connexion' && $champ != 'table' && $valeur != null ) {
                    $liste_champs[] = $champ;
                    $liste_valeurs[] = $valeur;
                    $liste_params[] = '?';
                }
            }

            $champs = implode( ', ', $liste_champs );
            $params = implode( ', ', $liste_params );

            $sql = "INSERT INTO $this->table ( $champs ) VALUES ( $params )";

            $query = $this->connexion->prepare( $sql );
            $query->execute( $liste_valeurs );

        }
       
        public function update( int $id ) {
            
            $liste_champs = [];
            $liste_valeurs = [];
            foreach( $this as $champ => $valeur ) {
                if( $champ != 'connexion' && $champ != 'table' && $valeur != null ) {
                    $liste_champs[] = $champ . '= ?';
                    $liste_valeurs[] = $valeur;
                }
            }

            $liste_valeurs[] = $id;
            $champs = implode( ', ', $liste_champs );

            $sql = "UPDATE $this->table SET $champs WHERE id = ?";
            $query = $this->connexion->prepare( $sql );
            $query->execute( $liste_valeurs );
        
        }

        public function hydrate( array $data ) {
            foreach( $data as $key=>$value ) {
                $setter = 'set' . ucfirst( $key );
                if( method_exists( $this, $setter ) ) {
                    $this->$setter( $value );
                }
            }

            return $this;
        }

        public function delete( int $id ) {
            $sql = "DELETE FROM $this->table WHERE id = ?";
            $query = $this->connexion->prepare( $sql );
            $query->execute( [$id]);
        }


        
    }
