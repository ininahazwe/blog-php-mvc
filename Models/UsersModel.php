<?php

    namespace App\Models;

    class UsersModel extends Model {

        protected $id;
        protected $email;
        protected $password;
        protected $pseudo;
        protected $role;

        public function __construct() {
            $this->table = 'users';
            $this->getConnexion();
        }

        public function getUserByEmail( string $email ) {
            $sql = "SELECT * FROM $this->table WHERE email = '$email'";
            var_dump( $sql );
            return $this->connexion->query( $sql )->fetch();
        }
    
        public function setSession() {
            $_SESSION['user'] = array(
                'id'        =>  $this->id,
                'pseudo'    =>  $this->pseudo,
                'role'      =>  $this->role
            );
        }


        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of email
         */ 
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Set the value of email
         *
         * @return  self
         */ 
        public function setEmail($email)
        {
                $this->email = $email;

                return $this;
        }

        /**
         * Get the value of password
         */ 
        public function getPassword()
        {
                return $this->password;
        }

        /**
         * Set the value of password
         *
         * @return  self
         */ 
        public function setPassword($password)
        {
                $this->password = $password;

                return $this;
        }

        /**
         * Get the value of pseudo
         */ 
        public function getPseudo()
        {
                return $this->pseudo;
        }

        /**
         * Set the value of pseudo
         *
         * @return  self
         */ 
        public function setPseudo($pseudo)
        {
                $this->pseudo = $pseudo;

                return $this;
        }

        /**
         * Get the value of role
         */ 
        public function getRole()
        {
                return $this->role;
        }

        /**
         * Set the value of role
         *
         * @return  self
         */ 
        public function setRole($role)
        {
                $this->role = $role;

                return $this;
        }

        
    }