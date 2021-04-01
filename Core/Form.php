<?php

    namespace App\Core;

    class Form {

        private $formCode = "";

        private function addAttributes( array $attributs ) {
            $str="";
            foreach($attributs as $attribut=>$valeur ) {
                $str .= "$attribut = '$valeur' ";
            }
            return $str;
        }        

        public function create() {
            return $this->formCode;
        }

        public static function validate( array $form, array $fields ) {

            foreach( $fields as $field ) {
                if( empty($form[$field]) ) {
                    return false;
                }
            }
            
            return true;

        }

        public function startForm( string $method="post", string $action="", array $attributs=[] ) {
            $this->formCode .= "<form action='$action' method='$method'";
            $this->formCode .= $this->addAttributes($attributs);
            $this->formCode .= ">";
            return $this;
        }

        public function endForm() {
            $this->formCode .= "</form>";
            return $this;
        }

        public function addLabelFor( string $for, string $texte, array $attributs=[]  ) {
            $this->formCode .= "<label for='$for'";
            $this->formCode .= $this->addAttributes($attributs) . ">";
            $this->formCode .= $texte;
            $this->formCode .= "</label>";
            return $this;
        }

        public function addInput( string $type, string $name, array $attributs=[] ) {
            $this->formCode .= "<input type='$type' name='$name'";
            $this->formCode .= $this->addAttributes($attributs);
            $this->formCode .= "/>";
            return $this;
        }

        public function addTextarea( string $name, string $valeur = '', array $attributs=[] ) {
            $this->formCode .= "<textarea name='$name'";
            $this->formCode .= $this->addAttributes($attributs);
            $this->formCode .= "/>$valeur</textarea>";
            return $this;
        }

        public function addButton( string $texte, array $attributs=[] ) {
            $this->formCode .= "<button ";
            $this->formCode .= $this->addAttributes($attributs);
            $this->formCode .= ">$texte</button>";
            return $this;
        }

        public function addString( string $string ) {
            $this->formCode .= $string;
            return $this;
        }

        public function addSelect( string $name, array $options, string $selected , array $attributs=[] ) {

            $this->formCode .= "<select name='$name'";
            $this->formCode .= $this->addAttributes($attributs) . '>';
            foreach( $options as $valeur=>$texte ) {
                $this->formCode .= "<option value='$valeur' ". ( $valeur == $selected ? ' selected ':  '') ." >$texte</option>";
            }
            $this->formCode .= "</select>";
            return $this;

        }


       

    }